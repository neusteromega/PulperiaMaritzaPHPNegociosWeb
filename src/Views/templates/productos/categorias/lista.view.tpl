<section>
    <h2>Listado de Categorías</h2>
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
                        <a href="index.php?page=Productos-Categorias-CategoriaForm&mode=INS">Nuevo</a>
                    {{endif canInsert}}    
                </th>
            </tr>
        </thead>
        <tbody>
            {{foreach categorias}}
            <tr>
                <td>{{CatID}}</td>
                <td>
                    {{if ~canView}}
                        <a href="index.php?page=Productos-Categorias-CategoriaForm&mode=DSP&id={{CatID}}">{{CatNombre}}</a>
                    {{endif ~canView}}
                    {{ifnot ~canView}} 
                        {{CatNombre}}
                    {{endifnot ~canView}}
                </td>
                <td>{{CatEstado}}</td>
                <td>
                    {{if ~canEdit}}
                        <a href="index.php?page=Productos-Categorias-CategoriaForm&mode=UPD&id={{CatID}}">Editar&nbsp;&nbsp;</a>
                    {{endif ~canEdit}}
                    {{if ~canDelete}}
                        <a href="index.php?page=Productos-Categorias-CategoriaForm&mode=DEL&id={{CatID}}">Eliminar</a>
                    {{endif ~canDelete}}
                </td>
            </tr>
            {{endfor categorias}}
        </tbody>
    </table>
</section>