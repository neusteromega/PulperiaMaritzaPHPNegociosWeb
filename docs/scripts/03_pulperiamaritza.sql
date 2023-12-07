USE pulperiamaritza

CREATE TABLE usuario (
    usercod bigint(10) NOT NULL AUTO_INCREMENT,
    useremail varchar(80) DEFAULT NULL,
    username varchar(80) DEFAULT NULL,
    userpswd varchar(128) DEFAULT NULL,
    userfching datetime DEFAULT NULL,
    userpswdest char(3) DEFAULT NULL,
    userpswdexp datetime DEFAULT NULL,
    userest char(3) DEFAULT NULL,
    useractcod varchar(128) DEFAULT NULL,
    userpswdchg varchar(128) DEFAULT NULL,
    usertipo char(3) DEFAULT NULL COMMENT 'Tipo de Usuario, Normal, Consultor o Cliente',
    PRIMARY KEY (usercod),
    UNIQUE KEY useremail_UNIQUE (useremail),
    KEY usertipo (
        usertipo,
        useremail,
        usercod,
        userest
    )
) ENGINE = InnoDB AUTO_INCREMENT = 1 DEFAULT CHARSET = utf8;

CREATE TABLE roles (
    rolescod varchar(128) NOT NULL,
    rolesdsc varchar(45) DEFAULT NULL,
    rolesest char(3) DEFAULT NULL,
    PRIMARY KEY (rolescod)
) ENGINE = InnoDB DEFAULT CHARSET = utf8;

CREATE TABLE roles_usuarios (
    usercod bigint(10) NOT NULL,
    rolescod varchar(128) NOT NULL,
    roleuserest char(3) DEFAULT NULL,
    roleuserfch datetime DEFAULT NULL,
    roleuserexp datetime DEFAULT NULL,
    PRIMARY KEY (usercod, rolescod),
    KEY rol_usuario_key_idx (rolescod),
    CONSTRAINT rol_usuario_key FOREIGN KEY (rolescod) REFERENCES roles (rolescod) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT usuario_rol_key FOREIGN KEY (usercod) REFERENCES usuario (usercod) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB DEFAULT CHARSET = utf8;

CREATE TABLE funciones (
    fncod varchar(255) NOT NULL,
    fndsc varchar(255) DEFAULT NULL,
    fnest char(3) DEFAULT NULL,
    fntyp char(3) DEFAULT NULL,
    PRIMARY KEY (fncod)
) ENGINE = InnoDB DEFAULT CHARSET = utf8;

CREATE TABLE funciones_roles (
    rolescod varchar(128) NOT NULL,
    fncod varchar(255) NOT NULL,
    fnrolest char(3) DEFAULT NULL,
    fnexp datetime DEFAULT NULL,
    PRIMARY KEY (rolescod, fncod),
    KEY rol_funcion_key_idx (fncod),
    CONSTRAINT funcion_rol_key FOREIGN KEY (rolescod) REFERENCES roles (rolescod) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT rol_funcion_key FOREIGN KEY (fncod) REFERENCES funciones (fncod) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB DEFAULT CHARSET = utf8;

CREATE TABLE categorias (
    CatID INT NOT NULL PRIMARY KEY AUTO_INCREMENT COMMENT "Llave Primaria",
    CatNombre VARCHAR(70) NOT NULL COMMENT "Nombre de la Categoría",
    CatEstado CHAR(3) NOT NULL DEFAULT "ACT" COMMENT "Estado de la Categoría",
    CatCreacion DATETIME NOT NULL COMMENT "Fecha y Hora de Creación de la Categoría",
    CatImagen VARCHAR(200) NOT NULL COMMENT "Ruta de Imagen de Categoría"
) COMMENT "Categorias de los Productos";

CREATE TABLE proveedores (
    PrvID INT NOT NULL PRIMARY KEY AUTO_INCREMENT COMMENT "Llave Primaria",
    PrvNombre VARCHAR(70) NOT NULL COMMENT "Nombre del Proveedor",
    PrvEstado CHAR(3) NOT NULL DEFAULT "ACT" COMMENT "Estado del Proveedor",
    PrvCreacion DATETIME NOT NULL COMMENT "Fecha y Hora de Creación del Proveedor",
    PrvImagen VARCHAR(200) NOT NULL COMMENT "Ruta de Imagen de Proveedor"
) COMMENT "Proveedores de los Productos";

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

CREATE TABLE comprasEncabezado (
    CmpID INT NOT NULL PRIMARY KEY AUTO_INCREMENT COMMENT "Llave Primaria",
    CmpFecha DATE NOT NULL COMMENT "Fecha de la Compra",
    usercod BIGINT(10) NOT NULL COMMENT "PK de Usuarios",
    CONSTRAINT FKUserCod FOREIGN KEY (usercod) REFERENCES usuarios(usercod)
) COMMENT "Encabezado de una Compra";

CREATE TABLE comprasDetalle (
    CmpID INT NOT NULL COMMENT "FK de comprasEncabezado",
    PrdID INT NOT NULL COMMENT "FK de Productos",
    PrdPrecioHist DECIMAL(10,2) NOT NULL COMMENT "Precio Histórico del Producto",
    PrdCantidad INT NOT NULL COMMENT "Cantidad del Producto a Comprar",
    CONSTRAINT FKCmpID FOREIGN KEY (CmpID) REFERENCES comprasEncabezado(CmpID),
    CONSTRAINT FKPrdID FOREIGN KEY (PrdID) REFERENCES productos(PrdID)
) COMMENT "Detalle de una Compra";

CREATE TABLE carritoCompras (
    CrtID INT NOT NULL PRIMARY KEY AUTO_INCREMENT COMMENT "Llave Primaria del Producto",
    CrtNombre VARCHAR(150) NOT NULL COMMENT "Nombre del Producto",
    CrtCantidad INT NOT NULL COMMENT "Cantidad del Producto a Comprar",
    CrtPrecio DECIMAL(10,2) NOT NULL COMMENT "Precio del Producto",
    CrtImagen VARCHAR(200) NOT NULL COMMENT "Ruta de la Imagen del Producto"
) COMMENT "Carrito de Compras";