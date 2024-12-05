# Comandos GIT & (GITHUB)
## Descargar e Instalar GIT
- https://git-scm.com/

```
git config --global user.name "Su Nombre"
git config --global user.email "sucorreo@mail.com"
```
## Crear una cuenta en GITHUB (Bitbucket, GitLab)
- https://github.com
-----
## Comandos iniciales
### inicializar GIT o Clonar un repositorio
```
git init

git clone direccion_repositorio
```
### Referencia de repositorio Local con Remoto
- En necesario crear un nuevo repositorio en GITHUB
- Luego git remote add repositorio_remoto
```
git remote add origin https://github.com/cchura94/backend_laravel_vue_proy.git
```
----
## Comandos para publicar nuevos cambios al reposotorio remoto
```
git add .
git commit -m "Autenticacion con Laravel Api Rest"
git push origin master
```
