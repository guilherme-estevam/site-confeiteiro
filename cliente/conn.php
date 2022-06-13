<?php
$servername = "sql306.epizy.com";
$username = "epiz_31560357";
$password = "rjO74c5WDR9d";
$dbname = "epiz_31560357_guilherme"; 

$conn = mysqli_connect($servername, $username, $password);

if (!$conn) {
  die("Falha na Conexão: " . mysqli_connect_error());
}
// echo "Conectado com Sucesso <br><br>";

// Selecionando Banco
if (!mysqli_select_db($conn,$dbname)) {
  echo "Não foi possível selecionar base de dados \"$dbname\": " . mysqli_error($conn);
}
?>
