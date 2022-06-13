<html>
<head>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
  <title>Site Confeiteiro</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <style>
    body {background: rgb(0,219,255); background: linear-gradient(90deg, rgba(0,219,255,1) 20%, rgba(188,246,255,1) 50%, rgba(0,212,255,1) 80%);}
  </style>
</head>
<body>
  <div class="container" style="text-align: center;width: 100%;padding-top: 5%;">
    <div class="row align-items-center" >
      <div class="col">
        <h1> Bolos Disponíveis</h1>
      </div>
      <div class="col dropdown-center dropdown-menu-dark">
        <button class="btn btn-primary btn-lg dropdown-toggle" type="button" id="dropdown2" data-bs-toggle="dropdown" aria-expanded="false">
          Filtrar por Categoria
        </button>
        <ul class="dropdown-menu" aria-labelledby="dropdown2">
          <?php
            $filtro = $_GET["filtro"];

            $filtroTodos = "";
            $filtroAniversario = "";
            $filtroConfeitado = "";
            $filtroEspecial = "";
            $filtroSimples = "";

            if($filtro == "Todos" or $filtro == ""){
              $filtroTodos = "active";
            } else if($filtro == "Aniversario"){
              $filtroAniversario = "active";
            } else if($filtro == "Confeitado"){
              $filtroConfeitado = "active";
            } else if($filtro == "Especial"){
              $filtroEspecial = "active";
            } else if($filtro == "Simples"){
              $filtroSimples = "active";
            }

            echo '<li><a class="dropdown-item '.$filtroTodos.'" href="./index.php?filtro=Todos">Todos</a></li>';
            echo '<li><a class="dropdown-item '.$filtroAniversario.'" href="./index.php?filtro=Aniversario">Aniversário</a></li>';
            echo '<li><a class="dropdown-item '.$filtroConfeitado.'" href="./index.php?filtro=Confeitado">Confeitado</a></li>';
            echo '<li><a class="dropdown-item '.$filtroEspecial.'" href="./index.php?filtro=Especial">Especial</a></li>';
            echo '<li><a class="dropdown-item '.$filtroSimples.'" href="./index.php?filtro=Simples">Simples</a></li>';
          ?>
        </ul>
      </div>
    </div>
  </div>
  <div class="w-75" style="margin: auto; margin-top:2%; margin-bottom:5%;">
    <table class="table table-dark table-striped table-hover align-middle">
        <thead>
          <tr>
            <th scope="col">Foto</th>
            <th scope="col">Descrição</th>
            <th scope="col">Valor</th>
            <th scope="col">Número de Fatias</th>
            <th scope="col">Data de Inclusão</th>
            <th scope="col">Categoria</th>
            <th scope="col">Editar</th>
          </tr>
        </thead>
        <tbody>
          <?php
            function printData($row) {
              if(!$row)
                return false;

              $idBolos=$row["idBolos"];
              $foto=$row["foto"];
              $descricao=$row["descricao"];
              $valor=$row["valor"];
              $fatias=$row["fatias"];
              $data=$row["data"];
              $categoria=$row["categoria"];
              echo '<tr><td><img class="img-thumbnail img-responsive" src='.$foto.' alt="Bolo de Chocolate" width="540" height="360"></td>';
              echo '<td>'.$descricao.'</td>';
              echo '<td>'.$valor.'R$ a fatia</td>';
              echo '<td>'.$fatias.' Disponíveis</td>';
              echo '<td>'.$data.'</td>';
              echo '<td>'.$categoria.'</td>';
              echo "<td><button type='button' class='btn btn-info' onclick ='cakeChoosen(String($idBolos))'>Enviar Mensagem</button></td>";

              return true;
            }

            header('Content-type: text/html; charset=utf-8');

            include 'conn.php';

            if($filtro == "Todos" or $filtro == "") {
              $sql = "SELECT * FROM `final-bolos` ORDER BY idBolos";

              $result = mysqli_query($conn, $sql);
              while(printData(mysqli_fetch_assoc($result))) {}
              
            } else {
              $sql = "SELECT * FROM `final-bolos` WHERE categoria = ? ORDER BY idBolos";

              //stmt = statment ou comando
              //stmt é o comando a ser preparado
              $stmt = mysqli_stmt_init($conn);  
              $stmt_prepared_okay = mysqli_stmt_prepare($stmt, $sql);
              // create a prepared statement
              if($stmt_prepared_okay) {
                // Liga parametros com os marcadores
                mysqli_stmt_bind_param($stmt, "s", $filtro);
                // executa a query
                mysqli_stmt_execute($stmt);
                // get results
                $result = mysqli_stmt_get_result($stmt);
                // print results
                while(printData(mysqli_fetch_array($result, MYSQLI_ASSOC))) {}
              } else {
                echo "<tr><td>Filtragem Inválida</tr></td>";
              }
              // closing
              mysqli_stmt_close($stmt);
            }
            mysqli_free_result($result);
            mysqli_close($conn);
          ?>
        </tbody>
      </table>
    </div>
  </div>
</body>
<script>
function cakeChoosen(idBolos) {
  window.location.href = "./sendMessage.php?id="+idBolos;
}
</script>
</html>
