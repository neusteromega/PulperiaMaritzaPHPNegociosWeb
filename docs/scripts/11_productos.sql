CREATE TABLE productos (
    PrdID INT NOT NULL PRIMARY KEY AUTO_INCREMENT COMMENT "Llave Primaria",
    PrdNombre VARCHAR(150) NOT NULL COMMENT "Nombre del Producto",
    PrdPrecio DECIMAL(10,2) NOT NULL COMMENT "Precio del Producto",
    PrdImagen VARCHAR(200) NOT NULL COMMENT "Ruta de la Imagen del Producto",
    PrdStock INT NOT NULL COMMENT "Stock Disponible del Producto",
    CatID INT NOT NULL COMMENT "PK de Proveedores",
    PrvID INT NOT NULL COMMENT "PK de Categorías",
    PrdCreacion DATETIME NOT NULL COMMENT "Fecha y Hora de Creación del Producto",
    PrdEstado CHAR(3) NOT NULL DEFAULT "ACT" COMMENT "Estado del Producto",
    CONSTRAINT FKCatID FOREIGN KEY (CatID) REFERENCES categorias(CatID),
    CONSTRAINT FKPrvID FOREIGN KEY (PrvID) REFERENCES proveedores(PrvID)
) COMMENT "Productos Registrados";