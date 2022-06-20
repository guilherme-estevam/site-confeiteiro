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
    <div class="row align-items-center" >
      <div class="col">
        <h1>Mensagem dos Clientes</h1>
      </div>
    </div>
  </div>
  <div style="margin: 2% 3% 5% 3%;">
    <table class="table table-dark table-striped table-hover align-middle">
        <thead>
          <tr>
            <th scope="col">Nome</th>
            <th scope="col">Email</th>
            <th scope="col">Telefone</th>
            <th scope="col">N° WhatsApp</th>
            <th scope="col">Mensagem</th>
            <th scope="col">Status Mensagem</th>
            <th scope="col">Data Recebimento</th>
            <th scope="col">Data Resposta</th>
            <th scope="col">Finalização</th>
            <th scope="col">Editar Atendimento</th>
          </tr>
        </thead>
        <tbody>
          <?php
            header('Content-type: text/html; charset=utf-8');

            include '../utils/conn.php';

            $sql = "SELECT `final-mensagens`.idMensagens as idMensagens, cliente, email, telefone, whatsapp, mensagem, 
            `final-atendimento`.idAtendimento as idAtendimento, status, dataRecebimento, dataResposta, finalizacao 
            FROM `final-mensagens`, `final-atendimento` 
            WHERE `final-mensagens`.idMensagens = `final-atendimento`.idMensagens";

            $result = mysqli_query($conn, $sql);

            if(!$result)
              die("Falha na Execução da Consulta");

            if(mysqli_num_rows($result) == 0)
              echo "<h4>Não existem Mensagens no momento</h4><br>";

            while($row = mysqli_fetch_assoc($result)) {
                $idMensagens=$row["idMensagens"];
                $idAtendimento=$row["idAtendimento"];
                $cliente=$row["cliente"];
                $email=$row["email"];
                $telefone=$row["telefone"];
                $whatsapp=$row["whatsapp"];
                $mensagem=$row["mensagem"] ?? "Sem Mensagem";
                $status=$row["status"];
                $dataRecebimento=$row["dataRecebimento"];
                $dataResposta=$row["dataResposta"] ?? "Não Respondido";
                $finalizacao=$row["finalizacao"] ?? "Não Finalizado";

                echo '<tr>';
                echo '<td>'.$cliente.'</td>';
                echo '<td>'.$email.'</td>';
                echo '<td>'.$telefone.'</td>';
                echo '<td>'.$whatsapp.'</td>';
                echo "<td><button type='button' class='btn btn-info' onclick ='messageChoosen(String($idMensagens))'>Visualizar Mensagem</button></td>";
                echo '<td>'.$status.'</td>';
                echo '<td>'.$dataRecebimento.'</td>';
                echo '<td>'.$dataResposta.'</td>';
                echo '<td>'.$finalizacao.'</td>';
                echo "<td><button type='button' class='btn btn-info' data-bs-toggle='modal' data-bs-target='#updateModal' onclick ='openModal(String($idAtendimento))'>Editar</button></td>";
                echo '</tr>';
            }
            
            mysqli_free_result($result);
          ?>
        </tbody>
      </table>
    </div>
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
          <input type="hidden" id="idAtendimentoUpdate" name="idAtendimento" value="">
          <div class="modal-body">
            <div class="mb-3">
              <div class="col dropdown">
                <button class="btn btn-primary dropdown-toggle" type="button" id="dropdown1" data-bs-toggle="dropdown" aria-expanded="false">
                  Indique o Status
                </button>
                <ul id="statusList" class="dropdown-menu" aria-labelledby="dropdown1">
                  <li><button type="button" class="btn btn-outline-primary dropdown-item" onclick ="updateDropdown(0, 'status')">Respondida Email</button></li>
                  <li><button type="button" class="btn btn-outline-primary dropdown-item" onclick ="updateDropdown(1, 'status')">Respondida WhatsApp</button></li>
                  <li><button type="button" class="btn btn-outline-primary dropdown-item" onclick ="updateDropdown(2, 'status')">Respondida Email e WhatsApp</button></li>
                  <li><button type="button" class="btn btn-outline-primary dropdown-item active" onclick ="updateDropdown(3, 'status')">Não Respondida</button></li>
                </ul>
              </div>
              <input type="hidden" id="statusInput" name="status" value="3">
            </div>
            <div class="mb-3">
              <div class="col dropdown">
                <button class="btn btn-primary dropdown-toggle" type="button" id="dropdown2" data-bs-toggle="dropdown" aria-expanded="false">
                  Indique a Finalização
                </button>
                <ul id="finishingList" class="dropdown-menu" aria-labelledby="dropdown2">
                  <li><button type="button" class="btn btn-outline-primary dropdown-item" onclick ="updateDropdown(0, 'finalizacao')">Com Venda</button></li>
                  <li><button type="button" class="btn btn-outline-primary dropdown-item" onclick ="updateDropdown(1, 'finalizacao')">Sem Venda</button></li>
                  <li><button type="button" class="btn btn-outline-primary dropdown-item active" onclick ="updateDropdown(2, 'finalizacao')">Não Finalizado</button></li>
                </ul>
              </div>
              <input type="hidden" id="finalizacaoInput" name="finalizacao" value="2">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primary" onclick="update()">Atualizar</button>
        </form>
            <form id="deleteForm" action="delete.php" method="post">
              <input type="hidden" id="idAtendimentoDelete" name="idAtendimento" value="">
              <button type="submit" class="btn btn-danger" onclick="deleteAttendance()">Deletar</button>
            </form>
          </div>
      </div>
    </div>
  </div>
</body>
<script>
var lastId;

function openModal(idAtendimento) {
  lastId = idAtendimento;
}

function update() {
  document.getElementById("idAtendimentoUpdate").value = lastId;
}

function deleteAttendance() {
  document.getElementById("idAtendimentoDelete").value = lastId;
}

function messageChoosen(idMensagens) {
  window.location.href = "./message.php?id="+idMensagens;
}

function updateDropdown(number, type) {
  let elements = [];
  if(type == 'status') {
    elements = document.getElementById("statusList").children;
    document.getElementById("statusInput").value = number;
  } else if(type == 'finalizacao') {
    elements = document.getElementById("finishingList").children;
    document.getElementById("finalizacaoInput").value = number;
  }

  for (let index = 0; index < elements.length; index++) {
    let element = elements[index];
    element.firstElementChild.className = "btn btn-outline-primary dropdown-item";

    if(index === number)
      element.firstElementChild.className = "btn btn-outline-primary dropdown-item active";
  }
}
</script>
</html>
