# Use a imagem node:alpine como base
FROM node:20.12.0

WORKDIR /srv/app

COPY package*.json ./

RUN ls

COPY ./docker/docker-entrypoint.sh ./docker-entrypoint.sh

# Adiciona permissão de execução para o script
RUN chmod +x /srv/app/docker-entrypoint.sh

COPY . .

EXPOSE 5173

# Define o script de entrada
ENTRYPOINT ["sh", "./docker/docker-entrypoint.sh"]
