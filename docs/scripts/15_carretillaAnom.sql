CREATE TABLE carretillaanom (
    CrtID INT NOT NULL PRIMARY KEY COMMENT "Llave Primaria del Producto",
    CrtNombre VARCHAR(150) NOT NULL COMMENT "Nombre del Producto",
    CrtCantidad INT NOT NULL COMMENT "Cantidad del Producto a Comprar",
    CrtPrecio DECIMAL(10,2) NOT NULL COMMENT "Precio del Producto",
    CrtImagen VARCHAR(200) NOT NULL COMMENT "Ruta de la Imagen del Producto",
    CrtIngreso DATETIME NOT NULL COMMENT "Fecha y Hora de Ingreso del Producto al Carrito"
) COMMENT "Carrito de Compras";