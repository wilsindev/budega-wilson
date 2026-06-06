<?php
require_once __DIR__ . '/../includes/auth_check.php';
require_once __DIR__ .  '/../includes/clientequery.class.php';
require_once __DIR__ .  '/../config/conexao.php';

$query = new ClienteQuery($pdo);
$clienteId = $_GET['id'] ?? null;

if (!$clienteId) {
    header("Location: clientes.php");
    exit;
}
else{
    $cliente = $query->getDadosClientes($clienteId);
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!empty($_POST['nome']) && !empty($_POST['cpf']) && !empty($_POST['telefone'])) {
        if (strlen($_POST['nome']) < 3) {
        $erro = "O nome do cliente deve ter pelo menos 3 caracteres.";
        }
        else if (strlen($_POST['cpf']) != 14) {
            $erro = "Por favor, insira um CPF válido.";
        }
        else if (strlen($_POST['telefone']) < 14) {
            $erro = "Por favor, insira um telefone válido no formato (XX) XXXXX-XXXX.";
        }
        else {
            try{
                $query->atualizarCliente(
                    $clienteId,
                    $_POST['nome'],
                    $_POST['cpf'],
                    $_POST['telefone']
                );
                header("Location: clientes.php");
                exit;
            } catch (PDOException $e) {
                if ($e->getCode() == 23000) {
                    $erro = "Já existe um cliente com esse CPF. Por favor, verifique o CPF e tente novamente.";
                } else {
                    throw $e;
                }
            }
        } 
    }
    else {
        $erro = "Por favor, preencha todos os campos obrigatórios.";
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
    <title>Loja do Wilson - Editar cliente</title>
</head>
<body class="bg-[#f4f6f9] w-full min-h-screen">
    <?php include __DIR__ . '/../includes/header.php'; ?>
    <main class="flex flex-col items-center justify-center w-full min-h-screen py-10">

        <div class="bg-white border border-slate-200 rounded-2xl p-8 w-full max-w-md flex flex-col gap-6 shadow-card">
            <!-- Header do card -->
            <div class="flex items-start justify-between">
                <div class="flex flex-col gap-1">
                    <h2 class="text-[17px] font-semibold text-slate-800 tracking-tight">Editar cliente</h2>
                    <p class="text-[13px] text-slate-400">Atualize os dados do cliente abaixo.</p>
                </div>
            </div>

            <div class="h-px bg-slate-100"></div>

            <!-- Formulário -->
            <form action="" method="post" class="flex flex-col gap-4" x-data>

                <!-- Nome -->
                <div class="flex flex-col gap-1.5">
                    <label for="nome" class="text-[11px] font-semibold text-[#060606] tracking-widest uppercase">Nome</label>
                    <input type="text" id="nome" name="nome"
                           value="<?php echo htmlspecialchars($cliente->nome) ?>" required
                           class="bg-slate-50 border border-slate-200 text-slate-700 text-[13px] rounded-lg px-4 py-2.5 w-full transition-shadow
                                  focus:outline-none focus:border-indigo-400 focus:bg-white focus:shadow-[0_0_0_3px_rgba(129,140,248,0.15)]
                                  placeholder-slate-300">
                </div>

                <!-- CPF -->
                <div class="flex flex-col gap-1.5" x-data>
                    <label for="cpf" class="text-[11px] font-semibold text-[#060606] tracking-widest uppercase">CPF</label>
                    <input x-mask="999.999.999-99" type="text" id="cpf" name="cpf"
                           value="<?php echo htmlspecialchars($cliente->cpf) ?>" required
                           class="bg-slate-50 border border-slate-200 text-[#060606] text-[13px] rounded-lg px-4 py-2.5 w-full transition-shadow
                                  focus:outline-none focus:border-indigo-400 focus:bg-white focus:shadow-[0_0_0_3px_rgba(129,140,248,0.15)]
                                  placeholder-slate-300">
                </div>

                <!-- Telefone -->
                <div class="flex flex-col gap-1.5" x-data>
                    <label for="telefone" class="text-[11px] font-semibold text-[#060606] tracking-widest uppercase">Telefone</label>
                    <input x-mask="(99) 99999-9999" type="text" id="telefone" name="telefone"
                           value="<?php echo htmlspecialchars($cliente->telefone) ?>" required
                           class="bg-slate-50 border border-slate-200 text-[#060606] text-[13px] rounded-lg px-4 py-2.5 w-full transition-shadow
                                  focus:outline-none focus:border-indigo-400 focus:bg-white focus:shadow-[0_0_0_3px_rgba(129,140,248,0.15)]
                                  placeholder-slate-300">
                </div>


                <!-- Submit -->
                <button type="submit"
                        class="flex items-center justify-center gap-2 bg-indigo-600 hover:bg-indigo-700 active:scale-[0.98] text-white font-medium text-[13px] rounded-lg px-4 py-2.5 transition-all mt-1 shadow-btn">
                    <i class="fa-solid fa-check text-[11px]"></i>
                    Salvar alterações
                </button>

            </form>

            <!-- Cancelar -->
            <a href="clientes.php"
               class="flex items-center gap-1.5 text-[13px] text-[#060606] hover:text-rose-500 transition-colors w-fit">
                <i class="fa-solid fa-xmark text-[11px]"></i>
                Cancelar
            </a>

        </div>
    </main>
</body>
</html>