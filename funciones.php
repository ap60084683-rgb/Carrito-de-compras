<?php
// Este archivo solo contiene funciones

function agregarProducto($nombre, $precio, $cantidad) {
    $_SESSION['carrito'][] = [
        "nombre" => (string)$nombre,
        "precio" => (float)$precio,
        "cantidad" => (int)$cantidad
    ];
}

function actualizarCantidades($cantidades) {
    foreach ($cantidades as $indice => $nuevaCantidad) {
        if (isset($_SESSION['carrito'][$indice]) && is_array($_SESSION['carrito'][$indice])) {
            $_SESSION['carrito'][$indice]['cantidad'] = (int)$nuevaCantidad;
        }
    }
}

function eliminarProducto($indice) {
    if (isset($_SESSION['carrito'][$indice])) {
        $_SESSION['eliminados'][] = $_SESSION['carrito'][$indice];
        unset($_SESSION['carrito'][$indice]);
        $_SESSION['carrito'] = array_values($_SESSION['carrito']); // Reindexar
    }
}

function rehacerProducto($indice) {
    if (isset($_SESSION['eliminados'][$indice])) {
        $_SESSION['carrito'][] = $_SESSION['eliminados'][$indice];
        unset($_SESSION['eliminados'][$indice]);
        $_SESSION['eliminados'] = array_values($_SESSION['eliminados']);
    }
}

function calcularTotal() {
    $total = 0;
    foreach ($_SESSION['carrito'] as $item) {
        if (is_array($item)) {
            $total += $item['precio'] * $item['cantidad'];
        }
    }
    return $total;
}

