<?php
session_start();
require_once 'conexao.php';

//verifica se o fornecedor tem permissao 
//supondo que o perfil 1 seja o admin 

if($_SESSION['perfil']!=1 && $_SESSION['perfil']!=3) {
    echo "Acesso Negado";
}

if($_SERVER['REQUEST_METHOD']=="POST") {
    $nome_fornecedor = $_POST['nome_fornecedor'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $endereco = $_POST['endereco'];
    $contato = $_POST['contato'];

    $sql = "INSERT INTO fornecedor (nome_fornecedor, email, telefone, endereco, contato) values (:nome_fornecedor, :email, :endereco, :telefone, :contato)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':nome_fornecedor', $nome_fornecedor);
    $stmt->bindParam(':email', $email);
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
        <label for="nome_fornecedor">Nome:</label>
        <input type="text" id="nome_fornecedor" name="nome_fornecedor" placeholder="Digite seu nome" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" placeholder="Exemplo@email" required>

        <label for="telefone">telefone:</label>
        <input type="text" id="telefone" name="telefone" placeholder="(47) 984303837" required>
        
        <label for="endereco">endereco:</label>
        <input type="text" id="endereco" name="endereco" placeholder="Rua exemplo" required>

        <label for="contato">contato:</label>
        <input type="text" id="contato" name="contato" required>
        


        <button type="submit">Salvar</button>
        <button type="reset">Cancelar</button>
    </form>

    <a href="principal.php">voltar</a>
    <center>
    <address>
        Tatiane Vieira / Estudante / Tecnico em Deenvolvimento de Sistemas
    </address>
</center>
</body>
</html>