<?php
    require_once __DIR__ . '/../includes/auth_check.php';
    require_once __DIR__ .  '/../includes/categoriaquery.class.php';
    require_once __DIR__ . '/../config/conexao.php';
    if (isset($_POST['nome'])){
        $query = new CategoriaQuery($pdo);
        $categoriaNome = $_POST['nome'];
        $query->adicionarCategoria($categoriaNome);
        header("Location: categorias.php");
        exit;
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Loja do Wilson</title>
</head>
<body class="bg-[#f4f6f9] w-full min-h-screen">
    <?php include __DIR__ . '/../includes/header.php'; ?>
    <main class="flex flex-col items-center justify-center w-full min-h-screen py-10">

        <div class="bg-white border border-slate-200 rounded-2xl p-8 w-full max-w-md flex flex-col gap-6"
             style="box-shadow: 0 1px 3px rgba(15,23,42,0.06), 0 8px 24px rgba(15,23,42,0.05);">

            <!-- Header do card -->
            <div class="flex flex-col gap-1">
                <h2 class="text-[17px] font-semibold text-slate-800 tracking-tight">Cadastro de Categoria</h2>
                <p class="text-[13px] text-slate-400">Preencha os dados para adicionar uma nova categoria.</p>
            </div>

            <div class="h-px bg-slate-100"></div>

            <!-- Formulário -->
            <form action="" method="post" class="flex flex-col gap-4">

                <!-- Nome -->
                <div class="flex flex-col gap-1.5">
                    <label for="nome" class="text-[11px] font-semibold text-[#060606] tracking-widest uppercase">Nome da categoria</label>
                    <input type="text" id="nome" name="nome" required
                           class="bg-slate-50 border border-slate-200 text-slate-700 text-[13px] rounded-lg px-4 py-2.5 w-full transition-shadow
                                  focus:outline-none focus:border-indigo-400 focus:bg-white focus:shadow-[0_0_0_3px_rgba(129,140,248,0.15)]
                                  placeholder-slate-300"
                           placeholder="Ex: Bebidas, Salgados…">
                </div>

                <!-- Submit -->
                <button type="submit"
                        class="flex items-center justify-center gap-2 bg-indigo-600 hover:bg-indigo-700 active:scale-[0.98] text-white font-medium text-[13px] rounded-lg px-4 py-2.5 transition-all mt-1"
                        style="box-shadow: 0 1px 3px rgba(79,70,229,0.25), 0 1px 0 rgba(255,255,255,0.1) inset;">
                    <i class="fa-solid fa-plus text-[11px]"></i>
                    Cadastrar categoria
                </button>

            </form>

            <!-- Voltar -->
            <a href="produtos.php"
               class="flex items-center gap-1.5 text-[13px] text-[#060606] hover:text-rose-500 transition-colors w-fit">
                <i class="fa-solid fa-arrow-left text-[11px]"></i>
                Voltar para produtos
            </a>

        </div>
    </main>
</body>
</html>