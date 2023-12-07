CREATE TABLE proveedores (
    PrvID INT NOT NULL PRIMARY KEY AUTO_INCREMENT COMMENT "Llave Primaria",
    PrvNombre VARCHAR(70) NOT NULL COMMENT "Nombre del Proveedor",
    PrvEstado CHAR(3) NOT NULL DEFAULT "ACT" COMMENT "Estado del Proveedor",
    PrvCreacion DATETIME NOT NULL COMMENT "Fecha y Hora de Creación del Proveedor",
    PrvImagen VARCHAR(200) NOT NULL COMMENT "Ruta de Imagen de Proveedor"
) COMMENT "Proveedores de los Productos";