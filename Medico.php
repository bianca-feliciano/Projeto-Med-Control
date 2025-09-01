<?php
require_once 'Usuario.php';

class Medico extends Usuario {
    private $crm;
    private $especializacao;
    private $nome;
    private $dataNascimento;

    public function __construct($email, $senha, $crm, $especializacao, $nome, $dataNascimento) {
        parent::__construct($email, $senha);
        $this->crm = $crm;
        $this->especializacao = $especializacao;
        $this->nome = $nome;
        $this->dataNascimento = $dataNascimento;
    }

    public function getCrm() {
        return $this->crm;
    }

    public function getEspecializacao() {
        return $this->especializacao;
    }

    public function getNome() {
        return $this->nome;
    }

    public function getDataNascimento() {
        return $this->dataNascimento;
    }
}
?>
