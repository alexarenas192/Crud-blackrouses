<?php
// ¡CONEXIÓN CORREGIDA! Apunta al servicio 'db' en Docker
$mysqli = new mysqli("db", "user", "password", "blackroses_db");

if ($mysqli->connect_error) {
    die("Conexión fallida: " . $mysqli->connect_error);
}

// Crear carpeta uploads si no existe
if (!is_dir("uploads")) {
    mkdir("uploads", 0777, true);
}
// Las líneas de chown/chgrp fueron eliminadas para evitar errores de permisos en Docker.


// Insertar o actualizar cóctel
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accion = $_POST['accion'];

    if ($accion === 'agregar' || $accion === 'editar') {
        $nombre = $_POST['nombre'];
        $ingredientes = $_POST['ingredientes'];
        $preparacion = $_POST['preparacion'];
        $id = $_POST['id'] ?? 0;

        // Subida de imagen
        if (!empty($_FILES['imagen']['name'])) {
            $imagen = time() . "_" . basename($_FILES['imagen']['name']); // evita duplicados
            $ruta = "uploads/" . $imagen;
            if (!move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta)) {
                echo "ERROR_UPLOAD";
                exit;
            }
        } else {
            $ruta = $_POST['imagenActual'] ?? "";
        }

        if ($accion === 'agregar') {
            $stmt = $mysqli->prepare("INSERT INTO coctel (nombre, ingredientes, preparacion, imagen) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $nombre, $ingredientes, $preparacion, $ruta);
            echo $stmt->execute() ? "OK" : "ERROR_DB";
        } else {
            $stmt = $mysqli->prepare("UPDATE coctel SET nombre=?, ingredientes=?, preparacion=?, imagen=? WHERE id=?");
            $stmt->bind_param("ssssi", $nombre, $ingredientes, $preparacion, $ruta, $id);
            echo $stmt->execute() ? "OK" : "ERROR_DB";
        }
        exit;
    }

    if ($accion === 'eliminar') {
        $id = $_POST['id'];
        $mysqli->query("DELETE FROM coctel WHERE id = $id");
        echo "OK";
        exit;
    }
}

// Obtener un cóctel
if (isset($_GET['obtener'])) {
    $id = $_GET['obtener'];
    $res = $mysqli->query("SELECT * FROM coctel WHERE id = $id");
    echo json_encode($res->fetch_assoc());
    exit;
}

// Listar cócteles
if (isset($_GET['listar'])) {
    $res = $mysqli->query("SELECT * FROM coctel ORDER BY id DESC");
    while ($row = $res->fetch_assoc()) {
        // Asegurarse que la imagen tenga ruta correcta
        $img = $row['imagen'] ? $row['imagen'] : "images/default.png";
        echo "<tr>
                <td>{$row['nombre']}</td>
                <td>{$row['ingredientes']}</td>
                <td>{$row['preparacion']}</td>
                <td><img src='{$img}' width='80' height='80' style='object-fit:cover;'></td>
                <td>
                  <button class='btn-editar' data-id='{$row['id']}'>Editar</button>
                  <button class='btn-eliminar' data-id='{$row['id']}'>Eliminar</button>
                </td>
              </tr>";
    }
    exit;
}
?>