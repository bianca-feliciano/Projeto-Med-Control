<?php
require_once __DIR__ . '/../model/Paciente.php';
require_once __DIR__ . '/../config/Database.php';

class PacienteController {
    private $conn;

    public function __construct() {
        $this->conn = (new Database())->conectar();
    }

    public function listarTodos() {
        $sql = "SELECT * FROM Paciente ORDER BY nome_paciente";
        $result = $this->conn->query($sql);
        $pacientes = [];

        while ($row = $result->fetch_assoc()) {
            $pacientes[] = new Paciente(
                $row['cpf_paciente'],
                $row['telefone_paciente'],
                $row['nome_paciente'],
                $row['dataNascimento'],
                $row['endereco']
            );
        }

        return $pacientes;
    }

    public function salvarOuAtualizar($paciente) {
        $check = $this->conn->query("SELECT * FROM Paciente WHERE cpf_paciente = '{$paciente->getCpf()}'");
        if ($check->num_rows > 0) {
            $sql = "UPDATE Paciente SET 
                        telefone_paciente = '{$paciente->getTelefone()}', 
                        nome_paciente = '{$paciente->getNome()}', 
                        dataNascimento = '{$paciente->getDataNascimento()}', 
                        endereco = '{$paciente->getEndereco()}'
                    WHERE cpf_paciente = '{$paciente->getCpf()}'";
        } else {
            $sql = "INSERT INTO Paciente (cpf_paciente, telefone_paciente, nome_paciente, dataNascimento, endereco) 
                    VALUES ('{$paciente->getCpf()}', '{$paciente->getTelefone()}', '{$paciente->getNome()}', '{$paciente->getDataNascimento()}', '{$paciente->getEndereco()}')";
        }

        return $this->conn->query($sql);
    }

    public function excluir($cpf) {
        return $this->conn->query("DELETE FROM Paciente WHERE cpf_paciente = '$cpf'");
    }

    public function buscarPorCpf($cpf) {
        $sql = "SELECT * FROM Paciente WHERE cpf_paciente = '$cpf'";
        $result = $this->conn->query($sql);
        $row = $result->fetch_assoc();

        if (!$row) return null;

        return new Paciente(
            $row['cpf_paciente'],
            $row['telefone_paciente'],
            $row['nome_paciente'],
            $row['dataNascimento'],
            $row['endereco']
        );
    }
}
?>
