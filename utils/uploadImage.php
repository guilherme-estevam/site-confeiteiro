<?php
// Save File Image 
//pasta dentro do HTDOCS onde os arquivos serão salvos.
$target_dir = "../images/"; 

$target_file = $target_dir.basename($_FILES["foto"]["name"]);

$uploadOk = 1; //Flag

$fileExtesion = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

// Check if file already exists
$imageName = substr($target_file, 0, strlen($target_file)-4);
$extension = substr($target_file, -4);
$numberOfImages = 0;

while(file_exists($target_file)) {
  $numberOfImages++;
  $target_file = $imageName."(".$numberOfImages.")".$extension;;
}

// Check file size
if($_FILES["foto"]["size"] > 2097152) { // 2MB 
  $uploadOk = 0;
  echo "<h3>Essa imagem é grande demais.</h3>";
}

// Allow certain file formats
if($fileExtesion != "jpg" && $fileExtesion != "png") {
  $uploadOk = 0;
  echo "<h3>Não aceitamos esse formato de imagem.</h3>";
}

// Check if $uploadOk is ok
if($uploadOk != 0) {
  if(move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file))
    echo "<h3>Imagem salva com Sucesso.</h3>";
  else
    echo "<h3>Não foi possível salvar sua Imagem.</h3>";
}
?>
