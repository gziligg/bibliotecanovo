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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = $_POST["titulo"];
    $autor = $_POST["autor"];
    $quantidade = $_POST["quantidade"];
    $descricao = $_POST["descricao"];
    $genero = $_POST["genero"];

    $imagemNome = $_FILES["imagem"]["name"];
    $imagemDir = "images/";

    // Remover espaços, acentos e cedilhas do nome da imagem
    $imagemNome = preg_replace('/[^a-zA-Z0-9]/', '', $imagemNome);
    $imagemCaminho = $imagemDir . $imagemNome;

    if (!is_dir($imagemDir)) {
        mkdir($imagemDir, 0777, true);
    }

    move_uploaded_file($_FILES["imagem"]["tmp_name"], $imagemCaminho);

    $sql = "INSERT INTO livros (titulo, autor, quantidade, disponivel, descricao, genero, imagem) VALUES ('$titulo', '$autor', '$quantidade', '$quantidade', '$descricao', '$genero', '$imagemCaminho')";

    $conn->query($sql);

    // Redirecionar para a mesma página
    header("Location: ".$_SERVER['PHP_SELF']);
    exit();
}

$result = $conn->query("SELECT * FROM livros");

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
                <a style="background-color: #c5deff;" href="addlivro.php">Adicionar livro</a>
                <a href="projetolei.php">Projeto leitura</a>
                <a href="reservas.php">Reservas</a>
                <a href="clublivro.php">Club do livro</a>
                <a href="logout.php">Sair</a>
            </div>
        </nav>
    </header>
    <div id="adicionar-livro-secao" class="addlivro">
        <div class="container1">
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
            
                $titulo = $_POST["titulo"];
                $autor = $_POST["autor"];
                $quantidade = $_POST["quantidade"];
                $descricao = $_POST["descricao"];
                $genero = $_POST["genero"];

                $imagemNome = $_FILES["imagem"]["name"];
                $imagemDir = "images/";
                $imagemNome = preg_replace('/[^a-zA-Z0-9]/', '', $imagemNome);
                $imagemCaminho = $imagemDir . $imagemNome;

                if (!is_dir($imagemDir)) {
                    mkdir($imagemDir, 0777, true);
                }

                move_uploaded_file($_FILES["imagem"]["tmp_name"], $imagemCaminho);

                $sql = "INSERT INTO livros (titulo, autor, quantidade, disponivel, descricao, genero, imagem) VALUES ('$titulo', '$autor', '$quantidade', '$quantidade', '$descricao', '$genero', '$imagemCaminho')";

                $conn->query($sql);

                $conn->close();
            }
            ?>

            <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>" enctype="multipart/form-data">
                <h2>Cadastro de Livros</h2>
                <label for="titulo">Título do Livro</label><br>
                <input style="margin-bottom: 10px;" class="in" type="text" name="titulo" required>

                <label for="autor">Autor</label><br>
                <input style="margin-bottom: 10px;" class="in" type="text" name="autor" required>

                <label for="quantidade">Quantidade</label><br>
                <input style="margin-bottom: 10px;" class="in" type="number" name="quantidade" required>

                <label for="genero">Gênero</label><br>
                <select style="margin-bottom: 10px;" class="in" name="genero" required>
                    <option value="">Selecione um gênero</option>
                    <?php
                    $generos = array(
                        'Ficção Científica',
                        'Fantasia',
                        'Romance',
                        'Mistério',
                        'Suspense',
                        'Terror/Horror',
                        'Aventura',
                        'Policial',
                        'Histórico',
                        'Biografia',
                        'Autobiografia',
                        'Ficção Histórica',
                        'Literatura Clássica',
                        'Drama',
                        'Comédia',
                        'Poesia',
                        'Ensaio',
                        'Filosofia',
                        'Autoajuda',
                        'Negócios/Empreendedorismo',
                        'Ciências',
                        'Psicologia',
                        'Autoconhecimento',
                        'Religião/Espiritualidade',
                        'Contos',
                        'Crônicas',
                        'Teatro',
                        'Educação',
                        'Viagens',
                        'Culinária',
                        'HQ/Quadrinhos',
                        'Infantojuvenil'
                    );

                    foreach ($generos as $genero) {
                        echo "<option value='$genero'>$genero</option>";
                    }
                    ?>
                </select>

                <label for="descricao">Descrição</label><br>
                <textarea class="ino" name="descricao" required></textarea><br>

                <label class="picture" for="picture__input" tabIndex="0">
                    <span class="picture__image"></span>
                </label>

                <label for="imagem"></label><br>
                <input type="file" name="imagem" id="picture__input" required><br>

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
                        <th>Título do Livro</th>
                        <th>Autor</th>
                        <th>Quantidade</th>
                        <th>Disponível</th>
                        <th>Gênero</th>
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

                    $sql = "SELECT * FROM livros WHERE titulo LIKE '%$search%'";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["titulo"] . "</td>";
                            echo "<td>" . $row["autor"] . "</td>";
                            echo "<td class='itn'>" . $row["quantidade"] . "</td>";
                            echo "<td class='itn'>" . $row["disponivel"] . "</td>";
                            echo "<td>" . $row["genero"] . "</td>";
                            echo "<td class='options'>
                                    <a class='fa fa-pencil-square-o ininn' href='detalhesadm.php?id=" . $row["id"] . "'></a>
                                    <a class='fa fa-minus-square-o ininn' data-id='" . $row["id"] . "' onclick='confirmDelete(" . $row["id"] . ")'></a>
                                  </td>";
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
        const inputFile = document.querySelector("#picture__input");
        const pictureImage = document.querySelector(".picture__image");
        const pictureImageTxt = "Inserir imagem";
        pictureImage.innerHTML = pictureImageTxt;

        inputFile.addEventListener("change", function (e) {
            const inputTarget = e.target;
            const file = inputTarget.files[0];

            if (file) {
                const reader = new FileReader();

                reader.addEventListener("load", function (e) {
                    const readerTarget = e.target;

                    const img = document.createElement("img");
                    img.src = readerTarget.result;
                    img.classList.add("picture__img");

                    pictureImage.innerHTML = "";
                    pictureImage.appendChild(img);
                });

                reader.readAsDataURL(file);
            } else {
                pictureImage.innerHTML = pictureImageTxt;
            }
        });

        function confirmDelete(id) {
            const confirmMessage = "Tem certeza que deseja excluir este livro?";
            if (confirm(confirmMessage)) {
                fetch(`apagar.php?id=${id}`)
                    .then(response => response.text())
                    .then(data => {
                        location.reload();
                    })
                    .catch(error => {
                        console.error("Erro ao apagar o livro:", error);
                    });
            }
        }
    </script>
</body>
</html>
