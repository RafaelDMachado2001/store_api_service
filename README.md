# Store API Service

API de gerenciamento de produtos e preços desenvolvida com Laravel.

## Pré-requisitos

Antes de começar, certifique-se de ter instalado em sua máquina:

-   [Docker](https://www.docker.com/get-started) (versão 20.10 ou superior)
-   [Docker Compose](https://docs.docker.com/compose/install/) (versão 2.0 ou superior)
-   [Git](https://git-scm.com/downloads)

## Instalação e Configuração

### 1. Clone do Repositório

Clone o repositório do projeto:

```bash
git clone <url-do-repositorio>
cd store_api_service
```

### 2. Configuração do Ambiente

Se o arquivo `.env` não existir, crie-o baseado nas configurações do `docker-compose.yml`. As variáveis de ambiente principais são:

-   `DB_CONNECTION`: pgsql
-   `DB_HOST`: pgsql
-   `DB_PORT`: 5432
-   `DB_DATABASE`: store_api_service
-   `DB_USERNAME`: sail
-   `DB_PASSWORD`: password

### 3. Rodar os Containers Docker

Inicie os containers Docker usando Docker Compose:

```bash
docker-compose up -d
```

Este comando irá:

-   Construir a imagem do container da aplicação
-   Iniciar o container do PostgreSQL
-   Configurar a rede entre os containers

Aguarde alguns instantes até que todos os containers estejam em execução. Você pode verificar o status com:

```bash
docker-compose ps
```

### 4. Instalar Dependências

Instale as dependências do Composer dentro do container:

```bash
docker-compose exec frontend composer install
```

### 5. Chave do projeto

Gere a chave para o projeto

```bash
docker-compose exec frontend php artisan key:generate
```

### 6. Executar Migrations

Execute as migrations para criar as tabelas no banco de dados:

```bash
docker-compose exec frontend php artisan migrate
```

### 7. Alimentar o Banco com Seeders

Execute os seeders para popular o banco de dados com dados iniciais:

```bash
docker-compose exec frontend php artisan db:seed
```

Os seeders executados são:

-   `PrecosBaseSeeder`: Cria preços base para os produtos
-   `ProdutosBaseSeeder`: Cria produtos iniciais

## Acesso à Aplicação

Após concluir todos os passos acima, a aplicação estará disponível em:

-   **Aplicação Web**: http://localhost
-   **API**: http://localhost/api

### Rotas da API Disponíveis

-   `POST /api/sincronizar/produtos` - Sincronizar produtos
-   `POST /api/sincronizar/precos` - Sincronizar preços
-   `GET /api/produtos/lista` - Listar produtos

## Comandos Úteis

### Parar os containers

```bash
docker-compose down
```

### Ver logs dos containers

```bash
docker-compose logs -f
```

### Executar comandos Artisan

```bash
docker-compose exec frontend php artisan <comando>
```

### Acessar o container

```bash
docker-compose exec frontend bash
```

## Estrutura do Projeto

-   `routes/api.php` - Rotas da API
-   `routes/web.php` - Rotas web
-   `database/seeders/` - Seeders do banco de dados
-   `docker-compose.yml` - Configuração dos containers Docker

## Tecnologias Utilizadas

-   Laravel (Framework PHP)
-   PostgreSQL (Banco de dados)
-   Docker & Docker Compose (Containerização)
-   Laravel Sail (Ambiente de desenvolvimento)
