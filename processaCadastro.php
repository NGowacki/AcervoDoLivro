<?php
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $titulo = $_POST['titulo'];
    $anoPublic = $_POST['anoPublic'];
    $genero = $_POST['genero'];
    $estoque = $_POST['estoque'];
    $autor_id = $_POST['autor_id'];

    // Processar o upload da imagem
    $target_dir = "img/";
    $target_file = $target_dir . basename($_FILES["imgFile"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Verificar se o arquivo é uma imagem real
    $check = getimagesize($_FILES["imgFile"]["tmp_name"]);
    if($check !== false) {
        $uploadOk = 1;
    } else {
        echo "O arquivo não é uma imagem.";
        $uploadOk = 0;
    }

    // Verificar se o arquivo já existe e renomear se necessário
    $new_file_name = uniqid() . '.' . $imageFileType;
    $target_file = $target_dir . $new_file_name;

    // Verificar tamanho do arquivo
    if ($_FILES["imgFile"]["size"] > 500000) {
        echo "Desculpe, o arquivo é muito grande.";
        $uploadOk = 0;
    }

    // Permitir apenas certos formatos de arquivo
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
        echo "Desculpe, apenas arquivos JPG, JPEG, PNG & GIF são permitidos.";
        $uploadOk = 0;
    }

    // Verificar se $uploadOk está definido como 0 por um erro
    if ($uploadOk == 0) {
        echo "Desculpe, seu arquivo não foi enviado.";
    // Se tudo estiver ok, tentar fazer o upload do arquivo
    } else {
        if (move_uploaded_file($_FILES["imgFile"]["tmp_name"], $target_file)) {
            $imgName = $new_file_name;

            // Tratar a data para o formato correto
            $anoPublic = date("Y-m-d", strtotime($anoPublic));

            // Inserir dados no banco de dados
            $sql = "INSERT INTO Livros (titulo, anoPublic, genero, estoque, imgName, autor_id)
                    VALUES ('$titulo', '$anoPublic', '$genero', $estoque, '$imgName', $autor_id)";

            if ($conn->query($sql) === TRUE) {
                echo "Novo livro cadastrado com sucesso!";
            } else {
                echo "Erro: " . $sql . "<br>" . $conn->error;
            }

        } else {
            echo "Desculpe, houve um erro ao enviar seu arquivo.";
        }
    }

    $conn->close();
}
?>