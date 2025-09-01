<?php
require_once __DIR__ . '/../controller/ConsultaController.php';
require_once __DIR__ . '/../controller/PacienteController.php';

if (!isset($_GET['email'], $_GET['mes'], $_GET['ano'])) {
    die("Parâmetros incompletos.");
}

$email = $_GET['email'];
$mes = (int) $_GET['mes'];
$ano = (int) $_GET['ano'];

$consultaController = new ConsultaController();
$pacienteController = new PacienteController();

try {
    $consultas = $consultaController->listarPorMedicoEmailEMesAno($email, $mes, $ano);
} catch (Exception $e) {
    die("Erro ao gerar relatório: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Relatório de Pacientes Atendidos</title>
    <link rel="stylesheet" href="../css/relatorio.css">
</head>
<body>

<div class="top-bar">
    <div>MedControl 🩺</div>
    <div>Relatório de Pacientes Atendidos</div>
</div>

<div class="container">

<?php
if (empty($consultas)) {
    echo "<h3>Nenhuma consulta encontrada para o médico " . htmlspecialchars($email) . " em " . str_pad($mes, 2, '0', STR_PAD_LEFT) . "/" . htmlspecialchars($ano) . ".</h3>";
} else {
    echo "<h2>Relatório de Pacientes Atendidos</h2>";
    echo "<p><strong>Médico:</strong> " . htmlspecialchars($email) . "</p>";
    echo "<p><strong>Período:</strong> " . str_pad($mes, 2, '0', STR_PAD_LEFT) . "/" . htmlspecialchars($ano) . "</p>";
    echo "<table>";
    echo "<thead><tr><th>Nome do Paciente</th><th>CPF</th><th>Data/Hora da Consulta</th></tr></thead>";
    echo "<tbody>";
    foreach ($consultas as $consulta) {
        $paciente = $pacienteController->buscarPorCpf($consulta->getPacienteCpf());
        if ($paciente) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($paciente->getNome()) . "</td>";
            echo "<td>" . htmlspecialchars($paciente->getCpf()) . "</td>";
            echo "<td>" . htmlspecialchars(date('d/m/Y H:i', strtotime($consulta->getDataHora()))) . "</td>";
            echo "</tr>";
        }
    }
    echo "</tbody>";
    echo "</table>";
}
?>

<div class="btn-container">
    <button class="btn-voltar" onclick="location.href='login_assistente.php'">Voltar</button>
    <?php if (!empty($consultas)): ?>
        <button id="btnPdf">Gerar PDF</button>
    <?php endif; ?>
</div>

</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.23/jspdf.plugin.autotable.min.js"></script>

<script>
document.getElementById('btnPdf')?.addEventListener('click', () => {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();

    doc.setFontSize(18);
    doc.setTextColor(0, 77, 0);
    doc.text("Relatório de Pacientes Atendidos", 14, 20);

    doc.setFontSize(12);
    doc.setTextColor(0, 0, 0);
    doc.text("Médico: <?= addslashes(htmlspecialchars($email)) ?>", 14, 30);
    doc.text("Período: <?= str_pad($mes, 2, '0', STR_PAD_LEFT) ?>/<?= $ano ?>", 14, 38);

    let startY = 50;
    doc.autoTable({
        startY: startY,
        head: [['Nome do Paciente', 'CPF', 'Data/Hora da Consulta']],
        body: [
            <?php
            foreach ($consultas as $consulta):
                $paciente = $pacienteController->buscarPorCpf($consulta->getPacienteCpf());
                if ($paciente):
                    $nome = addslashes(htmlspecialchars($paciente->getNome()));
                    $cpf = addslashes(htmlspecialchars($paciente->getCpf()));
                    $dataHora = date('d/m/Y H:i', strtotime($consulta->getDataHora()));
                    echo "['$nome', '$cpf', '$dataHora'],";
                endif;
            endforeach;
            ?>
        ],
        styles: { fontSize: 10 },
        headStyles: { fillColor: [178, 250, 180] },
        theme: 'striped'
    });

    doc.save('relatorio_pacientes.pdf');
});
</script>

</body>
</html>