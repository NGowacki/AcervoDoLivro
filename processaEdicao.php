<?php
include 'connection.php'; // Inclui o arquivo de conexão ao banco de dados

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $titulo = $_POST['titulo'];
    $anoPublic = $_POST['anoPublic'];
    $genero = $_POST['genero'];
    $estoque = $_POST['estoque'];
    $autor_id = $_POST['autor_id'];

    // Atualiza a imagem se um novo arquivo foi enviado
    if (!empty($_FILES['imgFile']['name'])) {
        $imgName = $_FILES['imgFile']['name'];
        $imgTmpName = $_FILES['imgFile']['tmp_name'];
        $imgSize = $_FILES['imgFile']['size'];
        $imgError = $_FILES['imgFile']['error'];
        $imgType = $_FILES['imgFile']['type'];

        // Verifica se há erros no upload
        if ($imgError === 0) {
            $imgExt = strtolower(pathinfo($imgName, PATHINFO_EXTENSION));
            $allowed = array('jpg', 'jpeg', 'png');

            if (in_array($imgExt, $allowed)) {
                $imgNameNew = uniqid('', true) . "." . $imgExt;
                $imgDestination = 'img/' . $imgNameNew;
                move_uploaded_file($imgTmpName, $imgDestination);
            } else {
                echo "Tipo de arquivo não permitido!";
                exit;
            }
        } else {
            echo "Erro ao fazer upload da imagem!";
            exit;
        }

        // Consulta para atualizar o livro incluindo a nova imagem
        $sql = "UPDATE Livros SET titulo=?, anoPublic=?, genero=?, estoque=?, imgName=?, autor_id=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssisii", $titulo, $anoPublic, $genero, $estoque, $imgNameNew, $autor_id, $id);
    } else {
        // Consulta para atualizar o livro sem alterar a imagem
        $sql = "UPDATE Livros SET titulo=?, anoPublic=?, genero=?, estoque=?, autor_id=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssiis", $titulo, $anoPublic, $genero, $estoque, $autor_id, $id);
    }

    if ($stmt->execute()) {
        echo "Livro atualizado com sucesso!";
        header("Location: index.php");
    } else {
        echo "Erro ao atualizar livro: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Método de requisição inválido!";
}
?>
