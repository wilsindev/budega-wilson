<?php
    require_once __DIR__ . '/../includes/auth_check.php';
    if($_SESSION['is_admin'] !== 1){
        header("Location: clientes.php");
        exit;
    }
    $clienteId = $_GET['id'] ?? null;
    if(!$clienteId){
        header("Location: clientes.php");
        exit;
    }
    
    require_once __DIR__ .  '/../includes/clientequery.class.php';
    require_once __DIR__ .  '/../config/conexao.php';
    $query = new ClienteQuery($pdo);
    $resultado = $query->removerCliente($clienteId);
    if ($resultado) {
        header("Location: clientes.php");
    } else {
        header("Location: clientes.php?error=23000");
    }
    exit;
