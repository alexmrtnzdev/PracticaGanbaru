<?php
include('conexion.php');

$t = $_POST['texto'];
$cat = $_POST['cats'];

$sql1 = "INSERT INTO tareas (nombre) VALUES ('" . $t . "')";
$conn->query($sql1);
$last = $conn->insert_id;

    if ($cat) {
        foreach ($cat as $c) {
            $conn->query("INSERT INTO tareas_cat (tarea_id,categoria_id) VALUES ($last, $c)");
        }
    }

$sql = "SELECT t.id, t.nombre, GROUP_CONCAT(c.nombre) as tags FROM tareas t LEFT JOIN tareas_cat tc ON t.id=tc.tarea_id LEFT JOIN categorias c ON tc.categoria_id=c.id WHERE t.id=" . $last . " GROUP BY t.id";

$res = $conn->query($sql);
$fila = $res->fetch_assoc();

echo '<tr id="tr_' . $fila['id'] . '">';
echo '<td>' . $fila['nombre'] . '</td>';
echo '<td>';
echo str_replace(',', ' - ', $fila['tags']);
echo '</td>';
echo '<td align="center"><button class="btn_borrar" id="' . $fila['id'] . '" style="color:red; font-weight:bold">X</button></td>';
echo '</tr>';
