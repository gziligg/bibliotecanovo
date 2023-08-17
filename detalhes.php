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
    <link rel="stylesheet" type="text/css" href="../css/detalhes7.css">
    <title>Detalhes do Livro</title>
    <style>
    </style>
</head>
<body>
    <?php
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "biblioteca";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Falha na conexão com o banco de dados: " . $conn->connect_error);
    }

    if (isset($_GET['id'])) {
        $livroId = $_GET['id'];
        $sql = "SELECT * FROM livros WHERE id = $livroId";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $livro = $result->fetch_assoc();
            echo "<div class='livros-container'>";
            echo "<div class='livros-container4'>";
            echo "<img src='" . $livro["imagem"] . "' alt='" . $livro["titulo"] . "' style='width: 300px; margin-top: 20px; height='200px'>";
            echo "<div class='livros-container3'>";
            echo "<p style='margin-top: 80px;'>Descrição: " . $livro["descricao"] . "</p>";
            echo "<a href='livros_reservados.php?id=" . $livroId . "' class='benn' style='position: relative; top: 170px;'>Ver disponibilidade</a>";
            echo "<a href='tela1.php' class='benn' style= 'position: relative; top: 170px; left: 20px;'>Voltar</a>";
            echo "</div>";
            echo "</div>";
            echo "<div class='livros-container2'>";
            echo "<h2>" . $livro["titulo"] . "</h2>";
            echo "<p>" . $livro["autor"] . "</p>";
            echo "<p>Quantidade: " . $livro["disponivel"] . "</p>";
            echo "<p id='media-avaliacao'></p>";
            echo "<ul class='avaliacao'>";
            echo "<li class='star-icon' data-avaliacao='1'></li>";
            echo "<li class='star-icon' data-avaliacao='2'></li>";
            echo "<li class='star-icon' data-avaliacao='3'></li>";
            echo "<li class='star-icon' data-avaliacao='4'></li>";
            echo "<li class='star-icon' data-avaliacao='5'></li>";
            echo "</ul>";
            echo "</div>";
            echo "</div>";

            if ($livro["disponivel"] == 0) {
                echo "<a href='livros_reservados.php?id=" . $livroId . "' class='benn' style='position: relative; top: 610px;'>Alugar</a>";
            }

            if (isset($_SESSION['livro_disponivel'])) {
                if ($_SESSION['livro_disponivel']) {
                    echo "<span class='sucesso'>Livro disponível</span>";
                } else {
                    echo "<span class='erro'>Livro indisponível</span>";
                }
                unset($_SESSION['livro_disponivel']); // Limpar a variável de sessão
            }

            function atualizarMediaAvaliacoes() {
                global $conn, $livroId;
                $mediaQuery = "SELECT AVG(avaliacao) AS media, COUNT(*) AS total FROM avaliacoes WHERE livro_id = $livroId"; 
                $mediaResult = $conn->query($mediaQuery);
                if ($mediaResult && $mediaResult->num_rows > 0) {
                    $mediaRow = $mediaResult->fetch_assoc();
                    $media = $mediaRow['media'];
                    $totalAvaliacoes = $mediaRow['total'];
                    if ($media !== null) {
                        $media = round($media, 1);
                        $insertQuery = "INSERT INTO media_avaliacoes (livro_id, media) VALUES ($livroId, $media) ON DUPLICATE KEY UPDATE media = $media";
                        $insertResult = $conn->query($insertQuery);
                        return $media;
                    }
                }
                return "N/A";
            }

            echo "<script>
                function exibirMediaAvaliacoes() {
                    var mediaAvaliacao = document.getElementById('media-avaliacao');
                    var media = '" . atualizarMediaAvaliacoes() . "';
                    mediaAvaliacao.textContent = ' Avaliação: ' + media + ' estrelas';
                }
                exibirMediaAvaliacoes();
                
                function exibirMensagem() {
                    var sucessoSpan = document.querySelector('.sucesso');
                    var erroSpan = document.querySelector('.erro');
                    
                    if (sucessoSpan) {
                        sucessoSpan.style.display = 'inline-block';
                        setTimeout(function() {
                            sucessoSpan.style.display = 'none';
                        }, 2000); // Exibe por 2 segundos
                    }
                    
                    if (erroSpan) {
                        erroSpan.style.display = 'inline-block';
                        setTimeout(function() {
                            erroSpan.style.display = 'none';
                        }, 2000); // Exibe por 2 segundos
                    }
                }
                exibirMensagem();
            </script>";
        } else {
            echo "<p>Livro não encontrado.</p>";
        }
    } else {
        echo "<p>Nenhum livro selecionado.</p>";
    }

    $conn->close();
    ?>

    <script>
        var stars = document.querySelectorAll('.star-icon');

        function enviarAvaliacao(avaliacao) {
            var livroId = <?php echo $livroId; ?>;
            var userId = <?php echo $_SESSION['idu']; ?>;

            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'salvar_avaliacao.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    console.log(xhr.responseText);
                    exibirMediaAvaliacoes();
                }
            };
            xhr.send('rating=' + avaliacao + '&livroId=' + livroId + '&userId=' + userId);
        }

        document.addEventListener('click', function(e) {
            var classStar = e.target.classList;
            if (classStar.contains('star-icon')) {
                var avaliacao = e.target.getAttribute('data-avaliacao');
                enviarAvaliacao(avaliacao);

                stars.forEach(function(star) {
                    star.classList.remove('ativo');
                });
                classStar.add('ativo');
                console.log(avaliacao);
            }
        });
    </script>
</body>
</html>
