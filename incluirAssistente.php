<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Acesso inválido");
}

require_once '../../controller/AssistenteController.php';
require_once '../../model/Assistente.php';

// Verificação segura dos dados recebidos
$email = $_POST['email'] ?? '';
$senha = $_POST['senha'] ?? '';
$cpf = $_POST['cpf'] ?? '';
$telefone = $_POST['telefone'] ?? '';
$nome = $_POST['nome'] ?? '';
$dataNascimento = $_POST['data_nascimento'] ?? '';
$endereco = $_POST['endereco'] ?? '';

// Cria objeto Assistente
$assistente = new Assistente($email, $senha, $cpf, $telefone, $nome, $dataNascimento, $endereco);

// Salva no banco
$controller = new AssistenteController();
$controller->salvarOuAtualizar($assistente);

// Redireciona após salvar
header("Location: ../../index.php");
exit;
?>
