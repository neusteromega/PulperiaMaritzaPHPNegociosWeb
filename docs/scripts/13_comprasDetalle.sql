CREATE TABLE comprasDetalle (
    CmpID INT NOT NULL COMMENT "FK de comprasEncabezado",
    PrdID INT NOT NULL COMMENT "FK de Productos",
    PrdPrecioHist DECIMAL(10,2) NOT NULL COMMENT "Precio Histórico del Producto",
    PrdCantidad INT NOT NULL COMMENT "Cantidad del Producto a Comprar",
    CONSTRAINT FKCmpID FOREIGN KEY (CmpID) REFERENCES comprasEncabezado(CmpID),
    CONSTRAINT FKPrdID FOREIGN KEY (PrdID) REFERENCES productos(PrdID)
) COMMENT "Detalle de una Compra";