<?php
session_start();
require_once __DIR__ . '/../controller/ConsultaController.php';
require_once __DIR__ . '/../controller/PacienteController.php';

$email = $_SESSION['email'] ?? null;
if (!$email) {
    die("Usuário não autenticado.");
}

$consultaController = new ConsultaController();
$pacienteController = new PacienteController();

try {
    $consultas = $consultaController->listarPorMedicoEmail($email);
} catch (Exception $e) {
    die("Erro ao buscar consultas: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Agenda Pessoal</title>
    <link rel="stylesheet" href="../css/agendaPessoal.css">
</head>
<body>
    <div class="top-bar">
        <div>MedControl 🩺</div>
        <div>AGENDA PESSOAL</div>
    </div>

    <div class="container">
        <?php if (empty($consultas)): ?>
            <p>Nenhuma consulta agendada.</p>
        <?php else: ?>
            <table>
                <tr>
                    <th>DATA/HORÁRIO</th>
                    <th>PACIENTE</th>
                    <th></th>
                </tr>
                <?php foreach ($consultas as $consulta): ?>
                    <?php
                        $paciente = $pacienteController->buscarPorCpf($consulta->getPacienteCpf());
                        $dataHora = date('d/m/Y H:i', strtotime($consulta->getDataHora()));
                        $cpf = htmlspecialchars($paciente ? $paciente->getCpf() : '');
                    ?>
                    <tr>
                        <td><?= $dataHora ?></td>
                        <td><?= htmlspecialchars($paciente ? $paciente->getNome() : 'Desconhecido') ?></td>
                        <td>
                            <?php if ($cpf): ?>
                                <a href="ver_paciente.php?cpf=<?= urlencode($cpf) ?>" title="Ver dados do paciente">🔍</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>

        <form action="login_medico.php" method="get">
            <button class="btn-voltar">VOLTAR</button>
        </form>
    </div>
</body>
</html>