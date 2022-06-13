<?php
  include 'conn.php';

  // Save File Image 
  //pasta dentro do HTDOCS onde os arquivos serão salvos.
  $target_dir = "../images/"; 

  $target_file = $target_dir.basename($_FILES["foto"]["name"]);

  $uploadOk = 1; //Flag

  $fileExtesion = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

  // Check if file already exists
  if (file_exists($target_file))
    $uploadOk = 0;

  // Check file size
  if ($_FILES["foto"]["size"] > 2097152) // 2MB 
    $uploadOk = 0;

  // Allow certain file formats
  if ($fileExtesion != "jpg" && $fileExtesion != "png")
    $uploadOk = 0;

  // Check if $uploadOk is ok
  if ($uploadOk != 0)
    move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file);

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
