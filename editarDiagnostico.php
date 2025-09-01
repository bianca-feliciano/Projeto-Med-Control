<?php
require_once '../controller/ConsultaController.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    die("ID da consulta não informado.");
}

$consultaController = new ConsultaController();
$consulta = $consultaController->buscarPorId($id);
if (!$consulta) {
    die("Consulta não encontrada.");
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Editar Diagnóstico</title>
<link rel="stylesheet" href="../css/editarDiagnostico.css">
</head>
<body>
  <div class="header">ÁREA DO MÉDICO</div>

  <div class="container">
    <h2>Editar Diagnóstico</h2>

    <form method="post" action="atualizarDiagnostico.php">
      <input type="hidden" name="id" value="<?= $consulta->getId() ?>" />

      <p><strong>Data/Hora:</strong> <?= htmlspecialchars($consulta->getDataHora()) ?></p>
      <p><strong>Paciente CPF:</strong> <?= htmlspecialchars($consulta->getPacienteCpf()) ?></p>

      <label for="diagnostico">Diagnóstico:</label>
      <textarea name="diagnostico" id="diagnostico" rows="4" required><?= htmlspecialchars($consulta->getDiagnostico()) ?></textarea>

      <button type="submit">Salvar Alterações</button>
    </form>

    <form method="get" action="login_medico.php" style="margin-top: 8px;">
      <button type="submit" class="btn-voltar">Voltar</button>
    </form>
  </div>
</body>
</html>