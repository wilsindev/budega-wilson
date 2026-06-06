<?php
    require_once __DIR__ . '/../includes/auth_check.php';
    require_once __DIR__ .  '/../includes/clientequery.class.php';
    require_once __DIR__ . '/../config/conexao.php';
    $erro = "";
    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        $clienteNome = trim($_POST['nome'] ?? '');
        $clienteCpf = trim($_POST['cpf'] ?? '');
        $clienteTelefone = trim($_POST['telefone'] ?? '');
        if ($clienteNome !== '' && $clienteCpf !== '' && $clienteTelefone !== ''){
            if(strlen($clienteNome) < 3) {
                $erro = "O nome do cliente deve ter pelo menos 3 caracteres.";
            }
            else if (strlen($clienteCpf) !== 14) {
                $erro = "Por favor, insira um CPF válido no formato XXX.XXX.XXX-XX.";
            }
             else if (strlen($clienteTelefone) < 14) {
                $erro = "Por favor, insira um telefone válido no formato (XX) XXXXX-XXXX";
            }
            else{
                try{
                    $query = new ClienteQuery($pdo);
                    $query->adicionarCliente($clienteNome, $clienteCpf, $clienteTelefone);
                    header("Location: clientes.php");
                    exit;
                }
                catch(PDOException $e){
                    if($e->getCode() == 23000){
                        $erro = "Já existe um cliente com esse CPF. Por favor, verifique o CPF e tente novamente.";
                    }
                    //se o erro não for o 23000, ou seja, não for um erro de nome de categoria duplicado, deixa o erro estourar normalmente pra ser tratado em outro lugar ou mostrar uma mensagem de erro genérica.
                    else{
                        throw $e; // outro erro qualquer, deixa estourar na tela
                    }
                }
            }
        }
        else{
            $erro = "Preencha todas as informações para cadastrar um cliente.";
        }
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="icon" type="image/x-icon" href="../assets/logobudegafav.png">
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/mask@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script defer src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script defer src="../js/select.js"></script>
    <link rel="stylesheet" href="../css/index.css">
    <title>Loja do Wilson - Cadastro de cliente</title>
</head>
<style>
</style>
<body class="bg-[#f4f6f9] w-full min-h-screen">
    <?php include __DIR__ . '/../includes/header.php'; ?>
    <main class="flex flex-col items-center justify-center w-full min-h-screen py-10">

        <div class="bg-white border border-slate-200 rounded-2xl p-8 w-full max-w-md flex flex-col gap-6 shadow-card"
            >
            <?php if ($erro): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <strong class="font-bold">Oops!</strong>
                    <span class="block sm:inline"><?= $erro ?></span>
                </div>
            <?php endif; ?>
            <!-- Header do card -->
            <div class="flex flex-col gap-1">
                <h2 class="text-[17px] font-semibold text-slate-800 tracking-tight">Cadastro de cliente</h2>
                <p class="text-[13px] text-slate-400">Preencha os dados para adicionar um novo cliente.</p>
            </div>

            <div class="h-px bg-slate-100"></div>

            <!-- Formulário -->
            <form action="" method="post" class="flex flex-col gap-4">

                <!-- Nome -->
                <div class="flex flex-col gap-1.5">
                    <label for="nome" class="text-[11px] font-semibold text-[#060606] tracking-widest uppercase">Nome <span class="text-red-600">*</span></label>
                    <input type="text" id="nome" name="nome" 
                           class="bg-slate-50 border border-slate-200 text-slate-700 text-[13px] rounded-lg px-4 py-2.5 w-full transition-shadow
                                  focus:outline-none focus:border-indigo-400 focus:bg-white focus:shadow-[0_0_0_3px_rgba(129,140,248,0.15)]
                                  placeholder-slate-300"
                           placeholder="Nome do cliente">
                </div>

                <!-- Cpf -->
                <div class="flex flex-col gap-1.5" x-data>
                    <label for="cpf" class="text-[11px] font-semibold text-[#060606] tracking-widest uppercase">Cpf <span class="text-red-600">*</span></label>
                    <input  x-mask="999.999.999-99" type="text" id="cpf" name="cpf" 
                           class="bg-slate-50 border border-slate-200 text-slate-700 text-[13px] rounded-lg px-4 py-2.5 w-full transition-shadow
                                  focus:outline-none focus:border-indigo-400 focus:bg-white focus:shadow-[0_0_0_3px_rgba(129,140,248,0.15)]
                                  placeholder-slate-300"
                           placeholder="Cpf do cliente">
                </div>

                <!-- Telefone -->
                <div class="flex flex-col gap-1.5" x-data>
                    <label for="telefone" class="text-[11px] font-semibold text-[#060606] tracking-widest uppercase">Telefone <span class="text-red-600">*</span></label>
                    <input  x-mask="(99) 99999-9999" type="text" id="telefone" name="telefone" 
                           class="bg-slate-50 border border-slate-200 text-slate-700 text-[13px] rounded-lg px-4 py-2.5 w-full transition-shadow
                                  focus:outline-none focus:border-indigo-400 focus:bg-white focus:shadow-[0_0_0_3px_rgba(129,140,248,0.15)]
                                  placeholder-slate-300"
                           placeholder="Telefone do cliente">
                </div>

                <!-- Submit -->
                <button type="submit"
                        class="flex items-center justify-center gap-2 bg-indigo-600 hover:bg-indigo-700 active:scale-[0.98] text-white font-medium text-[13px] rounded-lg px-4 py-2.5 transition-all mt-1 shadow-btn"
                        >
                    <i class="fa-solid fa-plus text-[11px]"></i>
                    Cadastrar cliente
                </button>

            </form>

            <!-- Voltar -->
            <a href="clientes.php"
               class="flex items-center gap-1.5 text-[13px] text-[#060606] hover:text-rose-500 transition-colors w-fit">
                <i class="fa-solid fa-arrow-left text-[11px]"></i>
                Voltar para clientes
            </a>

        </div>
    </main>
</body>
</html>