<!DOCTYPE html>
<html>
<head>
    <title>Confirmación de tu compra</title>
    <style>
        .cart-photo {
            margin-right: 15px;
        }
        .img-thumbnail {
            border-radius: 5px;
            border: 1px solid #ddd;
            display: block;
        }
        /* Limitar el ancho de la columna del producto */
        .product-details {
            max-width: 250px; /* Ajusta este valor según sea necesario */
            word-wrap: break-word;
        }
    </style>
</head>
<body>
    <h1>¡Gracias por tu compra, {{ $order->usuario->name }}!</h1>
    <p>Detalles de tu orden:</p>
    <ul>
        <li><strong>ID de la orden:</strong> {{ $order->ID_Orden }}</li>
        <li><strong>Total:</strong> ${{ $order->total }}</li>
        <li><strong>Fecha:</strong> {{ $order->fecha }}</li>
    </ul>

    <h3>Productos comprados:</h3>

    <table style="width:100%; border-collapse: collapse;">
        <thead>
            <tr>
                <!-- Especificar el ancho de la columna Producto -->
                <th style="border: 1px solid #dddddd; padding: 8px; width: 200px;">Producto</th>
                <th style="border: 1px solid #dddddd; padding: 8px; width: 150px;">Precio</th>
                <th style="border: 1px solid #dddddd; padding: 8px; width: 100px;">Cantidad</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cartItems as $item)
            <tr>
                <td style="border: 1px solid #dddddd; padding: 8px; width: 200px;">
                    <div style="display: flex; align-items: center;">
                    @if (!empty($item->attributes['image']))
                        <img src="{{ $message->embed(public_path('storage/' . $item->attributes['image'])) }}" style="width: 80px; height: 80px; object-fit: cover; border: 1px solid #ddd; border-radius: 5px;" alt="{{ $item->name }}">
                     @else
                        <p>Este producto no tiene imagen.</p>
                    @endif
                        <div class="product-details" style="margin-left: 10px; max-width: 250px;">
                            <b>{{ $item->name }}</b><br>
                            Modelo: {{ $item->attributes['model'] ?? $item->attributes->model }}<br>
                            Fabricante: {{ $item->attributes['manufacturer'] ?? $item->attributes->manufacturer }}
                        </div>
                    </div>
                </td>
                <td style="border: 1px solid #dddddd; padding: 8px; width: 150px;">
                    ${{ number_format($item->price, 2, '.', ',') }} MXN
                </td>
                <td style="border: 1px solid #dddddd; padding: 8px; width: 100px;">
                    {{ $item->quantity }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <p>Nos pondremos en contacto contigo para más detalles.</p>
</body>
</html>
