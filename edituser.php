<?php
session_start();


if (!isset($_SESSION['idi'])) {
    header('Location: ../screen/log.php');
    exit();
}


$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "biblioteca";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Falha na conexão com o banco de dados: " . $conn->connect_error);
}


$id = $_GET['id'];


// Verifique se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupere os dados do formulário e atualize as variáveis
    $nome = $_POST["nome"];
    $user = $_POST["user"];
    $email = $_POST["email"];
    $senha = $_POST["senha"];


    // Atualize os dados do usuário no banco de dados
    $sql_update = "UPDATE pessoas SET nome = '$nome', user = '$user', email = '$email', senha = '$senha' WHERE id = '$id'";
    $conn->query($sql_update);
}


$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "biblioteca";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Falha na conexão com o banco de dados: " . $conn->connect_error);
}
    $sql = "SELECT * FROM pessoas WHERE id = '$id'";
    $result = $conn->query($sql);


    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $nome = $row["nome"];
        $user = $row["user"];
        $email = $row["email"];
        $senha = $row["senha"];
    }


$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/edit.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Biblioteca</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .pagination {
            margin-top: 10px;
        }


        .pagination a {
            display: inline-block;
            padding: 8px 16px;
            text-decoration: none;
            color: #0081B8;
            border: 1px solid #0081B8;
            margin-right: 5px;
        }


        .pagination a.active {
            background-color: #0081B8;
            color: white;
        }


        .pagination2 {
            margin-top: 10px;
        }


        .pagination2 a {
            display: inline-block;
            padding: 8px 16px;
            text-decoration: none;
            color: #0081B8;
            border: 1px solid #0081B8;
            margin-right: 5px;
        }


        .pagination2 a.active {
            background-color: #0081B8;
            color: white;
        }
    </style>
</head>
<body>
    <header>
        <nav class="navigation">
            <div>
                <h3>Bibli.ON</h3>
            </div>
            <div>
                <a href="menuadm.php">Detalhes</a>
                <a style="background-color: #c5deff;" href="menuadm.php">Gerenciar usuários</a>
                <a href="addlivro.php">Adicionar livro</a>
                <a href="reservas.php">Reservas</a>
                <a href="projetolei.php">Projeto leitura</a>
            </div>
        </nav>
    </header>
    <div>
        <center>
        <div class="usuarios">
            <div class="container-edit">
        <h2 style="margin-right: 30px; margin-left: 20px; color: #c5deff">Editar</h2>
        <form method="POST" action="edituser.php?id=<?php echo $id; ?>" enctype="multipart/form-data">
        <br>
        <label for="titulo" style="color: #c5deff">Nome</label><br>
                    <input class="in" type="text" name="nome" style="color: #0081B8" value= "<?php echo $nome; ?>" required><br>


                    <label for="autor" style="color: #c5deff">User</label><br>
                    <input class="in" type="text" name="user" style="color: #0081B8" value="<?php echo $user; ?>" required><br>


                    <label for="quantidade" style="color: #c5deff">Email</label><br>
                    <input class="in" type="text" name="email" style="color: #0081B8" value="<?php echo $email; ?>" required><br>


                    <label for="genero" style="color: #c5deff">Senha</label><br>
                    <input class="in" type="text" name="senha" style="color: #0081B8" value="<?php echo $senha; ?>" required><br>
       
                    <a class="lin" href="gerenciar.php" style="color: #0081B8"  >Editar</button></a>
                    <button class="lin" style="color: #0081B8" type="submit">Excluir</button>
    </center>


        </form>
    </div>
    <div>
    </div>
</body>
</html>