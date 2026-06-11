<?php
    require_once __DIR__ . '/../includes/auth_check.php';
    if($_SESSION['is_admin'] !== 1){
        header("Location: produtos.php");
        exit;
    }
    $produtoId = $_GET['id'] ?? null;
    if(!$produtoId){
        header("Location: produtos.php");
        exit;
    }
    require_once __DIR__ .  '/../includes/produtoquery.class.php';
    require_once __DIR__ .  '/../config/conexao.php';
    $query = new ProdutoQuery($pdo);
    $resultado = $query->removerProduto($produtoId);
    if ($resultado) {
        header("Location: produtos.php?status=excluido");
    } else {
        header("Location: produtos.php?error=23000");
    }
    exit;