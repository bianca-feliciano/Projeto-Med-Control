<?php
class Consulta {
    private $id; // Id da consulta, auto incrementado no banco
    private $medicoEmail;
    private $pacienteCpf;
    private $dataHora;
    private $diagnostico;

    // Construtor sem id — para criação nova
    public function __construct($medicoEmail, $pacienteCpf, $dataHora, $diagnostico = null, $id = null) {
        $this->id = $id;
        $this->medicoEmail = $medicoEmail;
        $this->pacienteCpf = $pacienteCpf;
        $this->dataHora = $dataHora;
        $this->diagnostico = $diagnostico;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getMedicoEmail() {
        return $this->medicoEmail;
    }

    public function getPacienteCpf() {
        return $this->pacienteCpf;
    }

    public function getDataHora() {
        return $this->dataHora;
    }

    public function getDiagnostico() {
        return $this->diagnostico;
    }

    public function setDiagnostico($diagnostico) {
        $this->diagnostico = $diagnostico;
    }
}
?>

