<?php
session_start();
require_once 'conexao.php';

//verifica se o usuario tem permissao 
//supondo que o perfil 1 seja o admin 

if($_SESSION['perfil']!=1) {
    echo "Acesso Negado";
}

if($_SERVER['REQUEST_METHOD']=="POST") {
    $nome_fornecedor = $_POST['nome'];
    $email = $_POST['email'];
    $id_fornecedor = $_POST['id_perfil'];
    $telefone = $_POST['telefone'];
    $endereco = $_POST['endereco'];
    $contato = $_POST['contato'];

    $sql = "INSERT INTO fornecedor (nome_fornecedor, email, id_fornecedor, telefone, endereco, contato) values (:nome, :email, :senha, :id_fornecedor, :endereco, :telefone, :contato)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':nome', $nome_fornecedor);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':senha', $senha);
    $stmt->bindParam(':telefone', $telefone);
    $stmt->bindParam(':endereco', $endereco);
    $stmt->bindParam(':contato', $contato);


    if($stmt->execute()) {
        echo "<script>alert('Fornecedor cadastrado com sucesso!');</script>";
    }else{
        echo "<script>alert('Erro ao cadastrar Fornecedor!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Fornecedor</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Cadastrar Fornecedor</h2>
    <form action="cadastro_fornecedor.php" method="POST"> 
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="telefone">telefone:</label>
        <input type="num" id="telefone" name="telefone" required>
        
        <label for="endereco">endereco:</label>
        <input type="text" id="endereco" name="endereco" required>

        <label for="contato">contato:</label>
        <input type="num" id="contato" name="contato" required>
        

        <label for="id_perfil">Perfil:</label>
        <select id="id_perfil" name="id_perfil">
            <option value="1">Administrador</option>
            <option value="2">Secretaria</option>
            <option value="3">Almoxerife</option>
            <option value="4">Cliente</option>
        </select>

        <button type="submit">Salvar</button>
        <button type="reset">Cancelar</button>
    </form>

    <a href="principal.php">voltar</a>
</body>
</html>