
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <title>Relatório de Pacientes por Médico</title>
    <link rel="stylesheet" href="../css/form.css">
</head>
<body>
    <div class="top-bar">
        <div>MedControl 🩺</div>
        <div>RELATÓRIO MÉDICO</div>
    </div>

    <div class="main-content">
        <div class="container">
            <form method="GET" action="../public/gerar_relatorio_medico.php">
                <label for="email">Email do Médico:</label>
                <input type="email" id="email" name="email" placeholder="exemplo@medico.com" required>

                <label for="mes">Mês:</label>
                <select id="mes" name="mes" required>
                    <option value="">Selecione o mês</option>
                    <?php
                        // Exibir os meses com nomes por extenso
                        setlocale(LC_TIME, 'pt_BR.UTF-8');
                        for ($m = 1; $m <= 12; $m++) {
                            $mesNome = strftime('%B', mktime(0, 0, 0, $m, 1));
                            echo "<option value=\"$m\">" . ucfirst($mesNome) . "</option>";
                        }
                    ?>
                </select>

                <label for="ano">Ano:</label>
                <input type="text" id="ano" name="ano" placeholder="Ex: 2025" required pattern="\d{4}" title="Digite um ano válido com 4 dígitos">

                <input type="submit" value="Gerar Relatório">
            </form>
        </div>
</body>
</html>
