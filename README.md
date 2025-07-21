# Laravel Products

Este es un proyecto de Laravel que permite crear y gestionar productos en una aplicación web, utilizando el framework Laravel manipulando el DOM con Javascript a través de AJAX.

Para el Backend se utiliza el framework Laravel y para el Frontend se utiliza blade mostrando la informacion con Javascript y para estilos por el tiempo se ha utilizado tailwindcss cdn, como base de datos se utiliza MySQL y para el almacenamiento de archivos se utiliza el driver Local.

## Requisitos

Asegurarse de tener instalado en su máquina:

- [Docker](https://www.docker.com/)
- [Docker Compose](https://docs.docker.com/compose/)

Dependera si se encuentra en Windows o Linux en el caso de Windows, debera configurar wsl para utilizar la virtualización de Docker.

## Instalación y configuración

1. Clonar el repositorio en su máquina local.
```bash
git clone https://github.com/Juan-Vasquez/laravel-products.git
```

2. Entrar en el directorio del proyecto, puede realizarlo desde el editor de texto o bien utilizando la terminal, para poder copear archivo .env.example a .env

3. Levantar los contenedores con Docker compose, ubicarse dentro del proyecto y ejecutar la siguiente orden.
```bash
docker compose up -d
```

4. Conectarse al contenedor de la aplicacion para correr algunos comandos como las migraciones, seeder, la llave key y storage link, el seeder es mas para poder crear un usuario por defecto que para este ejemplo se utilizo correo test@example.com y contraseña 12345678, sientase libres de modificarlo si asi lo prefieren. 

```bash
docker exec -it laravel-products-app php artisan key:generate
docker exec -it laravel-products-app php artisan migrate
docker exec -it laravel-products-app php artisan db:seed
docker exec -it laravel-products-app php artisan storage:link
```

5. Configurar un host personalizado, ya que en nginx se ha configurado el host laravel-products.test si no prefiere utilizar el nombre de dominio de su preferencia, puede modificarlo en el archivo nginx.conf.

7. Abrir el navegador y acceder a la url http://laravel-products.test

## Documentación

- [Laravel](https://laravel.com/docs)
- [Docker](https://docs.docker.com/)
- 