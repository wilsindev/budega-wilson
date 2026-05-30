<?php
    require_once __DIR__ . '/../includes/auth_check.php';
    if($_SESSION['is_admin'] !== 1){
        header("Location: categorias.php");
        exit;
    }
    $categoriaId = $_GET['id'] ?? null;
    if(!$categoriaId){
        header("Location: categorias.php");
        exit;
    }
    require_once __DIR__ .  '/../includes/categoriaquery.class.php';
    require_once __DIR__ .  '/../config/conexao.php';
    $query = new CategoriaQuery($pdo);
    $resultado = $query->removerCategoria($categoriaId);
    if ($resultado) {
        header("Location: categorias.php");
    } else {
        header("Location: categorias.php?error=23000");
    }
    exit;
