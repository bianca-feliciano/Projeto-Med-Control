<?php
require_once '../../controller/MedicoController.php';

if (isset($_GET['crm'])) {
    $crm = $_GET['crm'];

    $controller = new MedicoController();
    $controller->excluir($crm);
}

header("Location: indexMedico.php");
exit;
?>
