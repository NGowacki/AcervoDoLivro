<?php
include 'connection.php'; // Inclui o arquivo de conexão ao banco de dados

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Consulta para deletar o livro
    $sql = "DELETE FROM autores WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "Autor deletado com sucesso!";
        header("Location: meusAutores.php");
    } else {
        echo "Erro ao deletar autor: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "ID do autor não fornecido!";
}
?>
