<?php
require_once 'mysql.php';
session_start();
if(isset($_POST['login']) && isset($_POST['password'])) {
    $email = $_POST['login'];
    $password = $_POST['password'];

    if(empty($email) || empty($password)) {
        $response = array(
            'status' => 'error',
            'message' => 'Por favor, preencha todos os campos.'
        );
    } else {
        $conn = conectarBancoDados();
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $resultados = $stmt->get_result();

        if ($resultados->num_rows > 0) {
            $row = $resultados->fetch_assoc();
            $hashed_password = $row["senha"];

            if (password_verify($password, $hashed_password)) {
                // Cria um token aleatório
                $token = bin2hex(random_bytes(32));
                // Armazena o token no banco de dados
                $stmt = $conn->prepare("UPDATE users SET token = ? WHERE email = ?");
                $stmt->bind_param("ss", $token, $email);
                $stmt->execute();
                // Cria um cookie para armazenar o token
                setcookie('token', $token, time() + (2 * 60 * 60), '/dashboard', 'https://dhardware.rf.gd', true, true);
                $response = array(
                    'status' => 'success',
                    'message' => 'Login realizado com sucesso!',
                    'token' => $token
                );
            } else {
                $response = array(
                    'status' => 'error',
                    'message' => 'Senha incorreta.'
                );
            }
        } else {
            $response = array(
                'status' => 'error',
                'message' => 'Usuário não encontrado.'
            );
        }
        $conn->close();
    }
} else {
    $response = array(
        'status' => 'error',
        'message' => 'Por favor, preencha todos os campos.'
    );
}

header('Content-Type: application/json');
echo json_encode($response);

?>

