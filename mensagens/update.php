<?php
  include '../utils/conn.php';

  $idAtendimento = $_POST["idAtendimento"];

  $statusNum = $_POST["status"];
  $statusList = array("Respondida Email", "Respondida WhatsApp", "Respondida Email e WhatsApp", "Não Respondida");
  $status = $statusList[$statusNum];

  $dataResposta = $statusNum == 3 ? NULL : date("Y-m-d");

  $finalizacaoNum = $_POST["finalizacao"];
  $finalizacoes = array("Com Venda", "Sem Venda");
  $finalizacao = $finalizacaoNum == 2 ? NULL : $finalizacoes[$finalizacaoNum];

  $sql = "UPDATE `final-atendimento` SET status = ?, dataResposta = ?, finalizacao = ? WHERE idAtendimento = ?";

  //stmt = statment ou comando
  //stmt é o comando a ser preparado
  $stmt = mysqli_stmt_init($conn);  
  $stmt_prepared_okay = mysqli_stmt_prepare($stmt, $sql);
  // create a prepared statement
  if($stmt_prepared_okay){
      // Liga parametros com os marcadores
      mysqli_stmt_bind_param($stmt, "ssss", $status, $dataResposta, $finalizacao, $idAtendimento);
      // executa a query
      mysqli_stmt_execute($stmt);
      // close statement
      mysqli_stmt_close($stmt);
  }
  
  mysqli_close($conn);
  header('location: ./index.php');
?>
