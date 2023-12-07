<section>
    <h1>{{modedsc}}</h1>
</section>
{{with producto}}
<form action="index.php?page=Productos-ProductoForm&mode={{~mode}}&id={{PrdID}}" method="POST">
    <input type="hidden" name="xss_token" value="{{~xss_token}}">
    <label for="PrdID">Código: </label>
    <input type="text" name="PrdID" id="PrdID" value="{{PrdID}}" readonly/>
    <br><br>

    <label for="PrdNombre">Nombre: </label>
    <input type="text" name="PrdNombre" id="PrdNombre" value="{{PrdNombre}}" {{~readonly}}/>
    <br>
    {{if prdnombre_error}}<div>{{prdnombre_error}}</div>{{endif prdnombre_error}}
    <br>

    <label for="PrdPrecio">Precio: </label>
    <input type="number" name="PrdPrecio" id="PrdPrecio" value="{{PrdPrecio}}" {{~readonly}}/>
    <br>
    {{if prdprecio_error}}<div>{{prdprecio_error}}</div>{{endif prdprecio_error}}
    <br>

    <label for="PrdStock">Stock Disponible: </label>
    <input type="number" name="PrdStock" id="PrdStock" value="{{PrdStock}}" {{~readonly}}/>
    <br>
    {{if prdstock_error}}<div>{{prdstock_error}}</div>{{endif prdstock_error}}
    <br>

    <label for="PrdImagen">Ruta de la Imagen: </label>
    <input type="text" name="PrdImagen" id="PrdImagen" value="{{PrdImagen}}" {{~readonly}}/>
    <br>
    {{if prdimagen_error}}<div>{{prdimagen_error}}</div>{{endif prdimagen_error}}
    <br>

    <label for="CatID">Categoría: </label>
    <select name="CatID" id="CatID" {{if ~readonly}}readonly{{endif ~readonly}}>
    {{foreach ~categorias}}
    <option value="{{value}}" {{selected}}>{{text}}</option>
    {{endfor ~categorias}}
    </select>
    <br>
    {{if catid_error}}<div>{{catid_error}}</div>{{endif catid_error}}
    <br>

    <label for="PrvID">Proveedor: </label>
    <select name="PrvID" id="PrvID" {{if ~readonly}}readonly{{endif ~readonly}}>
    {{foreach ~proveedores}}
    <option value="{{value}}" {{selected}}>{{text}}</option>
    {{endfor ~proveedores}}
    </select>
    <br>
    {{if prvid_error}}<div>{{prvid_error}}</div>{{endif prvid_error}}
    <br>

    <label for="PrdEstado">Estado: </label>
    <select name="PrdEstado" id="PrdEstado" {{if ~readonly}}readonly{{endif ~readonly}}>
        <option value="ACT" {{ACT_selected}}>Activo</option>
        <option value="INA" {{INA_selected}}>Inactivo</option>
    </select>
    <br>
    {{if prdestado_error}}<div>{{prdestado_error}}</div>{{endif prdestado_error}}
    <br>

    {{if ~showConfirm}}
    <button type="submit" name="btnConfirm">Confirmar</button>&nbsp;
    {{endif ~showConfirm}}

    <button id="btnCancel">Cancelar</button>
</form>
{{endwith producto}}

<script>
    document.addEventListener("DOMContentLoaded", ()=>{
        document.getElementById("btnCancel").addEventListener("click", (e)=>{
            e.preventDefault();
            e.stopPropagation();
            document.location.assign("index.php?page=Productos-ProductosList");
        });
    });
</script>