<?php
class Database {
    private $host = "localhost";
    private $login = "root";
    private $senha = "";
    private $bd = "engenharia";
    private $porta = 3306;
    public $con;

    public function conectar() {
        $this->con = new mysqli($this->host, $this->login, $this->senha, $this->bd, $this->porta);
        if ($this->con->connect_error) {
            die("Erro de conexão: " . $this->con->connect_error);
        }
        return $this->con;
    }
}
?>
