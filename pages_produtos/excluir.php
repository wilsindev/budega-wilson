<?php
    require_once __DIR__ . '/../includes/auth_check.php';
    if($_SESSION['is_admin'] !== 1){
        header("Location: categorias.php");
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
    $query->removerProduto($produtoId);
    header("Location: produtos.php?status=excluido");
    exit;