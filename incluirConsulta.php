<?php
// Permite acesso apenas via método POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Acesso inválido");
}

require_once '../../controller/ConsultaController.php';
require_once '../../model/Consulta.php';

// Captura os dados do formulário com trim para evitar espaços extras
$emailMedico = trim($_POST['emailMedico'] ?? '');
$cpf = trim($_POST['cpf'] ?? '');
$dataHoraInput = trim($_POST['dataHora'] ?? '');


// Validação dos campos obrigatórios
if (empty($emailMedico) || empty($cpf) || empty($dataHoraInput) ) {
    die("Todos os campos são obrigatórios.");
}

// Validação básica do email
if (!filter_var($emailMedico, FILTER_VALIDATE_EMAIL)) {
    die("Email do médico inválido.");
}

// Limpa CPF para conter somente números
$cpfLimpo = preg_replace('/\D/', '', $cpf);

// Verifica se o CPF tem 11 dígitos
if (strlen($cpfLimpo) !== 11) {
    die("CPF inválido: deve conter 11 dígitos numéricos.");
}

// Converte datetime-local "YYYY-MM-DDTHH:MM" para "YYYY-MM-DD HH:MM:SS"
$dataHora = str_replace('T', ' ', $dataHoraInput) . ':00';

// Cria o objeto Consulta
$consulta = new Consulta($emailMedico, $cpfLimpo, $dataHora, null);

// Instancia o controller
$controller = new ConsultaController();

try {
    // Salva a consulta (inserção)
    $salvo = $controller->salvarOuAtualizar($consulta);

    if ($salvo) {
        $idConsulta = $consulta->getId();

        if (empty($idConsulta)) {
            die("Consulta salva, mas não foi possível obter o ID para redirecionamento.");
        }

        // Redireciona para a página de visualização da consulta
        header("Location: ../../public/consulta/visualizarConsulta.php?id=" . urlencode($idConsulta));
        exit;
    } else {
        die("Erro ao salvar a consulta. Verifique os dados e tente novamente.");
    }
} catch (Exception $e) {
    die("Erro inesperado: " . $e->getMessage());
}
