<?php
require_once '../../controller/ConsultaController.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $controller = new ConsultaController();
    $controller->excluir($id);
}

header("Location: visualizarConsulta.php"); // Ajuste para a página que lista as consultas
exit;
?>
