<?php 
    require_once __DIR__ . '/../includes/auth_check.php';
    $erro = '';
     if(isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 0){
        header("Location: ../pages_produtos/produtos.php");
        exit;
    }
    require_once __DIR__ .  '/../includes/userquery.class.php';
    require_once __DIR__ .  '/../config/conexao.php';
    // Vê se o formulário foi submetido
    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        if (!empty($_POST['nome']) && !empty($_POST['email']) && !empty($_POST['senha'])){
            if(strlen($_POST['senha']) < 8){
                $erro = "A senha deve conter no mínimo 8 caracteres.";
            } 
            else {
                try{
                    $query = new UserQuery($pdo);
                    $query->salvarUser($_POST['nome'], $_POST['email'], $_POST['senha'], $_POST['is_admin']);
                    header("Location: logar.php");
                    exit;
                }
                catch(PDOException $e){
                    if($e->getCode() == 23000){
                        $erro = "Já existe um usuário com esse Email. Por favor, verifique o Email e tente novamente.";
                    }
                    //se o erro não for o 23000, ou seja, não for um erro de nome de categoria duplicado, deixa o erro estourar normalmente pra ser tratado em outro lugar ou mostrar uma mensagem de erro genérica.
                    else{
                        throw $e; // outro erro qualquer, deixa estourar na tela
                    }
                }
            }
        } 
        else {
            $erro = "Preencha todas as credenciais para continuar o cadastro.";
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
    <link href="https://fonts.googleapis.com/css2?family=Geist:wght@300;400;500;600&family=Geist+Mono:wght@400;500&display=swap" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="../assets/logobudegafav.png">
    <title>Loja do Wilson — Cadastro</title>
    <style>
        * { font-family: 'Geist', system-ui, sans-serif; }
        body { background-color: #f4f6f9; }
        .card {
            background: #ffffff;
            border: 1px solid #e8ecf0;
            box-shadow: 0 1px 3px rgba(15,23,42,0.06), 0 8px 24px rgba(15,23,42,0.05);
            animation: fadein 0.3s ease;
        }
        @keyframes fadein { from { opacity:0; transform:translateY(8px); } to { opacity:1; transform:translateY(0); } }
        .field {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            color: #1e293b;
            font-size: 13px;
            border-radius: 8px;
            padding: 10px 14px;
            width: 100%;
            transition: border-color 0.15s, box-shadow 0.15s, background 0.15s;
        }
        .field::placeholder { color: #94a3b8; }
        .field:focus {
            outline: none;
            border-color: #818cf8;
            background: #ffffff;
            box-shadow: 0 0 0 3px rgba(129,140,248,0.15);
        }
        .btn-primary {
            background: #4f46e5;
            box-shadow: 0 1px 3px rgba(79,70,229,0.25), 0 1px 0 rgba(255,255,255,0.1) inset;
            transition: background 0.15s, transform 0.1s, box-shadow 0.15s;
        }
        .btn-primary:hover { background: #4338ca; transform: translateY(-1px); box-shadow: 0 4px 12px rgba(79,70,229,0.3); }
        .btn-primary:active { transform: translateY(0); }
        .divider { height: 1px; background: #e8ecf0; }
        label { font-size: 11px; font-weight: 600; color: #64748b; letter-spacing: 0.08em; text-transform: uppercase; }
    </style>
</head>
<body class="w-full min-h-screen flex items-center justify-center py-10 px-4">
    <div class="card rounded-2xl p-8 w-full max-w-md flex flex-col gap-6">

        <!-- Logo -->
        <div class="flex flex-col items-center gap-2.5">
            <div class="w-15 h-15 rounded-lgflex items-center justify-center shrink-0">
                <img src="../assets/logobudega.png" alt="Logo da loja do Wilson">
            </div>
            <span class="font-semibold text-slate-800 text-[15px] tracking-tight">Seja bem-vindo à Loja do Wilson</span>
        </div>

        <div class="divider"></div>

        <!-- Título -->
        <div class="flex flex-col gap-1">
            <h2 class="text-[17px] font-semibold text-slate-800 tracking-tight">Criar conta</h2>
            <p class="text-[13px] text-slate-400">Preencha os dados para se cadastrar.</p>
        </div>

        <!-- Erro -->
        <?php if(!empty($erro)): ?>
        <div class="bg-red-50 border border-red-200 text-red-600 text-[13px] rounded-lg px-4 py-3 flex items-center gap-2">
            <i class="fa-solid fa-circle-exclamation text-[11px]"></i>
            <?php echo $erro ?>
        </div>
        <?php endif; ?>

        <!-- Form -->
        <form action="" method="post" class="flex flex-col gap-4">

            <div class="flex flex-col gap-1.5">
                <label for="nome">Nome</label>
                <input type="text" id="nome" name="nome" class="field" placeholder="Seu nome completo" required autocomplete="username">
            </div>

            <div class="flex flex-col gap-1.5">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" class="field" placeholder="example@email.com" required autocomplete="email">
            </div>

            <div class="flex flex-col gap-1.5">
                <label for="senha">Senha</label>
                <input type="password" id="senha" name="senha" class="field" placeholder="Mínimo 8 caracteres" required autocomplete="new-password">
            </div>

            <select name="is_admin" id="is_admin" class="field">
                <option value="0">Funcionário</option>
                <option value="1">Administrador</option>
            </select>

            <button type="submit"
                    class="btn-primary text-white font-medium text-[13px] rounded-lg px-4 py-2.5 mt-1">
                Criar conta
            </button>

        </form>

        <div class="divider"></div>

        <a href="produtos.php" class="text-[13px] text-slate-400 hover:text-indigo-500 transition-colors text-center">
            Voltar para <span class="text-indigo-500 font-medium">produtos</span>
        </a>

    </div>
</body>
</html>