<?php
session_start();
require_once 'conexao.php';

//verifique se o usuario tem permissao de admin ou secreatria
if($_SESSION['perfil'] !=1 && $_SESSION['perfil']!=2 ) {
    echo "<script>alert('Acesso Negado!');window.location.href='principal.php';</script>";
    exit();
}

$fornecedor = []; //inicializa a variavel para evitar erros

//se o formulario for enviado, busca o usuario pelo ID ou NOME
if($_SERVER["REQUEST_METHOD"]== "POST" && !empty($_POST['busca'])) {
    $busca = trim($_POST['busca']);
    //verifica se a busca é um numero ou um nome
    if(is_numeric($busca)) {
        $sql = "SELECT * FROM fornecedor WHERE id_fornecedor = :busca ORDER BY nome_fornecedor ASC";
        $stmt=$pdo->prepare($sql);
        $stmt->bindParam(':busca', $busca, PDO::PARAM_INT);
    }else{
        $sql = "SELECT * FROM fornecedor WHERE nome_fornecedor LIKE :busca_nome ORDER BY nome_fornecedor ASC";
        $stmt=$pdo->prepare($sql);
        $stmt->bindValue(':busca_nome', "$busca%", PDO::PARAM_STR);
    }
}else{
    $sql = "SELECT * FROM fornecedor ORDER BY nome_fornecedor ASC";
    $stmt=$pdo->prepare($sql);
}
$stmt->execute();
$fornecedor = $stmt->fetchALL(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Principal</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Lista de Fornecedor</h2>

    <form action="buscar_fornecedor.php" method="POST">
        <label for="busca">Digite o ID ou NOME (opcional): </label>
        <input type="text" id="busca" name="busca">
        <button type="submit">Pesquisar</button>
    </form>
    <?php if(!empty($fornecedores)): ?>
        <table border="1">
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Email</th>
                <th>Perfil</th>
                <th>Açoes</th>
            </tr>
        <?php foreach($fornecedores as $fornecedor): ?>

            <tr>
                <td><?=htmlspecialchars($fornecedor['id_fornecedor'])?></td>
                <td><?=htmlspecialchars($fornecedor['nome_fornecedor'])?></td>
                <td><?=htmlspecialchars($fornecedor['email'])?></td>
                <td><?=htmlspecialchars($fornecedor['id_perfil'])?></td>
                <td>
                    <a href="alterar_fornecedor.php?id=<?htmlspecialchars($fornecedor['id_fornecedor'])?>">Alterar</a>

                    <a href="excluir_fornecedor.php?id=<?htmlspecialchars($fornecedor['id_fornecedor'])?>"onclick="return confirm('Tem certeza que voce quer excluir?')">Exluir</a>
                </td>
            </tr>
        <?php endforeach;?>
        </table>
    <?php else:?>
        <p>Nenhum Fornecedor encontrado</p>
    <?php endif;?>
    <a href="principal.php">Voltar</a>
</body>
</html>