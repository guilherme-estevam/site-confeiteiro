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
  <form class="row g-3 p-5" action="create.php" method="post" enctype="multipart/form-data">
    <?php echo '<input type="hidden" name="idBolos" value='.$_GET["id"].'>'?>
    <div class="col-md-3">
      <label for="clientInput" class="form-label">Seu Nome</label>
      <input type="text" class="form-control" id="clientInput" name="cliente" placeholder="Fulano de Tal" required>
    </div>
    <div class="col-md-3">
      <label for="emailInput" class="form-label">Seu Email</label>
      <input type="email" class="form-control" id="emailInput" name="email" placeholder="fulano@gmail.com" required>
    </div>
    <div class="col-md-3">
      <label for="phoneInput" class="form-label">Seu Telefone</label>
      <input type="text" class="form-control" id="phoneInput" name="telefone" placeholder="85912345678" required>
    </div>
    <div class="col-md-3">
      <label for="whatsappInput" class="form-label">Seu Whatsapp</label>
      <input type="text" class="form-control" id="whatsappInput" name="whatsapp" placeholder="85912345678" required>
    </div>
    <div class="col-md-12">
      <label for="textArea" class="form-label">Escreva aqui detalhes da sua Mensagem</label>
      <textarea class="form-control" id="textArea" name="mensagem" rows="6" placeholder=
"Exemplos: 
O que gostou no bolo
O que quer mudar
Qual o tema do bolo desejado
Descrição do que quer no topo do bolo
Observações Gerais"></textarea>
    </div>
    <div class="col-md-12">
      <label for="imageInput" class="form-label">Envie uma Imagem de referência se preferir</label>
      <input type="file" class="form-control" id="imageInput" name="foto" placeholder="Insira uma Imagem">
    </div>
    <div class="col-12">
      <button type="submit" class="btn btn-primary">Enviar Mensagem</button>
    </div>
  </form>
  </div>
</body>
</html>
