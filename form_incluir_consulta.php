<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <title>Cadastrar Consulta</title>
</head>
<body>
    <div class="top-bar">
        <div>MedControl 🩺</div>
        <div>CADASTRAR CONSULTA</div>
    </div>

    <div class="main-content">
        <div class="container">
            <link rel="stylesheet" href="../css/form.css">
            <form method="POST" action="../public/consulta/incluirConsulta.php">

                <label for="emailMedico">Email do Médico</label>
                <input type="email" id="emailMedico" name="emailMedico" required>

                <label for="cpf">CPF do Paciente</label>
                <input type="text" id="cpf" name="cpf" required>

                <label for="dataHora">Data e Hora da Consulta</label>
                <input type="datetime-local" id="dataHora" name="dataHora" required>

                <input type="submit" value="Salvar Consulta">

            </form>
        </div>
</body>
</html>
