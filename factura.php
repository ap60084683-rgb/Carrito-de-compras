<?php
session_start();
include 'funciones.php';

$factura = $_SESSION['carrito'];
$total = calcularTotal();
$_SESSION['carrito'] = []; // Vaciar carrito
$_SESSION['eliminados'] = []; // Vaciar eliminados también
?>
<!DOCTYPE html>
<html>
<head>
    <title>Factura</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <h2>Factura de Compra</h2>
    <?php if (!empty($factura)): ?>
        <table>
            <tr><th>Producto</th><th>Precio (S/)</th><th>Cantidad</th><th>Subtotal (S/)</th></tr>
            <?php foreach ($factura as $item): ?>
                <?php if (is_array($item)): ?>
                    <tr>
                        <td><?= htmlspecialchars($item['nombre']) ?></td>
                        <td>S/<?= number_format($item['precio'], 2) ?></td>
                        <td><?= $item['cantidad'] ?></td>
                        <td>S/<?= number_format($item['precio'] * $item['cantidad'], 2) ?></td>
                    </tr>
                <?php endif; ?>
            <?php endforeach; ?>
        </table>
        <p><strong>Total pagado: S/<?= number_format($total, 2) ?></strong></p>
        <p>¡Gracias por su compra!</p>
    <?php else: ?>
        <p>No hay productos en la factura.</p>
    <?php endif; ?>
    <a href="index.php">Volver al carrito</a>
</body>
</html>
