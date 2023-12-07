<section>
    <h2>Listado de Proveedores</h2>
</section>
<section class="WWList">
    <table>
        <thead>
            <tr>
                <th>Código</th>
                <th>Nombre</th>
                <th>Estado</th>
                <th>
                    {{if canInsert}}
                        <a href="index.php?page=Productos-Proveedores-ProveedorForm&mode=INS">Nuevo</a>
                    {{endif canInsert}}
                </th>
            </tr>
        </thead>
        <tbody>
            {{foreach proveedores}}
            <tr>
                <td>{{PrvID}}</td>
                <td>
                    {{if ~canView}}
                        <a href="index.php?page=Productos-Proveedores-ProveedorForm&mode=DSP&id={{PrvID}}">{{PrvNombre}}</a>
                    {{endif ~canView}}
                    {{ifnot ~canView}}  
                        {{PrvNombre}}
                    {{endifnot ~canView}}
                </td>
                <td>{{PrvEstado}}</td>
                <td>
                    {{if ~canEdit}}
                        <a href="index.php?page=Productos-Proveedores-ProveedorForm&mode=UPD&id={{PrvID}}">Editar&nbsp;&nbsp;</a>
                    {{endif ~canEdit}}
                    {{if ~canDelete}}
                        <a href="index.php?page=Productos-Proveedores-ProveedorForm&mode=DEL&id={{PrvID}}">Eliminar</a>
                    {{endif ~canDelete}}
                </td>
            </tr>
            {{endfor proveedores}}
        </tbody>
    </table>
</section>