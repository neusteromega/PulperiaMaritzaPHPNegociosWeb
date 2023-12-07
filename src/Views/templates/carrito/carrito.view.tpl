<h1>Carrito de Compras</h1>
<div class="container">
    <div class="products">
        {{foreach carrito}}
        <div class="product-card">
            <div class="product-image">
                <img src="{{CrtImagen}}" alt="{{CrtNombre}}">
            </div>
            <div class="product-details">
                <div class="product-name">
                    <p>{{CrtNombre}}</p>
                </div>

                <div class="product-price">
                    <p>L.{{CrtPrecio}}</p>
                </div>

                <div class="product-quantity">
                    <p>{{CrtCantidad}}</p>
                </div>

                <div class="product-total">
                    <p>L.{{CrtTotal}}</p>
                </div>

                <form action="index.php?page=Carrito-Carrito&id={{CrtID}}" method="post">
                    <button type="submit" class="delete-product">X</button>
                </form>
            </div>
        </div>
        {{endfor carrito}}
    </div>
    <div class="totals">
        {{with totales}}
        <div class="total">
            <h3>Subtotal:</h3>
            <p>L.{{Subtotal}}</p>
        </div>

        <div class="total">
            <h3>ISV:</h3>
            <p>L.{{ISV}}</p>
        </div>

        <div class="total">
            <h3>Total a Pagar:</h3>
            <p>L.{{Total}}</p>
        </div>

        {{endwith totales}}
        <button type="button" class="btn-pagar">Pagar con PayPal</button>
    </div>
</div>