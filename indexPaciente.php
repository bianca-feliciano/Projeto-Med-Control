<?php
session_start();
require_once '../../controller/PacienteController.php';

if (!isset($_SESSION['assistente'])) {
    header("Location: ../../public/login_assistente.php");
    exit;
}

$controller = new PacienteController();
$pacientes = $controller->listarTodos();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Pacientes</title>
    <link rel="stylesheet" href="../../css/listagem.css">
</head>
<body>

    <div class="top-bar">
        <div class="titulo">MedControl 🩺</div>
        <div class="area">PACIENTES</div>
    </div>

    <div class="main-content">
        <h2>Lista de Pacientes</h2>

        <table>
            <tr>
                <th>Nome</th>
                <th>CPF</th>
                <th>Ações</th>
            </tr>
            <?php foreach ($pacientes as $paciente): ?>
            <tr>
                <td><?= htmlspecialchars($paciente->getNome()) ?></td>
                <td><?= htmlspecialchars($paciente->getCpf()) ?></td>
                <td>
                    <button class="btn" onclick="location.href='visualizarPaciente.php?cpf=<?= $paciente->getCpf() ?>'">Visualizar</button>
                    <button class="btn" onclick="location.href='../../view/form_incluir_paciente.php?cpf=<?= $paciente->getCpf() ?>'">Editar</button>
                    <button class="btn-excluir" onclick="if(confirm('Deseja realmente excluir este paciente?')) location.href='excluirPaciente.php?cpf=<?= $paciente->getCpf() ?>'">Excluir</button>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>

        <a href="../../public/login_assistente.php" class="btn-voltar">Voltar</a>
    </div>

</body>
</html>