<section>
    <h2>Listado de Productos</h2>
</section>
<section class="WWList">
    <table>
        <thead>
            <tr>
                <th>Código</th>
                <th>Nombre</th>
                <th>Precio</th>
                <th>Stock Disponible</th>
                <th>Estado</th>
                <th>
                    {{if canInsert}}
                        <a href="index.php?page=Productos-ProductoForm&mode=INS">Nuevo</a>
                    {{endif canInsert}}    
                </th>
            </tr>
        </thead>
        <tbody>
            {{foreach productos}}
            <tr>
                <td>{{PrdID}}</td>
                <td>
                    {{if ~canView}}
                        <a href="index.php?page=Productos-ProductoForm&mode=DSP&id={{PrdID}}">{{PrdNombre}}</a>
                    {{endif ~canView}} 
                    {{ifnot ~canView}}  
                        {{PrdNombre}}
                    {{endifnot ~canView}} 
                </td>
                <td>{{PrdPrecio}}</td>
                <td>{{PrdStock}}</td>
                <td>{{PrdEstado}}</td>
                <td>
                    {{if ~canEdit}}
                        <a href="index.php?page=Productos-ProductoForm&mode=UPD&id={{PrdID}}">Editar&nbsp;&nbsp;</a> 
                    {{endif ~canEdit}}
                    {{if ~canDelete}}
                        <a href="index.php?page=Productos-ProductoForm&mode=DEL&id={{PrdID}}">Eliminar</a>
                    {{endif ~canDelete}}
                </td>
            </tr>
            {{endfor productos}}
        </tbody>
    </table>
</section>