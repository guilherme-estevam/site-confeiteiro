<?php
  include '../utils/conn.php';

  $idAtendimento = $_POST["idAtendimento"];
  
  $sql = "SELECT idMensagens FROM `final-atendimento` WHERE idAtendimento = ?";
  
  //stmt = statment ou comando
  //stmt é o comando a ser preparado
  $stmt = mysqli_stmt_init($conn);  
  $stmt_prepared_okay = mysqli_stmt_prepare($stmt, $sql);
  // create a prepared statement
  if($stmt_prepared_okay) {
    // Liga parametros com os marcadores
    mysqli_stmt_bind_param($stmt, "s", $idAtendimento);
    // executa a query
    mysqli_stmt_execute($stmt);
    // get results
    $result = mysqli_stmt_get_result($stmt);
    // save results
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $idMensagens=$row["idMensagens"];

    // Delete from mensagens
    $insertSql = "DELETE FROM `final-mensagens` WHERE idMensagens = ?";
    $stmt_prepared_okay = mysqli_stmt_prepare($stmt, $insertSql);

    if($stmt_prepared_okay) {
      mysqli_stmt_bind_param($stmt, "s", $idMensagens);
      // executa a query
      mysqli_stmt_execute($stmt);
    }
  }
    
  // close statement
  mysqli_stmt_close($stmt);
  mysqli_close($conn);
  header("location: ./index.php");
?>
