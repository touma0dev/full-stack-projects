<?php
// Array com as perguntas e opções de resposta
$perguntas = array(
    "Qual é a sua cor preferida?" => array(
        "Azul", "Verde", "Vermelho"
    ),
    "Você prefere praia ou montanha?" => array(
        "Praia", "Montanha", "Não tenho preferência"
    ),
    "Qual é o seu hobby favorito?" => array(
        "Ler", "Assistir filmes", "Praticar esportes"
    ),
    "Qual é o seu animal favorito?" => array(
        "Cachorro", "Gato", "Outro"
    ),
    "Você prefere doce ou salgado?" => array(
        "Doce", "Salgado", "Não tenho preferência"
    ),
    "Qual é o seu estilo de música favorito?" => array(
        "Rock", "Pop", "Rap"
    ),
    "Qual é o seu esporte favorito?" => array(
        "Futebol", "Basquete", "Outro"
    ),
    "Você prefere café ou chá?" => array(
        "Café", "Chá", "Não gosto de nenhum dos dois"
    ),
    "Qual é a sua estação do ano favorita?" => array(
        "Verão", "Inverno", "Outra"
    ),
    "Você prefere livros ou filmes?" => array(
        "Livros", "Filmes", "Não tenho preferência"
    ),
);
?>

<?php
session_start();
require_once '../mysql.php';

// Verifica se o usuário está logado


// Obtém o ID do usuário a partir do token
$token = $_SESSION['token'];
$conn = conectarBancoDados();
$stmt = $conn->prepare('SELECT id FROM users WHERE token = ?');
$stmt->bind_param('s', $token);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$user_id = $user['id'];

// Verifica se o formulário foi submetido
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Obtém as respostas do formulário
  $respostas = array();
  $indice_pergunta = 1;
  foreach ($perguntas as $pergunta => $opcoes) {
    if (isset($_POST["pergunta{$indice_pergunta}"])) {
      $resposta = $_POST["pergunta{$indice_pergunta}"];
      $respostas[] = $resposta;
    } else {
      $respostas[] = "";
    }
    $indice_pergunta++;
  }

  // Insere as respostas na tabela de respostas
  $stmt = $conn->prepare('INSERT INTO respostas (user_id, resposta0, resposta1, resposta2, resposta3, resposta4, resposta5, resposta6, resposta7, resposta8, resposta9) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
  $stmt->bind_param('issssssssss', $user_id, ...$respostas);
  $stmt->execute();
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Formulário de perguntas</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
  <div class="container">
    <form method="POST">
      <h2>Formulário de perguntas</h2>
      <table class="table">
        <?php $indice_pergunta = 1; ?>
        <?php foreach ($perguntas as $pergunta => $opcoes) : ?>
          <tr>
            <td><?= $pergunta; ?></td>
            <td>
              <?php foreach ($opcoes as $opcao) : ?>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="pergunta<?= $indice_pergunta; ?>" value="<?= $opcao; ?>" required>
                  <label class="form-check-label"><?= $opcao; ?></label>
                </div>
              <?php endforeach; ?>
            </td>
          </tr>
          <?php $indice_pergunta++; ?>
        <?php endforeach; ?>
      </table>
      <button type="submit" class="btn btn-primary">Enviar</button>
    </form>
  </div>
  
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
