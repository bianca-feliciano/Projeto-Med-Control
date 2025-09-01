<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Acesso inválido");
}

require_once '../../controller/ConsultaController.php';
require_once '../../model/Consulta.php';

// Pega os dados do formulário
$id = $_POST['id'] ?? null;  // pode ser null para nova consulta
$emailMedico = $_POST['emailMedico'] ?? '';
$cpf = $_POST['cpf'] ?? '';
$dataHoraInput = $_POST['data_hora'] ?? '';
$descricao = $_POST['descricao'] ?? '';

// Valida campos obrigatórios
if (empty($emailMedico) || empty($cpf) || empty($dataHoraInput)) {
    die("Todos os campos são obrigatórios.");
}

// Converte datetime-local "YYYY-MM-DDTHH:MM" para "YYYY-MM-DD HH:MM:SS"
$dataHora = str_replace('T', ' ', $dataHoraInput) . ':00';

// Limpa CPF para conter só números
$cpfLimpo = preg_replace('/\D/', '', $cpf);
$cpfLimpo = substr($cpfLimpo, 0, 11);

// Valida CPF limpo
if (strlen($cpfLimpo) !== 11) {
    die("CPF inválido: deve conter 11 dígitos numéricos.");
}

// Cria objeto Consulta (ajuste o construtor conforme sua classe)
$consulta = new Consulta($emailMedico, $cpfLimpo, $dataHora, $descricao);

// Se estiver editando, seta o ID na consulta
if (!empty($id)) {
    $consulta->setId((int)$id);
}

$controller = new ConsultaController();

try {
    $sucesso = $controller->salvarOuAtualizar($consulta);

    if ($sucesso) {
        // Pega o ID atualizado/inserido para redirecionar
        $idConsulta = $consulta->getId();
        header("Location: ../../public/consulta/visualizarConsulta.php?id=" . urlencode($idConsulta));
        exit;
    } else {
        die("Erro ao salvar consulta. Verifique os dados do médico e paciente.");
    }
} catch (Exception $e) {
    die("Erro: " . $e->getMessage());
}
