<p align="center"><img src=""></p>


# Teste prático 
> Laravel 6
> laravel/passport

## Instalação 
* composer install
* npm install && npm run dev
* Renomei o arquivo .env.example para .env
* Configure o acesso do seu banco de dados no arquivo .env
* Configure APP_NAME do arquivo .env
* php artisan key:generate --ansi
* php artisan migrate
* php artisan db:seed
* php artisan serve Ou php -S localhost:3333 -t public

Usuários
Existem dois tipos diferentes de usuários na aplicação:

Admin = secret (admin@teste.com.br)
User = secret


## Parte api
> post

- localhost:3333/api/register
- localhost:3333/api/login


Renato Lucena - 06/04/2020