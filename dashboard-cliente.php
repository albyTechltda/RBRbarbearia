<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RBR - Lista de Cabeleireiros</title>
    <link rel="stylesheet" href="dashboard.css">
</head>
<body>
    <div class="container">
        <header>
            <div class="user-info">
                <img src="#" alt="Logo da empresa" class="avatar">
                <div>

                   <?php
                    session_start();

                    // Verificar se o nome do cliente está na sessão
                    if (isset($_SESSION['nome_cliente'])) {
                        $nomeCliente = $_SESSION['nome_cliente'];
                        echo "<h1>Bem-vindo, $nomeCliente!</h1>";

                        // Conectar ao banco de dados
                        $servername = "localhost";
                        $username = "root";
                        $password = "root";
                        $dbname = "RBR";

                        $conn = new mysqli($servername, $username, $password, $dbname);

                        if ($conn->connect_error) {
                            die("Conexão falhou: " . $conn->connect_error);
                        }

                        // Consulta SQL para buscar a foto do barbeiro
                        $sql = "SELECT foto FROM cabeleireiros WHERE nome = '$nomeCliente'";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            // Exibir a foto do barbeiro se encontrada
                            $row = $result->fetch_assoc();
                            $fotoBarbeiro = $row['foto'];
                        } else {
                        }

                        $conn->close();
                    } else {
                        echo "<h1>Bem-vindo!</h1>";
                    }
                    ?>
                </div>
            </div>
        </header>
        <section class="barber-list">
            <h3>Cabeleireiros</h3>
            <?php
            // Conectar ao banco de dados novamente para exibir os cabeleireiros cadastrados
            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
                die("Conexão falhou: " . $conn->connect_error);
            }

            // Consulta SQL para buscar todos os cabeleireiros
            $sql = "SELECT * FROM cabeleireiros";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Exibir os cabeleireiros em botões
                while ($row = $result->fetch_assoc()) {
                    $nomeBarbeiro = $row['nome'];
                    $fotoBarbeiro = $row['foto'];

                    // Botão de seleção do cabeleireiro com onclick para redirecionar para servicos.php
                    echo "<button class='barber-item' onclick='redirectToServicos(\"$nomeBarbeiro\")'>";
                    echo "<img src='$fotoBarbeiro' alt='Foto do barbeiro' class='barber-avatar'>";
                    echo "<div class='barber-info'>";
                    echo "<h4>$nomeBarbeiro</h4>";
                    echo "<div class='schedule'>";
                    echo "<span class='icon-calendar'></span>";
                    echo "<span>Segunda à sexta</span>";
                    echo "</div>";
                    echo "<div class='hours'>";
                    echo "<span class='icon-clock'></span>";
                    echo "<span>8h às 18h</span>";
                    echo "</div>";
                    echo "</div>";
                    echo "</button>";
                }
            } else {
                echo "Nenhum cabeleireiro encontrado.";
            }

            $conn->close();

            // Script JavaScript para redirecionar para servicos.php com o cabeleireiro selecionado
            echo "<script>
                    function redirectToServicos(nomeBarbeiro) {
                        window.location.href = 'servicos.php?barbeiro=' + encodeURIComponent(nomeBarbeiro);
                    }
                  </script>";
            ?>
        </section>
    </div>
    <script src="scripts.js"></script>
</body>
</html>
