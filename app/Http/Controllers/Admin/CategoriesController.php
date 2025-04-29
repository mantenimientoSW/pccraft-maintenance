<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin\Category;

class CategoriesController extends Controller
{
    // MOSTRAR CATEGORIAS BIEN
    public function index()
    {
        $categories = Category::all();
        return view('category.index', compact('category'));
    }

    // POR DEFAULT
    public function create()
    {
        return view('category.create');
    }

    // POR DEFAULT/GPT
    public function store(Request $request)
    {
        $request->validate([
            'nombre_categoria' => 'required|string|max:255',
        ]);

        Category::create($request->all());

        return redirect()->route('category.index')->with('success', 'Categoría creada con éxito.');
    }

    // GPT
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('category.edit', compact('category'));
    }

    // BIEN
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre_categoria' => 'required|string|max:255',
        ]);

        $category = Category::findOrFail($id);
        $category->update($request->all());

        return redirect()->route('category.index')->with('success', 'Categoría actualizada con éxito.');
    }

    /*
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->route('category.index')->with('success', 'Categoría eliminada con éxito.');
    }*/
}
