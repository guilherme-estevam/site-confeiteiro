<?php
  include '../utils/conn.php';
  include '../utils/uploadImage.php';

  $idBolos = $_POST["idBolos"];
  $foto = $target_file;
  $descricao = $_POST["descricao"];
  $valor = $_POST["valor"];
  $fatias = $_POST["fatias"];
  $data = date("Y-m-d");
  $categoriaNum = $_POST["categoria"];
  $categorias = array("Aniversário", "Confeitado", "Especial", "Simples");
  $categoria = $categorias[$categoriaNum];

  $sql = "UPDATE `final-bolos` SET foto = ?, descricao = ?, valor = ?, fatias = ?, data = ?, categoria = ? WHERE idBolos = ?";

  //stmt = statment ou comando
  //stmt é o comando a ser preparado
  $stmt = mysqli_stmt_init($conn);  
  $stmt_prepared_okay = mysqli_stmt_prepare($stmt, $sql);
  // create a prepared statement
  if($stmt_prepared_okay){
      // Liga parametros com os marcadores
      mysqli_stmt_bind_param($stmt, "sssssss", $foto, $descricao, $valor, $fatias, $data, $categoria, $idBolos);
      // executa a query
      mysqli_stmt_execute($stmt);
      // close statement
      mysqli_stmt_close($stmt);
  }
  
  mysqli_close($conn);
  header('location: ./index.php');
?>
