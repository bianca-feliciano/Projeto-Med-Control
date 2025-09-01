<?php
require_once '../controller/ConsultaController.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Acesso inválido.");
}

$cpfInput = $_POST['cpf'] ?? '';
// Limpa CPF para ter só números
$cpf = preg_replace('/\D/', '', $cpfInput);

if (strlen($cpf) !== 11) {
    die("CPF inválido. Deve conter 11 dígitos numéricos.");
}

$consultaController = new ConsultaController();

try {
    $consultas = $consultaController->listarPorPacienteCpf($cpf);
} catch (Exception $e) {
    die("Erro ao buscar consultas: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Consultas do Paciente</title>
    <link rel="stylesheet" href="../css/pacienteDados.css">
</head>
<body>
    <div class="top-bar">
        <div>MedControl 🩺</div>
        <div>CONSULTAS DO PACIENTE</div>
    </div>

    <div class="container">
        <?php if (empty($consultas)): ?>
            <p class="message">Nenhuma consulta encontrada para o paciente com CPF <?= htmlspecialchars($cpf) ?>.</p>
        <?php else: ?>
            <table>
                <tr>
                    <th>MÉDICO (EMAIL)</th>
                    <th>DATA/HORÁRIO</th>
                    <th>DIAGNÓSTICO</th>
                </tr>
                <?php foreach ($consultas as $consulta): ?>
                    <?php
                        // Formatar data/hora no padrão dd/mm/YYYY HH:ii
                        $dataHora = date('d/m/Y H:i', strtotime($consulta->getDataHora()));
                    ?>
                    <tr>
                        <td><?= htmlspecialchars($consulta->getMedicoEmail()) ?></td>
                        <td><?= $dataHora ?></td>
                        <td><?= htmlspecialchars($consulta->getDiagnostico()) ?></td>
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