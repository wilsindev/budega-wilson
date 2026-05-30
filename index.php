<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/css2?family=Geist:wght@300;400;500;600&family=Geist+Mono:wght@400;500&display=swap" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="assets/logobudegafav.png">
    <title>Loja do Wilson</title>
    <style>
        * { font-family: 'Geist', system-ui, sans-serif; }
        body { background-color: #f4f6f9; }

        .card {
            background: #ffffff;
            border: 1px solid #e8ecf0;
            box-shadow: 0 1px 3px rgba(15,23,42,0.06), 0 8px 24px rgba(15,23,42,0.05);
            animation: fadein 0.4s ease;
        }
        @keyframes fadein { from { opacity:0; transform:translateY(10px); } to { opacity:1; transform:translateY(0); } }

        .btn-primary {
            background: #4f46e5;
            box-shadow: 0 1px 3px rgba(79,70,229,0.25), 0 1px 0 rgba(255,255,255,0.1) inset;
            transition: background 0.15s, transform 0.1s, box-shadow 0.15s;
        }
        .btn-primary:hover { background: #4338ca; transform: translateY(-1px); box-shadow: 0 4px 12px rgba(79,70,229,0.3); }
        .btn-primary:active { transform: translateY(0); }

        .divider { height: 1px; background: #e8ecf0; }

        .feature-icon {
            width: 36px; height: 36px;
            background: #eef2ff;
            border: 1px solid #c7d2fe;
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            color: #4f46e5;
            font-size: 14px;
            flex-shrink: 0;
        }
    </style>
</head>
<body class="w-full min-h-screen flex items-center justify-center py-10 px-4">

    <div class="card rounded-2xl p-8 w-full max-w-md flex flex-col gap-6">

        <div class="flex flex-col items-center gap-3 text-center">
            <img src="assets/logobudega.png" alt="Logo Loja do Wilson" class="w-16 h-16 object-contain">
            <div>
                <h1 class="text-[20px] font-semibold text-slate-800 tracking-tight">Loja do Wilson</h1>
                <p class="text-[13px] text-slate-400 mt-1">Sistema de gestão de supermercado</p>
            </div>
        </div>

        <div class="divider"></div>

        <div class="flex flex-col gap-3">
            <div class="flex items-center gap-3">
                <div class="feature-icon"><i class="fa-solid fa-box"></i></div>
                <div>
                    <p class="text-[13px] font-medium text-slate-700">Produtos</p>
                    <p class="text-[12px] text-slate-400">Gerencie o estoque e categorias</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <div class="feature-icon"><i class="fa-solid fa-users"></i></div>
                <div>
                    <p class="text-[13px] font-medium text-slate-700">Clientes</p>
                    <p class="text-[12px] text-slate-400">Cadastro e consulta de clientes</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <div class="feature-icon"><i class="fa-solid fa-chart-simple"></i></div>
                <div>
                    <p class="text-[13px] font-medium text-slate-700">Dashboard</p>
                    <p class="text-[12px] text-slate-400">Visão geral do sistema</p>
                </div>
            </div>
        </div>

        <div class="divider"></div>

        <a href="pages_users/logar.php"
           class="btn-primary text-white font-medium text-[13px] rounded-lg px-4 py-2.5 flex items-center justify-center gap-2">
            <i class="fa-solid fa-arrow-right-to-bracket text-[11px]"></i>
            Entrar no sistema
        </a>

    </div>

</body>
</html>