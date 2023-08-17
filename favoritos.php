<?php
session_start();

if (!isset($_SESSION['nomeUsuario'])) {
    header('Location: log.php');
    exit();
}

$nomeUsuario = $_SESSION['nomeUsuario'];
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/reserva2.css">
    <title>Carrinho</title>
</head>
<body>
    <h1 class="favoritos">Favoritos</h1>
    <div class="livros-container">
    <?php
        $servername = "localhost";
        $username = "root";
        $password = "root";
        $dbname = "biblioteca";

        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("Falha na conexão com o banco de dados: " . $conn->connect_error);
        }

        $userId = $_SESSION['idu'];
        $sql = "SELECT livros.*, carrinho.* FROM carrinho INNER JOIN livros ON carrinho.id_livro = livros.id WHERE carrinho.id_pessoa = $userId";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            echo "<ul>";
            while ($livro = $result->fetch_assoc()) {
                echo "<div class='livro'>";
                echo "<img class='livro-imagem' src='" . $livro["imagem"] . "' alt='" . $livro["titulo"] . "'>";
                echo "<h3>Título: " . $livro["titulo"] . "</h3>";
                echo "<p>Gênero: " . $livro["genero"] . "</p>";
                echo "</div>";
                
            }
            echo "</ul>";
        } else {
            echo "<p>Nenhum livro reservado.</p>";
        }

        $conn->close();
    ?>
    </div>
</body>
</html>
