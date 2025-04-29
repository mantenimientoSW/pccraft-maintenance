<!DOCTYPE html>
<html>
<head>
    <title>Pedido Entregado</title>
</head>
<body>
    <h1>¡Tu pedido ha sido entregado!</h1>
    <p>Hola {{ $order->usuario->name }},</p>
    <p>Nos complace informarte que tu pedido con ID {{ $order->ID_Orden }} ha sido entregado satisfactoriamente.</p>
    <p>Esperamos que disfrutes tu compra. Si tienes alguna consulta, no dudes en contactarnos.</p>
    <p>Atentamente,</p>
    <p>El equipo de {{ config('app.name') }}</p>
</body>
</html>
