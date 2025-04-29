@extends('admin.layouts.template')

@section('title', 'Editar Producto')

@section('content_header')
    <h1>Editar Producto</h1>
@endsection

@section('content')
<div class="container mx-auto p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold">Datos Generales</h2>
        <a href="{{ route('admin-productos') }}" class="text-red-500">Cancelar</a>
    </div>

    <form action="{{ route('productos.update', $product->ID_producto) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label for="nombre" class="block text-gray-700">Nombre del producto</label>
                <input type="text" id="nombre" name="nombre" class="w-full p-2 border border-gray-300 rounded" value="{{ $product->nombre }}">
            </div>
            
            <div>
                <label for="ID_Categoria" class="block text-gray-700">Categoría</label>
                <select id="ID_Categoria" name="ID_Categoria" class="w-full p-2 border border-gray-300 rounded">
                    @foreach($categories as $categoria)
                        <option value="{{ $categoria->ID_Categoria }}" {{ $product->ID_Categoria == $categoria->ID_Categoria ? 'selected' : '' }}>
                            {{ $categoria->nombre_categoria }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div>
                <label for="modelo" class="block text-gray-700">Modelo</label>
                <input type="text" id="modelo" name="modelo" class="w-full p-2 border border-gray-300 rounded" value="{{ $product->modelo }}">
            </div>
            
            <div>
                <label for="precio" class="block text-gray-700">Precio</label>
                <input type="number" id="precio" name="precio" step="0.01" class="w-full p-2 border border-gray-300 rounded" value="{{ $product->precio }}">
            </div>

            <div>
                <label for="fabricante" class="block text-gray-700">Fabricante</label>
                <input type="text" id="fabricante" name="fabricante" class="w-full p-2 border border-gray-300 rounded" value="{{ $product->fabricante }}">
            </div>

            <div>
                <label for="stock" class="block text-gray-700">Stock</label>
                <input type="number" id="stock" name="stock" class="w-full p-2 border border-gray-300 rounded" value="{{ $product->stock }}">
            </div>

            <div>
                <label for="descuento" class="block text-gray-700">Descuento (%)</label>
                <input type="number" id="descuento" name="descuento" step="0.01" class="w-full p-2 border border-gray-300 rounded" value="{{ $product->descuento }}">
            </div>
        </div>

        <div class="mb-6">
            <label for="descripcion" class="block text-gray-700">Descripción</label>
            <textarea id="descripcion" name="descripcion" class="w-full p-2 border border-gray-300 rounded">{{ $product->descripcion }}</textarea>
        </div>

        <!-- Imagen -->
        <div class="mb-6">
            <label class="block text-gray-700">Imágenes del producto</label>
            <div id="dropzone" class="border-4 border-dashed border-blue-500 p-6 flex justify-center items-center bg-gray-100 relative h-48"
                ondragover="event.preventDefault()" ondrop="handleDrop(event)">
                <p id="dropzone-text" class="text-gray-500">Arrastra tus imágenes aquí o 
                    <span class="text-blue-500 cursor-pointer underline" id="select-files">selecciona archivos</span>
                </p>
                <input type="file" name="url_photo[]" id="fileInput" multiple class="w-full hidden" accept="image/*" onchange="handleFiles(this.files)">
            </div>

            @error('url_photo')
            <p class="text-red-500 mt-2">{{ $message }}</p>
            @enderror

            <div id="preview" class="mt-4 grid grid-cols-3 gap-4">
                @foreach (json_decode($product->url_photo, true) as $photo)
                    <div class="relative">
                        <img src="{{ asset('storage/' . $photo) }}" class="w-full h-auto object-cover rounded border border-gray-200">
                        <button type="button" class="absolute top-0 right-0 bg-red-500 text-white rounded-full p-1 cursor-pointer" 
                                onclick="removeImage('{{ $photo }}', this)">
                            X
                        </button>
                    </div>
                @endforeach
            </div>
            <input type="hidden" name="deleted_photos" id="deleted_photos">
        </div>
    <!--  JSON -->
        <div class="mb-6">
            <label for="especificacionJSON" class="block text-gray-700">Especificaciones (JSON)</label>
            <input type="file" id="especificacionJSON" name="especificacionJSON" accept=".json" class="w-full p-2 border border-gray-300 rounded">
            @error('especificacionJSON')
            <p class="text-red-500 mt-2">{{ $message }}</p>
            @enderror

            <div id="jsonPreview" class="border p-4 mt-2 overflow-y-auto" style="max-height: 200px; {{ $product->especificacionJSON ? '' : 'display:none;' }}">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr>
                            <th class="border-b p-2">Atributo</th>
                            <th class="border-b p-2">Valor</th>
                        </tr>
                    </thead>
                    <tbody id="jsonContent">
                        @if ($product->especificacionJSON)
                            @foreach (json_decode($product->especificacionJSON, true) as $key => $value)
                                <tr>
                                    <td class="border-b p-2">{{ $key }}</td>
                                    <td class="border-b p-2">{{ $value }}</td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

        <div class="flex justify-between">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Actualizar Producto</button>
            <button type="submit" form="delete-product-form" class="bg-red-500 text-white px-4 py-2 rounded">Eliminar Producto</button>
        </div>
    </form>

    <form id="delete-product-form" action="{{ route('productos.destroy', $product->ID_producto) }}" method="POST" class="hidden">
        @csrf
        @method('DELETE')
    </form>
</div>
<script>
    let deletedPhotos = [];
    let newPhotos = [];
    let existingPhotos = @json(json_decode($product->url_photo, true) ?? []);

    function removeImage(photo, button) {
        deletedPhotos.push(photo);
        document.getElementById('deleted_photos').value = JSON.stringify(deletedPhotos);
        button.parentElement.remove();
        updateDropZoneMessage();
    }

    document.getElementById('select-files').addEventListener('click', function() {
        document.getElementById('fileInput').click();
    });

    function handleFiles(files) {
        const preview = document.getElementById('preview');
        for (const file of files) {
            if (!newPhotos.includes(file.name)) {
                newPhotos.push(file.name);
                const reader = new FileReader();
                reader.onload = function(e) {
                    const div = document.createElement('div');
                    div.classList.add('relative');
                    div.innerHTML = `
                        <img src="${e.target.result}" class="w-full h-auto object-cover rounded border border-gray-200">
                        <button type="button" class="absolute top-0 right-0 bg-red-500 text-white rounded-full p-1 cursor-pointer" onclick="removeImage('${file.name}', this)">X</button>
                    `;
                    preview.appendChild(div);
                };
                reader.readAsDataURL(file);
            }
        }
        updateDropZoneMessage();
    }

    function handleDrop(event) {
        event.preventDefault();
        const files = event.dataTransfer.files;
        handleFiles(files);
    }

    const dropZone = document.getElementById('dropzone');
    dropZone.addEventListener('dragover', function (e) {
        e.preventDefault();
        dropZone.classList.add('border-blue-600');
    });

    dropZone.addEventListener('dragleave', function () {
        dropZone.classList.remove('border-blue-600');
    });

    dropZone.addEventListener('drop', handleDrop);

    // Bug que abría el explorador de archivos dos veces
    document.getElementById('fileInput').addEventListener('change', function (event) {
        handleFiles(event.target.files);
    });

    // Actualizar el mensaje del dropzone al cargar la página
    document.addEventListener('DOMContentLoaded', function() {
        updateDropZoneMessage();
    });

    function updateDropZoneMessage() {
        const dropzoneText = document.getElementById('dropzone-text');
        const totalPhotos = existingPhotos.length + newPhotos.length - deletedPhotos.length;
        if (totalPhotos >= 3) {
            dropzoneText.innerHTML = 'Has alcanzado el límite de 3 imágenes.';
        } else {
            dropzoneText.innerHTML = 'Arrastra tus imágenes aquí o <span id="select-files" class="text-blue-500 cursor-pointer underline">selecciona archivos</span>';
            
            // Re-adjuntar el evento click al nuevo elemento #select-files
            document.getElementById('select-files').addEventListener('click', function () {
                document.getElementById('fileInput').click();
            });
        }
    }
</script>
<script>
    document.getElementById('especificacionJSON').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file && file.type === 'application/json') {
            const reader = new FileReader();
            reader.onload = function(e) {
                const jsonContent = JSON.parse(e.target.result);
                const jsonPreview = document.getElementById('jsonPreview');
                const jsonContentElement = document.getElementById('jsonContent');
                jsonContentElement.innerHTML = '';

                for (const [key, value] of Object.entries(jsonContent)) {
                    const row = document.createElement('tr');
                    const attributeCell = document.createElement('td');
                    attributeCell.classList.add('border-b', 'p-2');
                    attributeCell.textContent = key;

                    const valueCell = document.createElement('td');
                    valueCell.classList.add('border-b', 'p-2');
                    valueCell.textContent = value;

                    row.appendChild(attributeCell);
                    row.appendChild(valueCell);
                    jsonContentElement.appendChild(row);
                }

                jsonPreview.style.display = 'block';
            };
            reader.readAsText(file);
        } else {
            document.getElementById('jsonPreview').style.display = 'none';
        }
    });
</script>
@endsection