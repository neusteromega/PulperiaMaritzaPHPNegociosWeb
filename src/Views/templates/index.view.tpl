<h1>{{SITE_TITLE}}</h1>

<div class="container">
    <h1>Categorías</h1>
    <a href="index.php?page=Productos-Categorias-CategoriasList">Ver Todas</a>
</div>
<div>
    {{foreach categorias}}
        <img src="{{CatImagen}}" alt="{{CatNombre}}">
        <h2>{{CatNombre}}</h2>
    {{endfor categorias}}
</div>

<div>
    <h1>Productos</h1>
    <a href="index.php?page=Productos-ProductosList">Ver Todos</a>
</div>
<div>
    {{foreach productos}}
        <img src="{{PrdImagen}}" alt="{{PrdNombre}}">
        <h2>{{PrdNombre}}</h2>
        <span>{{PrdPrecio}}</span>
        <button>Agregar al Carrito</button>
    {{endfor productos}}
</div>

<div>
    <h1>Proveedores</h1>
    <a href="index.php?page=Productos-Proveedores-ProveedoresList">Ver Todos</a>
</div>
<div>
    {{foreach proveedores}}
        <img src="{{PrvImagen}}" alt="{{PrvNombre}}">
        <h2>{{PrvNombre}}</h2>
    {{endfor proveedores}}
</div>