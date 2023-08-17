<?php
session_start();

if (!isset($_SESSION['idu'])) {
    header('Location: log.php');
    exit();
}

if (isset($_POST['livroId'])) {
    $livroId = $_POST['livroId'];
    $nomeUsuario = $_SESSION['idu'];

    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "biblioteca";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Falha na conexão com o banco de dados: " . $conn->connect_error);
    }

    $sqlVerificar = "SELECT * FROM carrinho WHERE id_livro = '$livroId' AND id_pessoa = '$nomeUsuario'";
    $resultado = $conn->query($sqlVerificar);

    if ($resultado->num_rows > 0) {
        $sqlRemover = "DELETE FROM carrinho WHERE id_livro = '$livroId' AND id_pessoa = '$nomeUsuario'";

        if ($conn->query($sqlRemover) === TRUE) {
            echo 'Livro removido dos favoritos';
        } else {
            echo 'Erro ao remover o livro do cfavorito: ' . $conn->error;
        }
    } else {
       
        $sqlInserir = "INSERT INTO carrinho (id_livro, id_pessoa) VALUES ('$livroId', '$nomeUsuario')";

        if ($conn->query($sqlInserir) === TRUE) {
            echo 'Livro adicionado aos favoritos';
        } else {
            echo 'Erro ao adicionar o livro ao carrinho: ' . $conn->error;
        }
    }

    $conn->close();
}
?>
