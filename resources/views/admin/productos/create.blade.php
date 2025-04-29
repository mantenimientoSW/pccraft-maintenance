@extends('admin.layouts.template')

@section('title', 'Crear Producto')

@section('content_header')
    <h1>Crear Nuevo Producto</h1>
@endsection

@section('content')
<div class="container mx-auto p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold">Datos Generales</h2>
        <a href="{{ route('admin-productos') }}" class="text-red-500">Cancelar</a>
    </div>

    <form action="{{ route('productos.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label for="nombre" class="block text-gray-700">Nombre del producto</label>
                <input type="text" id="nombre" name="nombre" class="w-full p-2 border border-gray-300 rounded" value="{{ old('nombre') }}">
                @error('nombre')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            
            <div>
                <label for="ID_Categoria" class="block text-gray-700">Categoría</label>
                <select id="ID_Categoria" name="ID_Categoria" class="w-full p-2 border border-gray-300 rounded">
                    @foreach($categories as $categoria)
                        <option value="{{ $categoria->ID_Categoria }}" {{ old('ID_Categoria') == $categoria->ID_Categoria ? 'selected' : '' }}>
                            {{ $categoria->nombre_categoria }}
                        </option>
                    @endforeach
                </select>
                @error('ID_Categoria')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            
            <div>
                <label for="modelo" class="block text-gray-700">Modelo</label>
                <input type="text" id="modelo" name="modelo" class="w-full p-2 border border-gray-300 rounded" value="{{ old('modelo') }}">
                @error('modelo')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            
            <div>
                <label for="precio" class="block text-gray-700">Precio</label>
                <input type="number" id="precio" name="precio" step="0.01" class="w-full p-2 border border-gray-300 rounded" value="{{ old('precio') }}">
                @error('precio')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label for="fabricante" class="block text-gray-700">Fabricante</label>
                <input type="text" id="fabricante" name="fabricante" class="w-full p-2 border border-gray-300 rounded" value="{{ old('fabricante') }}">
                @error('fabricante')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label for="stock" class="block text-gray-700">Stock</label>
                <input type="number" id="stock" name="stock" class="w-full p-2 border border-gray-300 rounded" value="{{ old('stock') }}">
                @error('stock')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label for="descuento" class="block text-gray-700">Descuento (%)</label>
                <input type="number" id="descuento" name="descuento" step="0.01" class="w-full p-2 border border-gray-300 rounded" value="{{ old('descuento') }}">
                @error('descuento')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="mb-6">
            <label for="descripcion" class="block text-gray-700">Descripción</label>
            <textarea id="descripcion" name="descripcion" class="w-full p-2 border border-gray-300 rounded">{{ old('descripcion') }}</textarea>
            @error('descripcion')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
        </div>
    <!-- Imagen conchesumare -->
        <div class="mb-6">
            <label class="block text-gray-700">Agregar imagen</label>
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

            <div id="preview" class="mt-4 grid grid-cols-3 gap-4"></div>
        </div>
    <!-- json conchesumare -->
    <div class="mb-6">
        <label for="especificacionJSON" class="block text-gray-700">Especificaciones (JSON)</label>
        <input type="file" id="especificacionJSON" name="especificacionJSON" accept=".json" class="w-full p-2 border border-gray-300 rounded">
        @error('especificacionJSON')
        <p class="text-red-500 mt-2">{{ $message }}</p>
        @enderror

        <!--vista previa-->
        <div id="jsonPreview" class="border p-4 mt-2 overflow-y-auto" style="max-height: 200px; display: none;">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr>
                        <th class="border-b p-2">Atributo</th>
                        <th class="border-b p-2">Valor</th>
                    </tr>
                </thead>
                <tbody id="jsonContent">
                    <!-- insert -->
                </tbody>
            </table>
        </div>
    </div>

    <div class="flex justify-between">
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Crear Producto</button>
    </div>
        </form>
    </div>
<script>
    //IMAGENES
    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('select-files').addEventListener('click', function () {
            document.getElementById('fileInput').click(); // clickeo seleccion archivos
        });
        const dropZone = document.getElementById('dropzone');
        const fileInput = document.getElementById('fileInput');

        if (dropZone && fileInput) {
            dropZone.addEventListener('dragover', function (e) {
                e.preventDefault();
                dropZone.classList.add('border-blue-600');
            });

            dropZone.addEventListener('dragleave', function () {
                dropZone.classList.remove('border-blue-600');
            });

            dropZone.addEventListener('drop', handleDrop);

            fileInput.addEventListener('change', function (event) {
                handleFiles(event.target.files);
            });
        }
    });

    let selectedFiles = [];

    // drag archivoss
    function handleDrop(event) {
        event.preventDefault();
        const files = event.dataTransfer.files;
        handleFiles(files);
    }


    function handleFiles(files) {
        const preview = document.getElementById('preview');
        const maxFiles = 3;

        Array.from(files).forEach(file => {
            if (!file.type.startsWith('image/')) return;
            if (selectedFiles.some(f => f.name === file.name && f.size === file.size)) return;
            if (selectedFiles.length >= maxFiles) return alert('Solo puedes subir hasta 3 imágenes.');

            selectedFiles.push(file);
            const reader = new FileReader();
            reader.onload = function (e) {
                const imgContainer = document.createElement('div');
                imgContainer.classList.add('relative');

                const img = document.createElement('img');
                img.src = e.target.result;
                img.classList.add('w-full', 'h-auto', 'object-cover', 'rounded', 'border', 'border-gray-200');

                // eliminar imagen
                const removeBtn = document.createElement('button');
                removeBtn.innerHTML = 'X';
                removeBtn.classList.add('absolute', 'top-0', 'right-0', 'bg-red-500', 'text-white', 'rounded-full', 'p-1', 'cursor-pointer');
                removeBtn.onclick = function () {
                    imgContainer.remove();
                    selectedFiles = selectedFiles.filter(f => f !== file);
                    updateDropZoneMessage();
                };

                imgContainer.appendChild(img);
                imgContainer.appendChild(removeBtn);
                preview.appendChild(imgContainer);
                updateDropZoneMessage();
            };
            reader.readAsDataURL(file);
        });

        if (selectedFiles.length >= maxFiles) {
            document.getElementById('dropzone-text').innerHTML = 'Has alcanzado el límite de 3 imágenes.';
        }
    }

    // Actualizar mensajs
    function updateDropZoneMessage() {
        const dropzoneText = document.getElementById('dropzone-text');
        if (selectedFiles.length >= 3) {
            dropzoneText.innerHTML = 'Has alcanzado el límite de 3 imágenes.';
        } else {
            dropzoneText.innerHTML = 'Arrastra tus imágenes aquí o <span id="select-files" class="text-blue-500 cursor-pointer underline">selecciona archivos</span>';
            
            // GPt para Re-adjuntar el evento click al nuevo elemento #select-files
            document.getElementById('select-files').addEventListener('click', function () {
                document.getElementById('fileInput').click();
            });
        }
    }

    // drag and drop
    const dropZone = document.getElementById('dropzone');
    dropZone.addEventListener('dragover', function (e) {
        e.preventDefault();
        dropZone.classList.add('border-blue-600');
    });

    dropZone.addEventListener('dragleave', function () {
        dropZone.classList.remove('border-blue-600');
    });

    dropZone.addEventListener('drop', handleDrop);

    // bug pendejo que abria explorador de archivo twice
    document.getElementById('fileInput').addEventListener('change', function (event) {
        handleFiles(event.target.files);
    });
</script>
<script>
    //JSON
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