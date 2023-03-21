<?php
require_once 'mysql.php';
session_start();

// Connect to the database
$db = conectarBancoDados();

if(!$db){
    die("Connection error: " . mysqli_connect_error());
}

$response = array('status' => 'error', 'message' => '');
if(isset($_POST['usuario']) && isset($_POST['email']) && isset($_POST['register-password'])) {
    // Obter os dados do formulário
    $usuario=$_POST['usuario'];
    $email=preg_replace('/[^a-zA-Z0-9@._-]/','',$_POST['email']);
    $password=preg_replace('/[^a-zA-Z0-9@._-]/','',$_POST['register-password']);
    // Server-side validation
    if(!preg_match('/^[a-zA-ZáéíóúàâêôãõüçÁÉÍÓÚÀÂÊÔÃÕÜÇ ]+$/', $usuario)) {
        $response['message'] = "Coloque um nome verdadeiro igual a 'Lucas Henrique'.";
    } elseif (!preg_match('/^[a-zA-Z0-9._%+-]{1,64}@/', $email)) {
        $response['message'] = "E-mail inválido: o e-mail deve ter no mínimo 6 caracteres antes do @.";
    } elseif (!preg_match('/^(?=.*[a-zA-Z0-9._%+-])(?=.*@(gmail|hotmail|outlook)\.com).{6,}$/', $email)) {
        $response['message'] = "E-mail inválido: apenas endereços de e-mail do Gmail ou do Outlook com no mínimo 6 caracteres antes do @ são permitidos.";
    } elseif(strlen($password) < 8) {
        $response['message'] = "Senha inválida: a senha deve ter no mínimo 8 caracteres.";
    } else {
        // Hash the password
        $hash = password_hash($password, PASSWORD_DEFAULT);
        
        // Check if the email already exists in the database
        $query = "SELECT * FROM users WHERE email='$email'";
        $result = mysqli_query($db, $query);
        if(mysqli_num_rows($result) > 0) {
            $response['message'] = "O e-mail já existe.";
        } else {
            // Insert the user in the database
            $query = "INSERT INTO users (usuario, email, senha) VALUES ('$usuario', '$email', '$hash')";
            $result = mysqli_query($db, $query);
            
            if(!$result) {
                $response['message'] = "Erro ao registrar o usuário.";
            } else {
                $response['status'] = 'success';
                $response['message'] = "Seu registro foi feito com sucesso.";
            }
        }
    }
}

header('Content-Type: application/json');
echo json_encode($response);
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Expires: 0');
?>

