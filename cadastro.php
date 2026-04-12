<?php 
    require_once "query.class.php";
    require_once "conexao.php";
    $query = new Query($pdo);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Budega do Wilson</title>
</head>
<body class="text-black w-full h-screen">
    <main class="flex flex-col items-center justify-center w-full min-h-screen py-10">
    <div class="bg-[#5489ee] flex flex-col shadow-lg rounded-2xl p-6 w-[700px] gap-2">
    
        <div class=" flex justify-center ">
            <h2 class="text-xl text-white font-bold mb-4">Cadastro Vendedor</h2>
        </div>
        <form action="cadastro.php" method="post" class="flex flex-col justify-center items-center gap-4">
            
            <input type="text" id="nome" name="nome" required class="bg-white  text-black rounded-md p-2" placeholder="Nome">
            <input type="text" id="nome" name="nome" required class="bg-white text-black rounded-md p-2" placeholder="">
        </form>

        
    </div>
    </main>
</body>
</html>