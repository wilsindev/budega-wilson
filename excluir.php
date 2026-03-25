<?php
    $produtoId = $_GET['id'];
    require_once "query.class.php";
    require_once "conexao.php";
    $query = new Query($pdo);
    $query->removerProduto($produtoId);
    header("Location: produtos.php");