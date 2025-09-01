<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Acesso inválido");
}

require_once '../../controller/MedicoController.php';
require_once '../../model/Medico.php';

// Verificação segura dos dados recebidos
$email = $_POST['email'] ?? '';
$senha = $_POST['senha'] ?? '';
$crm = $_POST['crm'] ?? '';
$especializacao = $_POST['especializacao'] ?? '';
$nome = $_POST['nome'] ?? '';
$dataNascimento = $_POST['data_nascimento'] ?? '';

// Cria objeto Medico
$medico = new Medico($email, $senha, $crm, $especializacao, $nome, $dataNascimento);

// Salva no banco
$controller = new MedicoController();
$controller->salvarOuAtualizar($medico);

// Redireciona após salvar
header("Location: ../../public/medico/indexMedico.php");
exit;
?>
