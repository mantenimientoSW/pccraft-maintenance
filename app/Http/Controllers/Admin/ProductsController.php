<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ProductsController extends Controller
{
    // Mostrar todos los productos
    public function index(Request $request)
    {
        try {
            $query = Product::query(); // Comenzamos una nueva consulta

            // Filtros
            if ($request->filled('fecha')) {
                $query->orderBy('fecha_agregada', $request->fecha);
            }

            if ($request->filled('precio')) {
                $query->orderBy('precio', $request->precio);
            }

            if ($request->filled('nombre')) {
                $query->orderBy('nombre', $request->nombre);
            }

            if ($request->filled('categoria')) {
                $query->where('ID_Categoria', $request->categoria);
            }

            // Búsqueda
            if ($request->filled('search')) {
                $query->where(function($q) use ($request) {
                    $q->where('nombre', 'like', '%' . $request->search . '%')
                      ->orWhere('modelo', 'like', '%' . $request->search . '%');
                });
            }

            $products = $query->with('category')->get();

            $categories = Category::all();

            return view('admin.productos.index', compact('products', 'categories'));
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Error al cargar los productos: ' . $e->getMessage());
        }
    }

    // FORMULARIO BASE PARA CREAR PRODUCTO
    public function create()
    {
        try {
            $categories = Category::all(); // CATEGORIAS
            return view('admin.productos.create', compact('categories'));
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Error al cargar el formulario de creación: ' . $e->getMessage());
        }
    }

    // Método para validar que el JSON tenga la estructura correcta
    protected function validateJsonStructure($jsonContent)
    {
        try {
            $data = json_decode($jsonContent, true);
        
            // Verificar que el JSON sea un array o un objeto válido
            if (!is_array($data)) {
                return false;
            }
        
            // Verificar que el JSON tenga pares clave-valor válidos
            foreach ($data as $key => $value) {
                if (!is_string($key)) {
                    return false; // Asegura que todas las claves sean cadenas
                }
            }
        
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    // STORE - Guardar producto
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $request->validate([
                'nombre' => 'required|string|max:255',
                'modelo' => 'required|string|max:255',
                'fabricante' => 'required|string|max:255',
                'descripcion' => 'required|string',
                'precio' => 'required|numeric',
                'stock' => 'required|integer',
                'ID_Categoria' => 'required|exists:categories,ID_Categoria',
                'url_photo.*' => 'required|image|max:5128',
                'especificacionJSON' => 'nullable|file|mimes:json|max:2048', // Validación del archivo JSON
            ]);

            $data = $request->all();

            //fotos
            if ($request->hasFile('url_photo')) {
                $photos = [];
                foreach ($request->file('url_photo') as $image) {
                    $path = $image->store('photos', 'public');
                    $photos[] = $path;
                }
                $data['url_photo'] = str_replace('\\/', '/', json_encode($photos));
            }

            //json y almacenar
            if ($request->hasFile('especificacionJSON')) {
                $jsonFile = $request->file('especificacionJSON');
                $jsonContent = file_get_contents($jsonFile->getPathname());
                if (!$this->validateJsonStructure($jsonContent)) {
                    throw new Exception('El archivo JSON tiene un formato inválido.');
                }
            } else {
                $jsonContent = null;
            }
            
            $data['especificacionJSON'] = $jsonContent;
            $data['vendidos'] = 0;
            Product::create($data);

            DB::commit();
            return redirect()->route('productos.index')->with('success', 'Producto creado con éxito.');
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error al guardar el producto en la base de datos: ' . $e->getMessage());
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error al crear el producto: ' . $e->getMessage());
        }
    }

    // EDIT - Mostrar formulario de edición
    public function edit($id)
    {
        try {
            $product = Product::findOrFail($id);
            $categories = Category::all();
            return view('admin.productos.edit', compact('product', 'categories'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('productos.index')
                ->with('error', 'El producto no fue encontrado.');
        } catch (Exception $e) {
            return redirect()->route('productos.index')
                ->with('error', 'Error al cargar el producto: ' . $e->getMessage());
        }
    }

    // UPDATE - Actualizar producto
    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $request->validate([
                'nombre' => 'required|string|max:255',
                'modelo' => 'required|string|max:255',
                'fabricante' => 'required|string|max:255',
                'descripcion' => 'required|string',
                'precio' => 'required|numeric',
                'stock' => 'required|integer',
                'ID_Categoria' => 'required|exists:categories,ID_Categoria',
                'url_photo.*' => 'nullable|image|max:5128',
                'especificacionJSON' => 'nullable|file|mimes:json|max:2048', // Validación del archivo JSON
            ]);
        
            $product = Product::findOrFail($id);
            $product->fecha_agregada = now()->setTimezone('America/Mexico_City');
        
            if ($request->filled('deleted_photos')) {
                try {
                    $deletedPhotos = json_decode($request->input('deleted_photos'), true);
                    foreach ($deletedPhotos as $photo) {
                        if (file_exists(storage_path('app/public/' . $photo))) {
                            unlink(storage_path('app/public/' . $photo));
                        }
                    }
                    $product->url_photo = json_encode(array_diff(json_decode($product->url_photo, true), $deletedPhotos));
                } catch (Exception $e) {
                    throw new Exception('Error al procesar las fotos eliminadas: ' . $e->getMessage());
                }
            }
        
            if ($request->hasFile('url_photo')) {
                try {
                    $photos = json_decode($product->url_photo, true) ?? [];
                    foreach ($request->file('url_photo') as $image) {
                        $path = $image->store('photos', 'public');
                        $path = str_replace('\\', '/', $path); 
                        \Log::info('Path after replacement: ' . $path); //amigo chat
                        $photos[] = $path;
                    }
                    $product->url_photo = json_encode($photos);
                } catch (Exception $e) {
                    throw new Exception('Error al procesar las nuevas fotos: ' . $e->getMessage());
                }
            }
        
            // Manejo del archivo JSON
            if ($request->hasFile('especificacionJSON')) {
                $jsonFile = $request->file('especificacionJSON');
                $jsonContent = file_get_contents($jsonFile->getPathname());
        
                // Validar contenido
                if (!$this->validateJsonStructure($jsonContent)) {
                    throw new Exception('El archivo JSON tiene un formato inválido.');
                }
        
                $product->especificacionJSON = $jsonContent; 
            }
        
            $product->update($request->except('fecha_agregada', 'url_photo', 'especificacionJSON'));
        
            $product->save(); 
        
            DB::commit();
            return redirect()->route('productos.index')->with('success', 'Producto actualizado con éxito.');
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return redirect()->route('productos.index')
                ->with('error', 'El producto no fue encontrado.');
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error al actualizar el producto en la base de datos: ' . $e->getMessage());
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error al actualizar el producto: ' . $e->getMessage());
        }
    }
    
    

    // DESTROY - Eliminar producto
    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            
            $product = Product::findOrFail($id);
            
            // Eliminar fotos asociadas
            if ($product->url_photo) {
                $photos = json_decode($product->url_photo, true);
                foreach ($photos as $photo) {
                    if (file_exists(storage_path('app/public/' . $photo))) {
                        unlink(storage_path('app/public/' . $photo));
                    }
                }
            }
            
            $product->delete();
            
            DB::commit();
            return redirect()->route('productos.index')->with('success', 'Producto eliminado con éxito.');
            
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return redirect()->route('productos.index')
                ->with('error', 'El producto no fue encontrado.');
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->route('productos.index')
                ->with('error', 'No se puede eliminar el producto porque está siendo utilizado.');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->route('productos.index')
                ->with('error', 'Error al eliminar el producto: ' . $e->getMessage());
        }
    }
}
