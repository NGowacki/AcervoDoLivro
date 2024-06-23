<?php
include 'connection.php'; // Inclui o arquivo de conexão ao banco de dados
include 'function.php';

// Consulta para obter os livros e seus autores
$sql = "SELECT id, nome, dataNascimento, nacionalidade, bibliografia FROM autores";
$result = $conn->query($sql);

$autores = [];
while ($row = $result->fetch_assoc()) {
    $autores[] = [
        'id' => $row['id'],
        'nome' => $row['nome'],
        'dataNascimento' => $row['dataNascimento'],
        'nacionalidade' => $row['nacionalidade'],
        'bibliografia' => $row['bibliografia'],
    ];
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biblioteca Virtual</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/styles.css">
    <script src="css/jquery/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="css/datatables/datatables.min.css">
    <script src="css/datatables/datatables.min.js"></script>
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
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="index.php">Meus Autores</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12 p-5 bg-white">
                <div class="row">
                    <div class="col text-end">
                        <a href="cadastrarAutor.php" class="btn btn-secondary"><i class="fa-solid fa-plus me-2"></i>Novo Autor</a>
                    </div>
                </div>
                <hr>
                <?php if (!empty($autores)) { ?>
                    <table class="table table-striped table-bordered" id="table_autores">
                        <thead class="table-dark">
                            <tr>
                                <th>Nome</th>
                                <th class="text-center">Data nascimento</th>
                                <th>Nacionalidade</th>
                                <th class="text-center">Bibliografia</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($autores as $autor) { ?>
                                <tr>
                                    <td><?= $autor['nome'] ?></td>
                                    <td class="text-center"><?= $autor['dataNascimento'] ?></td>
                                    <td class="text-center"><?= $autor['nacionalidade'] ?></td>
                                    <td><?= $autor['bibliografia'] ?></td>
                                    <td class="text-end">
                                        <a href="editarAutor.php?id=<?= $autor['id'] ?>"><i class="fa-regular fa-pen-to-square me-2"></i>Editar</a>
                                        <span class="mx-2 opacity-50">|</span>
                                        <a href="deletarAutor.php?id=<?= $autor['id'] ?>"><i class="fa-solid fa-trash-can me-2"></i>Eliminar</a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col">
                            <p class="mb-5">Total: <strong><?= count($autores) ?></strong></p>
                        </div>
                    </div>
                <?php } else { ?>
                    <p class="my-5 text-center opacity-75">Não existem autores registados.</p>
                <?php } ?>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
<script>
    $(document).ready(function() {
        // datatable
        $('#table_autores').DataTable({
            pageLength: 10,
            pagingType: "full_numbers",
            language: {
                decimal: "",
                emptyTable: "Sem dados disponíveis na tabela.",
                info: "Mostrando _START_ até _END_ de _TOTAL registros",
                infoEmpty: "Mostrando 0 até 0 de 0 registros",
                infoFiltered: "(Filtrando MAX total de registros)",
                infoPostFix: "",
                thousands: ",",
                lengthMenu: "Mostrando _MENU_ registros por página.",
                loadingRecords: "Carregando...",
                processing: "Processando...",
                search: "Filtrar:",
                zeroRecords: "Nenhum registro encontrado.",
                paginate: {
                    first: "Primeira",
                    last: "Última",
                    next: "Seguinte",
                    previous: "Anterior"
                },
                aria: {
                    sortAscending: ": ative para classificar a coluna em ordem crescente.",
                    sortDescending: ": ative para classificar a coluna em ordem decrescente."
                }
            }
        });
    });
</script>