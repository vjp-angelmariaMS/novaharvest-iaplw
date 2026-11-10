<?php
// conexión con MariaDB utilizando las variables de entorno
$dsn = sprintf(
    "mysql:host=%s;dbname=%s;charset=utf8mb4",
    getenv('DB_HOST'),
    getenv('DB_NAME')
);
$pdo = new PDO($dsn, getenv('DB_USER'), getenv('DB_PASS'));
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// preparo la consulta para guardar el aviso
$stmt = $pdo->prepare(
    "INSERT INTO avisos (nombre, email, producto)
    VALUES (:nombre, :email, :producto)"
);
// con esto se podrá ejecutar la consulta con los datos del formulario
$stmt->execute([
    'nombre' => $_POST['nombre'],
    'email' => $_POST['email'],
    'producto' => $_POST['producto']
]);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NovaHarvest - Aviso registrado</title>
    <link rel="stylesheet" href="/css/estilos.css">
</head>
<body>
    <header>
        <a href="/">
            <img src="/img/logo.png" alt="Logotipo de NovaHarvest">
        </a>
        <p><a href="/">NovaHarvest</a></p>
        <nav>
            <a href="/">Inicio</a>
            <a href="/excedentes.php">Excedentes</a>
            <a href="/avisos.html">Avísame</a>
            <a href="/temporada.md">Temporada</a>
            <a href="/estado.php">Estado</a>
        </nav>
    </header>
    <main>
        <h1>Aviso registrado</h1>
        <p>Gracias. Te avisaremos cuando haya excedentes del producto que buscas.</p>
        <a class="boton" href="/excedentes.php">Consultar excedentes</a>
    </main>
    <footer>NovaHarvest · IES Valle del Jerte · Curso 2026-2027</footer>
</body>
</html>