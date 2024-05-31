# Simple Product CRUD

## Visão Geral

...

## Tecnologias Utilizadas

- **Backend**: Laravel 10.10 - MySQL 8.0 - Redis 7.2.5
- **Frontend**: Vue.js 3
- **Estilização**: SASS, TailwindCSS
- **Autenticação**: Laravel Sanctum
- **Docker**: Para ambiente de desenvolvimento

## Pré-requisitos

Antes de começar, você precisará ter as seguintes ferramentas instaladas em sua máquina:

- [Docker](https://www.docker.com/get-started)
- [Docker Compose](https://docs.docker.com/compose/install/)

## Configuração do Ambiente

### Clonar o Repositório
```shell
git clone https://github.com/charllyslima/simple-product-crud.git
cd simple-product-crud
```

### Construir e Subir os Containers Docker

#### API

```shell
cd backend/
docker-compose up -d
```

#### Frontend
```shell
cd frontend/
docker-compose up -d
```

### Executar Migrações
```shell
docker-compose exec app php artisan migrate
```


## Utilização

### Executar o Servidor de Desenvolvimento

Para iniciar o servidor de desenvolvimento, execute:


```shell
 docker-compose up -d
```

O backend estará disponível em http://localhost e o frontend em http://localhost:8080.

## Comandos Úteis
Acessar o Terminal do Container
```shell
docker-compose exec app bash
```
Executar Comandos Artisan
Dentro do container, você pode executar comandos php artisan:

```shell
docker-compose exec app php artisan <comando>
```
Para criar um usuário, utilize o comando customizado create:user:

```shell
docker-compose exec app php artisan create:user email@example.com password123 "João da Silva"
```

