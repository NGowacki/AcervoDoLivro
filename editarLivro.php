<?php
include 'connection.php'; // Inclui o arquivo de conexão ao banco de dados

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
    <title>Editar Livro</title>
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
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <main class="container mt-5">
        <h2>Editar Livro</h2>
        <form action="processaEdicao.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= $livro['id'] ?>">
            <div class="mb-3">
                <label for="titulo" class="form-label">Título</label>
                <input type="text" class="form-control" id="titulo" name="titulo" value="<?= $livro['titulo'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="anoPublic" class="form-label">Ano de Publicação</label>
                <input type="date" class="form-control" id="anoPublic" name="anoPublic" value="<?= $livro['anoPublic'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="genero" class="form-label">Gênero</label>
                <input type="text" class="form-control" id="genero" name="genero" value="<?= $livro['genero'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="estoque" class="form-label">Quantidade em Estoque</label>
                <input type="number" class="form-control" id="estoque" name="estoque" value="<?= $livro['estoque'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="imgFile" class="form-label">Imagem do Livro</label>
                <input type="file" class="form-control" id="imgFile" name="imgFile" accept="image/*">
            </div>
            <div class="mb-3">
                <label for="autor_id" class="form-label">Autor</label>
                <select class="form-select" id="autor_id" name="autor_id" required>
                    <?php
                    include 'connection.php';
                    $sql = "SELECT id, nome FROM Autores";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            $selected = ($row['id'] == $livro['autor_id']) ? 'selected' : '';
                            echo "<option value='" . $row['id'] . "' $selected>" . $row['nome'] . "</option>";
                        }
                    } else {
                        echo "<option value=''>Nenhum autor encontrado</option>";
                    }
                    $conn->close();
                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Salvar Alterações</button>
        </form>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
