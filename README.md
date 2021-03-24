# README #

This README would normally document whatever steps are necessary to get your application up and running.

### CONFIGURACIÓN DE INSTALACIÓN DEL PATH APP? ###
<IfModule mod_rewrite.c>
    Options -MultiViews

    RewriteEngine On
    #RewriteBase /path/to/app
    RewriteBase /sapreportes
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
   # RewriteRule ^ index.php [QSA,L]
    RewriteRule ^ /sapreportes/index.php [QSA,L]
</IfModule>

### ¿Qué cambios importantes se realizarón? ###

* Reestructura
* Version
* [Learn Markdown](https://bitbucket.org/tutorials/markdowndemo)

### Crear archivo .env para conexion de base de datos ###
DEBUG=true
DB_DRIVER=pdo_mysql
DB_HOST=localhost
DB_DATABASE=sap_reports
DB_USERNAME=root
DB_PASSWORD=toor
DB_CHARSET=utf8mb4

### How do I get set up? ###

* composer install
* modificar el htaccess en caso sea con APACHE
* Dependencies
* Database configuration


### Traduciones

Cargar traduccion desde url : http://localhost:8188/?lang=en
Uso en templates twig :  {{ 'texto' | trans }} /  {{ variable|trans }}
Carpeta de traducciones : /locales
    - en.yml
    - es.yml
    - pr.yml