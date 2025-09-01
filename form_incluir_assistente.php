<?php
require_once '../controller/AssistenteController.php';

$assistente = null;
if (isset($_GET['cpf'])) {
    $controller = new AssistenteController();
    $assistente = $controller->buscarPorCpf($_GET['cpf']);
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Assistente</title>
    <link rel="stylesheet" href="../css/form.css">
</head>
<body>
    <div class="top-bar">
        <div>MedControl 🩺</div>
        <div>CADASTRAR ASSISTENTE</div>
    </div>

    <div class="main-content">
        <div class="container">
            <form method="POST" action="../public/assistente/incluirAssistente.php">
                <?php if ($assistente): ?>
                    <input type="hidden" name="cpf" value="<?= htmlspecialchars($assistente->getCpf()) ?>">
                <?php endif; ?>

                <label>Nome</label>
                <input type="text" name="nome" value="<?= $assistente ? htmlspecialchars($assistente->getNome()) : '' ?>" required>

                <label>CPF</label>
                <?php if ($assistente): ?>
                    <input type="text" value="<?= htmlspecialchars($assistente->getCpf()) ?>" disabled>
                <?php else: ?>
                    <input type="text" name="cpf" required>
                <?php endif; ?>

                <label>Telefone</label>
                <input type="text" name="telefone" value="<?= $assistente ? htmlspecialchars($assistente->getTelefone()) : '' ?>" required>

                <label>Data de Nascimento</label>
                <input type="date" name="data_nascimento" value="<?= $assistente ? htmlspecialchars($assistente->getDataNascimento()) : '' ?>" required>

                <label>Endereço</label>
                <input type="text" name="endereco" value="<?= $assistente ? htmlspecialchars($assistente->getEndereco()) : '' ?>" required>

                <label>Email</label>
                <input type="email" name="email" value="<?= $assistente ? htmlspecialchars($assistente->getEmail()) : '' ?>" required>

                <label>Senha</label>
                <input type="text" name="senha" <?= $assistente ? 'placeholder="Preencha apenas para alterar"' : 'required' ?>>

                <input type="submit" value="Salvar">
            </form>
        </div>
</body>
</html>
