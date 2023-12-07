{{with producto}}
<form action="index.php?page=Productos-Catalogo-CatalogoDetalle&id={{PrdID}}" method="post">
    <section class="product">
        <div class="photo-container">
            <div class="photo-main">
                <img src="{{PrdImagen}}" alt="{{PrdNombre}}">
            </div>
        </div>
        <div class="product__info">
            <div class="title">
                <h1>{{PrdNombre}}</h1>
            </div>

            <div class="price">
                L.<span>{{PrdPrecio}}</span>
            </div>

            <div class="description">
                <h3>CATEGORÍA: </h3>
                <p>{{Categoria}}</p>

                <h3>CANTIDAD: </h3>
                <input type="number" name="PrdCantidad" id="PrdCantidad" min="1" max="{{PrdStock}}" value="1"/>
                {{if prdcantidad_error}}<div>{{prdcantidad_error}}</div>{{endif prdcantidad_error}}

                <h3>DISPONIBLES EN STOCK: </h3>
                <p>{{PrdStock}}</p>

                <button type="submit" name="btnAgregarCarrito" class="buy--btn">AGREGAR AL CARRITO</button>&nbsp;
                {{if prdcarrito_error}}<div>{{prdcarrito_error}}</div>{{endif prdcarrito_error}}
            </div>
        </div>
    </section>
</form>
{{endwith producto}}