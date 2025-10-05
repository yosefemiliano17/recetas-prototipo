<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventario de Sucursal - {{ $sucursal->getIdSucursal() }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 py-10">

<div class="max-w-3xl mx-auto bg-white p-8 rounded-2xl shadow-lg">
    <h1 class="text-2xl font-bold mb-6 text-gray-700 text-center">Registrar Receta</h1>
    <h2 class="text-lg font-semibold text-center text-gray-600 mb-8">Sucursal ID: {{ $sucursal->getIdSucursal() }}</h2>


    <form action="{{ route('recetas.store') }}" method="POST" class="space-y-6">
        @csrf
        <input type="hidden" name="sucursal_id" value="{{ $sucursal->getIdSucursal() }}">

        <div id="medicamentos-container" class="space-y-4 pt-4 border-t">
            <h2 class="text-lg font-semibold text-gray-600">Medicamentos</h2>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Medicamento</label>
                <select name="medicamentos[0][id]" class="w-full bg-white border border-gray-300 rounded-lg p-2.5">
                    <option value="">-- Selecciona un medicamento --</option>
                    
                    @foreach($medicamentosDetalles as $id => $medicamento)
                            <option value="{{ $id }}">
                                {{ $medicamento->getNombre() }} ({{ $medicamento->getDosis() }}mg)
                            </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Cantidad</label>
                <input type="number" name="medicamentos[0][cantidad]" value="1" min="1" class="w-full border rounded-lg p-2.5">
            </div>
        </div>

        <div class="flex justify-end items-center pt-4 mt-6 border-t space-x-4">
             <a href="{{ route('recetas.create') }}" class="px-6 py-3 bg-gray-500 text-white font-semibold rounded-lg hover:bg-gray-600 transition">
                Volver
            </a>
            <button type="submit" 
                    class="px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition disabled:bg-gray-400 disabled:cursor-not-allowed"
                    @disabled(empty($inventarioArray))>
                Pedir
            </button>
        </div>
    </form>
</div>

</body>
</html>