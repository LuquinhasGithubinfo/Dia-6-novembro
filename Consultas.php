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


$sql_tarefas = "SELECT Tar_codigo, Tar_Setor, Tar_Prioridade, Tar_Descricao, Tar_Status, Usu_Codigo FROM Tbl_Tarefas";
$result_tarefas = $conn->query($sql_tarefas);


$sql_usuarios = "SELECT usu_codigo, Usu_Nome, Usu_Email FROM Tbl_Usuarios";
$result_usuarios = $conn->query($sql_usuarios);

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta de Tarefas e Usuários</title>
    <link rel="stylesheet" href="styles.css"> 
</head>
<body>
    
    <div class="top-bar">
        <a href="index.html" class="btn-sair">Sair</a>
    </div>

    
    <h1>Consulta de Tarefas e Usuários</h1>

    
    <h2>Tarefas Cadastradas</h2>
    <div class="tarefas">
        <?php
        
        if ($result_tarefas->num_rows > 0) {
            echo "<table>
                    <tr>
                        <th>Código</th>
                        <th>Setor</th>
                        <th>Prioridade</th>
                        <th>Descrição</th>
                        <th>Status</th>
                        <th>Código do Usuário</th>
                    </tr>";
            
            
            while ($row = $result_tarefas->fetch_assoc()) {
                echo "<tr>
                        <td>" . $row["Tar_codigo"] . "</td>
                        <td>" . $row["Tar_Setor"] . "</td>
                        <td>" . $row["Tar_Prioridade"] . "</td>
                        <td>" . $row["Tar_Descricao"] . "</td>
                        <td>" . $row["Tar_Status"] . "</td>
                        <td>" . $row["Usu_Codigo"] . "</td>
                      </tr>";
            }
            echo "</table>";
        } else {
            echo "Nenhuma tarefa encontrada.";
        }
        ?>
    </div>

    <hr>

    
    <h2>Usuários Cadastrados</h2>
    <div class="usuarios">
        <?php
        
        if ($result_usuarios->num_rows > 0) {
            echo "<table>
                    <tr>
                        <th>Código</th>
                        <th>Nome</th>
                        <th>Email</th>
                    </tr>";
            
            
            while ($row = $result_usuarios->fetch_assoc()) {
                echo "<tr>
                        <td>" . $row["usu_codigo"] . "</td>
                        <td>" . $row["Usu_Nome"] . "</td>
                        <td>" . $row["Usu_Email"] . "</td>
                      </tr>";
            }
            echo "</table>";
        } else {
            echo "Nenhum usuário encontrado.";
        }
        ?>
    </div>

   
    <?php $conn->close(); ?>
</body>
</html>
