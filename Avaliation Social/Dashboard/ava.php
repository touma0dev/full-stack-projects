<?php
require_once '../mysql.php';
session_start();

// Verifica se o token está presente no cookie
if (isset($_COOKIE['token'])) {
    $token = $_COOKIE['token'];

    $conn = conectarBancoDados();
    $stmt = $conn->prepare("SELECT * FROM users WHERE token = ?");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $resultados = $stmt->get_result();

    if ($resultados->num_rows > 0) {
        // Verifica se o email do usuário está validado
        $row = $resultados->fetch_assoc();
        $nome = $row['usuario'];
        $email = $row['email'];
        $avaliacao = $row['avalicao'];
        $link_text = $avaliacao ? 'Avaliação já feita' : '<a style="text-decoration:none;color: #1f1c2e;" href="https://dhardware.rf.gd/dashboard/ava.php">Iniciar</a>';

        // Redireciona o usuário para a página desejada, caso já tenha feito a avaliação
        if ($avaliacao == 1) {
            header('Location: https://dhardware.rf.gd/dashboard/');
            exit();
        }

    } else {
        // Informação não encontrada, redireciona para a página de formulário
        header("Location: https://dhardware.rf.gd/formulario");
        exit();
    }

    $conn->close();
} else {
    // Cookie não encontrado, redireciona para a página de formulário
    header("Location: https://dhardware.rf.gd/formulario");
    exit();
}
?>
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

<!DOCTYPE html>
<html lang="ptBR">
  <head>
    <link rel="stylesheet" href="ava.css">
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Ava-Social</title>
  </head>

  <body>
    <nav class="navbar">
      <h1 class="logo"><span class="app-icon"></span>SociaRate</h1>
      <ul class="user">
        <div class="avatar">
          <svg
            id="avatar"
            fill="#000000"
            width="33px"
            height="33px"
            viewBox="0 0 32 32"
            xmlns="http://www.w3.org/2000/svg"
          >
            <defs>
              <style>
                .cls-1 {
                  fill: none;
                }
              </style>
            </defs>
            <path
              id="_inner-path_"
              data-name="<inner-path>"
              class="cls-1"
              d="M8.0071,24.93A4.9958,4.9958,0,0,1,13,20h6a4.9959,4.9959,0,0,1,4.9929,4.93,11.94,11.94,0,0,1-15.9858,0ZM20.5,12.5A4.5,4.5,0,1,1,16,8,4.5,4.5,0,0,1,20.5,12.5Z"
            ></path>
            <path
              d="M26.7489,24.93A13.9893,13.9893,0,1,0,2,16a13.899,13.899,0,0,0,3.2511,8.93l-.02.0166c.07.0845.15.1567.2222.2392.09.1036.1864.2.28.3008.28.3033.5674.5952.87.87.0915.0831.1864.1612.28.2417.32.2759.6484.5372.99.7813.0441.0312.0832.0693.1276.1006v-.0127a13.9011,13.9011,0,0,0,16,0V27.48c.0444-.0313.0835-.0694.1276-.1006.3412-.2441.67-.5054.99-.7813.0936-.08.1885-.1586.28-.2417.3025-.2749.59-.5668.87-.87.0933-.1006.1894-.1972.28-.3008.0719-.0825.1522-.1547.2222-.2392ZM16,8a4.5,4.5,0,1,1-4.5,4.5A4.5,4.5,0,0,1,16,8ZM8.0071,24.93A4.9957,4.9957,0,0,1,13,20h6a4.9958,4.9958,0,0,1,4.9929,4.93,11.94,11.94,0,0,1-15.9858,0Z"
            ></path>
            <rect
              id="_Transparent_Rectangle_"
              data-name="<Transparent Rectangle>"
              class="cls-1"
              width="32"
              height="32"
            ></rect>
          </svg>
        </div>
        <li name="usuario" class="nome" id="nome">
          <a href="">  <?php echo $nome ?></a>
        </li>

        <li class="logout">
          <b
            style="margin-left: 1em"
            class="logout"
            onclick="logout()"
            title="Clique aqui para sair"
            id="logout"
          >
            <svg
              id="avatar"
              fill="#000000"
              height="30px"
              width="30px"
              version="1.1"
              xmlns="http://www.w3.org/2000/svg"
              xmlns:xlink="http://www.w3.org/1999/xlink"
              viewBox="0 0 490.3 490.3"
              xml:space="preserve"
            >
            <script>
                    function logout() {
                        document.cookie = "token=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/dashboard;";
                        window.location.href = "https://dhardware.rf.gd/formulario";
                    }
                </script>
              <g>
                <g>
                  <path
                    d="M0,121.05v248.2c0,34.2,27.9,62.1,62.1,62.1h200.6c34.2,0,62.1-27.9,62.1-62.1v-40.2c0-6.8-5.5-12.3-12.3-12.3
s-12.3,5.5-12.3,12.3v40.2c0,20.7-16.9,37.6-37.6,37.6H62.1c-20.7,0-37.6-16.9-37.6-37.6v-248.2c0-20.7,16.9-37.6,37.6-37.6h200.6
c20.7,0,37.6,16.9,37.6,37.6v40.2c0,6.8,5.5,12.3,12.3,12.3s12.3-5.5,12.3-12.3v-40.2c0-34.2-27.9-62.1-62.1-62.1H62.1
C27.9,58.95,0,86.75,0,121.05z"
                  ></path>
                  <path
                    d="M385.4,337.65c2.4,2.4,5.5,3.6,8.7,3.6s6.3-1.2,8.7-3.6l83.9-83.9c4.8-4.8,4.8-12.5,0-17.3l-83.9-83.9
c-4.8-4.8-12.5-4.8-17.3,0s-4.8,12.5,0,17.3l63,63H218.6c-6.8,0-12.3,5.5-12.3,12.3c0,6.8,5.5,12.3,12.3,12.3h229.8l-63,63
C380.6,325.15,380.6,332.95,385.4,337.65z"
                  ></path>
                </g>
              </g></svg>
          </b>
        </li>
      </ul>
    </nav>
    <div class="warning">
      <h4>
        Por favor, preencha o formulário com calma e atenção. Lembre-se de que
        cada usuário só pode enviar um formulário.
      </h4>
    </div>
 
<?php
session_start();
require_once '../mysql.php';

// Verifica se o usuário está logado
if (isset($_COOKIE['token'])) {
    $token = $_COOKIE['token'];

    // Obtém o email do usuário a partir do token da sessão atual
    $conn = conectarBancoDados();
    $stmt = $conn->prepare('SELECT email FROM users WHERE token = ?');
    $stmt->bind_param('s', $token);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $email = $user['email'];

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
        try {
            // Insere as respostas na tabela de respostas
            $stmt = $conn->prepare('INSERT INTO respostas (email, resposta0, resposta1, resposta2, resposta3, resposta4, resposta5, resposta6, resposta7, resposta8, resposta9) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
            $stmt->bind_param('sssssssssss', $email, ...$respostas);
            $stmt->execute();
            
            // Atualiza a coluna "avaliacao" da tabela "users" com o valor 1
            $stmt = $conn->prepare('UPDATE users SET avalicao = 1 WHERE email = ?');
            $stmt->bind_param('s', $email);
            $stmt->execute();
            
            // Redireciona o usuário para a página desejada após 2 segundos
            echo "<script>
                    function submitForm() {
                        setTimeout(function() {
                            window.location.href = 'https://dhardware.rf.gd/dashboard/';
                        }, 2);
                    }
                    submitForm();
                  </script>";
            
        } catch(Exception $e) {
            echo "Ocorreu um erro ao inserir as respostas: " . $e->getMessage();
        }
    }
}
?>

<form id="myForm" onsubmit="return submitForm()" method="post">
	<h2>Formulário de perguntas</h2>
	<table>
		<?php $indice_pergunta = 1; ?>
		<?php foreach ($perguntas as $pergunta => $opcoes) : ?>
			<tr>
				<td style="text-align:center;"><?= $pergunta; ?></td>
				<td>
					<?php foreach ($opcoes as $opcao) : ?>
						<label>
							<input type="radio" name="pergunta<?= $indice_pergunta; ?>" value="<?= $opcao; ?>" required>
							<?= $opcao; ?>
						</label>
					<?php endforeach; ?>
				</td>
			</tr>
			<?php $indice_pergunta++; ?>
		<?php endforeach; ?>
	</table>
    <a hreft="https://dhardware.rf.gd/dashboard/">
  <button type="submit" class="flex" id="submitButton">Enviar</button>
</a>
  <div class="loader" style="display: none;">
    <span class="dot"></span> 
    <span class="dot"></span>
    <span class="dot"></span>
  </div>
</form>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
<?php 
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Expires: 0');
?>
