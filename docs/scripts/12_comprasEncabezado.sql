CREATE TABLE comprasEncabezado (
    CmpID INT NOT NULL PRIMARY KEY AUTO_INCREMENT COMMENT "Llave Primaria",
    CmpFecha DATE NOT NULL COMMENT "Fecha de la Compra",
    usercod BIGINT(10) NOT NULL COMMENT "PK de Usuarios",
    CONSTRAINT FKUserCod FOREIGN KEY (usercod) REFERENCES usuarios(usercod)
) COMMENT "Encabezado de una Compra";