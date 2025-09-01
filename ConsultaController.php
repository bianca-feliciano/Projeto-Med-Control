<?php
require_once __DIR__ . '/../model/Consulta.php';
require_once __DIR__ . '/../config/Database.php';

class ConsultaController {
    private $conn;

    public function __construct() {
        $this->conn = (new Database())->conectar();
    }

    private function limparCpf(string $cpf): string {
        // Remove tudo que não for número e limita a 11 caracteres (CPF padrão)
        $cpfLimpo = preg_replace('/\D/', '', $cpf);
        return substr($cpfLimpo, 0, 11);
    }

    public function listarTodasOrdenadas() {
        $sql = "SELECT * FROM Consulta ORDER BY `data_hora` DESC";
        $result = $this->conn->query($sql);
        $consultas = [];

        while ($row = $result->fetch_assoc()) {
            $consultas[] = new Consulta(
                $row['Medico_Usuario_email'],
                $row['Paciente_cpf_paciente'],
                $row['data_hora'],
                $row['diagnostico'],
                $row['id']  // passa o id para o objeto Consulta
            );
        }

        return $consultas;
    }

    public function listarPorMes(string $yearMonth): array {
        $consultas = [];
        $yearMonth = $this->conn->real_escape_string($yearMonth);

        $sql = "SELECT * FROM Consulta WHERE DATE_FORMAT(`data_hora`, '%Y-%m') = '$yearMonth' ORDER BY `data_hora` ASC";
        $result = $this->conn->query($sql);

        while ($row = $result->fetch_assoc()) {
            $consultas[] = new Consulta(
                $row['Medico_Usuario_email'],
                $row['Paciente_cpf_paciente'],
                $row['data_hora'],
                $row['diagnostico'],
                $row['id']
            );
        }

        return $consultas;
    }

    public function salvarOuAtualizar($consulta) {
        $medicoEmail = $this->conn->real_escape_string($consulta->getMedicoEmail());
        $cpfOriginal = $consulta->getPacienteCpf();
        $pacienteCpf = $this->limparCpf($cpfOriginal);

        if (strlen($pacienteCpf) !== 11) {
            throw new Exception("CPF inválido: deve conter 11 dígitos numéricos.");
        }

        $pacienteCpf = $this->conn->real_escape_string($pacienteCpf);
        $dataHora = $this->conn->real_escape_string($consulta->getDataHora());
        $diagnostico = $consulta->getDiagnostico() ? "'" . $this->conn->real_escape_string($consulta->getDiagnostico()) . "'" : "NULL";
        $id = $consulta->getId();

        if ($id) {
            $id = (int)$id;
            $sql = "UPDATE Consulta SET 
                        Medico_Usuario_email = '$medicoEmail',
                        Paciente_cpf_paciente = '$pacienteCpf',
                        `data_hora` = '$dataHora',
                        diagnostico = $diagnostico
                    WHERE id = $id";
            $result = $this->conn->query($sql);
            if (!$result) {
                throw new Exception("Erro ao atualizar consulta: " . $this->conn->error);
            }
        } else {
            $sql = "INSERT INTO Consulta (Medico_Usuario_email, Paciente_cpf_paciente, `data_hora`, diagnostico) 
                    VALUES ('$medicoEmail', '$pacienteCpf', '$dataHora', $diagnostico)";
            $result = $this->conn->query($sql);
            if (!$result) {
                throw new Exception("Erro ao inserir consulta: " . $this->conn->error);
            }

            $insertedId = $this->conn->insert_id;
            if ($insertedId > 0) {
                $consulta->setId($insertedId);
            } else {
                throw new Exception("Erro ao obter ID da consulta inserida.");
            }
        }

        return true;
    }

    public function excluir(int $id) {
        $id = (int)$id;
        $sql = "DELETE FROM Consulta WHERE id = $id";
        return $this->conn->query($sql);
    }

    public function buscarPorId(int $id) {
        $id = (int) $id;
        $sql = "SELECT * FROM Consulta WHERE id = $id LIMIT 1";
        $result = $this->conn->query($sql);

        if (!$result || $result->num_rows == 0) {
            return null;
        }

        $row = $result->fetch_assoc();
        return new Consulta(
            $row['Medico_Usuario_email'],
            $row['Paciente_cpf_paciente'],
            $row['data_hora'],
            $row['diagnostico'],
            $row['id']
        );
    }

    public function listarPorMedicoEmailEMesAno($email, $mes, $ano) {
        $email = $this->conn->real_escape_string($email);
        $mes = (int)$mes;
        $ano = (int)$ano;

        $sql = "SELECT * FROM Consulta 
                WHERE Medico_Usuario_email = '$email' 
                AND MONTH(data_hora) = $mes 
                AND YEAR(data_hora) = $ano";
        
        $result = $this->conn->query($sql);
        $consultas = [];

        while ($row = $result->fetch_assoc()) {
            $consultas[] = new Consulta(
                $row['Medico_Usuario_email'],
                $row['Paciente_cpf_paciente'],
                $row['data_hora'],
                $row['diagnostico'],
                $row['id']
            );
        }

        return $consultas;
    }

    public function listarPorMedicoEmail($email) {
        $email = $this->conn->real_escape_string($email);

        $sql = "SELECT * FROM Consulta 
                WHERE Medico_Usuario_email = '$email'
                AND data_hora > NOW()
                ORDER BY data_hora ASC";

        $result = $this->conn->query($sql);
        $consultas = [];

        while ($row = $result->fetch_assoc()) {
            $consulta = new Consulta(
                $row['Medico_Usuario_email'],
                $row['Paciente_cpf_paciente'],
                $row['data_hora'],
                $row['diagnostico']
            );
            $consulta->setId($row['id']);
            $consultas[] = $consulta;
        }

        return $consultas;
    }

    public function listarPorPacienteCpf($cpf) {
        $cpf = $this->conn->real_escape_string($cpf);

        $sql = "SELECT * FROM Consulta WHERE Paciente_cpf_paciente = '$cpf' ORDER BY data_hora ASC";
        $result = $this->conn->query($sql);
        $consultas = [];

        while ($row = $result->fetch_assoc()) {
            $consultas[] = new Consulta(
                $row['Medico_Usuario_email'],
                $row['Paciente_cpf_paciente'],
                $row['data_hora'],
                $row['diagnostico'],
                $row['id']
            );
        }

        return $consultas;
    }







}
?>
