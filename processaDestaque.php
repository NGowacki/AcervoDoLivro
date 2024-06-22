<?php
include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $livro_id = $_POST['livro_id'];
    $substitute_id = $_POST['substitute_id'] ?? null;

    $sql_count = "SELECT COUNT(*) AS count FROM destaques";
    $result_count = $conn->query($sql_count);
    $row_count = $result_count->fetch_assoc();

    if ($row_count['count'] < 3) {
        $sql_insert = "INSERT INTO destaques (livro) VALUES ($livro_id)";
        if ($conn->query($sql_insert) !== TRUE) {
            echo "Erro ao adicionar destaque: " . $conn->error;
        }
    } else {
        if ($substitute_id) {
            $sql_update = "UPDATE destaques SET livro = $livro_id WHERE id = $substitute_id";
            if ($conn->query($sql_update) !== TRUE) {
                echo "Erro ao substituir destaque: " . $conn->error;
            }
        }
    }
}

$conn->close();
header("Location: gerenciarDestaques.php");
exit;
?>
