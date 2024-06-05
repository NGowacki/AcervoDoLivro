<?php
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $dataNascimento = $_POST['dataNascimento'];
    $nacionalidade = $_POST['nacionalidade'];
    $bibliografia = $_POST['bibliografia'];

    // Tratar a data para o formato correto
    $dataNascimento = date("Y-m-d", strtotime($dataNascimento));

    // Inserir dados no banco de dados
    $sql = "INSERT INTO Autores (nome, dataNascimento, nacionalidade, Bibliografia)
            VALUES ('$nome', '$dataNascimento', '$nacionalidade', '$bibliografia')";

    if ($conn->query($sql) === TRUE) {
        echo "Novo autor cadastrado com sucesso!";
    } else {
        echo "Erro: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>