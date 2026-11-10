-- selecciono la base de datos de NovaHarvest
USE novaharvest;

-- creo la tabla de excedentes agrícolas
CREATE TABLE excedentes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    producto VARCHAR(100) NOT NULL,
    productor VARCHAR(100) NOT NULL,
    pueblo VARCHAR(100) NOT NULL,
    kilos INT NOT NULL DEFAULT 0,
    precio_kg DECIMAL(6,2) NOT NULL
);

-- creo la tabla de avisos de compradores
CREATE TABLE avisos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL,
    producto VARCHAR(100) NOT NULL,
    fecha DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- inserto los excedentes iniciales
INSERT INTO excedentes
(producto, productor, pueblo, kilos, precio_kg)
VALUES
('Melocotón', 'Huerta Los Castaños', 'Cabezuela del Valle', 120, 1.80),
('Cereza', 'Finca El Rebollar', 'Rebollar', 223, 2.24),
('Manzana', 'Huerto La Garganta', 'Navaconcejo', 90, 1.50),
('Uva', 'Hermanos Sánchez', 'Jerte', 80, 1.60),
('Pera', 'Huerta Los Castaños', 'Cabezuela del Valle', 65, 1.40);

-- retiro los privilegios iniciales del usuario sobre esta base de datos
REVOKE ALL PRIVILEGES ON novaharvest.* FROM 'novaharvest_app'@'%';

-- concedo únicamente los permisos necesarios para la aplicación
GRANT SELECT, INSERT ON novaharvest.* TO 'novaharvest_app'@'%';