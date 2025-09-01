<?php
require_once __DIR__ . '/../model/Medico.php';
require_once __DIR__ . '/../config/Database.php';
require_once 'ConsultaController.php';
require_once 'PacienteController.php';

class MedicoController {
    private $conn;

    public function __construct() {
        $this->conn = (new Database())->conectar();
    }

    public function listarTodos() {
        $sql = "SELECT * FROM Medico 
                INNER JOIN Usuario ON Medico.Usuario_email = Usuario.email 
                ORDER BY nome";
        $result = $this->conn->query($sql);
        $medicos = [];

        while ($row = $result->fetch_assoc()) {
            $medicos[] = new Medico(
                $row['email'],
                $row['senha'],
                $row['crm'],
                $row['especializacao'],
                $row['nome'],
                $row['dataNascimento']
            );
        }

        return $medicos;
    }

    public function salvarOuAtualizar($medico) {
        $check = $this->conn->query("SELECT * FROM Usuario WHERE email = '{$medico->getEmail()}'");

        if ($check->num_rows > 0) {
            // Atualiza Usuario
            $this->conn->query("UPDATE Usuario SET senha = '{$medico->getSenha()}' WHERE email = '{$medico->getEmail()}'");

            // Atualiza Medico
            $sql = "UPDATE Medico SET 
                        especializacao = '{$medico->getEspecializacao()}', 
                        nome = '{$medico->getNome()}', 
                        dataNascimento = '{$medico->getDataNascimento()}' 
                    WHERE crm = '{$medico->getCrm()}' AND Usuario_email = '{$medico->getEmail()}'";
        } else {
            // Insere Usuario
            $this->conn->query("INSERT INTO Usuario (email, senha) 
                                VALUES ('{$medico->getEmail()}', '{$medico->getSenha()}')");

            // Insere Medico
            $sql = "INSERT INTO Medico (crm, especializacao, nome, dataNascimento, Usuario_email) 
                    VALUES ('{$medico->getCrm()}', '{$medico->getEspecializacao()}', '{$medico->getNome()}', '{$medico->getDataNascimento()}', '{$medico->getEmail()}')";
        }

        return $this->conn->query($sql);
    }

    public function excluir($crm) {
        $result = $this->conn->query("SELECT Usuario_email FROM Medico INNER JOIN Usuario ON Medico.Usuario_email = Usuario.email WHERE crm = '$crm'");

        if ($row = $result->fetch_assoc()) {
            $email = $row['Usuario_email'];
            return $this->conn->query("DELETE FROM Usuario WHERE email = '$email'");
        }

        return false;
    }

    public function buscarPorCrm($crm) {
        $sql = "SELECT * FROM Medico 
                INNER JOIN Usuario ON Medico.Usuario_email = Usuario.email 
                WHERE Medico.crm = '$crm'";
        $result = $this->conn->query($sql);
        $row = $result->fetch_assoc();

        if (!$row) return null;

        return new Medico(
            $row['email'],
            $row['senha'],
            $row['crm'],
            $row['especializacao'],
            $row['nome'],
            $row['dataNascimento']
        );
    }

    public function buscarPorEmail($email) {
        $sql = "SELECT * FROM Medico 
                INNER JOIN Usuario ON Medico.Usuario_email = Usuario.email 
                WHERE Usuario.email = '$email'";
        $result = $this->conn->query($sql);
        $row = $result->fetch_assoc();

        if (!$row) return null;

        return new Medico(
            $row['email'],
            $row['senha'],
            $row['crm'],
            $row['especializacao'],
            $row['nome'],
            $row['dataNascimento']
        );
    }


}
?>
