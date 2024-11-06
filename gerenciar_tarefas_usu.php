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


$sql_tarefas = "SELECT Tar_codigo, Tar_Setor, Tar_Prioridade, Tar_Descricao FROM Tbl_Tarefas";
$result_tarefas = $conn->query($sql_tarefas);


$sql_usuarios = "SELECT usu_codigo, Usu_Nome FROM Tbl_Usuarios";
$result_usuarios = $conn->query($sql_usuarios);


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usu_codigo = $_POST['usu_codigo'];
    $tar_codigo = $_POST['tar_codigo'];
    $data_assign = $_POST['data_assign'];

    $sql_insert = "INSERT INTO gerenciar_tarefas_usu (Usu_Codigo, Tar_Codigo, Data_Assign) 
                   VALUES ('$usu_codigo', '$tar_codigo', '$data_assign')";
    if ($conn->query($sql_insert) === TRUE) {
        echo "Tarefa atribuída com sucesso!";
    } else {
        echo "Erro ao atribuir tarefa: " . $conn->error;
    }
}


$sql_assignments = "SELECT g.id, u.Usu_Nome, t.Tar_Setor, t.Tar_Descricao, g.Data_Assign 
                    FROM gerenciar_tarefas_usu g 
                    JOIN Tbl_Usuarios u ON g.Usu_Codigo = u.usu_codigo
                    JOIN Tbl_Tarefas t ON g.Tar_Codigo = t.Tar_codigo";
$result_assignments = $conn->query($sql_assignments);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Tarefas e Usuários</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    
    <div class="top-bar">
        <a href="index.html" class="btn-sair">Sair</a>
    </div>

    <h1>Gerenciar Tarefas Atribuídas</h1>

    <h2>Atribuir Tarefa a Usuário</h2>
    <form method="POST" action="gerenciar_tarefas_usu.php">
        <label for="usu_codigo">Selecionar Usuário:</label>
        <select name="usu_codigo" id="usu_codigo">
            <?php while ($row = $result_usuarios->fetch_assoc()) { ?>
                <option value="<?= $row['usu_codigo'] ?>"><?= $row['Usu_Nome'] ?></option>
            <?php } ?>
        </select><br><br>

        <label for="tar_codigo">Selecionar Tarefa:</label>
        <select name="tar_codigo" id="tar_codigo">
            <?php while ($row = $result_tarefas->fetch_assoc()) { ?>
                <option value="<?= $row['Tar_codigo'] ?>"><?= $row['Tar_Setor'] ?> - <?= $row['Tar_Descricao'] ?></option>
            <?php } ?>
        </select><br><br>

        <label for="data_assign">Data de Atribuição:</label>
        <input type="date" name="data_assign" id="data_assign" required><br><br>

        <button type="submit">Atribuir Tarefa</button>
    </form>

    <h2>Tarefas Atribuídas</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Usuário</th>
            <th>Setor da Tarefa</th>
            <th>Descrição da Tarefa</th>
            <th>Data de Atribuição</th>
        </tr>
        <?php
        if ($result_assignments->num_rows > 0) {
            while ($row = $result_assignments->fetch_assoc()) {
                echo "<tr>
                        <td>" . $row["id"] . "</td>
                        <td>" . $row["Usu_Nome"] . "</td>
                        <td>" . $row["Tar_Setor"] . "</td>
                        <td>" . $row["Tar_Descricao"] . "</td>
                        <td>" . $row["Data_Assign"] . "</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='5'>Nenhuma tarefa atribuída.</td></tr>";
        }
        ?>
    </table>

</body>
</html>

<?php

$conn->close();
?>
