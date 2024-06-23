<?php
include 'connection.php';

$sql_destaques = "SELECT destaques.id, livros.titulo, livros.imgName 
                  FROM destaques 
                  JOIN livros ON destaques.livro = livros.id";
$result_destaques = $conn->query($sql_destaques);

$sql_livros = "SELECT id, titulo FROM livros";
$result_livros = $conn->query($sql_livros);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Destaques</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
<div class="container mt-5">
    <h2>Gerenciar Destaques</h2>
    <form action="processaDestaque.php" method="POST">
        <div class="mb-3">
            <label for="livro_id" class="form-label">Selecione o Livro para Destaque</label>
            <select class="form-select" id="livro_id" name="livro_id" required>
                <?php
                while ($row = $result_livros->fetch_assoc()) {
                    echo "<option value='{$row['id']}'>{$row['titulo']}</option>";
                }
                ?>
            </select>
        </div>
        <?php if ($result_destaques->num_rows == 3): ?>
            <div class="mb-3">
                <label for="substitute_id" class="form-label">Selecione um Destaque para Substituir</label>
                <select class="form-select" id="substitute_id" name="substitute_id" required>
                    <?php
                    while ($row = $result_destaques->fetch_assoc()) {
                        echo "<option value='{$row['id']}'>{$row['titulo']}</option>";
                    }
                    ?>
                </select>
            </div>
        <?php endif; ?>
        <button type="submit" class="btn btn-primary">Adicionar Destaque</button>
    </form>
    <h2 class="mt-5">Livros Destaques Atuais</h2>
    <div class="row">
        <?php
        $result_destaques->data_seek(0);
        while ($row = $result_destaques->fetch_assoc()) {
            echo "<div class='col-md-4'>
                    <div class='card'>
                        <img src='img/{$row['imgName']}' class='card-img-top' alt='...'>
                        <div class='card-body'>
                            <h5 class='card-title'>{$row['titulo']}</h5>
                        </div>
                    </div>
                  </div>";
        }
        ?>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
$conn->close();
?>
