<?php
require_once __DIR__ . '/../controller/PacienteController.php';

$cpf = $_GET['cpf'] ?? null;
if (!$cpf) {
    die("CPF não informado.");
}

$pacienteController = new PacienteController();
$paciente = $pacienteController->buscarPorCpf($cpf);

if (!$paciente) {
    die("Paciente não encontrado.");
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Dados do Paciente</title>
    <link rel="stylesheet" href="../css/pacienteDados.css">
</head>
<body>
    <div class="top-bar">DADOS DO PACIENTE</div>

    <div class="container center">
        <div class="info"><span>Nome:</span> <?= htmlspecialchars($paciente->getNome()) ?></div>
        <div class="info"><span>CPF:</span> <?= htmlspecialchars($paciente->getCpf()) ?></div>
        <div class="info"><span>Data de Nascimento:</span> <?= htmlspecialchars($paciente->getDataNascimento()) ?></div>
        <div class="info"><span>Endereço:</span> <?= htmlspecialchars($paciente->getEndereco()) ?></div>
        <div class="info"><span>Telefone:</span> <?= htmlspecialchars($paciente->getTelefone()) ?></div>

        <button class="btn-voltar" onclick="window.location.href='agendaPessoal.php'">VOLTAR</button>
    </div>
</body>
</html>