<?php
// Iniciar sessão para usar variáveis de sessão
session_start();

// Definir suas credenciais de conexão com o banco de dados
$servername = "localhost"; // ou o endereço do seu servidor MySQL
$username = "root"; // substitua com o nome de usuário do seu banco de dados
$password = "root"; // substitua com a senha do seu banco de dados
$dbname = "RBR"; // substitua com o nome do seu banco de dados

// Verificar se o método da requisição é POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar se os campos obrigatórios foram recebidos
    if (isset($_POST['tipo']) && isset($_POST['nome']) && isset($_POST['email']) && isset($_POST['telefone']) && isset($_POST['senha'])) {
        $tipo = $_POST['tipo'];
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $telefone = $_POST['telefone'];
        $senha = $_POST['senha'];

        // Conectar ao banco de dados
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Verificar conexão
        if ($conn->connect_error) {
            die("Conexão falhou: " . $conn->connect_error);
        }

        // Processar o formulário do cliente
        if ($tipo === "cliente") {
            // SQL para inserir dados do cliente
            $sql = "INSERT INTO clientes (nome, email, telefone, senha) VALUES ('$nome', '$email', '$telefone', '$senha')";
            $redirectPage = "login.html"; // Redirecionar clientes para o dashboard do cliente
        } elseif ($tipo === "cabeleireiro") {
            // Verificar se a foto foi enviada
            if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
                $fotoTmp = $_FILES['foto']['tmp_name'];
                $fotoNome = basename($_FILES['foto']['name']);
                $fotoDestino = "uploads/$fotoNome";

                // Mover a foto para o diretório de uploads
                if (move_uploaded_file($fotoTmp, $fotoDestino)) {
                    $foto = $fotoDestino;

                    // SQL para inserir dados do cabeleireiro com foto
                    $sql = "INSERT INTO cabeleireiros (nome, email, telefone, senha, foto) VALUES ('$nome', '$email', '$telefone', '$senha', '$foto')";
                    $redirectPage = "login.html"; // Redirecionar cabeleireiros para o dashboard do cabeleireiro
                } else {
                    echo "Erro ao fazer upload da foto.";
                    exit();
                }
            } else {
                echo "Erro no upload da foto.";
                exit();
            }
        }

        // Executar a consulta SQL
        if ($conn->query($sql) === TRUE) {
            echo "Cadastro realizado com sucesso!";
            // Redirecionar conforme o tipo de usuário após o cadastro
            header("Location: $redirectPage");
            exit();
        } else {
            echo "Erro: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();
    } else {
        echo "Erro: Dados do formulário não recebidos corretamente.";
    }
}
?>
