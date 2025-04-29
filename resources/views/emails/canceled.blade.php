<!DOCTYPE html>
<html>
<head>
    <title>Pedido Cancelado</title>
</head>
<body>
    <h1>Tu pedido ha sido cancelado</h1>
    <p>Hola {{ $order->usuario->name }},</p>
    <p>Lamentamos informarte que tu pedido con ID {{ $order->ID_Orden }} ha sido cancelado. Si tienes preguntas sobre este proceso, por favor contáctanos para obtener más detalles.</p>
    <p>Atentamente,</p>
    <p>El equipo de {{ config('app.name') }}</p>
</body>
</html>
