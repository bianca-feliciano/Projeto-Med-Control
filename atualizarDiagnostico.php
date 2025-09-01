<?php
require_once '../controller/ConsultaController.php';
require_once '../model/Consulta.php';

// Verifica se a requisição é POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Acesso inválido.");
}

// Captura os dados enviados
$id = $_POST['id'] ?? null;
$diagnostico = trim($_POST['diagnostico'] ?? '');

// Validação básica
if (!$id) {
    die("ID da consulta não informado.");
}
if (empty($diagnostico)) {
    die("Diagnóstico não pode estar vazio.");
}

// Instancia o controller e tenta buscar a consulta existente
$controller = new ConsultaController();
$consulta = $controller->buscarPorId($id);

if (!$consulta) {
    die("Consulta não encontrada.");
}

// Atualiza o diagnóstico
$consulta->setDiagnostico($diagnostico);

// Salva as alterações
try {
    $atualizado = $controller->salvarOuAtualizar($consulta);
    if ($atualizado) {
        header("Location: login_medico.php?id=" . urlencode($id));
        exit;
    } else {
        die("Erro ao atualizar diagnóstico.");
    }
} catch (Exception $e) {
    die("Erro: " . $e->getMessage());
}