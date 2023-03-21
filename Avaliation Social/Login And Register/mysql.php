<?php
function conectarBancoDados() {
    $databasename = 'epiz_33610278_aut';
    $senha = 'VY5TbAYcajF3';
    $usuario = 'epiz_33610278';
    $link = 'sql212.epizy.com';

    $conn = new mysqli($link, $usuario, $senha, $databasename);

    if ($conn->connect_error) {
        die("Conexão falhou: " . $conn->connect_error);
    }

    return $conn;
}
?>
