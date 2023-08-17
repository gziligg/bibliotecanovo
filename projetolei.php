<?php
session_start();

if (!isset($_SESSION['idi'])) {
    header('Location: ../screen/log.php');
    exit();
}

?>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $servername = "localhost";
        $username = "root";
        $password = "root";
        $dbname = "biblioteca";

        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
        die("Falha na conexão com o banco de dados: " . $conn->connect_error);
        }

        $titulo = $_POST["livro"];
        $turma = $_POST["turma"];

        $sql = "INSERT INTO clublivro (id_livro, id_turma) VALUES ('$titulo', '$turma')";

        if ($conn->query($sql) === TRUE) {
            header("Location: projetolei.php");
            exit();
        } else {
            echo "Erro ao inserir os dados: " . $conn->error;
        }
    
        $conn->close();
    }
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
                <h3>Bibli.ON</h3>
            </div>
            <div>
                <a href="menuadm.php">Detalhes</a>
                <a href="gerenciar.php">Gerenciar usuários</a>
                <a href="addlivro.php">Adicionar livro</a>
                <a style="background-color: #c5deff;" href="clubdolivro.php">Projeto leitura</a>
                <a href="reservas.php">Reservas</a>
                <a href="clublivro.php">Club do livro</a>
                <a href="logout.php">Sair</a>
            </div>
        </nav>
    </header>
    <div id="adicionar-livro-secao" class="addlivro">
        <div class="container1">
            <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>" enctype="multipart/form-data">
                <h2>Projeto leitura</h2>

                <label for="livro">Livro</label><br>
                <select style="margin-bottom: 10px;" class="in" name="livro" required>
                <?php       
                    $host = "localhost";
                    $user = "root";
                    $password = "root";
                    $database = "biblioteca";
                    
                    $conn = mysqli_connect($host, $user, $password, $database);
        
                    $sql = "SELECT * FROM livros";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        echo '<option value="">Selecione livro</option>'; 
                        while ($row = $result->fetch_assoc()) {
                            echo '<option value="' . $row["id"] . '">' . $row["titulo"] . '</option>';
                        }
                    } else {
                        echo '<option disabled>Nenhuma categoria encontrada para este evento.</option>';
                    }


                    $conn->close();
                ?>
                </select>

                <label for="turma">Turma</label><br>
                <select style="margin-bottom: 10px;" class="in" name="turma" required>
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
                            echo '<option value="' . $row["turma"] . '">' . $row["turma"] . '</option>';
                        }
                    } else {
                        echo '<option disabled>Nenhuma categoria encontrada para este evento.</option>';
                    }


                    $conn->close();
                ?>
                </select><br>

                <button class="lin" type="submit" name="cadastrar" value="Cadastrar">Cadastrar</button>
            </form>
        </div>
        <div class="container2">
            <form class="bun" method="GET" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
              <input class="bun1" type="text" name="search" id="search" class="search-input">
              <button class="bun2" type="submit" class="search-button"><i class="fa fa-search" aria-hidden="true"></i></button>
            </form>
            <table>
            <thead>
                <tr>
                <th>Livro</th>
                <th>Turma</th>
                <th>Opções</th>
                </tr>
            </thead>
            <tbody>
            <?php
              $servername = "localhost";
              $username = "root";
              $password = "root";
              $dbname = "biblioteca";

              $conn = new mysqli($servername, $username, $password, $dbname);
              if ($conn->connect_error) {
                die("Falha na conexão com o banco de dados: " . $conn->connect_error);
              }

              $search = isset($_GET['search']) ? $_GET['search'] : '';

              $sql = "SELECT * FROM clublivro WHERE id_livro LIKE '%$search%'";
              $result = $conn->query($sql);

              if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["id_livro"] . "</td>";
                    echo "<td>" . $row["id_turma"] . "</td>";
                    echo "<td class='options'><a class='fa fa-pencil-square-o ininn' href='detalhesadm.php?id=" . $row["id"] . "'></a>";
                    echo "<a id='delete-button' class='fa fa-minus-square-o ininn' href='apagar4.php?id=" . $row["id"] . "'></a></td>";
                    echo "</tr>";
                }
                } else {
                echo "<tr><td colspan='6'>Nenhum livro encontrado.</td></tr>";
                }

                $conn->close();
                ?>
            </tbody>
            </table>
        </div>
    </div>
    <script>
    const deleteButtons = document.querySelectorAll("#delete-button");

    deleteButtons.forEach(button => {
        button.addEventListener("click", function(e) {
            e.preventDefault();
            const deleteUrl = this.getAttribute('href');

            if (confirm("Tem certeza que deseja excluir este registro?")) {
                fetch(deleteUrl)
                    .then(response => response.text())
                    .then(data => {
                        location.reload();
                    })
                    .catch(error => {
                        console.error("Erro ao apagar o registro:", error);
                    });
            }
        });
    });
</script>

</body>
</html>
