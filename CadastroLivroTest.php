<?php
use PHPUnit\Framework\TestCase;

class CadastroLivroTest extends TestCase
{
    private $conn;

    protected function setUp(): void
    {
        $this->conn = new mysqli('localhost', 'root', '', 'acervodolivroteste');
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    protected function tearDown(): void
    {
        $this->conn->close();
    }

    public function testCadastroLivro()
    {
        $titulo = "Livro Teste";
        $anoPublic = "2023-01-01";
        $genero = "Ficção";
        $estoque = 10;
        $imgName = "imagem_teste.jpg";
        $autor_id = 1;

        $sql = "INSERT INTO Livros (titulo, anoPublic, genero, estoque, imgName, autor_id)
                VALUES ('$titulo', '$anoPublic', '$genero', $estoque, '$imgName', $autor_id)";
        
        $result = $this->conn->query($sql);

        $this->assertTrue($result, "Falha ao cadastrar livro");

        $sql = "SELECT * FROM Livros WHERE titulo='$titulo'";
        $result = $this->conn->query($sql);

        $this->assertEquals(1, $result->num_rows, "Livro não encontrado na tabela");

        // Limpar os dados inseridos para não afetar outros testes
        $sql = "DELETE FROM Livros WHERE titulo='$titulo'";
        $this->conn->query($sql);
    }

}
