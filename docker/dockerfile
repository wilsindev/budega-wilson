# ============================================================
# DOCKERFILE - Receita para construir nossa imagem PHP
# ============================================================
# Um Dockerfile é como uma receita de bolo: ele instrui o Docker
# a construir uma imagem personalizada passo a passo.
#
# LOCALIZAÇÃO: docker/Dockerfile
# CONTEXTO DE BUILD: a pasta RAIZ do projeto (definido no docker-compose.yml)
# Isso significa que os comandos COPY abaixo partem da raiz do projeto.
#
# Para construir e rodar, você não executa este arquivo diretamente.
# O docker-compose.yml faz isso automaticamente com "docker compose up".
# ============================================================

# FROM: define a imagem base (o "ponto de partida")
# Usamos a imagem oficial do PHP versão 8.2 com Apache já integrado.
# Apache é o servidor web que vai servir nossos arquivos PHP.
FROM php:8.2-apache

# RUN: executa um comando DURANTE a construção da imagem
# Aqui instalamos extensões extras do PHP que não vêm por padrão:
#   - pdo:       abstração de acesso a bancos de dados (suporte genérico)
#   - pdo_mysql: driver específico para conectar ao MySQL via PDO
RUN docker-php-ext-install pdo pdo_mysql

# Habilitamos o módulo "rewrite" do Apache.
# Ele permite redirecionar URLs de forma flexível.
# Necessário caso queiramos URLs sem ".php" no futuro.
RUN a2enmod rewrite

# COPY: copia um arquivo do seu computador para DENTRO da imagem
# Origem: docker/apache.conf  (relativo à RAIZ do projeto = contexto de build)
# Destino: /etc/apache2/sites-available/000-default.conf (dentro do container)
#
# Este arquivo personaliza o Apache para:
#   - Desativar listagem de arquivos nos diretórios (-Indexes)
#   - Bloquear acesso às pastas docker/ e config/ pelo navegador
COPY docker/apache.conf /etc/apache2/sites-available/000-default.conf