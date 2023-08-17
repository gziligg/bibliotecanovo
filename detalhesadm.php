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
  <link rel="stylesheet" type="text/css" href="../css/adm1.css">
  <title>Detalhes do Livro</title>
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

$id = $_GET['id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $titulo = $_POST["titulo"];
  $autor = $_POST["autor"];
  $novaQuantidade = $_POST["quantidade"];
  $genero = $_POST["genero"];
  $descricao = $_POST["descricao"];

  // Verificar se um novo arquivo de imagem foi enviado
  if ($_FILES["imagem"]["name"]) {
    $imagem = $_FILES["imagem"]["name"];
    $temp = $_FILES["imagem"]["tmp_name"];
    $destino = "images/" . $imagem;
    move_uploaded_file($temp, $destino);
  } else {
    // Caso contrário, manter a imagem existente
    $sql_imagem = "SELECT imagem FROM livros WHERE id = '$id'";
    $result_imagem = $conn->query($sql_imagem);
    $row_imagem = $result_imagem->fetch_assoc();
    $imagem = $row_imagem["imagem"];
  }

  // Buscar a quantidade atual do livro
  $sql_quantidade = "SELECT quantidade, disponivel FROM livros WHERE id = '$id'";
  $result_quantidade = $conn->query($sql_quantidade);
  $row_quantidade = $result_quantidade->fetch_assoc();
  $quantidadeAtual = $row_quantidade["quantidade"];
  $disponivelAtual = $row_quantidade["disponivel"];

  // Calcular a diferença entre a nova quantidade e a quantidade atual
  $diferencaQuantidade = $novaQuantidade - $quantidadeAtual;

  // Atualizar a quantidade e a quantidade disponível no banco de dados
  $novaDisponivel = $disponivelAtual + $diferencaQuantidade;

  $imagemNome = $_FILES["imagem"]["name"];
  $imagemDir = "images/";
  $imagemNome = preg_replace('/[^a-zA-Z0-9]/', '', $imagemNome);
  $imagemCaminho = $imagemDir . $imagemNome;
  if (!is_dir($imagemDir)) {
    mkdir($imagemDir, 0777, true);
  }

  move_uploaded_file($_FILES["imagem"]["tmp_name"], $imagemCaminho);

  $sql_update = "UPDATE livros SET titulo = '$titulo', autor = '$autor', quantidade = '$novaQuantidade', genero = '$genero', descricao = '$descricao', imagem = '$imagemCaminho', disponivel = '$novaDisponivel' WHERE id = '$id'";
  $conn->query($sql_update);

  // Redirecionar de volta para a página de detalhes do livro
  header("Location: detalhesadm.php?id=$id");
  exit();
}

$sql = "SELECT * FROM livros WHERE id = '$id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  $row = $result->fetch_assoc();
  $titulo = $row["titulo"];
  $autor = $row["autor"];
  $quantidade = $row["quantidade"];
  $genero = $row["genero"];
  $descricao = $row["descricao"];
  $imagem = $row["imagem"];
  ?>

  <h2 style="margin-right: 80px; margin-left: 20px;">Editar</h2>

  <form method="POST" action="detalhesadm.php?id=<?php echo $id; ?>" enctype="multipart/form-data">
    <label for="titulo">Título do Livro</label><br>
    <input class="in" type="text" name="titulo" value="<?php echo $titulo; ?>" required><br>

    <label for="autor">Autor</label><br>
    <input class="in" type="text" name="autor" value="<?php echo $autor; ?>" required><br>

    <label for="quantidade">Quantidade</label><br>
    <input class="in" type="number" name="quantidade" value="<?php echo $quantidade; ?>" required><br>

    <label for="genero">Gênero</label><br>
    <input class="in" type="text" name="genero" value="<?php echo $genero; ?>" required><br>

    <label for="descricao">Descrição</label><br>
    <textarea class="ino" name="descricao" required><?php echo $descricao; ?></textarea><br>

    <label class="picture" for="picture__input" tabIndex="0">
        <span class="picture__image"></span>
    </label>

    <input type="file" name="imagem" id="picture__input"><br>
    <div class="gengen">
      <button class="lin" type="submit">Editar</button>
      <a href="addlivro.php">Voltar</a>
    </div>
  </form>

<?php
} else {
  echo "<p>Nenhum livro encontrado.</p>";
}

$conn->close();
?>

</body>
<script>
    const inputFile = document.querySelector("#picture__input");
    const pictureImage = document.querySelector(".picture__image");
    const pictureImageTxt = "Choose an image";
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
</script>
</html>