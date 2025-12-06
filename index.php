<?php include('conexion.php'); ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Prueba Desarrollo</title>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<style>
    body { font-family: Arial, sans-serif; padding: 15px; }
    .caja_form { background: #f0f0f0; padding: 15px; border: 1px solid #999; margin-bottom: 20px; }
    input[type="text"] { width: 60%; padding: 5px; }
</style>
</head>
<body>

    <h2>Mis Tareas</h2>

    <div class="caja_form">
        <form id="form">
            <input type="text" name="texto" id="txt_tarea" required>
            
            <span style="margin-left:10px">
            <?php
            $s = "SELECT * FROM categorias";
            $r = $conn->query($s);
            while($row = $r->fetch_assoc()){
                echo '<input type="checkbox" name="cats[]" value="'.$row['id'].'"> '.$row['nombre'].' ';
            }
            ?>
            </span>
            
            <button type="submit">Guardar</button>
        </form>
    </div>

    <table border="1" width="100%" cellpadding="5" style="border-collapse: collapse;">
        <thead>
            <tr bgcolor="#cccccc">
                <th>Nombre Tarea</th>
                <th>Categorias Asignadas</th>
                <th>Borrar</th>
            </tr>
        </thead>
        <tbody id="tareas">
            <?php
            $q = "SELECT t.id, t.nombre, GROUP_CONCAT(c.nombre) as tags FROM tareas t LEFT JOIN tareas_cat tc ON t.id=tc.tarea_id LEFT JOIN categorias c ON tc.categoria_id=c.id GROUP BY t.id ORDER BY t.id DESC";
            $res = $conn->query($q);
            while($f = $res->fetch_assoc()){
            ?>
            <tr id="tr_<?php echo $f['id']; ?>">
                <td><?php echo $f['nombre']; ?></td>
                <td>
                    <?php 
                    echo str_replace(',', ' - ', $f['tags']); 
                    ?>
                </td>
                <td align="center">
                    <button class="btn_borrar" id="<?php echo $f['id']; ?>" style="color:red; font-weight:bold">X</button>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>

<script>
$(document).ready(function(){

    $("#form").submit(function(e){
        e.preventDefault();
        
        var t = $("#txt_tarea").val();
        var c = [];
        
        $('input[name="cats[]"]:checked').each(function(){
            c.push($(this).val());
        });

        if(t == "") { alert("error"); return; }

        $.ajax({
            type: "POST",
            url: "guardar.php",
            data: { texto: t, cats: c },
            success: function(response){
                $("#tareas").prepend(response);
                $("#txt_tarea").val("");
                $('input[type="checkbox"]').prop('checked', false);
            }
        });
    });

    $(document).on("click", ".btn_borrar", function(){
        var id_borrar = $(this).attr("id");
        var padre = $(this).closest("tr");
        
        if(confirm("¿seguro?")){
            $.post("borrar.php", {id: id_borrar}, function(resp){
                if(resp == "ok"){
                    padre.remove();
                }
            });
        }
    });

});
</script>

</body>
</html>