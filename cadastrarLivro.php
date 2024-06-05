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
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="cadastrar_livro.php">Cadastrar Livro</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <main class="container mt-5">
        <h2>Cadastrar Novo Livro</h2>
        <form action="processaCadastro.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="titulo" class="form-label">Título</label>
                <input type="text" class="form-control" id="titulo" name="titulo" required>
            </div>
            <div class="mb-3">
                <label for="anoPublic" class="form-label">Ano de Publicação</label>
                <input type="date" class="form-control" id="anoPublic" name="anoPublic" required>
            </div>
            <div class="mb-3">
                <label for="genero" class="form-label">Gênero</label>
                <input type="text" class="form-control" id="genero" name="genero" required>
            </div>
            <div class="mb-3">
                <label for="estoque" class="form-label">Quantidade em Estoque</label>
                <input type="number" class="form-control" id="estoque" name="estoque" required>
            </div>
            <div class="mb-3">
                <label for="imgFile" class="form-label">Imagem do Livro</label>
                <input type="file" class="form-control" id="imgFile" name="imgFile" accept="image/*" required>
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
                            echo "<option value='" . $row['id'] . "'>" . $row['nome'] . "</option>";
                        }
                    } else {
                        echo "<option value=''>Nenhum autor encontrado</option>";
                    }
                    $conn->close();
                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Cadastrar</button>
        </form>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
