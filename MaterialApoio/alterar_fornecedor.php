<?php
session_start();
require_once 'conexao.php';

//verifique se o usuario tem permissao de admin ou secreatria
if($_SESSION['perfil'] !=1) {
    echo "<script>alert('Acesso Negado!');window.location.href='principal.php';</script>";
    exit();
}

//inicializa variaveis
$fornecedor = null;

if($_SERVER["REQUEST_METHOD"] == "POST" ){
    if(!empty($_POST['busca_fornecedor'])) {
        $busca = trim($_POST['busca_fornecedor']);

        //verifica se a busca é um numero ID ou um NOME
        if(is_numeric($busca)) {
            $sql = "SELECT * FROM fornecedor WHERE id_fornecedor = :busca";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':busca',$busca, PDO::PARAM_INT);
        }else{
            $sql = "SELECT * FROM fornecedor WHERE nome_fornecedor LIKE :busca_nome";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':busca_nome',"$busca%", PDO::PARAM_STR);
        }

        $stmt->execute();
        $fornecedor = $stmt->fetch(PDO::FETCH_ASSOC);

        //se o fornecedor nao for encontrado exibe um alerta
        if(!$fornecedor){
            echo "<script>alert('Fornecedor nao encontrado!');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Altera Fornecedor</title>
    <link rel="stylesheet" href="styles.css">
<!--certifique que o js esta sendo carregado corretamente-->
    <script:src="scripts.js"></script>
</head>
<body>
    <h2>Alterar Fornecedor</h2>

    <form action="alterar_fornecedor.php" method="POST">
        <label for="busca_fornecedor">Digite o ID ou NOME do usuario</label>
        <input type="text" id="busca_fornecedor" name="busca_fornecedor" required onkeyup="buscarSugestoes()">

<!--DIV para exibir sugestoes de usuario-->
    <div id="sugestoes"></div>
    <button type="submit">Buscar</button>
    </form>

    <?php if($fornecedor): ?>
<!--formulario para alterar fornecedor-->
    <form action="processa_alteracao_fornecedor.php" method="POST">
        <input type="hidden" name="id_fornecedor" value="<?=htmlspecialchars($fornecedor['id_fornecedor'])?>">

        <label for="nome_fornecedor">Nome:</label>
        <input type="text" id="nome_fornecedor" name="nome_fornecedor" value="<?=htmlspecialchars($fornecedor['nome_fornecedor'])?>"required>

        <label for="email">E-mail:</label>
        <input type="email" id="email" name="email" value="<?=htmlspecialchars($fornecedor['email'])?>"required>

        <label for="id_perfil">Perfil</label>
        <select name="id_perfil" id="id_perfil">
            <option value="1" <?php$usuario['id_perfil'] == 1? 'select':''?>>Administrador</option>
            <option value="2" <?php$usuario['id_perfil'] == 2? 'select':''?>>Secretaria</option>
            <option value="3" <?php$usuario['id_perfil'] == 3? 'select':''?>>Almoxarife</option>
            <option value="4" <?php$usuario['id_perfil'] == 4? 'select':''?>>Cliente</option>
        </select>
<!--se o usuario logado for adnin exibir opção de alterar senha-->
        <?php if($_SESSION['perfil'] == 1): ?>
            <label for="nova_senha">Nova Senha</label>
            <input type="password" id="nova_senha" name="nova_senha">
        <?php endif;?>

        <button type="submit">Alterar</button>
        <button type="reset">Cancelar</button>
    </form>
    <?php endif; ?>
    <a href="principal.php">Voltar</a>
</body> 
<center>
    <address>
        Tatiane Vieira / Estudante / Tecnico em Deenvolvimento de Sistemas
    </address>
</center>
</html>