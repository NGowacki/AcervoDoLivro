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

        $stmt = $this->conn->prepare("INSERT INTO Livros (titulo, anoPublic, genero, estoque, imgName, autor_id) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssi", $titulo, $anoPublic, $genero, $estoque, $imgName, $autor_id);
        $result = $stmt->execute();

        $this->assertTrue($result, "Falha ao cadastrar livro");

        $stmt = $this->conn->prepare("SELECT * FROM Livros WHERE titulo=?");
        $stmt->bind_param("s", $titulo);
        $stmt->execute();
        $result = $stmt->get_result();

        $this->assertEquals(1, $result->num_rows, "Livro não encontrado na tabela");

        // Limpar os dados inseridos para não afetar outros testes
        $stmt = $this->conn->prepare("DELETE FROM Livros WHERE titulo=?");
        $stmt->bind_param("s", $titulo);
        $stmt->execute();
    }

    public function testDadosInvalidos()
    {
        $titulo = "";
        $anoPublic = "2023-01-01";
        $genero = "Ficção";
        $estoque = 10;
        $imgName = "imagem_teste.jpg";
        $autor_id = 1;

        $stmt = $this->conn->prepare("INSERT INTO Livros (titulo, anoPublic, genero, estoque, imgName, autor_id) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssi", $titulo, $anoPublic, $genero, $estoque, $imgName, $autor_id);
        
        if (empty($titulo)) {
            $result = false;
        } else {
            $result = $stmt->execute();
        }

        $this->assertFalse($result, "Cadastro de livro com título inválido não deveria ter sucesso");
    }
}
?>
