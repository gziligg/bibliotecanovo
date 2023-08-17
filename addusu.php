<?php
session_start();

if (!isset($_SESSION['idi'])) {
    header('Location: ../screen/log.php');
    exit();
}

?>

<?php
$host = "localhost";
$user = "root";
$password = "root";
$database = "biblioteca";


$con = mysqli_connect($host, $user, $password, $database);


if (isset($_POST['cadastrar'])) {
    $nome = $_POST['nome'];
    $user = $_POST['users'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $senha_check = $_POST['senha_check'];


    if ($senha_check != $senha) {
        die("Senhas não correspondem");
    } else {
        $query = mysqli_query($con, "SELECT * FROM pessoas WHERE user='$user'");
        if (mysqli_num_rows($query) > 0) {
            echo "<p class='dio'>Adm já existe. Por favor, escolha outro usuário.</p>";
        } else {
            $query = mysqli_query($con, "SELECT * FROM pessoas WHERE email='$email'");
            if (mysqli_num_rows($query) > 0) {
                echo "<p class='dio'>Email já cadastrado. Por favor, escolha outro email.</p>";
            } else { 
                
                $query = mysqli_query($con, "INSERT INTO pessoas (nome, user, email, senha) VALUES ('$nome', '$user', '$email', '$senha')");

                if ($query) {
                    header("Location: gerenciar.php");
                    exit();
                } else {
                    echo "<p class='dio'>Erro ao cadastrar o usuario. Por favor, tente novamente.</p>";
                }
            }
        }
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="../css/login8.css">
    <link rel="icon" type="image/png" href="https://diretoaoponto-tech.com.br/icon-target.png"/>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">




    <title>Virtual library</title>
    <script>
        setTimeout(function() {
            var invalidMsg = document.getElementById("invalid-msg");
            if (invalidMsg) {
                var opacity = 1;
                var interval = setInterval(function() {
                    if (opacity <= 0) {
                        clearInterval(interval);
                        invalidMsg.style.display = "none";
                    } else {
                        invalidMsg.style.opacity = opacity;
                        opacity -= 0.1;
                    }
                }, 50);
            }
        }, 1500);
    </script>
</head>
<body>
    <form class="cadin" method="post">
        <h2>Cadastro usuário</h2>
        <div class="non1">
            <div>
                <label>Nome</label>
                <input style="background-color: rgba(255, 255, 255, 0.1);" type="text" name="nome" placeholder="Nome" required><br>
                <label>Usuário</label>
                <input style="background-color: rgba(255, 255, 255, 0.1);" type="text" name="users" placeholder="Usuário" required><br>
                <label>Email</label>
                <input style="background-color: rgba(255, 255, 255, 0.1);" type="email" name="email" placeholder="Email" required><br>
            </div>
            <div class="non2">
            <label>Turma</label>
                <select style="background-color: rgba(255, 255, 255, 0.1);" class name="" id="">
                        <?php       
                            $host = "localhost";
                            $user = "root";
                            $password = "root";
                            $database = "biblioteca";
                            
                            
                            $conn = mysqli_connect($host, $user, $password, $database);
                
                            $sql = "SELECT * FROM turmas";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                echo '<option value="">Selecione turma</option>'; 
                                while ($row = $result->fetch_assoc()) {
                                    echo '<option value="' . $row["id"] . '">' . $row["turma"] . '</option>';
                                }
                            } else {
                                echo '<option disabled>Nenhuma categoria encontrada para este evento.</option>';
                            }


                    $conn->close();
                ?>
                </select><br>
                <label>Senha</label>
                <input style="background-color: rgba(255, 255, 255, 0.1);" type="password" name="senha" placeholder="Senha" required><br>
                <label>Repetir senha</label>
                <input style="background-color: rgba(255, 255, 255, 0.1);" type="password" name="senha_check" placeholder="Senha" required><br>
                <button type="submit" name="cadastrar">Cadastrar</button>
                <a class="cr" href="gerenciar.php">Voltar</a>
        </div>
    </form>
</body>
</html>
