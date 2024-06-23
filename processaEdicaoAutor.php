<?php
include 'connection.php'; // Inclui o arquivo de conexão ao banco de dados

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtém os dados do formulário
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $dataNascimento = $_POST['dataNascimento'];
    $nacionalidade = $_POST['nacionalidade'];
    $bibliografia = $_POST['bibliografia'];

    $sql = "UPDATE autores SET nome = ?, dataNascimento = ?, nacionalidade = ?, bibliografia = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $nome, $dataNascimento, $nacionalidade, $bibliografia, $id);

    if ($stmt->execute()) {
        echo "Autor atualizado com sucesso!";
        header("Location: meusAutores.php");
        exit();
    } else {
        echo "Erro ao atualizar o autor: " . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>
