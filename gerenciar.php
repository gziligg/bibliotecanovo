<?php
session_start();

if (!isset($_SESSION['idi'])) {
    header('Location: ../screen/log.php');
    exit();
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/gerenciar.css">
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
    <script>
        $(document).ready(function() {
        // Função para exibir os livros com base na página atual
        function displayBooks(currentPage, containerClass) {
            var books = $('.' + containerClass + ' .container-user2');
            var startIndex = (currentPage - 1) * 5;
            var endIndex = startIndex + 5;
            books.hide().slice(startIndex, endIndex).show();
        }

        // Exibir os livros iniciais
        displayBooks(1, 'container-user');

        // Calcular o número de páginas
        var totalBooks = $('.container-user2').length;
        var totalPages = Math.ceil(totalBooks / 5);

        // Gerar os links de paginação
        var pagination = $('.pagination');
        var prevLink = $('<a></a>').attr('href', '#').text('Voltar');
        pagination.append(prevLink);

        var currentPage = 1;
        var maxPage = Math.min(totalPages, 3);
        for (var i = 1; i <= maxPage; i++) {
            var link = $('<a></a>').attr('href', '#').text(i);
            pagination.append(link);
        }
        var nextLink = $('<a></a>').attr('href', '#').text('Próximo');
        pagination.append(nextLink);

        // Adicionar classe 'active' ao link da página atual
        pagination.find('a:first').addClass('active');

        // Evento de clique nos links de página
        pagination.on('click', 'a', function(event) {
            event.preventDefault();
            var totalPages = Math.ceil(totalBooks / 5);

            if ($(this).text() === 'Voltar') {
                if (currentPage > 1) {
                    currentPage--;
                }
            } else if ($(this).text() === 'Próximo') {
                if (currentPage < totalPages) {
                    currentPage++;
                }
            } else {
                currentPage = parseInt($(this).text());
            }

            // Remover links existentes
            pagination.empty();

            // Verificar o intervalo de páginas a ser exibido
            var startPage = Math.max(1, currentPage - 1);
            var endPage = Math.min(totalPages, startPage + 2);

            // Gerar os links de paginação
            var prevLink = $('<a></a>').attr('href', '#').text('Voltar');
            pagination.append(prevLink);

            for (var i = startPage; i <= endPage; i++) {
                var link = $('<a></a>').attr('href', '#').text(i);
                pagination.append(link);
            }

            var nextLink = $('<a></a>').attr('href', '#').text('Próximo');
            pagination.append(nextLink);

            // Adicionar classe 'active' ao link da página atual
            pagination.find('a').eq(currentPage - startPage + 1).addClass('active');

            displayBooks(currentPage, 'container-user');
        });
    });

    $(document).ready(function() {
        // Função para exibir os livros com base na página atual
        function displayBooks(currentPage, containerClass) {
            var books = $('.' + containerClass + ' .container-adm2');
            var startIndex = (currentPage - 1) * 5;
            var endIndex = startIndex + 5;
            books.hide().slice(startIndex, endIndex).show();
        }

        // Exibir os livros iniciais
        displayBooks(1, 'container-adm');

        // Calcular o número de páginas
        var totalBooks = $('.container-adm2').length;
        var totalPages = Math.ceil(totalBooks / 5);

        // Gerar os links de paginação
        var pagination = $('.pagination2');
        var prevLink = $('<a></a>').attr('href', '#').text('Voltar');
        pagination.append(prevLink);

        var currentPage = 1;
        var maxPage = Math.min(totalPages, 3);
        for (var i = 1; i <= maxPage; i++) {
            var link = $('<a></a>').attr('href', '#').text(i);
            pagination.append(link);
        }
        var nextLink = $('<a></a>').attr('href', '#').text('Próximo');
        pagination.append(nextLink);

        // Adicionar classe 'active' ao link da página atual
        pagination.find('a:first').addClass('active');

        // Evento de clique nos links de página
        pagination.on('click', 'a', function(event) {
            event.preventDefault();
            var totalPages = Math.ceil(totalBooks / 5);

            if ($(this).text() === 'Voltar') {
                if (currentPage > 1) {
                    currentPage--;
                }
            } else if ($(this).text() === 'Próximo') {
                if (currentPage < totalPages) {
                    currentPage++;
                }
            } else {
                currentPage = parseInt($(this).text());
            }

            // Remover links existentes
            pagination.empty();

            // Verificar o intervalo de páginas a ser exibido
            var startPage = Math.max(1, currentPage - 1);
            var endPage = Math.min(totalPages, startPage + 2);

            // Gerar os links de paginação
            var prevLink = $('<a></a>').attr('href', '#').text('Voltar');
            pagination.append(prevLink);

            for (var i = startPage; i <= endPage; i++) {
                var link = $('<a></a>').attr('href', '#').text(i);
                pagination.append(link);
            }

            var nextLink = $('<a></a>').attr('href', '#').text('Próximo');
            pagination.append(nextLink);

            // Adicionar classe 'active' ao link da página atual
            pagination.find('a').eq(currentPage - startPage + 1).addClass('active');

            displayBooks(currentPage, 'container-adm');
        });
    });
    </script>
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
                <a href="projetolei.php">Projeto leitura</a>
                <a href="reservas.php">Reservas</a>
                <a href="clublivro.php">Club do livro</a>
                <a href="logout.php">Sair</a>
            </div>
        </nav>
    </header>
    <div>
        <div class="usuarios">
            <div class="container-user">
                <div class="cont-neo">
                    <a href="addusu.php" class="neo">Adicionar user</a>
                    <form class="bun" method="GET" action="">
                        <input class="bun1" type="text" name="search" id="search" class="search-input">
                        <button class="bun2" type="submit" class="search-button"><i class="fa fa-search" aria-hidden="true"></i></button>
                    </form>
                </div>
                <?php
                $servername = "localhost";
                $username = "root";
                $password = "root";
                $dbname = "biblioteca";

                $conn = new mysqli($servername, $username, $password, $dbname);
                if ($conn->connect_error) {
                    die("Falha na conexão com o banco de dados: " . $conn->connect_error);
                }

                $sql = "SELECT * FROM pessoas";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<div class='container-user2'>";
                        echo "<div class='users'>";
                        echo "<div class='part1'>";
                        echo "<h3 style='color: #0081B8;'>" . $row["nome"] . "</h3>";
                        echo "<p style='color: #0081B8;'>" . $row["user"] . "</p>";
                        echo "</div>";
                        echo "<a class='txtba' href='edituser.php?id=" . $row["id"] . "' class='user-link'>";
                        echo "<div class='part2'>";
                        echo "<i class='fa fa-pencil' aria-hidden='true'></i>";
                        echo "</div>";
                        echo "</a>";
                        echo "</div>";
                        echo "</div>";
                    }
                }

                ?>
            </div>
            <div class="pagination"></div>
        </div>
    </div>
    <div>
        <div class="usuarios">
            <div class="container-adm">
                <div class="cont-neo">
                    <a href="addadm.php" class="neo">Adicionar admin</a>
                    <form class="bun" method="GET" action="">
                        <input class="bun1" type="text" name="search2" id="search2" class="search-input">
                        <button class="bun2" type="submit" class="search-button"><i class="fa fa-search" aria-hidden="true"></i></button>
                    </form>
                </div>
                <?php
                $servername = "localhost";
                $username = "root";
                $password = "root";
                $dbname = "biblioteca";

                $conn = new mysqli($servername, $username, $password, $dbname);
                if ($conn->connect_error) {
                    die("Falha na conexão com o banco de dados: " . $conn->connect_error);
                }

                $sql = "SELECT * FROM adm";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $livroId = $row["id"];

                        echo "<a class='txtba' href='detaluser.php?id=" . $row["id"] . "' class='user-link'>";
                        echo "<div class='container-adm2'>";
                        echo "<div class='users'>";
                        echo "<div class='part1'>";
                        echo "<h3 style='color: #0081B8;'>" . $row["nome"] . "</h3>";
                        echo "<p style='color: #0081B8;'>" . $row["usuario"] . "</p>";
                        echo "</div>";
                        echo "<a class='txtba' href='editadm.php?id=" . $row["id"] . "' class='user-link'>";
                        echo "<div class='part2'>";
                        echo "<i class='fa fa-pencil' aria-hidden='true'></i>";
                        echo "</div>";
                        echo "</a>";
                        echo "</div>";
                        echo "</div>";
                        echo "</a>";
                    }
                }

                ?>
            </div>
            <div class="pagination2"></div>
        </div>
    </div>
</body>
</html>