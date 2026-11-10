# NovaHarvest

Proyecto que consiste en una página web para consultar excedentes agrícolas y registrar avisos para los compradores.

## Arranque del proyecto

Primero cloné el repositorio con este comando:

```bash
git clone https://github.com/vjp-angelmariaMS/novaharvest-iaplw.git

Creé el archivo .env a partir del ejemplo con este comando:
cp .env.example .env

Abrí el archivo .env y cambié los valores de las contraseñas.

Después creé los certificados para HTTPS con los siguientes comandos:
mkdir -p nginx/certs
MSYS_NO_PATHCONV=1 openssl req -x509 -nodes -days 365 -newkey rsa:2048 -keyout nginx/certs/novaharvest.key -out nginx/certs/novaharvest.crt -subj "/CN=localhost"

Levanté los contenedores con este comando:
docker compose up -d --build

Cargué las tablas y los datos iniciales de la base de datos:
docker compose exec -T db sh -c 'mariadb -u root -p"$MARIADB_ROOT_PASSWORD" novaharvest' < db/novaharvest.sql

Por último, comprobé que los contenedores están funcionando:
docker compose ps

Podemos acceder a las distintas páginas desde estas direcciones:
- Inicio: https://localhost:8443/
- Excedentes: https://localhost:8443/excedentes.php
- Avisos: https://localhost:8443/avisos.html
- Temporada: https://localhost:8443/temporada.md
- Estado del servidor: https://localhost:8443/estado.php
- Adminer: http://localhost:8081

Para entrar en Adminer uso estos datos:
- Sistema: MySQL
- Servidor: db
- Usuario: novaharvest_app
- Contraseña: la configurada en DB_PASS(1234 en novaharvest_app y 123456789 en root)
- Base de datos: novaharvest

Configuré adminer para que se pueda abrir desde el propio equipo mediante el puerto 8081.

Para comprobar los permisos ejecuté:
docker compose exec db mariadb -u root -p

Y dentro de MariaDB:
SHOW GRANTS FOR 'novaharvest_app'@'%';

Para detener los contenedores sin perder los datos:
docker compose down

Para volver a iniciarlos:
docker compose up -d

