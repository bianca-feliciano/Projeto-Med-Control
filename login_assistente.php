<?php
session_start();
require_once __DIR__ . '/../config/Database.php';

// Logout
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: ../index.php");
    exit;
}

// Login
if ($_SERVER["REQUEST_METHOD"] === "POST" && !isset($_SESSION['assistente'])) {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $db = new Database();
    $conn = $db->conectar();

    // Escapa os dados para evitar SQL Injection (não é totalmente seguro, mas ajuda um pouco)
    $email = $conn->real_escape_string($email);
    $senha = $conn->real_escape_string($senha);

    // Consulta direta na tabela Usuario
    $sqlUsuario = "SELECT * FROM Usuario WHERE email = '$email' AND senha = '$senha'";
    $usuario_result = $conn->query($sqlUsuario);

    if ($usuario_result->num_rows > 0) {
        // Verifica se esse usuário é assistente
        $sqlAssistente = "SELECT * FROM Assistente WHERE Usuario_email = '$email'";
        $assistente_result = $conn->query($sqlAssistente);

        if ($assistente_result->num_rows > 0) {
            $_SESSION['assistente'] = $email;
        } else {
            $erro_login = "Este usuário não é um assistente.";
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
    <title>Painel Assistente</title>
    <link rel="stylesheet" href="../css/login.css">
</head>
<body>
    <div style="text-align:center;">

    <?php if (!isset($_SESSION['assistente'])): ?>
        <!-- Tela de Login -->
        <h2>Login Assistente</h2>
        <?php if (isset($erro_login)) echo "<p style='color:red;'>$erro_login</p>"; ?>
        <form method="post">
            <label for="email">E-mail:</label>
            <input type="email" name="email" id="email" required><br><br>
            <label for="senha">Senha:</label>
            <input type="password" name="senha" id="senha" required><br><br>
            <a href="../index.php" style="margin-left: 20px;">
                <button type="button">Voltar </button>
            </a>
            <button type="submit">Entrar</button>
        </form>

    <?php else: ?>
        <!-- Interface Logada -->
        <div class="top-bar">
            <div>MedControl 🩺</div>
            <div>ÁREA DA ASSISTENTE</div>
        </div>

        <div class="main">
            <!-- Sidebar -->
            <div class="sidebar">
                <a href="?action=gerenciar_pacientes">GERENCIAR PACIENTE</a>
                <a href="?action=gerenciar_medicos">GERENCIAR MÉDICO</a>
                <a href="?action=gerenciar_consultas">GERENCIAR CONSULTAS</a>
                <a href="?action=relatorio_medico">OBTER RELATÓRIO DO MÉDICO</a>
                <a href="?logout=true">SAIR</a>
            </div>

            <!-- Conteúdo Principal -->
            <div class="content">
                <img src="https://cdn-icons-png.flaticon.com/512/847/847969.png" alt="Ícone usuário" width="80" height="80">
                <h2><?= htmlspecialchars($_SESSION['assistente']) ?></h2>

                <?php
                $action = $_GET['action'] ?? '';

                switch ($action) {
                    case 'gerenciar_consultas':
                        echo "<h2>Gerenciar Consultas</h2>";
                        echo '<a href="../view/form_incluir_consulta.php"><button>Cadastrar Nova Consulta</button></a> ';
                        echo '<a href="../public/consulta/visualizarConsulta.php"><button>Visualização de Consultas</button></a>';
                        break;

                    case 'gerenciar_medicos':
                        echo "<h2>Gerenciar Médicos</h2>";
                        echo '<a href="../view/form_incluir_medico.php"><button>Cadastrar Novo Médico</button></a> ';
                        echo '<a href="../public/medico/indexMedico.php"><button>Gerenciar Médicos</button></a>';
                        break;

                    case 'gerenciar_pacientes':
                        echo "<h2>Gerenciar Pacientes</h2>";
                        echo '<a href="../view/form_incluir_paciente.php"><button>Cadastrar Novo Paciente</button></a> ';
                        echo '<a href="../public/paciente/indexPaciente.php"><button>Gerenciar Pacientes</button></a>';
                        break;

                    case 'relatorio_medico':
                        header("Location: ../view/form_relatorio_medico.php");
                        exit;

                    default:
                        echo "<p>Selecione uma opção no menu à esquerda.</p>";
                        break;
                }
                ?>
            </div>
        </div>
    <?php endif; ?>
    </div>
</body>
</html>
