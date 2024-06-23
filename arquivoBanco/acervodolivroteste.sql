SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


CREATE TABLE `autores` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `dataNascimento` date NOT NULL,
  `nacionalidade` varchar(100) NOT NULL,
  `bibliografia` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



INSERT INTO `autores` (`id`, `nome`, `dataNascimento`, `nacionalidade`, `bibliografia`) VALUES
(1, 'J. K. Rowling', '1976-10-20', 'Inglesa', 'Nascida na Inglaterra...'),
(2, 'J. K. Rowling', '1976-10-20', 'Inglesa', 'Nascida na Inglaterra...'),
(3, 'Teste', '2023-09-05', 'Brasileira', '...');



CREATE TABLE `livros` (
  `id` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `anoPublic` int(11) NOT NULL,
  `genero` varchar(100) DEFAULT NULL,
  `estoque` int(11) NOT NULL,
  `imgName` varchar(255) DEFAULT NULL,
  `autor_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



INSERT INTO `livros` (`id`, `titulo`, `anoPublic`, `genero`, `estoque`, `imgName`, `autor_id`) VALUES
(1, 'Harry Potter I', 1999, 'Fantasia', 10, 'book.png', 1),
(2, 'Harry Potter 2', 2000, 'Fantasia', 15, 'book.png', 1),
(3, 'teste', 10102010, 'teste', 2, '665faf422c1c8.png', 2),
(4, 'teste', 2024, 'teste', 2, '665fb006d069b.png', 1);


ALTER TABLE `autores`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `livros`
  ADD PRIMARY KEY (`id`),
  ADD KEY `autor_id` (`autor_id`);


ALTER TABLE `autores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;


ALTER TABLE `livros`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;


ALTER TABLE `livros`
  ADD CONSTRAINT `livros_ibfk_1` FOREIGN KEY (`autor_id`) REFERENCES `autores` (`id`);
COMMIT;

CREATE TABLE destaques (
    id INT NOT NULL PRIMARY KEY,
    livro INT NOT NULL,
    FOREIGN KEY (livro) REFERENCES livros(id)
);