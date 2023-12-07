<section>
    <h1>{{modedsc}}</h1>
</section>
{{with proveedor}}
<form action="index.php?page=Productos-Proveedores-ProveedorForm&mode={{~mode}}&id={{PrvID}}" method="POST">
    <input type="hidden" name="xss_token" value="{{~xss_token}}">
    <label for="PrvID">Código: </label>
    <input type="text" name="PrvID" id="PrvID" value="{{PrvID}}" readonly/>
    <br><br>

    <label for="PrvNombre">Nombre: </label>
    <input type="PrvNombre" name="PrvNombre" id="PrvNombre" value="{{PrvNombre}}" {{~readonly}}/>
    <br>
    {{if prvnombre_error}}<div>{{prvnombre_error}}</div>{{endif prvnombre_error}}
    <br>

    <label for="PrvEstado">Estado: </label>
    <select name="PrvEstado" id="PrvEstado" {{if ~readonly}}readonly{{endif ~readonly}}>
        <option value="ACT" {{ACT_selected}}>Activo</option>
        <option value="INA" {{INA_selected}}>Inactivo</option>
    </select>
    <br>
    {{if prvestado_error}}<div>{{prvestado_error}}</div>{{endif prvestado_error}}
    <br>

    {{if ~showConfirm}}
    <button type="submit" name="btnConfirm">Confirmar</button>&nbsp;
    {{endif ~showConfirm}}

    <button id="btnCancel">Cancelar</button>
</form>
{{endwith proveedor}}

<script>
    document.addEventListener("DOMContentLoaded", ()=>{
        document.getElementById("btnCancel").addEventListener("click", (e)=>{
            e.preventDefault();
            e.stopPropagation();
            document.location.assign("index.php?page=Productos-Proveedores-ProveedoresList");
        });
    });
</script>