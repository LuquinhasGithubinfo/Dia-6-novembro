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


if (isset($_POST['update_user'])) {
    $usu_codigo = $_POST['usu_codigo'];
    $usu_nome = $_POST['usu_nome'];
    $usu_email = $_POST['usu_email'];

    $sql = "UPDATE Tbl_Usuarios SET Usu_Nome = '$usu_nome', Usu_Email = '$usu_email' WHERE usu_codigo = '$usu_codigo'";
    if ($conn->query($sql) === TRUE) {
        echo "Usuário atualizado com sucesso!";
    } else {
        echo "Erro ao atualizar usuário: " . $conn->error;
    }
}


if (isset($_POST['update_task'])) {
    $tar_codigo = $_POST['tar_codigo'];
    $tar_setor = $_POST['tar_setor'];
    $tar_prioridade = $_POST['tar_prioridade'];
    $tar_descricao = $_POST['tar_descricao'];
    $tar_status = $_POST['tar_status'];

    $sql = "UPDATE Tbl_Tarefas SET Tar_Setor = '$tar_setor', Tar_Prioridade = '$tar_prioridade', 
            Tar_Descricao = '$tar_descricao', Tar_Status = '$tar_status' WHERE Tar_codigo = '$tar_codigo'";

    if ($conn->query($sql) === TRUE) {
        echo "Tarefa atualizada com sucesso!";
    } else {
        echo "Erro ao atualizar tarefa: " . $conn->error;
    }
}


if (isset($_GET['delete_user'])) {
    $usu_codigo = $_GET['delete_user'];
    $sql = "DELETE FROM Tbl_Usuarios WHERE usu_codigo = '$usu_codigo'";
    if ($conn->query($sql) === TRUE) {
        echo "Usuário excluído com sucesso!";
    } else {
        echo "Erro ao excluir usuário: " . $conn->error;
    }
}


if (isset($_GET['delete_task'])) {
    $tar_codigo = $_GET['delete_task'];
    $sql = "DELETE FROM Tbl_Tarefas WHERE Tar_codigo = '$tar_codigo'";
    if ($conn->query($sql) === TRUE) {
        echo "Tarefa excluída com sucesso!";
    } else {
        echo "Erro ao excluir tarefa: " . $conn->error;
    }
}


$sql_usuarios = "SELECT * FROM Tbl_Usuarios";
$usuarios = $conn->query($sql_usuarios);


$sql_tarefas = "SELECT * FROM Tbl_Tarefas";
$tarefas = $conn->query($sql_tarefas);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterar Dados</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
   
    <div class="top-bar">
        <a href="index.html" class="btn-sair">Sair</a>
    </div>

    <h1>Alterar Dados de Usuários e Tarefas</h1>

    <h2>Alterar Dados do Usuário</h2>
    <form method="POST" action="alterar.php">
        <label for="usu_codigo">Código do Usuário:</label>
        <input type="number" name="usu_codigo" id="usu_codigo" required><br><br>
        <label for="usu_nome">Nome:</label>
        <input type="text" name="usu_nome" id="usu_nome" required><br><br>
        <label for="usu_email">Email:</label>
        <input type="email" name="usu_email" id="usu_email" required><br><br>
        <button type="submit" name="update_user">Atualizar Usuário</button>
    </form>

    <h2>Alterar Dados da Tarefa</h2>
    <form method="POST" action="alterar.php">
        <label for="tar_codigo">Código da Tarefa:</label>
        <input type="number" name="tar_codigo" id="tar_codigo" required><br><br>
        <label for="tar_setor">Setor:</label>
        <input type="text" name="tar_setor" id="tar_setor" required><br><br>
        <label for="tar_prioridade">Prioridade:</label>
        <input type="text" name="tar_prioridade" id="tar_prioridade" required><br><br>
        <label for="tar_descricao">Descrição:</label>
        <textarea name="tar_descricao" id="tar_descricao" required></textarea><br><br>
        <label for="tar_status">Status:</label>
        <input type="text" name="tar_status" id="tar_status" required><br><br>
        <button type="submit" name="update_task">Atualizar Tarefa</button>
    </form>

    <h2>Usuários Cadastrados</h2>
    <table border="1">
        <tr>
            <th>Código</th>
            <th>Nome</th>
            <th>Email</th>
            <th>Ações</th>
        </tr>
        <?php while ($row = $usuarios->fetch_assoc()) { ?>
            <tr>
                <td><?= $row['usu_codigo'] ?></td>
                <td><?= $row['Usu_Nome'] ?></td>
                <td><?= $row['Usu_Email'] ?></td>
                <td>
                    <a href="alterar.php?delete_user=<?= $row['usu_codigo'] ?>" onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</a>
                </td>
            </tr>
        <?php } ?>
    </table>

    <h2>Tarefas Cadastradas</h2>
    <table border="1">
        <tr>
            <th>Código</th>
            <th>Setor</th>
            <th>Prioridade</th>
            <th>Descrição</th>
            <th>Status</th>
            <th>Ações</th>
        </tr>
        <?php while ($row = $tarefas->fetch_assoc()) { ?>
            <tr>
                <td><?= $row['Tar_codigo'] ?></td>
                <td><?= $row['Tar_Setor'] ?></td>
                <td><?= $row['Tar_Prioridade'] ?></td>
                <td><?= $row['Tar_Descricao'] ?></td>
                <td><?= $row['Tar_Status'] ?></td>
                <td>
                    <a href="alterar.php?delete_task=<?= $row['Tar_codigo'] ?>" onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</a>
                </td>
            </tr>
        <?php } ?>
    </table>

</body>
</html>

<?php

$conn->close();
?>
