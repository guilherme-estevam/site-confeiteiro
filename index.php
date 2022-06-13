<html>
<head>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
  <title>CRUD de Bolos</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <style>
    body {background: rgb(0,219,255); background: linear-gradient(90deg, rgba(0,219,255,1) 20%, rgba(188,246,255,1) 50%, rgba(0,212,255,1) 80%);}
  </style>
</head>
<body>
  <div style="text-align: center;width: 100%;padding-top: 5%;">
    <button type="button" class="btn btn-success btn-lg" data-bs-toggle="modal" data-bs-target="#createModal">Adicionar Bolo</button>
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
          header('Content-type: text/html; charset=utf-8');

          include 'conn.php';

          $sql = "SELECT * FROM `final-bolos` ORDER BY idBolos";
          
          $result = mysqli_query($conn, $sql);
          
          if (!$result) {
              die("Falha na Execução da Consulta: " . $sql ."<br>" .
              mysqli_error($conn));
          }
          
          if (mysqli_num_rows($result) == 0) {
              echo "Não foram encontradas linhas, nada para mostrar <br>";
          }
          
          while ($row = mysqli_fetch_assoc($result)) {
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
              echo "<td><button type='button' class='btn btn-info' data-bs-toggle='modal' data-bs-target='#updateModal' onclick ='openModal(String($idBolos))'>Editar</button></td>";
          }
          
          mysqli_free_result($result);
        ?>
      </tbody>
    </table>
  </div>

  <!-- Update Modal -->
  <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="updateModalLabel">Atualizar Bolo</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id=updateForm action="update.php" method="post" enctype="multipart/form-data" onkeypress="return event.keyCode != 13;">
          <div class="modal-body">
            <div class="mb-3">
              <label for="imageInput" class="form-label">Foto</label>
              <input type="file" class="form-control" id="imageInput" name="foto" placeholder="Insira uma Imagem" required>
            </div>
            <div class="mb-3">
              <label for="descriptionInput" class="form-label">Descrição</label>
              <input type="text" class="form-control" id="descriptionInput" name="descricao" placeholder="Escreva a Descrição" required>
            </div>
            <div class="mb-3">
              <label for="valueInput" class="form-label">Valor</label>
              <input type="text" class="form-control" id="valueInput" name="valor" placeholder="Escolha o Valor" required>
            </div>
            <div class="mb-3">
              <label for="numInput" class="form-label">Número de Fatias</label>
              <input type="text" class="form-control" id="numInput" name="fatias" placeholder="Verifique o Número de Fatias" required>
            </div>
            <div class="mb-3">
              <div class="col dropdown-center">
                <button class="btn btn-primary dropdown-toggle" type="button" id="dropdown2" data-bs-toggle="dropdown" aria-expanded="false">
                  Indique a Categoria
                </button>
                <ul id="updateList" class="dropdown-menu" aria-labelledby="dropdown2">
                  <li><button type="button" class="btn btn-outline-primary dropdown-item" onclick ="updateCategory(0, 'update')">Aniversário</button></li>
                  <li><button type="button" class="btn btn-outline-primary dropdown-item" onclick ="updateCategory(1, 'update')">Confeitado</button></li>
                  <li><button type="button" class="btn btn-outline-primary dropdown-item" onclick ="updateCategory(2, 'update')">Especial</button></li>
                  <li><button type="button" class="btn btn-outline-primary dropdown-item active" onclick ="updateCategory(3, 'update')">Simples</button></li>
                </ul>
              </div>
              <input type="hidden" id="categoryUpdateInput" name="categoria" value="3">
            </div>
            <input type="hidden" id="idBoloUpdate" name="idBolos" value="">
          </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary" onclick="update()">Atualizar</button>
          </form>
          <form id="deleteForm" action="delete.php" method="post">
            <input type="hidden" id="idBoloDelete" name="idBolos" value="">
            <button type="submit" class="btn btn-danger" onclick="deleteCake()">Deletar</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Create Modal -->
  <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="createModalLabel">Adicionar Bolo</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="create.php" method="post" enctype="multipart/form-data">
          <div class="modal-body">
            <div class="mb-3">
              <label for="imageInput" class="form-label">Foto</label>
              <input type="file" accept="image/png, image/jpeg" class="form-control" id="imageInput" name="foto" placeholder="Insira uma Imagem" required>
            </div>
            <div class="mb-3">
              <label for="descriptionInput" class="form-label">Descrição</label>
              <input type="text" class="form-control" id="descriptionInput" name="descricao" placeholder="Escreva a Descrição" required>
            </div>
            <div class="mb-3">
              <label for="valueInput" class="form-label">Valor</label>
              <input type="text" class="form-control" id="valueInput" name="valor" placeholder="Escolha o Valor" required>
            </div>
            <div class="mb-3">
              <label for="numInput" class="form-label">Número de Fatias</label>
              <input type="text" class="form-control" id="numInput" name="fatias" placeholder="Verifique o Número de Fatias" required>
            </div>
            <div class="mb-3">
              <div class="col dropdown-center">
                <button class="btn btn-primary dropdown-toggle" type="button" id="dropdown2" data-bs-toggle="dropdown" aria-expanded="false">
                  Indique a Categoria
                </button>
                <ul id="createList" class="dropdown-menu" aria-labelledby="dropdown2">
                  <li><button type="button" class="btn btn-outline-primary dropdown-item" onclick ="updateCategory(0, 'create')">Aniversário</button></li>
                  <li><button type="button" class="btn btn-outline-primary dropdown-item" onclick ="updateCategory(1, 'create')">Confeitado</button></li>
                  <li><button type="button" class="btn btn-outline-primary dropdown-item" onclick ="updateCategory(2, 'create')">Especial</button></li>
                  <li><button type="button" class="btn btn-outline-primary dropdown-item active" onclick ="updateCategory(3, 'create')">Simples</button></li>
                </ul>
              </div>
            </div>
            <input type="hidden" id="categoryCreateInput" name="categoria" value="3">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primary">Adicionar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</body>
<script>
  var lastId;

  function openModal(idBolos) {
    lastId = idBolos;
  }

  function update() {
    document.getElementById("idBoloUpdate").value = lastId;
  }

  function deleteCake() {
    document.getElementById("idBoloDelete").value = lastId;
    document.getElementById("deleteForm").submit();
  }

  function updateCategory(categoryNumber, type) {
    let elements = [];
    if(type == 'create') {
      elements = document.getElementById("createList").children;
      document.getElementById("categoryCreateInput").value = categoryNumber;
    } else if(type == 'update') {
      elements = document.getElementById("updateList").children;
      document.getElementById("categoryUpdateInput").value = categoryNumber;
    }

    for (let index = 0; index < elements.length; index++) {
      let element = elements[index];
      element.firstElementChild.className = "btn btn-outline-primary dropdown-item";

      if(index === categoryNumber)
        element.firstElementChild.className = "btn btn-outline-primary dropdown-item active";
    }
  }
</script>
</html>
