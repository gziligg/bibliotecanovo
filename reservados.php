<?php
session_start();

date_default_timezone_set('America/Sao_Paulo');

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
    <h1 class="logo">Livros reservados</h1>
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
        $sql = "SELECT livro FROM reservas WHERE user = $userId";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            
            while ($livro = $result->fetch_assoc()) {
                $livrosid = $livro["livro"];
                
                $sql = "SELECT * FROM livros WHERE id = $livrosid";
                $result2 = $conn->query($sql);

                if($result2 && $result2->num_rows > 0) {
                    echo "<ul>";
                
                    while ($row = $result2->fetch_assoc()) {
                        echo "<div class='livro'>";
                        echo "<img class='livro-imagem' src='" . $row["imagem"] . "' alt='" . $row["titulo"] . "'>";
                        echo "<h3>Título: " . $row["titulo"] . "</h3>";
                        echo "</div>";
                    }
                    echo "</ul>"; 
                }
            }
        }

        $conn->close();
    ?>
    </div>
</body>
</html>
