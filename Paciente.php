<?php
class Paciente {
    private $cpf;
    private $telefone;
    private $nome;
    private $dataNascimento;
    private $endereco;

    public function __construct($cpf, $telefone, $nome, $dataNascimento, $endereco) {
        $this->cpf = $cpf;
        $this->telefone = $telefone;
        $this->nome = $nome;
        $this->dataNascimento = $dataNascimento;
        $this->endereco = $endereco;
    }

    public function getCpf() {
        return $this->cpf;
    }

    public function getTelefone() {
        return $this->telefone;
    }

    public function getNome() {
        return $this->nome;
    }

    public function getDataNascimento() {
        return $this->dataNascimento;
    }

    public function getEndereco() {
        return $this->endereco;
    }
}
?>
