<?php

namespace App\Http\Controllers\Ecommerce;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ConfiguradorPCController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    protected $componentesSeleccionados = [];
    protected $componentesQuery = [];

    public function getQueryComponents()
    {
        $this->componentesQuery = session('componentesQuery', []);
        $this->componentesSeleccionados = session('componentesSeleccionados', []);
        
        $procesadores = Product::whereHas('category', function ($query) {
            $query->where('ID_Categoria', 1); // Filtrar por categoría "Procesador"
        })->where('stock', '>', 0)->get();        
        $this->componentesQuery['procesadores'] = $procesadores;
        //dd($this->componentesQuery['procesadores']);
    
        // Obtener todas las tarjetas madre
        $tarjetaMadres = Product::whereHas('category', function ($query) {
            $query->where('ID_Categoria', 3); // Filtrar por categoría "Tarjeta Madre"
        })->where('stock', '>', 0)->get(); 
        $this->componentesQuery['tarjetaMadres'] = $tarjetaMadres;
    
        // Obtener todas las memorias RAM
        $memoriasRAM = Product::whereHas('category', function ($query) {
            $query->where('ID_Categoria', 4); // Filtrar por categoría "Memorias RAM"
        })->where('stock', '>', 0)->get(); 
        $this->componentesQuery['memoriasRAM'] = $memoriasRAM;
    
        // Obtener todas las tarjetas de video
        $tarjetasDeVideo = Product::whereHas('category', function ($query) {
            $query->where('ID_Categoria', 2); // Filtrar por categoría "Tarjeta de Video"
        })->where('stock', '>', 0)->get(); 
        $this->componentesQuery['tarjetasDeVideo'] = $tarjetasDeVideo;
    
        // Obtener todos los discos duros de almacenamiento principal
        $almacenamientoPrincipal = Product::whereHas('category', function ($query) {
            $query->where('ID_Categoria', 5); // Filtrar por categoría "Discos Duros"
        })->where('stock', '>', 0)->get(); 
        $this->componentesQuery['almacenamientoPrincipal'] = $almacenamientoPrincipal;

        /*
        // Obtener todos los discos duros de almacenamiento secundario
        $almacenamientoSecundario = Product::whereHas('category', function ($query) {
            $query->where('ID_Categoria', 5); // Filtrar por categoría "Discos Duros"
        })->get();
        $this->componentesQuery['almacenamientoSecundario'] = $almacenamientoSecundario;
        */
    
        // Obtener todos los gabinetes
        $gabinetes = Product::whereHas('category', function ($query) {
            $query->where('ID_Categoria', 6); // Filtrar por categoría "Gabinetes"
        })->where('stock', '>', 0)->get(); 
        $this->componentesQuery['gabinetes'] = $gabinetes;
    
        // Obtener todas las fuentes de poder
        $fuentesDePoder = Product::whereHas('category', function ($query) {
            $query->where('ID_Categoria', 8); // Filtrar por categoría "Fuentes de Poder"
        })->where('stock', '>', 0)->get(); 
        $this->componentesQuery['fuentesDePoder'] = $fuentesDePoder;
    
        // Obtener todos los sistemas de enfriamiento
        $enfriamientos = Product::whereHas('category', function ($query) {
            $query->where('ID_Categoria', 9); // Filtrar por categoría "Enfriamientos"
        })->where('stock', '>', 0)->get(); 
        $this->componentesQuery['enfriamientos'] = $enfriamientos;

        // Guardar en la sesión el array de componentesQuery
        //session(['componentesQuery' => $this->componentesQuery]);
        return $this->componentesQuery;
    }


    public function index()
    {
        //$user = User::find( auth()->id() );
        // Verificar si los datos ya están en la sesión
        $this->componentesQuery = session('componentesQuery', []);
        $this->componentesSeleccionados = session('componentesSeleccionados', []);
        
        // Si la sesión está vacía, obtenemos los productos
        if (empty($this->componentesQuery)) {
            // Guardar en la sesión el array de componentesQuery
            session(['componentesQuery' => $this->getQueryComponents()]);
        }
        
        $categoriaFaltante = $this->obtenerCategoriaFaltante();
        $montoTotal = $this->calcularMontoTotal();
        return view('ecommerce.configuradorpc', [
            'componentesQuery' => $this->componentesQuery, 
            'categoriaFaltante' => $categoriaFaltante,
            'montoTotal' => $montoTotal
        ])->with('title', 'E-COMMERCE STORE | CONFIGURADOR PC');
    }
    
    public function add(Request $request)
    {
        // Obtener los arrays de la seszión
        $this->componentesSeleccionados = session('componentesSeleccionados', []);
        $this->componentesQuery = session('componentesQuery', []);
    
        $id = $request->input('id');
        $categoria = $request->input('categoria'); // Procesador, tarjetaMadres, memoriasRAM
        $productoSeleccionado = Product::find($id); // Obtén el producto seleccionado por ID

        // Decodificar el JSON
        $especificacion = json_decode($productoSeleccionado->especificacionJSON, true);
    
        // Verifica la categoría "Procesador" del componente
        if ($categoria === "Procesador") {
            // Si no hay procesador seleccionado, agregar nuevo procesador al array
            $this->componentesSeleccionados['Procesador'] = $productoSeleccionado;
            if(!empty($this->componentesSeleccionados['Tarjeta Madre'])){
                $socket = $especificacion['socket'];
                // Actualizar las tarjetas madre compatibles basadas en el socket del procesador
                $procesadoresCompatibles = Product::where('especificacionJSON', 'LIKE', '%"'.$socket.'"%')
                                        ->where('ID_Categoria', 1) // Categoría de tarjetas madre
                                        ->where('stock', '>', 0)
                                        ->get();
                //dd($procesadoresCompatibles);
                $this->componentesQuery['procesadores'] = $procesadoresCompatibles;
            }
            // Verifica si el procesador ya está seleccionado en el array de componentes Tarjeta Madre y decide actualizar compatibilidad
            if (empty($this->componentesSeleccionados['Tarjeta Madre'])) {
                // Obtener el socket del procesador
                $socket = $especificacion['socket'];
                // Actualizar las tarjetas madre compatibles basadas en el socket del procesador
                $tarjetasMadreCompatibles = Product::where('especificacionJSON', 'LIKE', '%"'.$socket.'"%')
                                        ->where('ID_Categoria', 3) // Categoría de tarjetas madre
                                        ->where('stock', '>', 0)
                                        ->get();
                //dd($tarjetasMadreCompatibles);
                $this->componentesQuery['tarjetaMadres'] = $tarjetasMadreCompatibles;
            }

            if (empty($this->componentesSeleccionados['Memoría RAM'])) {
                // Actualizar memorias RAM compatibles basadas en el tipo de memoria
                $tipo_memoria = $especificacion['tipo_RAM'];
                $ramCompatibles = Product::where('especificacionJSON', 'LIKE', '%"'.$tipo_memoria.'"%')
                                        ->where('ID_Categoria', 4) // Categoría de memorias RAM
                                        ->where('stock', '>', 0)
                                        ->get();
                // Actualizamos el array de componentes query con los componentes compatibles con tipo_RAM 
                //dd($ramCompatibles);
                $this->componentesQuery['memoriasRAM'] = $ramCompatibles;
            } 
            // Guardar los arrays actualizados en la sesión
            session(['componentesSeleccionados' => $this->componentesSeleccionados]);
            session(['componentesQuery' => $this->componentesQuery]);
        }
        
        // Verifica la categoría "Tarjeta Madre" del componente
        if ($categoria === "Tarjeta Madre") {
            // Si no hay procesador seleccionado, agregar nuevo procesador al array
            $this->componentesSeleccionados['Tarjeta Madre'] = $productoSeleccionado;
            if(!empty($this->componentesSeleccionados['Procesador'])){
                // Obtener el socket del procesador
                $socket = $especificacion['socket'];
                // Actualizar las tarjetas madre compatibles basadas en el socket del procesador
                $tarjetasMadreCompatibles = Product::where('especificacionJSON', 'LIKE', '%"'.$socket.'"%')
                                        ->where('ID_Categoria', 3) // Categoría de tarjetas madre
                                        ->where('stock', '>', 0)
                                        ->get();
                //dd($tarjetasMadreCompatibles);
                $this->componentesQuery['tarjetaMadres'] = $tarjetasMadreCompatibles;
            }
            // Verifica si el procesador ya está seleccionado en el array de componentes Tarjeta Madre y decide actualizar compatibilidad
            if (empty($this->componentesSeleccionados['Procesador'])) {
                // Obtener el socket del procesador
                $socket = $especificacion['socket'];
                // Actualizar las tarjetas madre compatibles basadas en el socket del procesador
                $ProcesadoresCompatibles = Product::where('especificacionJSON', 'LIKE', '%"'.$socket.'"%')
                                        ->where('ID_Categoria', 1) // Categoría de tarjetas madre
                                        ->where('stock', '>', 0)
                                        ->get();
                //dd($tarjetasMadreCompatibles);
                $this->componentesQuery['procesadores'] = $ProcesadoresCompatibles;
            }

            if (empty($this->componentesSeleccionados['Memoría RAM'])) {
                // Actualizar memorias RAM compatibles basadas en el tipo de memoria
                $tipo_memoria = $especificacion['tipo_RAM'];
                $ramCompatibles = Product::where('especificacionJSON', 'LIKE', '%"'.$tipo_memoria.'"%')
                                        ->where('ID_Categoria', 4) // Categoría de memorias RAM
                                        ->where('stock', '>', 0)
                                        ->get();
                // Actualizamos el array de componentes query con los componentes compatibles con tipo_RAM 
                //dd($ramCompatibles);
                $this->componentesQuery['memoriasRAM'] = $ramCompatibles;
            } 

            if (empty($this->componentesSeleccionados['Gabinete'])) {
                $factor_forma = $especificacion['factor_forma'];
                $gabinetes = Product::where('especificacionJSON', 'LIKE', '%' . $factor_forma . '%')
                    ->where('ID_Categoria', 6) // Asegúrate de que esta categoría sea la correcta para gabinetes
                    ->where('stock', '>', 0)
                    ->get();
                $this->componentesQuery['gabinetes'] = $gabinetes;
            } 
            // Guardar los arrays actualizados en la sesión
            session(['componentesSeleccionados' => $this->componentesSeleccionados]);
            session(['componentesQuery' => $this->componentesQuery]);
        }
        
        if ($categoria === "Memoría RAM") {
            // Si no hay procesador seleccionado, agregar nuevo procesador al array
            $this->componentesSeleccionados['Memoría RAM'] = $productoSeleccionado;
            // Verifica si el procesador ya está seleccionado en el array de componentes Tarjeta Madre y decide actualizar compatibilidad
            if (empty($this->componentesSeleccionados['Procesador'])) {
                // Obtener el socket del procesador
                $tipo_ram = $especificacion['tipo_RAM'];
                // Actualizar las tarjetas madre compatibles basadas en el socket del procesador
                $ProcesadoresCompatibles = Product::where('especificacionJSON', 'LIKE', '%"'.$tipo_ram.'"%')
                                        ->where('ID_Categoria', 3) // Categoría de tarjetas madre
                                        ->where('stock', '>', 0)
                                        ->get();
                //dd($tarjetasMadreCompatibles);
                $this->componentesQuery['Memoría RAM'] = $ProcesadoresCompatibles;
            }

            if (empty($this->componentesSeleccionados['Tarjeta Madre'])) {
                // Actualizar memorias RAM compatibles basadas en el tipo de memoria
                $tipo_memoria = $especificacion['tipo_RAM'];
                $ramCompatibles = Product::where('especificacionJSON', 'LIKE', '%"tipo_RAM":"'.$tipo_memoria.'"%')
                                        ->where('ID_Categoria', 3) // Categoría de memorias RAM
                                        ->where('stock', '>', 0)
                                        ->get();
                // Actualizamos el array de componentes query con los componentes compatibles con tipo_RAM 
                //dd($ramCompatibles);
                $this->componentesQuery['Tarjeta Madre'] = $ramCompatibles;
            }

            //VALIDAR QUE EL GABINETE SE ESCOJA DEPENDIENDO SI HAY PROCESADOR O TARJETA MADRE SELECCIONADO
            if (empty($this->componentesSeleccionados['Gabinete'])) {
                // Obtener todos los gabinetes
                $gabinetes = Product::whereHas('category', function ($query) {
                    $query->where('ID_Categoria', 6); // Filtrar por categoría "Gabinetes"
                })->get(); 
                $this->componentesQuery['gabinetes'] = $gabinetes;
            }
            // Guardar los arrays actualizados en la sesión
            session(['componentesSeleccionados' => $this->componentesSeleccionados]);
            session(['componentesQuery' => $this->componentesQuery]);
        }

        if ($categoria === "Gabinete") {
            // Si no hay procesador seleccionado, agregar nuevo procesador al array
            $this->componentesSeleccionados['Gabinete'] = $productoSeleccionado;
            if (empty($this->componentesSeleccionados['Tarjeta Madre'])) {
                $factor_forma = $especificacion['factor_forma'];
                $gabinetes = Product::where('especificacionJSON', 'LIKE', '%' . $factor_forma . '%')
                    ->where('ID_Categoria', 3) // Asegúrate de que esta categoría sea la correcta para gabinetes
                    ->where('stock', '>', 0)
                    ->get();
                $this->componentesQuery['gabinetes'] = $gabinetes;
            } 
            session(['componentesSeleccionados' => $this->componentesSeleccionados]);
            session(['componentesQuery' => $this->componentesQuery]);
        }

        if ($categoria === "Tarjeta de Video") {
            // Si no hay procesador seleccionado, agregar nuevo procesador al array
            $this->componentesSeleccionados['Tarjeta de Video'] = $productoSeleccionado;
            session(['componentesSeleccionados' => $this->componentesSeleccionados]);
        }

        if ($categoria === "Disco Duro") {
            // Si no hay procesador seleccionado, agregar nuevo procesador al array
            $this->componentesSeleccionados['Disco Duro'] = $productoSeleccionado;
            session(['componentesSeleccionados' => $this->componentesSeleccionados]);
        }   
        /*
        if ($categoria === "Almacenamiento Secundario") {
            // Si no hay procesador seleccionado, agregar nuevo procesador al array
            $this->componentesSeleccionados['Almacenamiento Secundario'] = $productoSeleccionado;
            session(['componentesSeleccionados' => $this->componentesSeleccionados]);
        }
        */

        if ($categoria === "Enfriamiento") {
            // Si no hay procesador seleccionado, agregar nuevo procesador al array
            $this->componentesSeleccionados['Enfriamiento'] = $productoSeleccionado;
            session(['componentesSeleccionados' => $this->componentesSeleccionados]);
        }

        if ($categoria === "Fuente de poder") {
            // Si no hay procesador seleccionado, agregar nuevo procesador al array
            $this->componentesSeleccionados['Fuente de poder'] = $productoSeleccionado;
            session(['componentesSeleccionados' => $this->componentesSeleccionados]);
        }

        // Retornar la vista con los componentes seleccionados y query de Componentes Actualizado
        $categoriaFaltante = $this->obtenerCategoriaFaltante();
        $montoTotal = $this->calcularMontoTotal();
        return view('ecommerce.configuradorpc', [
            'componentesQuery' => $this->componentesQuery, 
            'componentesSeleccionados' => $this->componentesSeleccionados,
            'categoriaFaltante' => $categoriaFaltante,
            'montoTotal' => $montoTotal
        ])->with('title', 'E-COMMERCE STORE | CONFIGURADOR PC');
    }

    public function addAll(Request $request)
    {
        //dd($request->all());
        $componentes = session('componentesSeleccionados', []);
        $componentesQuery = session('componentesQuery', []);

        // Validar el select
        $validated = $request->validate([
            'decision' => 'required|string|in:si,no',
        ]);

        $decision = $validated['decision'];

        // Realiza la lógica según la decisión tomada
        if ($decision === 'si') {
            // Lógica para la opción "Sí"
            $ensamble = true;
        } elseif ($decision === 'no') {
            // Lógica para la opción "No"
            $ensamble = false;
        }
        
        foreach ($componentes as $componente) {
            $producto = Product::find($componente->ID_producto);

            if (!$producto) {
                continue; // Salta si el producto no existe
            }

            // Calcular el precio con descuento
            $precioConDescuento = $componente->precio - ($componente->precio * ($componente->descuento / 100));
            $decodedUrls = json_decode($componente->url_photo, true);

            /*
            if (json_last_error() !== JSON_ERROR_NONE) {
                return redirect()->back()->withErrors('Error al procesar las URLs de las fotos de ' . $componente->nombre);
            }
            */

            $cantidad = 1;
            Cart::session(auth()->id())->add([
                'id' => $componente->ID_producto,
                'name' => $componente->nombre,
                'price' => $precioConDescuento,
                'quantity' => $cantidad,
                'attributes' => [
                    'image' => $decodedUrls[0],
                    'model' => $componente->modelo,
                    'manufacturer' => $componente->fabricante,
                    'originalPrice' => $componente->precio,
                    'discount' => $componente->descuento,
                    'ensamble' => $ensamble,
                ]
            ]);
        }

        // Guardar el carrito actualizado en la base de datos
        $this->saveCartToDatabase();

        return redirect()->route('cart.index')->with('success', 'Componentes agregados al carrito');
    }

     // Método para guardar el carrito en la base de datos
    private function saveCartToDatabase()
    {
        $userId = Auth::id();
        $cartContent = Cart::session($userId)->getContent()->toJson();
    
        \DB::table('carts')->updateOrInsert(
            ['user_id' => $userId],
            ['content' => $cartContent, 'updated_at' => now()]
        );
    }
    
    public function removeAll()
    {
        // Eliminar los valores de la sesión
        session()->forget('componentesSeleccionados');
        session()->forget('componentesQuery');
        // Inicializar los arrays vacíos
        $this->componentesSeleccionados = [];
        $this->componentesQuery = [];
        //Rellenar todos los querys de productos con los productos de la bd
        $this->componentesQuery = $this->getQueryComponents();

        session(['componentesSeleccionados' => $this->componentesSeleccionados]);
        session(['componentesQuery' => $this->componentesQuery]);

        $categoriaFaltante = $this->obtenerCategoriaFaltante();
        $montoTotal = $this->calcularMontoTotal();
        return view('ecommerce.configuradorpc', [
            'componentesQuery' => $this->componentesQuery, 
            'componentesSeleccionados' => $this->componentesSeleccionados,
            'categoriaFaltante' => $categoriaFaltante,
            'montoTotal' => $montoTotal,
        ])->with('title', 'E-COMMERCE STORE | CONFIGURADOR PC');
    }

    public function remove(Request $request)
    {
        // Obtener los arrays de la sesión
        $this->componentesSeleccionados = session('componentesSeleccionados', []);
        $this->componentesQuery = session('componentesQuery', []);
    
        $id = $request->input('id');
        $categoria = $request->input('categoria');
        $productoSeleccionado = Product::find($id);
        // Decodificar el JSON
        $especificacion = json_decode($productoSeleccionado->especificacionJSON, true);
    
        // Verifica la categoría "Procesador" del componente
        if ($categoria === "Procesador") {
            unset($this->componentesSeleccionados['Procesador']);
            session(['componentesSeleccionados' => $this->componentesSeleccionados]);
        }
        
        // Verifica la categoría "Tarjeta Madre" del componente
        if ($categoria === "Tarjeta Madre") {
            unset($this->componentesSeleccionados['Tarjeta Madre']);
            session(['componentesSeleccionados' => $this->componentesSeleccionados]);
        }
        
        if ($categoria === "Memoría RAM") {
            unset($this->componentesSeleccionados['Memoría RAM']);
            session(['componentesSeleccionados' => $this->componentesSeleccionados]);
        }

        if ($categoria === "Gabinete") {
            unset($this->componentesSeleccionados['Gabinete']);
            session(['componentesSeleccionados' => $this->componentesSeleccionados]);
        }

        if ($categoria === "Tarjeta de Video") {
            unset($this->componentesSeleccionados['Tarjeta de Video']);
            session(['componentesSeleccionados' => $this->componentesSeleccionados]);
        }

        if ($categoria === "Disco Duro") {
            unset($this->componentesSeleccionados['Disco Duro']);
            session(['componentesSeleccionados' => $this->componentesSeleccionados]);
        }
        /*
        if ($categoria === "Almacenamiento Secundario") {
            unset($this->componentesSeleccionados['Almacenamiento Secundario'] );
            session(['componentesSeleccionados' => $this->componentesSeleccionados]);
        }
        */

        if ($categoria === "Enfriamiento") {
            unset($this->componentesSeleccionados['Enfriamiento']);
            session(['componentesSeleccionados' => $this->componentesSeleccionados]);
        }

        if ($categoria === "Fuente de poder") {
            unset($this->componentesSeleccionados['Fuente de poder']);
            session(['componentesSeleccionados' => $this->componentesSeleccionados]);
        }

        // Retornar la vista con los componentes seleccionados y query de Componentes Actualizado
        $categoriaFaltante = $this->obtenerCategoriaFaltante();
        $montoTotal = $this->calcularMontoTotal();
        return view('ecommerce.configuradorpc', [
            'componentesQuery' => $this->componentesQuery, 
            'componentesSeleccionados' => $this->componentesSeleccionados,
            'categoriaFaltante' => $categoriaFaltante,
            'montoTotal' => $montoTotal,
        ])->with('title', 'E-COMMERCE STORE | CONFIGURADOR PC');
    }

    

    public function shop()
    {
        $products = Product::all();
        return view('welcome')->withTitle('E-COMMERCE STORE | SHOP')->with(['products' => $products]);
    }

    public function obtenerCategoriaFaltante()
    {
        $categoriasRequeridas = [
            'Procesador',
            'Tarjeta Madre',
            'Memoría RAM',
            'Gabinete',
            'Tarjeta de Video',
            'Disco Duro',
            // 'Almacenamiento Secundario', // Descomentar si también se requiere
            'Enfriamiento',
            'Fuente de poder'
        ];

        // Obtenemos los componentes seleccionados de la sesión
        $componentesSeleccionados = session()->get('componentesSeleccionados', []);

        // Recorrer las categorías requeridas y devolver la primera faltante
        foreach ($categoriasRequeridas as $categoria) {
            // Si la categoría no ha sido seleccionada o está vacía
            if (empty($componentesSeleccionados[$categoria])) {
                return $categoria; // Devuelve la primera categoría faltante
            }
        }

        // Si todas las categorías están completas
        return "Ensamble"; // O puedes devolver un mensaje indicando que no faltan categorías
    }

    public function calcularMontoTotal()
    {
        // Obtener los componentes seleccionados de la sesión
        $componentesSeleccionados = session('componentesSeleccionados', []);

        // Inicializar el monto total
        $montoTotal = 0;

        // Recorrer cada componente y calcular el precio con descuento
        foreach ($componentesSeleccionados as $componente) {
            if(!empty($componente)){
                $precioConDescuento = $componente->precio - ($componente->precio * ($componente->descuento / 100));
                $montoTotal += $precioConDescuento;
            }
        }

        // Retornar el monto total
        return $montoTotal;
    }

}
