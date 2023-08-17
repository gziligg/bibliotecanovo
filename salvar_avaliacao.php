<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "biblioteca";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['rating']) && isset($_POST['livroId']) && isset($_POST['userId'])) {
        $rating = $_POST['rating'];
        $livroId = $_POST['livroId'];
        $userId = $_POST['userId'];

        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("Falha na conexão com o banco de dados: " . $conn->connect_error);
        }

        $checkQuery = "SELECT * FROM avaliacoes WHERE livro_id = $livroId AND user_id = $userId";
        $checkResult = $conn->query($checkQuery);

        if ($checkResult && $checkResult->num_rows > 0) {

            $updateQuery = "UPDATE avaliacoes SET avaliacao = $rating WHERE livro_id = $livroId AND user_id = $userId";
            if ($conn->query($updateQuery) === TRUE) {
                echo "Avaliação atualizada com sucesso!";
            } else {
                echo "Erro ao atualizar a avaliação: " . $conn->error;
            }
        } else {

            $insertQuery = "INSERT INTO avaliacoes (livro_id, user_id, avaliacao) VALUES ($livroId, $userId, $rating)";
            if ($conn->query($insertQuery) === TRUE) {
                echo "Avaliação salva com sucesso!";
            } else {
                echo "Erro ao enviar a avaliação: " . $conn->error;
            }
        }

        $conn->close();
    }
}
?>
