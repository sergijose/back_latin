### Habilitar routes/api.php
- habilitar laravel sanctum para generacion de tokens de autenticación en laravel
```
php artisan install:api
```
### Generar un controlador

```
php artisan make:controller AuthController
```
## BASES DE DATOS
### Comandos de Migraciones

```
php artisan migrate 
php artisan migrate:rollback 
php artisan migrate:status
php artisan migrate:fresh

php artisan make:migration create_personas_table

```
## Modelos
```
php artisan make:model Persona
```