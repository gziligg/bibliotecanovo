<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "biblioteca";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Falha na conexão com o banco de dados: " . $conn->connect_error);
}

$turmaSelecionada = $_POST['turma'];

$sql = "SELECT * FROM clublivro WHERE id_turma = '$turmaSelecionada'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $idlivro = $row["id_livro"];

        $sql = "SELECT * FROM livros WHERE id = '$idlivro'";
        $result2 = $conn->query($sql);

        echo "<ul>";

        if($result2->num_rows > 0) {
            while($livros = $result2->fetch_assoc()) {
                echo "<div class='livro'>";
                echo "<img class='livro-imagem' src='" . $livros["imagem"] . "' alt='" . $livros["titulo"] . "'>";
                echo "<h3>Título: " . $livros["titulo"] . "</h3>";
                echo "</div>";
            }
        
        echo "</ul>";
        }
    }
} else {
    echo "<p>Nenhum livro encontrado para esta turma.</p>";
}

$conn->close();
?>
