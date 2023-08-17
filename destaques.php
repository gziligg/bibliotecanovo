<?php
session_start();

if (!isset($_SESSION['idu'])) {
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
    <link rel="stylesheet" type="text/css" href="../css/destaques.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Biblioteca</title>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>

    </style>
</head>
<body>
<header>
        <div class="logo">
            <h1 class="sp">Destaques</h1>
        </div>
        <div style="display: flex;">
            <div class="search-box2">
                <li class="search-btn2">
                    <a href="tela1.php" class="fa fa-arrow-left dropbtn3" aria-hidden="true"></a>
                </li>
            </div>
        </div>
    </header>
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


            $sql = "SELECT m.livro_id, AVG(m.media) AS media_avaliacoes 
                    FROM media_avaliacoes m 
                    GROUP BY m.livro_id 
                    ORDER BY media_avaliacoes DESC 
                    LIMIT 14";

            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $livroId = $row["livro_id"];
                    $mediaAvaliacoes = $row["media_avaliacoes"];

                    $livroSql = "SELECT * FROM livros WHERE id = '$livroId'";
                    $livroResult = $conn->query($livroSql);

                    if ($livroResult->num_rows > 0) {
                        $livroRow = $livroResult->fetch_assoc();
                        echo "<a class='txtba' href='detalhes.php?id=" . $livroRow["id"] . "' class='livro-link'>";
                        echo "<div class='livro'>";
                        echo "<img src='" . $livroRow["imagem"] . "' alt='" . $livroRow["titulo"] . "' class='livro-imagem'>";
                        echo "<h3>" . $livroRow["titulo"] . "</h3>";
                        echo "<p>" . $livroRow["genero"] . "</p>";
                        echo "<p>Estrelas: " . number_format($mediaAvaliacoes, 1) . "</p>";
                        echo "</div>";
                        echo "</a>";
                    }
                }
            } else {
                echo "<p>Nenhum livro em destaque encontrado.</p>";
            }

            $conn->close();
        ?>
    </div>
</body>
</html>
