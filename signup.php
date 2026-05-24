<?php 
    require_once '../includes/usersquery.class.php';
    require_once '../config/conexao.php';
    $query = new Query($pdo);
    if (!empty($_POST['nome']) || !empty($_POST['email']) || !empty($_POST['senha'])){
        $query->cadastrarFuncionario($_POST['nome'], $_POST['email'], $_POST['senha']);
        session_start();
        $_SESSION['userName'] = $_POST['nome'];
    }
    else{
        $erro = "Preencha todas as credenciais para continuar o cadastro";
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Budega do Wilson</title>
</head>
<body class="bg-[#0d1117] w-full min-h-screen">
    <main class="flex flex-col items-center justify-center w-full min-h-screen py-10">

        <div class="bg-[#161b22] border border-[#21262d] rounded-2xl p-8 w-full max-w-md flex flex-col gap-6">

            <div class="flex flex-col gap-1">
                <h2 class="text-xl font-semibold text-white">Cadastro de Vendedor</h2>
                <p class="text-sm text-[#8b949e]">Preencha os dados para cadastrar um novo funcionário.</p>
            </div>

            <hr class="border-[#21262d]">

            <form action="" method="post" class="flex flex-col gap-4">

                <div class="flex flex-col gap-1.5">
                    <label for="nome" class="text-xs font-medium text-[#8b949e] tracking-wide uppercase">Nome</label>
                    <input type="text" id="nome" name="nome" required
                           class="bg-[#0d1117] border border-[#30363d] focus:border-indigo-500 focus:outline-none text-[#e6edf3] placeholder-[#8b949e] text-sm rounded-lg px-4 py-2.5 w-full"
                           placeholder="Nome completo">
                </div>
                <div class="flex flex-col gap-1.5">
                    <label for="email" class="text-xs font-medium text-[#8b949e] tracking-wide uppercase">Email</label>
                    <input type="email" id="email" name="email" required
                           class="bg-[#0d1117] border border-[#30363d] focus:border-indigo-500 focus:outline-none text-[#e6edf3] placeholder-[#8b949e] text-sm rounded-lg px-4 py-2.5 w-full"
                           placeholder="Email">
                </div>
                <div class="flex flex-col gap-1.5">
                    <label for="senha" class="text-xs font-medium text-[#8b949e] tracking-wide uppercase">Senha</label>
                    <input type="password" id="senha" name="senha" required
                           class="bg-[#0d1117] border border-[#30363d] focus:border-indigo-500 focus:outline-none text-[#e6edf3] placeholder-[#8b949e] text-sm rounded-lg px-4 py-2.5 w-full"
                           placeholder="Senha">
                </div>

                <button type="submit"
                        class="bg-indigo-600 hover:bg-indigo-500 text-white font-medium text-sm rounded-lg px-4 py-2.5 transition-colors mt-2">
                    Cadastrar
                </button>
            </form>

            <a href="produtos.php"
               class="flex items-center gap-2 text-sm text-[#8b949e] hover:text-indigo-400 transition-colors">
                <i class="fa-solid fa-arrow-left text-xs"></i>
                Voltar para produtos
            </a>

        </div>
    </main>
</body>
</html>