<?php
include 'connection.php'; // Inclui o arquivo de conexão ao banco de dados
include 'function.php';
// Verifica se o ID do livro foi passado
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Consulta para obter os dados do livro
    $sql = "SELECT * FROM Livros WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $livro = $result->fetch_assoc();
    } else {
        echo "Livro não encontrado!";
        exit;
    }
} else {
    echo "ID do livro não fornecido!";
    exit;
}
?>



<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Livro</title>
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
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="cadastrarAutor.php">Autores</a></li>
                        </ul>
                        <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="meusAutores.php">Meus Autores</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="meusLivros.php">Meus Livros</a>
                    </li>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container-Fluid mt-5">
        <div class="row justify-content-center">
            <div class="col-sm-8 col-18">

                <div class="card p-4">
                    <h1 class="text-center text-warning mb-4"><i class="fa-solid fa-triangle-exclamation"></i></h1>
                    <p class="text-center mb-4"> Deseja deletar o Livro? </p>
                    <h4 class="mb-4 text-center"><strong><?= $livro['titulo'] ?></strong></h4>
                    <div class="text-center mb-4">
                        <span><i class="fa-solid fa-at me-1"></i>Ano de Publicação: <?= $livro['anoPublic']?></strong></span>
                        <span class="mx-5"></span> <span><i class="fa-solid fa-phone me-2°"></I>Quantidade:<?= $livro['estoque'] ?></strong></span>
                    </div>
                    <div class=" text-center my-3">
                        <a href="index.php" class="btn btn-outline-secondary px-5"><i class="fa-solid fa-xmark me-2"></i>Não</a>   <a href="processaDeleteLivro.php?id=<?= $livro['id'] ?>" class="btn btn-secondary px-5"><i class="fa-solid fa-check me-2"></i>Sim</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>