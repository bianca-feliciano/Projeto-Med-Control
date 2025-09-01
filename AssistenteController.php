<?php
require_once __DIR__ . '/../model/Assistente.php';
require_once __DIR__ . '/../config/Database.php';

class AssistenteController {
    private $conn;

    public function __construct() {
        $this->conn = (new Database())->conectar();
    }

    public function listarTodos() {
        $sql = "SELECT * FROM Assistente INNER JOIN Usuario ON Assistente.Usuario_email = Usuario.email ORDER BY nome";
        $result = $this->conn->query($sql);
        $assistentes = [];

        while ($row = $result->fetch_assoc()) {
            $assistentes[] = new Assistente(
                $row['email'],
                $row['senha'],
                $row['cpf_assistente'],
                $row['telefone_assistente'],
                $row['nome'],
                $row['dataNascimento'],
                $row['endereco']
            );
        }

        return $assistentes;
    }

    public function salvarOuAtualizar($assistente) {
        $check = $this->conn->query("SELECT * FROM Usuario WHERE email = '{$assistente->getEmail()}'");
        if ($check->num_rows > 0) {
            $this->conn->query("UPDATE Usuario SET senha = '{$assistente->getSenha()}' WHERE email = '{$assistente->getEmail()}'");
            $sql = "UPDATE Assistente SET 
                        cpf_assistente = '{$assistente->getCpf()}', 
                        telefone_assistente = '{$assistente->getTelefone()}', 
                        nome = '{$assistente->getNome()}', 
                        dataNascimento = '{$assistente->getDataNascimento()}', 
                        endereco = '{$assistente->getEndereco()}'
                    WHERE Usuario_email = '{$assistente->getEmail()}'";
        } else {
            $this->conn->query("INSERT INTO Usuario (email, senha) VALUES ('{$assistente->getEmail()}', '{$assistente->getSenha()}')");
            $sql = "INSERT INTO Assistente (cpf_assistente, telefone_assistente, nome, dataNascimento, endereco, Usuario_email) 
                    VALUES ('{$assistente->getCpf()}', '{$assistente->getTelefone()}', '{$assistente->getNome()}', '{$assistente->getDataNascimento()}', '{$assistente->getEndereco()}', '{$assistente->getEmail()}')";
        }

        return $this->conn->query($sql);
    }

    public function excluir($email) {
        return $this->conn->query("DELETE FROM Usuario WHERE email = '$email'");
    }

    public function buscarPorEmail($email) {
        $sql = "SELECT * FROM Assistente INNER JOIN Usuario ON Assistente.Usuario_email = Usuario.email WHERE email = '$email'";
        $result = $this->conn->query($sql);
        $row = $result->fetch_assoc();

        if (!$row) return null;

        return new Assistente(
            $row['email'],
            $row['senha'],
            $row['cpf_assistente'],
            $row['telefone_assistente'],
            $row['nome'],
            $row['dataNascimento'],
            $row['endereco']
        );
    }
}
?>
