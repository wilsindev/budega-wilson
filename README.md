Sistema de administração de loja desenvolvido com PHP puro.

## Requisitos

- [Docker Desktop](https://www.docker.com/products/docker-desktop/) ou GitHub Codespaces
- Docker Compose

## Como rodar

1. **Clone o repositório**
```bash
   git clone https://github.com/wilsindev/budega-wilson.git
   cd budega-wilson
```

2. **Configure as variáveis de ambiente**
```bash
   cp .env.example .env
```
   Preencha os valores no `.env` criado.

3. **Configure a conexão com o banco**  
   Insira as mesmas credenciais do `.env` em `config/conexao.php`.

4. **Suba os containers**
```bash
   docker-compose up -d
```

5. Acesse o sistema no navegador: `http://localhost:8080`

## Sobre o projeto

Projeto desenvolvido para a disciplina de Programação Web, com foco em um sistema de administração construído em PHP puro. Atualizações estão previstas, incluindo uma possível migração para Laravel.

## Stack

- PHP 8.2 + Apache
- MySQL
- Tailwind CSS + Alpine.js
- Docker
- ## Acesso inicial

| Campo | Valor |
|-------|-------|
| Email | admin@exemplo.com |
| Senha | admin |