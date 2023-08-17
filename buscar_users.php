<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "biblioteca";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Falha na conexão com o banco de dados: " . $conn->connect_error);
}

$turmaSelecionada = $_POST['user'];

$sql = "SELECT * FROM projetolivro WHERE user = '$turmaSelecionada'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<p>Livro: " . $row["nomelivro"] . "</p>";
    }
} else {
    echo "<p>Nenhum livro encontrado para esta turma.</p>";
}

$conn->close();
?>
