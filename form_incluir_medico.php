<?php
require_once '../controller/MedicoController.php';

$medico = null;
if (isset($_GET['crm'])) {
    $controller = new MedicoController();
    $medico = $controller->buscarPorCrm($_GET['crm']);
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Médico</title>
    <link rel="stylesheet" href="../css/form.css">
</head>
<body>
    <div class="top-bar">
        <div>MedControl 🩺</div>
        <div>CADASTRAR MÉDICO</div>
    </div>

    <div class="main-content">
        <div class="container">
            <form method="POST" action="../public/medico/incluirMedico.php">
                <?php if ($medico): ?>
                    <input type="hidden" name="crm" value="<?= htmlspecialchars($medico->getCrm()) ?>">
                <?php endif; ?>

                <label>Nome</label>
                <input type="text" name="nome" value="<?= $medico ? htmlspecialchars($medico->getNome()) : '' ?>" required>

                <label>CRM</label>
                <?php if ($medico): ?>
                    <input type="text" value="<?= htmlspecialchars($medico->getCrm()) ?>" disabled>
                <?php else: ?>
                    <input type="text" name="crm" required>
                <?php endif; ?>

                <label>Especialização</label>
                <input type="text" name="especializacao" value="<?= $medico ? htmlspecialchars($medico->getEspecializacao()) : '' ?>" required>

                <label>Data de Nascimento</label>
                <input type="date" name="data_nascimento" value="<?= $medico ? htmlspecialchars($medico->getDataNascimento()) : '' ?>" required>

                <label>Email</label>
                <input type="email" name="email" value="<?= $medico ? htmlspecialchars($medico->getEmail()) : '' ?>" required>

                <label>Senha</label>
                <input type="text" name="senha" <?= $medico ? 'placeholder="Preencha apenas para alterar"' : 'required' ?>>

                <input type="submit" value="Salvar">
            </form>
        </div>
    </div>
</body>
</html>
