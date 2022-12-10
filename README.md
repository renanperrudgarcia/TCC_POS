#### Rodando o projeto

-   Fazer uma cópia do arquivo .env e remover o .example do final
-   ajustar arquivo .env com seus valores
-   No terminal rodar: **docker-compose up -d**
-   Entrar no container do app: **docker exec -it trabalho-app bash**
    -   Instalar as bibliotecas: **composer install**

#### Configurando o banco pelo PgAdmin (instalado pelo docker)

-   Acesse: **localhost:5050**
-   Email: **pgadmin4@pgadmin.org**
-   Senha: **admin**
-   Para se conectar no banco de teste:
-   Host name/address postgres
-   Port 5432
-   Username: postgres
-   Password: changeme

> **Dentro do banco criado, crie uma database chamado **admin\*\*\*\*

#### Comandos básicos do Phinx para as migrations

-   Dentro do container-app, digite os passos abaixo:
    -   Executar o phinx: **./vendor/bin/phinx migrate -e development**
    -   Executar as migrations: **./vendor/bin/phinx seed:run**
    -   Se não surgiu erro algum, só olhar no pgadmin que as tabelas estarão lá.
