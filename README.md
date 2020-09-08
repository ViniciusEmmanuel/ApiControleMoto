## Propósito

- Api básica para atender o frontend [https://github.com/ViniciusEmmanuel/frontend-contro-moto]

## Desenvolvido

- Lumen [laravel]
- Postgres

## Pré requisitos 

- PHP >= 7.2
- OpenSSL PHP Extension
- PDO PHP Extension
- Mbstring PHP Extension

## Start

- copiar o arquivo .env.example com o nome de .env
- gerar uma key e setar na variavel APP_KEY no seu .env
- configurar seu BD, preferencialmente Postgres
- Usando Postgres, criar as duas views das tabelas de gasoline e maintenance. Dentro da pasta database/view.
- Start do servidor [php -S localhost:8000 ./index.php] 
