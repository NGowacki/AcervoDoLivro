<?php
include 'connection.php';

// Consulta para obter os livros e seus autores
$sql = "SELECT Livros.id, Livros.titulo, Livros.anoPublic, Livros.genero, Livros.estoque, Livros.imgName, Autores.nome AS autor
        FROM Livros
        JOIN Autores ON Livros.autor_id = Autores.id";
$result = $conn->query($sql);

$sql_destaques = "SELECT livros.titulo, livros.imgName 
                  FROM destaques 
                  JOIN livros ON destaques.livro = livros.id";
$result_destaques = $conn->query($sql_destaques);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biblioteca Virtual</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Acervo do Livro</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="gerenciarDestaques.php">Destaques</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Cadastros
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="cadastrarLivro.php">Livros</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="cadastrarAutor.php">Autores</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <main>
        <center>
            <div class="error">
                <?php
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
                    if ($_FILES["imgFile"]["size"] > 5000000) {
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
                                header('Location: index.php');
                            } else {
                                //echo "<script>console.log('Erro: " . $sql . "<br>" . $conn->error . "');</script>";
                            }
                
                        } else {
                            echo "Desculpe, houve um erro ao enviar seu arquivo.";
                        }
                    }
                }
                ?>
            </div>
        </center>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>

<?php
$conn->close();
?>