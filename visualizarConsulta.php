<?php
require_once '../../controller/ConsultaController.php';
require_once '../../controller/MedicoController.php';

$consultaController = new ConsultaController();
$medicoController = new MedicoController();

// Pega o mês e ano selecionados via GET ou usa o mês atual por padrão
$selectedMonth = $_GET['month'] ?? date('Y-m');
$consultas = [];

// Se recebeu um mês válido, filtra as consultas desse mês
if ($selectedMonth) {
    // '2023-05', por exemplo
    $yearMonth = $selectedMonth;
    // Busca as consultas do mês e ano selecionados
    $consultas = $consultaController->listarPorMes($yearMonth);
} else {
    // Se não houver filtro, busca todas as consultas ordenadas
    $consultas = $consultaController->listarTodasOrdenadas();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Consultas por Mês</title>

</head>
<body>
<div class="container">
    <h2>Consultas por Mês</h2>

    <form method="GET" action="">
        <label for="month">Selecione o mês:</label>
        <input type="month" id="month" name="month" value="<?= htmlspecialchars($selectedMonth) ?>" required>
        <button type="submit">Filtrar</button>
    </form>

    <?php if (empty($consultas)): ?>
        <p class="no-data">Nenhuma consulta encontrada para <?= date('m/Y', strtotime($selectedMonth . '-01')) ?>.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Data e Hora</th>
                    <th>Paciente (CPF)</th>
                    <th>Médico</th>
                    <th>Especialização</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($consultas as $consulta): ?>
                    <?php
                        $medico = $medicoController->buscarPorEmail($consulta->getMedicoEmail());
                    ?>
                    <tr>
                        <td><?= htmlspecialchars(date('d/m/Y H:i', strtotime($consulta->getDataHora()))) ?></td>
                        <td><?= htmlspecialchars($consulta->getPacienteCpf()) ?></td>
                        <td><?= $medico ? htmlspecialchars($medico->getNome()) : 'Médico não encontrado' ?></td>
                        <td><?= $medico ? htmlspecialchars($medico->getEspecializacao()) : '-' ?></td>
                        <td>
                            <button class="btn btn-editar" onclick="location.href='../../view/form_editar_consulta.php?id=<?= $consulta->getId() ?>'">Editar</button>
                            <button class="btn btn-excluir" onclick="if(confirm('Tem certeza que deseja excluir esta consulta?')) location.href='excluirConsulta.php?id=<?= $consulta->getId() ?>'">Excluir</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <a href="../../public/login_assistente.php" class="btn-voltar">Voltar</a>
</div>
</body>
</html>
