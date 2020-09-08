## Propósito

-   Api básica para atender o [https://github.com/ViniciusEmmanuel/frontend-contro-moto](frontend)

## Desenvolvido

-   Lumen [https://lumen.laravel.com/docs/7.x](Laravel)
-   Postgre

## Pré requisitos

-   PHP >= 7.2
-   OpenSSL PHP Extension
-   PDO PHP Extension
-   Mbstring PHP Extension

## Start

-   copiar o arquivo .env.example com o nome de .env
-   gerar uma key e setar na variável APP_KEY no seu .env
-   configurar seu BD, preferencialmente Postgre
-   Usando Postgre, criar as duas views das tabelas de gasoline e maintenance. Dentro da pasta database/view.
-   Start do servidor **php -S localhost:8000 ./index.php**
