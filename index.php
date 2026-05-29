<?php
session_start();
include 'funciones.php';

// Inicializar variables de sesión
if (!isset($_SESSION['carrito']) || !is_array($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}
if (!isset($_SESSION['eliminados']) || !is_array($_SESSION['eliminados'])) {
    $_SESSION['eliminados'] = [];
}

// Agregar producto
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['agregar'])) {
    agregarProducto($_POST['producto'], $_POST['precio'], $_POST['cantidad']);
}

// Actualizar cantidades
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['actualizar'])) {
    actualizarCantidades($_POST['cantidades']);
}

// Eliminar producto
if (isset($_GET['eliminar'])) {
    eliminarProducto($_GET['eliminar']);
}

// Rehacer producto
if (isset($_GET['rehacer'])) {
    rehacerProducto($_GET['rehacer']);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Carrito de Compras</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <h2>Carrito de Compras</h2>

    <form method="post">
        <label for="producto">Producto:</label><br>
        <input type="text" id="producto" name="producto" required><br><br>

        <label for="precio">Precio (S/):</label><br>
        <input type="number" step="0.01" id="precio" name="precio" required><br><br>

        <label for="cantidad">Cantidad:</label><br>
        <input type="number" id="cantidad" name="cantidad" min="1" value="1" required><br><br>

        <input type="submit" name="agregar" value="Agregar">
    </form>

    <hr>

    <?php if (!empty($_SESSION['carrito'])): ?>
        <form method="post">
            <table>
                <tr>
                    <th>Producto</th><th>Precio (S/)</th><th>Cantidad</th><th>Subtotal (S/)</th><th>Acción</th>
                </tr>
                <?php foreach ($_SESSION['carrito'] as $indice => $item): ?>
                    <?php if (is_array($item)): ?>
                        <tr>
                            <td><?= htmlspecialchars($item['nombre']) ?></td>
                            <td>S/<?= number_format($item['precio'], 2) ?></td>
                            <td><input type="number" name="cantidades[<?= $indice ?>]" value="<?= $item['cantidad'] ?>" min="1"></td>
                            <td>S/<?= number_format($item['precio'] * $item['cantidad'], 2) ?></td>
                            <td><a href="?eliminar=<?= $indice ?>">Eliminar</a></td>
                        </tr>
                    <?php endif; ?>
                <?php endforeach; ?>
            </table>
            <p><strong>Total: S/<?= number_format(calcularTotal(), 2) ?></strong></p>
            <input type="submit" name="actualizar" value="Actualizar">
            <a href="factura.php">Finalizar compra</a>
        </form>
    <?php else: ?>
        <p>El carrito está vacío.</p>
    <?php endif; ?>

    <!-- Productos eliminados con opción de rehacer -->
    <?php if (!empty($_SESSION['eliminados'])): ?>
        <hr>
        <h3>Productos eliminados (puedes rehacer):</h3>
        <ul>
            <?php foreach ($_SESSION['eliminados'] as $indice => $item): ?>
                <?php if (is_array($item)): ?>
                    <li><?= htmlspecialchars($item['nombre']) ?> - S/<?= number_format($item['precio'], 2) ?> 
                        <a href="?rehacer=<?= $indice ?>">Rehacer</a>
                    </li>
                <?php endif; ?>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</body>
</html>
