<header class="w-full bg-white border-b border-slate-200 z-50 relative" style="box-shadow: 0 1px 3px rgba(15,23,42,0.06);">
        <div class="flex items-center justify-between gap-4 px-6 py-3.5 max-w-screen-xl mx-auto">   
    
            <!-- Nav links -->
            <nav class="hidden md:flex items-center gap-1">
                <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-lg  flex items-center justify-center shrink-0">
                    <img src="../assets/logobudega.png" alt="">
                </div>
                <span class="font-semibold text-slate-800 text-[15px] tracking-tight leading-none">
                    Loja Do Wilson
                </span>
                </div>
                <?php
                // retorna o nome do arquivo atual, ex: dashboard.php, se colocasse só __file__ dava erro pois sempre retornava o header.php, e não o arquivo atual.
                $paginaAtual = basename($_SERVER['PHP_SELF']);
                // array de links do menu, onde a chave é o nome do arquivo e o valor é um array com o href e o nome do link.
                $links = [
                        'dashboard.php' => ['href' => '../pages_produtos/dashboard.php', 'nome' => 'Dashboard'],
                        'produtos.php'  => ['href' => '../pages_produtos/produtos.php',   'nome' => 'Produtos'],
                        'categorias.php'=> ['href' => '../pages_categorias/categorias.php','nome' => 'Categorias'],

                ];
                ?>
                <!-- $arquivo recebe a chave — 'dashboard.php', 'produtos.php', etc e $link recebe o valor — ['href' => '...', 'nome' => 'Dashboard'] -->
                <?php foreach($links as $arquivo => $link): ?>
                    <a href="<?php echo $link['href'] ?>"
                    class="px-3 py-1.5 text-[13px] font-medium rounded-lg transition-colors
                            <?php echo $paginaAtual == $arquivo
                                ? 'text-indigo-600 bg-indigo-50'
                                : 'text-slate-500 hover:text-slate-800 hover:bg-slate-100' ?>">
                        <?php echo $link['nome'] ?>
                    </a>
                <?php endforeach; ?>
            </nav>
    
            <!-- Right side -->
            <div class="flex items-center gap-2.5">
                <!-- User avatar -->
                <button class="flex items-center gap-2 pl-1 pr-2.5 py-1 rounded-lg hover:bg-slate-100 transition-colors group" onclick="document.getElementById('user-menu').classList.toggle('hidden')">
                    <div class="w-6 h-6 rounded-full bg-indigo-100 border border-indigo-200 flex items-center justify-center shrink-0">
                        <img src="../assets/avatar_user.jpg" alt="" class="rounded-full">
                    </div>
                    <span class="hidden sm:block text-[13px] font-medium text-slate-600 group-hover:text-slate-800 transition-colors">
                        <?php 
                            echo htmlspecialchars($_SESSION['user_name'])
                        ?>
                    </span>
                    <svg class="text-slate-400" width="12" height="12" viewBox="0 0 12 12" fill="none">
                        <path d="M2.5 4.5L6 8l3.5-3.5" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/>
                    </svg>
                </button>
                <!-- Dropdown menu -->
                <div id="user-menu" class="hidden absolute right-6 top-16 bg-white border border-slate-200 rounded-lg shadow-lg py-2 w-48">
                    <!-- <a href="#" class="block px-4 py-2 text-sm text-slate-700 hover:bg-indigo-50 hover:text-indigo-600 transition-colors">Perfil</a> -->
                    <a href="../pages_users/logout.php" class="sair block px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors">Sair</a>
                </div>
    
        </div>
</header>