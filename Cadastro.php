<?php

error_reporting(E_ALL);  
ini_set('display_errors', 1);


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "PROPRIEDADE_ESCOLAR";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['cadastrar_usuario'])) {
    $nome = $_POST['usu_nome'];
    $email = $_POST['usu_email'];
    
    $sql = "INSERT INTO Tbl_Usuarios (Usu_Nome, Usu_Email) VALUES ('$nome', '$email')";
    if ($conn->query($sql) === TRUE) {
        echo "Novo usuário cadastrado com sucesso!<br>";
    } else {
        echo "Erro ao cadastrar usuário: " . $conn->error . "<br>";
    }
}


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['cadastrar_tarefa'])) {
    $setor = $_POST['tar_setor'];
    $prioridade = $_POST['tar_prioridade'];
    $descricao = $_POST['tar_descricao'];
    $status = $_POST['tar_status'];
    $usu_codigo = $_POST['usu_codigo'];

    $sql = "INSERT INTO Tbl_Tarefas (Tar_Setor, Tar_Prioridade, Tar_Descricao, Tar_Status, Usu_Codigo) 
            VALUES ('$setor', '$prioridade', '$descricao', '$status', '$usu_codigo')";
    if ($conn->query($sql) === TRUE) {
        echo "Nova tarefa cadastrada com sucesso!<br>";
    } else {
        echo "Erro ao cadastrar tarefa: " . $conn->error . "<br>";
    }
}


$sql_usuarios = "SELECT * FROM Tbl_Usuarios";
$usuarios_result = $conn->query($sql_usuarios);

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Usuário e Tarefa</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    
    <div class="top-bar">
        <a href="index.html" class="btn-sair">Sair</a>
    </div>

    <h1>Cadastro de Usuário e Tarefa</h1>

    
    <h2>Cadastrar Novo Usuário</h2>
    <form action="cadastro.php" method="POST">
        <label for="usu_nome">Nome:</label>
        <input type="text" id="usu_nome" name="usu_nome" required><br><br>

        <label for="usu_email">Email:</label>
        <input type="email" id="usu_email" name="usu_email" required><br><br>

        <button type="submit" name="cadastrar_usuario">Cadastrar Usuário</button>
    </form>

    <hr>

    
    <h2>Cadastrar Nova Tarefa</h2>
    <form action="cadastro.php" method="POST">
        <label for="tar_setor">Setor:</label>
        <input type="text" id="tar_setor" name="tar_setor" required><br><br>

        <label for="tar_prioridade">Prioridade:</label>
        <input type="text" id="tar_prioridade" name="tar_prioridade" required><br><br>

        <label for="tar_descricao">Descrição:</label>
        <textarea id="tar_descricao" name="tar_descricao" rows="4" cols="50" required></textarea><br><br>

        <label for="tar_status">Status:</label>
        <input type="text" id="tar_status" name="tar_status" required><br><br>

        <label for="usu_codigo">Usuário:</label>
        <select id="usu_codigo" name="usu_codigo" required>
            <option value="">Selecione um usuário</option>
            <?php
            
            while ($row = $usuarios_result->fetch_assoc()) {
                echo "<option value='" . $row['usu_codigo'] . "'>" . $row['Usu_Nome'] . "</option>";
            }
            ?>
        </select><br><br>

        <button type="submit" name="cadastrar_tarefa">Cadastrar Tarefa</button>
    </form>

</body>
</html>
