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
    <?php
      include '../utils/conn.php';

      if($_FILES["foto"]["name"] != "")
        include '../utils/uploadImage.php';

      // Insert into mensagens
      $idBolos = $_POST["idBolos"];
      $cliente = $_POST["cliente"];
      $email = $_POST["email"];
      $telefone = $_POST["telefone"];
      $whatsapp = $_POST["whatsapp"];
      $mensagem = $_POST["mensagem"] == "" ? NULL : $_POST["mensagem"];
      $imagem = $target_file;

      // A chave é uma chave primária com auto increment, por isso não precisamos adicionar ela no sql
      $sql = "INSERT INTO `final-mensagens`(idBolos, cliente, email, telefone, whatsapp, mensagem, imagem) VALUES (?, ?, ?, ?, ?, ?, ?)";
      
      //stmt = statment ou comando
      //stmt é o comando a ser preparado
      $stmt = mysqli_stmt_init($conn);  
      $stmt_prepared_okay = mysqli_stmt_prepare($stmt, $sql);
      // create a prepared statement
      if($stmt_prepared_okay) {
        // Liga parametros com os marcadores
        mysqli_stmt_bind_param($stmt, "sssssss", $idBolos, $cliente, $email, $telefone, $whatsapp, $mensagem, $imagem);
        // executa a query
        mysqli_stmt_execute($stmt);

        // Insert into atendimento
        $idMensagens = mysqli_stmt_insert_id($stmt);
        $status = "Não Respondida";
        $dataRecebimento = date("Y-m-d");
        $dataResposta = NULL;
        $finalizacao = NULL;

        $newSql = "INSERT INTO `final-atendimento`(idMensagens, status, dataRecebimento, dataResposta, finalizacao) VALUES (?, ?, ?, ?, ?)";

        $stmt_prepared_okay = mysqli_stmt_prepare($stmt, $newSql);
        if($stmt_prepared_okay) {
          mysqli_stmt_bind_param($stmt, "sssss", $idMensagens, $status, $dataRecebimento, $dataResposta, $finalizacao);
          // executa a query
          mysqli_stmt_execute($stmt);
          echo "<h3>Mensagem enviada com Sucesso.</h3>";
        } else
        echo "<h3>Não foi possível enviar sua Mensagem.</h3>";
      } else 
      echo "<h3>Não foi possível enviar sua Mensagem.</h3>";
      
      // close statement
      mysqli_stmt_close($stmt);
      mysqli_close($conn);
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
  window.location.href = "./index.php?filtro=Todos";
}
</script>
</html>
