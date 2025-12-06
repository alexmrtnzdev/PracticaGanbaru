<?php
include "conexion.php";

$id = $_POST['id'];

$conn->query("DELETE FROM tareas WHERE id=$id");

echo "ok";
