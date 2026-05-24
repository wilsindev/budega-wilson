<?php 
    session_start();
    // Ah wilson, pq não só dar destroy logo? É porque o destroy não limpa as variaveis no session, ele só marca a sessão como destruida.
    session_unset();
    // Destró
    session_destroy();
    // Redireciona para a página de login
    header("Location: logar.php");
?>