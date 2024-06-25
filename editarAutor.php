<?php
include 'connection.php'; // Inclui o arquivo de conexão ao banco de dados

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM autores WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $autor = $result->fetch_assoc();
    } else {
        echo "Autor não encontrado!";
        exit;
    }
} else {
    echo "ID do Autor não fornecido!";
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Autor</title>
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
    <main class="container mt-5">
        <h2>Editar dados do Autor</h2>
        <form action="processaEdicaoAutor.php" method="POST">
            <div class="mb-3">
                <label for="nome" class="form-label">Nome</label>
                <input type="text" class="form-control" id="nome" name="nome" value="<?= htmlspecialchars($autor['nome']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="dataNascimento" class="form-label">Data de Nascimento</label>
                <input type="date" class="form-control" id="dataNascimento" name="dataNascimento" value="<?= htmlspecialchars($autor['dataNascimento']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="nacionalidade" class="form-label">Nacionalidade</label>
                <input type="text" class="form-control" id="nacionalidade" name="nacionalidade" value="<?= htmlspecialchars($autor['nacionalidade']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="bibliografia" class="form-label">Bibliografia</label>
                <textarea class="form-control" id="bibliografia" name="bibliografia" rows="3" required><?= htmlspecialchars($autor['bibliografia']) ?></textarea>
            </div>
            <input type="hidden" name="id" value="<?= $autor['id'] ?>">
            <button type="submit" class="btn btn-primary">Editar</button>
        </form>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
