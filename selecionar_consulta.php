<?php
session_start();
require_once '../controller/ConsultaController.php';

$email = $_SESSION['email'] ?? null;

if (!$email) {
    die("Médico não autenticado.");
}

$consultaController = new ConsultaController();
$consultas = $consultaController->listarPorMedicoEmail($email);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Selecionar Consulta</title>
    <link rel="stylesheet" href="../css/form.css">
</head>
<body>
    <div class="top-bar">
        <div>MedControl 🩺</div>
        <div>SELECIONAR CONSULTA</div>
    </div>

    <div class="main-content">
        <div class="container">
            <form method="get" action="../public/editarDiagnostico.php">
                <label for="consulta">Escolha uma consulta:</label>
                <select name="id" id="consulta" required>
                    <?php foreach ($consultas as $consulta): ?>
                        <option value="<?= $consulta->getId() ?>">
                            <?= htmlspecialchars($consulta->getDataHora()) ?> - Paciente CPF: <?= htmlspecialchars($consulta->getPacienteCpf()) ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <input type="submit" value="Editar Diagnóstico">
            </form>
        </div>
    </div>
</body>
</html>
