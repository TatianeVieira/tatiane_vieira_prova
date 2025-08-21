<?php
session_start();
require 'conexao.php';

//verifica se o usuario tem permissao de admin
if($_SESSION['perfil'] !=1) {
    echo "<script>alert('Acesso Negado!');window.location.href='principal.php';</script>";
    exit();
}

//inicializa variavel para aramazenar usuario
$fornecedores = [];

//busca todos os usuarios cadastrados em ordem alfabetica
$sql = "SELECT * FROM fornecedor ORDER BY nome_fornecedor ASC";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$fornecedores = $stmt->fetchAll(PDO::FETCH_ASSOC);

//se um ID for passado via get exclui o usuario
if(isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id_fornecedor = $_GET['id'];

    //exclui o usuario do banco dados
    $sql = "DELETE fornecedor WHERE id_fornecedor = :id";
    $stmt= $pdo->prepare($sql);
    $stmt->bindParam(':id', $id_fornecedor, PDO::FETCH_INT);

    if($stmt->execute()) {
        echo "<script>alert('Fornecedor excluido com sucerro!');window.location.href='excluir_fornecedor.php';</script>";
    }else{
        echo "<script>alert('Erro ao excluir o Fornecedor!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Excluir Fornecedor</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="js/bootstrap.js">

</head>
<body>
    <h2>Excluir Fornecedor</h2>
    <?php if(!empty($fornecedores)): ?>
        <table border="1">
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Email</th>
                <th>Perfil</th>
                <th>Ações</th>
            </tr>
            <?php foreach($fornecedores as $fornecedor): ?>
                <tr>
                    <td><?=htmlspecialchars($fornecedor['id_fornecedor'])?></td>
                    <td><?=htmlspecialchars($fornecedor['nome_fornecedor'])?></td>
                    <td><?=htmlspecialchars($fornecedor['email'])?></td>
                    <td><?=htmlspecialchars($fornecedor['id_perfil'])?></td>
                    <td>
                        <a href="excluir_fornecedor.php?id=<?=htmlspecialchars($fornecedor['id_fornecedor'])?>"onclick="return confirm('Tem certeza que deseja excluir este Fornecedor?')">Excluir</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>Nenhum Fornecedor encontrado.</p>
    <?php endif; ?>

    <a href="principal.php">Voltar</a>
</body>
</html>