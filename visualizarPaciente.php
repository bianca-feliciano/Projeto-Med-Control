<?php
require_once '../../controller/PacienteController.php';

if (!isset($_GET['cpf'])) {
    die("Paciente não especificado.");
}

$controller = new PacienteController();
$paciente = $controller->buscarPorCpf($_GET['cpf']);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <title>Detalhes do Paciente</title>
    <link rel="stylesheet" href="../../css/visualizacao.css">
</head>
<body>

    <div class="top-bar">
        <div>MedControl 🩺</div>
        <div>DETALHES DO PACIENTE</div>
    </div>

    <div class="container">
        <h2>Informações do Paciente</h2>
        <div class="info"><span class="label">Nome:</span> <?= htmlspecialchars($paciente->getNome()) ?></div>
        <div class="info"><span class="label">CPF:</span> <?= htmlspecialchars($paciente->getCpf()) ?></div>
        <div class="info"><span class="label">Data de Nascimento:</span> <?= htmlspecialchars($paciente->getDataNascimento()) ?></div>
        <div class="info"><span class="label">Telefone:</span> <?= htmlspecialchars($paciente->getTelefone()) ?></div>
        <div class="info"><span class="label">Endereço:</span> <?= htmlspecialchars($paciente->getEndereco()) ?></div>

        <button onclick="history.back()">Voltar</button>
    </div>

</body>
</html>