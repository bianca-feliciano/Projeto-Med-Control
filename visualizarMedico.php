<?php
require_once '../../controller/MedicoController.php';

if (!isset($_GET['crm'])) {
    die("Médico não especificado.");
}

$controller = new MedicoController();
$medico = $controller->buscarPorCrm($_GET['crm']);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Detalhes do Médico</title>
    <link rel="stylesheet" href="../../css/visualizacao.css">
</head>
<body>

    <div class="top-bar">
        <div>MedControl 🩺</div>
        <div>DETALHES DO MÉDICO</div>
    </div>

    <div class="container">
        <h2>Detalhes do Médico</h2>

        <div class="info"><span class="label">Nome:</span> <?= htmlspecialchars($medico->getNome()) ?></div>
        <div class="info"><span class="label">CRM:</span> <?= htmlspecialchars($medico->getCrm()) ?></div>
        <div class="info"><span class="label">Especialização:</span> <?= htmlspecialchars($medico->getEspecializacao()) ?></div>
        <div class="info"><span class="label">Data de Nascimento:</span> <?= htmlspecialchars($medico->getDataNascimento()) ?></div>
        <div class="info"><span class="label">Email:</span> <?= htmlspecialchars($medico->getEmail()) ?></div>

        <button onclick="../index.php">Voltar</button>
    </div>
</body>
</html>