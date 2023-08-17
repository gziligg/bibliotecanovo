<?php
session_start();

date_default_timezone_set('America/Sao_Paulo');

if (!isset($_SESSION['idu'])) {
    header('Location: log.php');
    exit();
}

if (isset($_GET['id'])) {
    $livroId = $_GET['id'];

    // Faça a conexão com o banco de dados
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "biblioteca";
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verifique se a conexão foi bem-sucedida
    if ($conn->connect_error) {
        die("Falha na conexão com o banco de dados: " . $conn->connect_error);
    }

    // Obtenha o ID do usuário atual
    $userId = $_SESSION['idu'];

    // Verifique se a quantidade do livro é igual a 0
    $verificarQuantidadeQuery = "SELECT disponivel FROM livros WHERE id = $livroId";
    $verificarQuantidadeResult = $conn->query($verificarQuantidadeQuery);

    // Verifique se a consulta retornou algum resultado
    if ($verificarQuantidadeResult && $verificarQuantidadeResult->num_rows > 0) {
        $livro = $verificarQuantidadeResult->fetch_assoc();
        $disponivel = $livro['disponivel'];

        if ($disponivel == 0) {
            // O livro não está disponível (quantidade = 0)
            $livroDisponivel = false; // Defina como false para exibir a mensagem "Livro não disponível"

        } else {
            
            $livroDisponivel = true; // Defina como false para exibir a mensagem "Livro já disponível"

            $verificarReservaQuery = "SELECT * FROM livros_solicitados WHERE livro_id = $livroId AND user_id = $userId";
            $verificarReservaResult = $conn->query($verificarReservaQuery);

            // Verifique se a consulta retornou algum resultado
            if ($verificarReservaResult && $verificarReservaResult->num_rows > 0) {
                
            }
        }
    } else {
        // Livro não encontrado
        $livroDisponivel = false;
    }

    // Defina as variáveis de sessão correspondentes ao status da reserva do livro e disponibilidade do livro
    $_SESSION['livro_disponivel'] = $livroDisponivel;

    header("Location: detalhes.php?id=$livroId");
    exit();

    $conn->close();
}
?>
