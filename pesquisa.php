<?php
session_start();

if (!isset($_SESSION['idi'])) {
    header('Location: ../screen/log.php');
    exit();
}

?>

<?php
// Verificar se o parâmetro 'search' foi enviado
if (isset($_POST['search'])) {
    $searchQuery = $_POST['search'];

    // Execute a consulta para pesquisar o nome na tabela "adm"
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "biblioteca";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Falha na conexão com o banco de dados: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM adm WHERE nome LIKE '%$searchQuery%'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $livroId = $row["id"];

            echo "<a class='txtba' href='detaluser.php?id=" . $row["id"] . "' class='user-link'>";
            echo "<div class='container-adm2'>";
            echo "<div class='users'>";
            echo "<div class='part1'>";
            echo "<h3 style='color: #0081B8;'>"$row["nome"] . "</h3>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
            echo "</a>";
        }
    } else {
        echo "<p>Nenhum resultado encontrado.</p>";
    }
}