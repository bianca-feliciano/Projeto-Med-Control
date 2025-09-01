<?php
require_once '../controller/PacienteController.php';

$paciente = null;
if (isset($_GET['cpf'])) {
    $controller = new PacienteController();
    $paciente = $controller->buscarPorCpf($_GET['cpf']);
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Paciente</title>
    <link rel="stylesheet" href="../css/form.css">
</head>
<body>
    <div class="top-bar">
        <div>MedControl 🩺</div>
        <div>CADASTRAR PACIENTE</div>
    </div>

    <div class="main-content">
        <div class="container">
            <form method="POST" action="../public/paciente/incluirPaciente.php">
                <?php if ($paciente): ?>
                    <input type="hidden" name="cpf" value="<?= htmlspecialchars($paciente->getCpf()) ?>">
                <?php endif; ?>

                <label>Nome</label>
                <input type="text" name="nome" value="<?= $paciente ? htmlspecialchars($paciente->getNome()) : '' ?>" required>

                <label>CPF</label>
                <?php if ($paciente): ?>
                    <input type="text" value="<?= htmlspecialchars($paciente->getCpf()) ?>" disabled>
                <?php else: ?>
                    <input type="text" name="cpf" required>
                <?php endif; ?>

                <label>Data de Nascimento</label>
                <input type="date" name="data_nascimento" value="<?= $paciente ? htmlspecialchars($paciente->getDataNascimento()) : '' ?>" required>

                <label>Telefone</label>
                <input type="text" name="telefone" value="<?= $paciente ? htmlspecialchars($paciente->getTelefone()) : '' ?>" required>

                <label>Endereço</label>
                <input type="text" name="endereco" value="<?= $paciente ? htmlspecialchars($paciente->getEndereco()) : '' ?>" required>

                <input type="submit" value="Salvar">
            </form>
        </div>
</body>
</html>
