<?php
    require_once __DIR__ . '/../includes/auth_check.php';
    if($_SESSION['is_admin'] !== 1){
        header("Location: vendas.php");
        exit;
    }
    $vendaId = $_GET['id'] ?? null;
    if(!$vendaId){
        header("Location: vendas.php?status=excluida");
        exit;
    }
    require_once __DIR__ .  '/../includes/vendaquery.class.php';
    require_once __DIR__ .  '/../config/conexao.php';
    $query = new VendaQuery($pdo);
    $query->cancelarVenda($vendaId);
    header("Location: vendas.php?status=excluida");