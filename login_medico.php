<?php
session_start();
require_once __DIR__ . '/../config/Database.php';

if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: ../index.php");
    exit;
}


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $db = new Database();
    $conn = $db->conectar();

    // Escapar os dados (minimiza risco, mas não substitui prepared statements)
    $email = $conn->real_escape_string($email);
    $senha = $conn->real_escape_string($senha);

    // Verifica se o usuário existe na tabela Usuario
    $sqlUsuario = "SELECT * FROM Usuario WHERE email = '$email' AND senha = '$senha'";
    $usuario_result = $conn->query($sqlUsuario);

    if ($usuario_result->num_rows > 0) {
        // Verifica se esse usuário é médico
        $sqlMedico = "SELECT * FROM Medico WHERE Usuario_email = '$email'";
        $medico_result = $conn->query($sqlMedico);

        if ($medico_result->num_rows > 0) {
            $_SESSION['usuario_tipo'] = 'medico';
            $_SESSION['email'] = $email;
        } else {
            $erro_login = "Este usuário não é um médico.";
        }
    } else {
        $erro_login = "Senha inválida.";
    }
}

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <title>Login Médico</title>
    <link rel="stylesheet" href="../css/login.css">
</head>
<body>
    <div style="text-align:center;">
<?php if (isset($_SESSION['email'])): ?>
    <div class="top-bar">
            <div>MedControl 🩺</div>
            <div>ÁREA DO MÉDICO</div>
        </div>

    <div class="main">
    <!-- Sidebar -->
    <div class="sidebar">
        <a href="?action=agenda_pessoal">AGENDA PESSOAL</a>
        <a href="?action=registrar_diagnostico">REGISTRAR DIAGNÓSTICO</a>
        <a href="?action=relatorio_paciente">RELATÓRIO DO PACIENTE</a>
        <a href="?logout=true">SAIR</a>
    </div>

    <!-- Conteúdo Principal -->
    <div class="content">
        <img src="https://cdn-icons-png.flaticon.com/512/847/847969.png" alt="Ícone usuário" width="80" height="80">
        <h2><?= htmlspecialchars($_SESSION['email']) ?></h2>

        <?php
        $action = $_GET['action'] ?? '';

        switch ($action) {
            case 'agenda_pessoal':
                header("Location: agendaPessoal.php");
                exit;

            case 'registrar_diagnostico':
                header("Location: ../view/selecionar_consulta.php");
                exit;

            case 'relatorio_paciente':
                header("Location: ../view/buscar_consulta_por_paciente.php");
                exit;

            default:
                echo "<p>Selecione uma opção no menu à esquerda.</p>";
                break;
        }
        ?>
    </div>
</div>

<?php else: ?>
    <h2>Login Médico</h2>
    <?php if (isset($erro_login)) echo "<p style='color:red;'>$erro_login</p>"; ?>
    <form method="post">
        <label for="email">E-mail:</label>
        <input type="email" id="email" name="email" required><br><br>
        <label for="senha">Senha:</label>
        <input type="password" id="senha" name="senha" required><br><br>
        <a href="../index.php" style="margin-left: 20px;">
            <button type="button">Voltar </button>
        </a>

        <button type="submit">Entrar</button>
        
    </form>
<?php endif; ?>
</div>
</body>
</html>

