<h1>Como rodar o sistema da sua loja?</h1>
<h2>Requisitos: Docker desktop ou codespace e 
Docker Compose</h2>
<ol>
  <li>Clone o repositório <br>
    git clone https://github.com/wilsindev/budega-wilson.git
    cd budega-wilson
  </li>
  <li>
    Configure as variáveis de ambiente <br>
    cp .env.example .env <br>
    Preencha os valores no .env
  </li>
  <li>
    Configure a conexão com o banco <br>
    cp config/conexao.example.php config/conexao.php (preencha com as mesmas credenciais do env)
  </li>
  <li>
    Suba os containers <br>
    docker-compose up -d
  </li>
  <li>
    Utilize sua loja!
  </li>
</ol>
<h2>Inicialmente, este projeto vai ser utilizado no trabalho de programação web, onde devo construir um sistema de administração com php puro. Atualizações irão vir e talvez eu coloque esse sistema para um de laravel. Obrigado por usar!</h2>