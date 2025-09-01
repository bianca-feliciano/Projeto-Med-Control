<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Acesso inválido");
}

require_once '../../controller/PacienteController.php';
require_once '../../model/Paciente.php';

// Verificação segura dos dados recebidos
$nome = $_POST['nome'] ?? '';
$cpf = $_POST['cpf'] ?? '';
$telefone = $_POST['telefone'] ?? '';
$dataNascimento = $_POST['data_nascimento'] ?? '';
$endereco = $_POST['endereco'] ?? null; // usado se for atualização

// Cria objeto Paciente
$paciente = new Paciente($cpf, $telefone, $nome, $dataNascimento, $endereco);

// Salva no banco
$controller = new PacienteController();
$controller->salvarOuAtualizar($paciente);

// Redireciona após salvar
header("Location: ../../public/paciente/indexPaciente.php");
exit;
?>

