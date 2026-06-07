<h1>Como rodar o sistema da sua loja?</h1>
<h2>Requisitos: Docker desktop ou codespace e 
Docker Compose</h2>
<ol>
  <li>
    Clone o repositório<br>
    <ul>
      <li>No seu terminal execute: git clone https://github.com/wilsindev/budega-wilson.git</li>
      <li>E se redirecione para a pasta com: cd budega-wilson</li>
    </ul>
  </li>
  <li>
    Configure as variáveis de ambiente <br>
    <ul>
      <li>No seu terminal execute: cp .env.example .env</li>
      <li>E logo em seguida preencha os valores no .env</li>
    </ul>
  </li>
  <li>
    Configure a conexão com o banco <br>
    <ul>
      <li>Insira suas credenciais em config/conexao.php (preencha com as mesmas credenciais do env)</li>
    </ul>
  </li>
  <li>
    Suba os containers<br>
    <ul>
      <li>Execute em seu terminal: docker-compose up -d</li>
    </ul>
  </li>
  <li>
    Utilize sua loja!
  </li>
</ol>
<h2>Inicialmente, este projeto vai ser utilizado no trabalho de programação web, onde devo construir um sistema de administração com php puro. Atualizações irão vir e talvez eu coloque esse sistema para um de laravel. Obrigado por usar!</h2>
<h6>Nome: Admin</h6>
<h6>Email: admin@exemplo.com</h6>
<h6>Senha: admin</h6>