<?php
include 'connection.php'; // Inclui o arquivo de conexão ao banco de dados

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
        <div id="carouselExampleCaptions" class="carousel slide">
            <div class="carousel-indicators">
                <?php
                $active = 'active';
                $slide_to = 0;
                while ($row = $result_destaques->fetch_assoc()) {
                    ?>
                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="<?= $slide_to ?>" class="<?= $active ?>" aria-current="true" aria-label="Slide <?= $slide_to ?>"></button>
                    <?php
                    $active = '';
                    $slide_to++;
                }
                ?>
            </div>
            <div class="carousel-inner">
                <?php
                $active = 'active';
                $result_destaques->data_seek(0);
                while ($row = $result_destaques->fetch_assoc()) {
                    ?>
                    <div class="carousel-item <?= $active ?>">
                        <img src="img/<?= $row['imgName'] ?>" class="d-block w-100" alt="...">
                        <div class="carousel-caption d-none d-md-block">
                            <h5><?= $row['titulo'] ?></h5>
                        </div>
                    </div>
                    <?php
                    $active = '';
                }
                ?>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
        <br><br>
        <center>
            <section class="secaoLivros">
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        ?>
                        <div class="bookcard">
                            <div class="card mb-3" style="max-width: 540px;">
                                <div class="row g-0">
                                    <div class="col-md-4">
                                        <img src="img/<?= $row['imgName'] ?>" class="img-fluid rounded-start" alt="...">
                                    </div>
                                    <div class="col-md-8">
                                        <div class="card-body">
                                            <h5 class="card-title"><?= $row['titulo'] ?></h5>
                                            <p class="card-text">Ano publicado: <?= $row['anoPublic'] ?></p>
                                            <p class="card-text">Gênero: <?= $row['genero'] ?></p>
                                            <p class="card-text">Autor: <?= $row['autor'] ?></p>
                                            <p class="card-text"><small class="text-body-secondary">Quantidade em estoque: <?= $row['estoque'] ?></small></p>
                                        </div>
                                    </div>
                                </div>
                                <a href="editarLivro.php?id=<?= $row['id'] ?>" class="btn btn-primary">Editar</a>
                                <a href="deletarLivro.php?id=<?= $row['id'] ?>" class="btn btn-danger">Deletar</a>
                            </div>
                        </div>
                        <?php
                    }
                } else {
                    ?>
                    <p>Nenhum livro encontrado.</p>
                    <?php
                }
                ?>
            </section>
        </center>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>

<?php
$conn->close(); // Fecha a conexão com o banco de dados
?>
