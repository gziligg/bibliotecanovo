<?php
session_start();

if (!isset($_SESSION['idi'])) {
    header('Location: ../screen/log.php');
    exit();
}

?>

<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "biblioteca";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Falha na conexão com o banco de dados: " . $conn->connect_error);
}

// Obtém a quantidade de livros cadastrados
$sqlLivros = "SELECT COUNT(*) AS totalLivros FROM livros";
$resultLivros = $conn->query($sqlLivros);
$rowLivros = $resultLivros->fetch_assoc();
$totalLivros = $rowLivros["totalLivros"];

// Obtém a quantidade de usuários cadastrados
$sqlUsuarios = "SELECT COUNT(*) AS totalUsuarios FROM pessoas";
$resultUsuarios = $conn->query($sqlUsuarios);
$rowUsuarios = $resultUsuarios->fetch_assoc();
$totalUsuarios = $rowUsuarios["totalUsuarios"];

// Obtém a quantidade de livros disponíveis
$sqlDisponiveis = "SELECT SUM(disponivel) AS totalDisponiveis FROM livros";
$resultDisponiveis = $conn->query($sqlDisponiveis);
$rowDisponiveis = $resultDisponiveis->fetch_assoc();
$totalDisponiveis = $rowDisponiveis["totalDisponiveis"];

$sqlReservas = "SELECT COUNT(livro) AS totalReservas FROM reservas";
$resultReservas = $conn->query($sqlReservas);
$rowReservas = $resultReservas->fetch_assoc();
$totalReservas = $rowReservas["totalReservas"];

$conn->close();
?>

<!DOCTYPE html>
<html>  
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/menuad.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Biblioteca</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <header>
        <nav class="navigation">
            <div>
                <h3>Bibli.ON</h3></a>
            </div>
            <div>
                <a style="background-color: #c5deff;" href="menuadm.php">Detalhes</a>
                <a href="gerenciar.php">Gerenciar usuários</a>
                <a href="addlivro.php">Adicionar livro</a>
                <a href="projetolei.php">Projeto leitura</a>
                <a href="reservas.php">Reservas</a>
                <a href="clublivro.php">Club do livro</a>
                <a href="logout.php">Sair</a>

            </div>
        </nav>
    </header>
    <div id="detalhes-adm" class="">
        <div class="case1">
            <div class="usuario">
                <div class="search-box">
                    <a class="fa fa-book" aria-hidden="true"></a>
                    <h3>Livros</h3>
                    <p>cadastrados</p>
                    <p><?php echo $totalLivros; ?></p>
                </div>
            </div>
            <div class="livro_cadastrados">
                <div class="search-box">
                    <a class="fa fa-user-circle-o" aria-hidden="true"></a>
                    <h3>Usuários</h3>
                    <p>cadastrados</p>
                    <p><?php echo $totalUsuarios; ?></p>
                </div>
            </div>
            <div class="livros_disponíveis">
                <div class="search-box">
                    <a class="fa fa-times-circle" aria-hidden="true"></a>
                    <h3>Multas</h3>
                    <p>geradas</p>
                    <p>n3</p>
                </div>
            </div>
        </div>
        <div class="case2">
            <div class="multas">
                <div class="search-box2">
                    <a class="fa fa-book" aria-hidden="true"></a>
                    <h3>Livros</h3>
                    <p>disponíveis</p>
                    <p><?php echo $totalDisponiveis; ?></p>
                </div>
            </div>
            <div class="generos">
                <div class="search-box2">
                    <a class="fa fa-tags" aria-hidden="true"></a>
                    <h3>Gêneros</h3>
                    <p>cadastrados</p>
                    <p>32</p>
                </div>
            </div>
            <div class="livros_emprestados">
                <div class="search-box2">
                    <a class="fa fa-tasks" aria-hidden="true"></a>
                    <h3>Livros</h3>
                    <p>emprestados</p>
                    <p><?php echo $totalReservas; ?></p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
