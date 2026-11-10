# Cuestiones teóricas UT1 - NovaHarvest

## 1. Software necesario

En mi proyecto utilizo cuatro servicios:

- Nginx: muestra la página web.
- PHP-FPM: ejecuta los archivos PHP.
- MariaDB: guarda los datos.
- Adminer: permite consultar la base de datos.

Utilizo alpine porque ocupa menos espacio. Las imágenes tienen versiones concretas para evitar cambios inesperados. En mi Dockerfile instalo PDO y mysqli, necesarios para trabajar con la base de datos.

## 2. Tecnologías

CGI crea un proceso para cada petición, mientras que FastCGI mantiene procesos preparados para atenderlas(para que tenga mayor rendimiento). En mi proyecto Nginx se comunica con PHP-FPM mediante FastCGI. Apache también puede ejecutar PHP utilizando mod_php. He separado Nginx y PHP-FPM para que cada uno tenga su propia función. Utilizo PDO para conectar con MariaDB.

## 3. Cliente y servidor

Los archivos css, html y markdown y las imágenes son archivos estáticos. Los archivos `excedentes.php`, `avisos.php` y `estado.php` los ejecuta PHP-FPM. El navegador recibe el resultado del PHP, no su código original. El formulario utiliza `required` para evitar campos vacíos, pero esa comprobación se puede saltar utilizando curl.

## 4. Nginx

Nginx recibe las peticiones y las guarda en sus registros. Cuando una página no existe, muestra el archivo `404.html`. También he configurado gzip para reducir el tamaño de algunos archivos y, por último, he configurado `temporada.md` para que se muestre como texto plano.

## 5. MariaDB

Los datos se guardan en el volumen `dbdata`, por lo que no se pierden al detener los contenedores con `docker compose down`. Aunque si ejecutamos `docker compose down -v` también elimina el volumen. La base de datos tiene dos tablas: `excedentes` y `avisos`. Si cambiamos la contraseña en `.env`, MariaDB no la cambia automáticamente si ya estaba inicializada.

## 6. Ejecución de un archivo PHP

Cuando entro en `excedentes.php`, Nginx recibe la petición y la envía a PHP-FPM. PHP-FPM ejecuta el archivo y consulta los productos en MariaDB. Después genera una tabla con los resultados y se la devuelve a Nginx. Finalmente, Nginx muestra la página en el navegador.

## 7. PHP-FPM

PHP-FPM tiene configurado un máximo de cinco procesos trabajadores. Al iniciarse crea dos y utiliza el usuario `www-data` para ejecutarlos. Si llegan seis peticiones y todos los procesos están ocupados, una tendrá que esperar. Mi configuración también establece la zona horaria `Europe/Madrid` y un límite de memoria de 128 MB.

## 8. Acceso a la base de datos

La contraseña DB_PASS se guarda en `.env` y PHP la obtiene mediante `getenv()`. La conexión utiliza `db` porque es el nombre del servicio MariaDB. PHP no necesita la contraseña de root porque utiliza el usuario `novaharvest_app`. Para guardar avisos utilizo `prepare()` y `execute()`, evitando introducir directamente los datos del formulario en la consulta.

## 9. Seguridad

En NovaHarvest utilizo varias medidas de seguridad:

- `.env` guarda las contraseñas y no se sube a Git.
- Adminer solo es accesible desde mi equipo.
- MariaDB solo permite a la aplicación consultar e insertar datos.
- HTTPS cifra la conexión con la página.
- `display_errors = Off` evita mostrar errores internos.
- `client_max_body_size 64K` limita el tamaño de las peticiones.

El navegador avisa del certificado porque es autofirmado y no pertenece a una autoridad reconocida.

## 10. Pruebas y diagnóstico

Si detengo PHP-FPM, las páginas PHP dejan de funcionar, pero la portada sigue disponible porque es estática. MariaDB utiliza un estado `healthy` para indicar que está preparada. PHP y Adminer esperan a que la base de datos esté lista. Durante el proyecto tuve un problema al generar el certificado y lo solucioné utilizando `MSYS_NO_PATHCONV=1` en Git Bash.

## 11. Documentación

En el README he explicado cómo descargar el proyecto, crear el archivo `.env`, generar los certificados y arrancar los contenedores. También he incluido las direcciones de la web y de Adminer. El archivo `.env.example` se sube porque no contiene contraseñas reales. El `.env` y los certificados no se suben para evitar compartir información privada.