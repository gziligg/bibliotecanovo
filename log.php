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
            echo "<p class='dio'>Usuário já existe. Por favor, escolha outro usuário.</p>";
        } else {
            $query = mysqli_query($con, "SELECT * FROM pessoas WHERE email='$email'");
            if (mysqli_num_rows($query) > 0) {
                echo "<p class='dio'>Email já cadastrado. Por favor, escolha outro email.</p>";
            } else {
                $query = mysqli_query($con, "INSERT INTO pessoas (nome, user, email, senha) VALUES ('$nome', '$user', '$email', '$senha')");
            }
        }
    }
}


?>
<?php
$host = "localhost";
$user = "root";
$password = "root";
$database = "biblioteca";


$conn = mysqli_connect($host, $user, $password, $database);




if (!$conn) {
    die("Falha na conexão: " . mysqli_connect_error());
}




if (isset($_POST['logar'])) {
    $email = mysqli_real_escape_string($conn, $_POST['gmail']);
    $senha = mysqli_real_escape_string($conn, $_POST['senha']);


    $sql = "SELECT * FROM adm WHERE email='$email' AND senha='$senha'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) === 1) {
        session_start();
        $row = mysqli_fetch_assoc($result);
        echo '<p id="invalid-msg" class="dio">Login feito com sucesso.</p>';
        $_SESSION['idi'] = $row['id'];
        header('Location: ../adm/menuadm.php');
        exit();
    } else {
    
        $sql = "SELECT * FROM pessoas WHERE email='$email' AND senha='$senha'";
        $result = mysqli_query($conn, $sql);


        if (mysqli_num_rows($result) === 1) {
            session_start();
            $row = mysqli_fetch_assoc($result);
            echo '<p id="invalid-msg" class="dio">Login feito com sucesso.</p>';
            $_SESSION['nomeUsuario'] = $row['user'];
            $_SESSION['idu'] = $row['id'];
            header('Location: tela1.php');
            exit();
        } else {
            echo '<p id="invalid-msg" class="dio">Email ou senha inválidos.</p>';
        }
    }


    mysqli_close($conn);
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




    <title>Bibli.ON</title>
    <script>
        function showRegistrationForm() {
            document.getElementById("log").style.display = "none";
            document.getElementById("cad").style.display = "flex";
        }




        function showRegistrationForm() {
            document.getElementById("log").style.display = "none";
            document.getElementById("cad").style.display = "flex";
        }




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

<script>
    function togglePassword() {
        var passwordInput = document.getElementById("password");
        if (passwordInput.type === "password") {
            passwordInput.type = "text";
        } else {
            passwordInput.type = "password";
        }
    }
</script>

</head>
<body>
    <form class="loginn" id="log" method="post">
        <h2>Login</h2>
        <label>Email</label>
        <input style="background-color: rgba(255, 255, 255, 0.1);" type="email" id="username" name="gmail" placeholder="Email"><br>
        <div style="position: relative;">
    <input style="background-color: rgba(255, 255, 255, 0.1);" type="password" id="password" name="senha" placeholder="Senha">
    <span style="position: absolute; top: 50%; right: 20px; transform: translateY(-50%); cursor: pointer;" onclick="togglePassword()">
        <i class="fa fa-eye"></i>
    </span>
</div><br>
<br>
        <button type="submit" name="logar">Login</button>
        <a class="cr" href="#" onclick="showRegistrationForm()">Criar conta</a>
    </form>
    <form class="cadin" id="cad" method="post">
        <h2>Cadastro</h2>
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
                <a class="cr" href="#" onclick="document.getElementById('cad').style.display = 'none'; document.getElementById('log').style.display = 'block';">Já tenho conta</a>
            </div>
        </div>
    </form>
</body>
</html>
