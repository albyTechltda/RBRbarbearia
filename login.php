<?php
session_start();

// Definir suas credenciais de conexão com o banco de dados
$servername = "localhost"; // ou o endereço do seu servidor MySQL
$username = "root"; // substitua com o nome de usuário do seu banco de dados
$password = "root"; // substitua com a senha do seu banco de dados
$dbname = "RBR"; // substitua com o nome do seu banco de dados

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['email']) && isset($_POST['senha'])) {
        $email = $_POST['email'];
        $senha = $_POST['senha'];

        // Conectar ao banco de dados
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Verificar conexão
        if ($conn->connect_error) {
            die("Conexão falhou: " . $conn->connect_error);
        }

        // Verificar cliente
        $sqlCliente = "SELECT * FROM clientes WHERE email='$email' AND senha='$senha'";
        $resultCliente = $conn->query($sqlCliente);

        if ($resultCliente->num_rows > 0) {
            $_SESSION['loggedin'] = true;
            $_SESSION['email'] = $email;
            $_SESSION['tipo'] = 'cliente';
            header("Location: dashboard-cliente.php");
            exit();
        }

        // Verificar cabeleireiro
        $sqlCabeleireiro = "SELECT * FROM cabeleireiros WHERE email='$email' AND senha='$senha'";
        $resultCabeleireiro = $conn->query($sqlCabeleireiro);

        if ($resultCabeleireiro->num_rows > 0) {
            $_SESSION['loggedin'] = true;
            $_SESSION['email'] = $email;
            $_SESSION['tipo'] = 'cabeleireiro';
            header("Location: dashboard-cabeleireiro.html");
            exit();
        }

        // Se nenhum usuário for encontrado
        echo "<script>alert('Email ou senha incorretos.'); window.location.href = 'login.html';</script>";

        $conn->close();
    } else {
        echo "<script>alert('Erro: Dados do formulário não recebidos.'); window.location.href = 'login.html';</script>";
    }
}
?>
