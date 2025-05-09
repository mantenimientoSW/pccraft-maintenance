<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Category;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CategoriesController extends Controller
{
    // MOSTRAR CATEGORIAS BIEN
    public function index()
    {
        try {
            $categories = Category::all();
            return view('category.index', compact('categories'));
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Error al cargar las categorías: ' . $e->getMessage());
        }
    }

    // POR DEFAULT
    public function create()
    {
        return view('category.create');
    }

    // POR DEFAULT/GPT
    public function store(Request $request)
    {
        try {
            $request->validate([
                'nombre_categoria' => 'required|string|max:255',
            ]);

            Category::create($request->all());
            return redirect()->route('category.index')->with('success', 'Categoría creada con éxito.');
        } catch (QueryException $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error al crear la categoría: ' . $e->getMessage());
        } catch (Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error inesperado al crear la categoría: ' . $e->getMessage());
        }
    }

    // GPT
    public function edit($id)
    {
        try {
            $category = Category::findOrFail($id);
            return view('category.edit', compact('category'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('category.index')
                ->with('error', 'La categoría no fue encontrada.');
        } catch (Exception $e) {
            return redirect()->route('category.index')
                ->with('error', 'Error al cargar la categoría: ' . $e->getMessage());
        }
    }

    // BIEN
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'nombre_categoria' => 'required|string|max:255',
            ]);

            $category = Category::findOrFail($id);
            $category->update($request->all());

            return redirect()->route('category.index')->with('success', 'Categoría actualizada con éxito.');
        } catch (ModelNotFoundException $e) {
            return redirect()->route('category.index')
                ->with('error', 'La categoría no fue encontrada.');
        } catch (QueryException $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error al actualizar la categoría: ' . $e->getMessage());
        } catch (Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error inesperado al actualizar la categoría: ' . $e->getMessage());
        }
    }

    /*
    public function destroy($id)
    {
        try {
            $category = Category::findOrFail($id);
            $category->delete();

            return redirect()->route('category.index')->with('success', 'Categoría eliminada con éxito.');
        } catch (ModelNotFoundException $e) {
            return redirect()->route('category.index')
                ->with('error', 'La categoría no fue encontrada.');
        } catch (QueryException $e) {
            return redirect()->route('category.index')
                ->with('error', 'No se puede eliminar la categoría porque está siendo utilizada.');
        } catch (Exception $e) {
            return redirect()->route('category.index')
                ->with('error', 'Error inesperado al eliminar la categoría: ' . $e->getMessage());
        }
    }*/
}
