<!DOCTYPE html>
<html>
<head>
    <title>Pedido Enviado</title>
</head>
<body>
    <h1>¡Tu pedido ha sido enviado!</h1>
    <p>Hola {{ $order->usuario->name }},</p>
    <p>Nos complace informarte que tu pedido con ID {{ $order->ID_Orden }} ha sido enviado.</p>
    <p>Te mantendremos informado sobre el estado de tu envío. ¡Gracias por comprar con nosotros!</p>
    <p>Atentamente,</p>
    <p>El equipo de {{ config('app.name') }}</p>
</body>
</html>
