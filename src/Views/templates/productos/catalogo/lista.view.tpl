<h1>Catálogo de Productos</h1>
<div class="container">
    {{foreach catalogo}}
    <div class="product-card" data-productId="{{PrdID}}">
        <div class="product-image">
            <a href="index.php?page=Productos-Catalogo-CatalogoDetalle&id={{PrdID}}">
                <img src="{{PrdImagen}}" alt="{{PrdNombre}}">
            </a>
        </div>
        <div class="product-details">
            <h2>{{PrdNombre}}</h2>
            <p class="price">L.{{PrdPrecio}}</span>
        </div>
        <div class="buttons">
            <form action="index.php?page=Productos-Catalogo-CatalogoList&id={{PrdID}}" method="post">
                <button type="submit" name="btnAgregarCarrito" class="add-to-cart">Agregar al Carrito</button>
            </form>
        </div>
    </div>
    {{endfor catalogo}}
</div>