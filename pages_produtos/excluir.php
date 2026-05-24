<?php
    require_once __DIR__ . '/../includes/auth_check.php';
    $produtoId = $_GET['id'];
    
    require_once __DIR__ .  '/../includes/produtoquery.class.php';
    require_once __DIR__ .  '/../config/conexao.php';
    $query = new ProdutoQuery($pdo);
    $query->removerProduto($produtoId);
    header("Location: produtos.php");