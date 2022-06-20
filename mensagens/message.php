<html>
<head>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
  <title>Gestão de Mensagens</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <style>
    body {background: rgb(0,219,255); background: linear-gradient(90deg, rgba(0,219,255,1) 20%, rgba(188,246,255,1) 50%, rgba(0,212,255,1) 80%);}
  </style>
</head>
<body>
  <div class="container" style="text-align: center;width: 100%;padding-top: 5%;">
  <?php
    include '../utils/conn.php';

    $idMensagens = $_GET["id"];

    $sql = "SELECT mensagem, imagem FROM `final-mensagens` WHERE idMensagens = ?";
    
    //stmt = statment ou comando
    //stmt é o comando a ser preparado
    $stmt = mysqli_stmt_init($conn);  
    $stmt_prepared_okay = mysqli_stmt_prepare($stmt, $sql);
    // create a prepared statement
    if($stmt_prepared_okay) {
      // Liga parametros com os marcadores
      mysqli_stmt_bind_param($stmt, "s", $idMensagens);
      // executa a query
      mysqli_stmt_execute($stmt);
      // get results
      $result = mysqli_stmt_get_result($stmt);
      $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

      $mensagem=$row["mensagem"] ?? "Não foi escrita nenhuma mensagem...";
      $imagem=$row["imagem"] ?? "Não foi enviada nenhuma imagem...";

      echo '<h3>Detalhes da Mensagem</h3>';
      echo '<h4>Mensagem</h4>';
      echo '<h5>'.$mensagem.'</h5>';
      echo '<h4>Imagem de Referência</h4>';
      if($row["imagem"] == NULL)
        echo '<h5>Não foi enviada nenhuma imagem...</h5>';
      else
        echo '<img class="img-thumbnail img-responsive" src='.$row["imagem"].' width="540" height="360">';
    } else
      echo '<h3>Infelizmente não foi possível obter a Mensagem...</h3>';
  ?>
    <div class="row justify-content-md-center">
      <div class="col-6">
        <br><br><button type="submit" class="btn btn-primary" onclick="backToIndex()">Voltar para o Início</button>
      </div>
    </div>
  </div>
</body>
<script>
function backToIndex() {
  window.location.href = "./index.php";
}
</script>
</html>
