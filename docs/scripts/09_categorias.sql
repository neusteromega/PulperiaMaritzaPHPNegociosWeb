CREATE TABLE categorias (
    CatID INT NOT NULL PRIMARY KEY AUTO_INCREMENT COMMENT "Llave Primaria",
    CatNombre VARCHAR(70) NOT NULL COMMENT "Nombre de la Categoría",
    CatEstado CHAR(3) NOT NULL DEFAULT "ACT" COMMENT "Estado de la Categoría",
    CatCreacion DATETIME NOT NULL COMMENT "Fecha y Hora de Creación de la Categoría",
    CatImagen VARCHAR(200) NOT NULL COMMENT "Ruta de Imagen de Categoría"
) COMMENT "Categorias de los Productos";