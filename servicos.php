<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GoBarber - Agendamento de Serviços</title>
    <link rel="stylesheet" href="servicos.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Agendamento de Serviços</h1>
            <?php
            session_start();
            ?>
        </header>
        <section class="barber-info">
            <?php
            // Verificar se o parâmetro barbeiro foi recebido na URL
            if (isset($_GET['barbeiro'])) {
                $barbeiroSelecionado = $_GET['barbeiro'];

                // Conectar ao banco de dados para buscar informações do barbeiro
                $servername = "localhost";
                $username = "root";
                $password = "root";
                $dbname = "RBR";

                $conn = new mysqli($servername, $username, $password, $dbname);

                if ($conn->connect_error) {
                    die("Conexão falhou: " . $conn->connect_error);
                }

                // Consulta SQL para buscar a foto do barbeiro
                $sql = "SELECT foto FROM cabeleireiros WHERE nome = '$barbeiroSelecionado'";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $fotoBarbeiro = $row['foto'];

                    // Exibir a foto e o nome do barbeiro
                    echo "<div class='barber-profile'>";
                    echo "<img src='$fotoBarbeiro' alt='Foto do barbeiro' class='avatar'>";
                    echo "<h2>$barbeiroSelecionado</h2>";
                    echo "</div>";
                }

                $conn->close();
            } else {
                echo "<p>Nenhum barbeiro selecionado.</p>";
            }
            ?>
        </section>
        <section class="servicos">
            <?php
            // Serviços com valores fixos
            $servicos = array(
                "Corte" => 45,
                "Barba" => 45,
                "Maquina" => 25,
                "Degrade" => 35,
                "Corte+barba" => 80,
                "Degrade+barba" => 70,
                "Maquina+barba" => 60
            );

            // Inicializar variáveis de serviço e valor
            $servicoSelecionado = $_GET['servico'] ?? '';
            $valor = '';

            // Verificar se o serviço foi selecionado e definir o valor
            if ($servicoSelecionado && isset($servicos[$servicoSelecionado])) {
                $valor = $servicos[$servicoSelecionado];
            }
            ?>
            <form action="" method="get">
                <input type="hidden" name="barbeiro" value="<?php echo $barbeiroSelecionado ?? ''; ?>">
                <label for="servicos">Selecione o serviço:</label>
                <select name="servico" id="servicos" onchange="this.form.submit()">
                    <option value="" disabled <?php echo empty($servicoSelecionado) ? 'selected' : ''; ?>>Selecione um serviço</option>
                    <?php
                    foreach ($servicos as $servico => $valorServico) {
                        $selected = $servicoSelecionado === $servico ? 'selected' : '';
                        echo "<option value='$servico' $selected>$servico - R$ $valorServico,00</option>";
                    }
                    ?>
                </select>
            </form>
            <?php if ($valor): ?>
                <h2>Serviço selecionado: <?php echo $servicoSelecionado; ?></h2>
                <p>Valor: R$ <?php echo $valor; ?>,00</p>
            <?php endif; ?>
        </section>
        <section class="agendamento">
            <h2>Agendar Serviço</h2>
            <form action="confirmacao.php" method="post">
                <input type="hidden" name="barbeiro" value="<?php echo $barbeiroSelecionado ?? ''; ?>">
                <input type="hidden" name="servico" value="<?php echo $servicoSelecionado ?? ''; ?>">
                <div class="form-group">
                    <label for="data">Escolha a data:</label>
                    <input type="date" id="data" name="data" required>
                </div>
                <div class="form-group">
                    <label for="hora">Escolha o horário:</label>
                    <input type="time" id="hora" name="hora" required>
                </div>
                <button type="submit" <?php echo $servicoSelecionado ? '' : 'disabled'; ?>>Agendar</button>
            </form>
        </section>
    </div>
    <script src="scripts.js"></script>
</body>
</html>
