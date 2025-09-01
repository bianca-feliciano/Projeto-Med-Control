<?php
require_once '../../controller/PacienteController.php';

if (isset($_GET['cpf'])) {
    $cpf = $_GET['cpf'];

    $controller = new PacienteController();
    $controller->excluir($cpf);
}

header("Location: indexPaciente.php");
exit;
?>

