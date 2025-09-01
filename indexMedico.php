<?php
require_once '../../controller/MedicoController.php';
$controller = new MedicoController();
$medicos = $controller->listarTodos();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Médicos</title>
    <link rel="stylesheet" href="../../css/listagem.css">
</head>
<body>

    <div class="top-bar">
        <div>MedControl 🩺</div>
        <div>GERENCIAR MÉDICOS</div>
    </div>

    <div class="container">
        <h2>Médicos</h2>
        <table>
            <tr>
                <th>Nome</th>
                <th>CRM</th>
                <th>Especialização</th>
                <th>Ações</th>
            </tr>
            <?php foreach ($medicos as $medico): ?>
            <tr>
                <td><?= htmlspecialchars($medico->getNome()) ?></td>
                <td><?= htmlspecialchars($medico->getCrm()) ?></td>
                <td><?= htmlspecialchars($medico->getEspecializacao()) ?></td>
                <td>
                    <button class="btn btn-ver" onclick="location.href='visualizarMedico.php?crm=<?= $medico->getCrm() ?>'">Visualizar</button>
                    <button class="btn btn-editar" onclick="location.href='../../view/form_incluir_medico.php?crm=<?= $medico->getCrm() ?>'">Editar</button>
                    <button class="btn btn-excluir" onclick="location.href='excluirMedico.php?crm=<?= $medico->getCrm() ?>'">Excluir</button>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>

        <a href="../../index.php">
            <button>Voltar</button>
        </a>

    </div>
</body>
</html>