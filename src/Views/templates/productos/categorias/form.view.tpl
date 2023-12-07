<section>
    <h1>{{modedsc}}</h1>
</section>
{{with categoria}}
<form action="index.php?page=Productos-Categorias-CategoriaForm&mode={{~mode}}&id={{CatID}}" method="POST">
    <input type="hidden" name="xss_token" value="{{~xss_token}}">
    <label for="CatID">Código: </label>
    <input type="text" name="CatID" id="CatID" value="{{CatID}}" readonly/>
    <br><br>

    <label for="CatNombre">Nombre: </label>
    <input type="text" name="CatNombre" id="CatNombre" value="{{CatNombre}}" {{~readonly}}/>
    <br>
    {{if catnombre_error}}<div>{{catnombre_error}}</div>{{endif catnombre_error}}
    <br>

    <label for="CatEstado">Estado: </label>
    <select name="CatEstado" id="CatEstado" {{if ~readonly}}readonly{{endif ~readonly}}>
        <option value="ACT" {{ACT_selected}}>Activa</option>
        <option value="INA" {{INA_selected}}>Inactiva</option>
    </select>
    <br>
    {{if catestado_error}}<div>{{catestado_error}}</div>{{endif catestado_error}}
    <br>

    {{if ~showConfirm}}
    <button type="submit" name="btnConfirm">Confirmar</button>&nbsp;
    {{endif ~showConfirm}}

    <button id="btnCancel">Cancelar</button>
</form>
{{endwith categoria}}

<script>
    document.addEventListener("DOMContentLoaded", ()=>{
        document.getElementById("btnCancel").addEventListener("click", (e)=>{
            e.preventDefault();
            e.stopPropagation();
            document.location.assign("index.php?page=Productos-Categorias-CategoriasList");
        });
    });
</script>