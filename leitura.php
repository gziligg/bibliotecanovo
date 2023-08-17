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
    <title>Clube do Livro</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <header>
        <div class="logo">
            <h1 class="sp">Projeto Leitura</h1>
        </div>
        <div style="display: flex;">
            <div style="margin-right: 30px; background-color: ">
                <select name="turma" id="turma">
                    <option value="">Selecione a turma</option>
                    <?php
                    $servername = "localhost";
                    $username = "root";
                    $password = "root";
                    $dbname = "biblioteca";

                    $conn = new mysqli($servername, $username, $password, $dbname);
                    if ($conn->connect_error) {
                        die("Falha na conexão com o banco de dados: " . $conn->connect_error);
                    }

                    $sql = "SELECT DISTINCT id_turma FROM clublivro";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row["id_turma"] . "'>" . $row["id_turma"] . "</option>";
                        }
                    }

                    $conn->close();
                    ?>
                </select>
            </div>
            <div class="search-box2">
                <li class="search-btn2">
                    <a href="tela1.php" class="fa fa-arrow-left dropbtn3" aria-hidden="true"></a>
                </li>
            </div>
        </div>
    </header>
    <div class="livros-container">
        <div class="livros"></div>
    </div>
    <script>
        $(document).ready(function() {
            $('#turma').change(function() {
                var selectedTurma = $(this).val();
                
                if (selectedTurma !== '') {
                    // Fazer uma requisição AJAX para buscar os livros da turma selecionada
                    $.ajax({
                        url: 'buscar_livros.php', // Arquivo PHP que fará a busca no banco de dados
                        method: 'POST',
                        data: { turma: selectedTurma },
                        success: function(response) {
                            // Atualizar a seção "livros" com os livros encontrados
                            $('.livros').html(response);
                        }
                    });
                }
            });
        });
    </script>
</body>
</html>
