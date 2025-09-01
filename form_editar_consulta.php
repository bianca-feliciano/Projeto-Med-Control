<?php
require_once '../controller/ConsultaController.php';
require_once '../controller/MedicoController.php';
require_once '../controller/PacienteController.php';

if (!isset($_GET['id'])) {
    header("Location: visualizarConsultas.php");
    exit;
}

$id = (int) $_GET['id'];

$consultaController = new ConsultaController();
$medicoController = new MedicoController();
$pacienteController = new PacienteController();

try {
    // Busca consulta pelo id
    $consulta = $consultaController->buscarPorId($id);
} catch (Exception $e) {
    echo "Erro ao carregar consulta: " . $e->getMessage();
    exit;
}

if (!$consulta) {
    echo "Consulta não encontrada.";
    exit;
}

// Carrega listas para selects
$medicos = $medicoController->listarTodos();
$pacientes = $pacienteController->listarTodos();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <title>Editar Consulta</title>
    <link rel="stylesheet" href="../css/form.css">
</head>
<body>
    <div class="top-bar">
        <div>MedControl 🩺</div>
        <div>EDITAR CONSULTA</div>
    </div>

    <div class="main-content">
        <div class="container">
            <form action="../public/consulta/editarConsulta.php" method="POST">
                <input type="hidden" name="id" value="<?= htmlspecialchars($consulta->getId()) ?>" />

                <label for="data_hora">Data e Hora:</label>
                <input type="datetime-local" id="data_hora" name="data_hora"
                    value="<?= date('Y-m-d\TH:i', strtotime($consulta->getDataHora())) ?>" required />

                <label for="medico_email">Médico:</label>
                <select id="medico_email" name="emailMedico" required>
                    <option value="">Selecione o médico</option>
                    <?php foreach ($medicos as $medico): ?>
                        <option value="<?= htmlspecialchars($medico->getEmail()) ?>"
                            <?= $medico->getEmail() === $consulta->getMedicoEmail() ? 'selected' : '' ?>>
                            <?= htmlspecialchars($medico->getNome()) ?> - <?= htmlspecialchars($medico->getEspecializacao()) ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <label for="paciente_cpf">Paciente:</label>
                <select id="paciente_cpf" name="cpf" required>
                    <option value="">Selecione o paciente</option>
                    <?php foreach ($pacientes as $paciente): ?>
                        <option value="<?= htmlspecialchars($paciente->getCpf()) ?>"
                            <?= $paciente->getCpf() === $consulta->getPacienteCpf() ? 'selected' : '' ?>>
                            <?= htmlspecialchars($paciente->getNome()) ?> (CPF: <?= htmlspecialchars($paciente->getCpf()) ?>)
                        </option>
                    <?php endforeach; ?>
                </select>

                <button type="submit">Salvar Alterações</button>
            </form>

            <form action="../public/consulta/visualizarConsulta.php" method="GET">
                <button type="submit" class="btn-cancelar">Cancelar</button>
            </form>
        </div>
</body>
</html>
