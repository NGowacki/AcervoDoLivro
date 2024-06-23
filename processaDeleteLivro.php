<?php
include 'connection.php'; // Inclui o arquivo de conexão ao banco de dados

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Consulta para deletar o livro
    $sql = "DELETE FROM Livros WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "Livro deletado com sucesso!";
        header("Location: index.php");
    } else {
        echo "Erro ao deletar livro: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "ID do livro não fornecido!";
}
?>
