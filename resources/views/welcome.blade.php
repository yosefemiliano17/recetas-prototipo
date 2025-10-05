<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Nueva Receta</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 py-10">
<div class="max-w-3xl mx-auto bg-white p-8 rounded-2xl shadow-lg">
    <h1 class="text-2xl font-bold mb-6 text-gray-700 text-center">Registrar Nueva Receta</h1>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">¡Éxito!</strong>
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <form action="{{ route('recetas.create') }}" method="POST" class="space-y-6">
        @csrf
        
        <div class="flex items-end gap-4">
            <div class="flex-grow">
                <label for="sucursal-select" class="block text-sm font-medium text-gray-700 mb-1">Sucursal</label>
                <select name="idSucursal" id="sucursal-select" class="w-full bg-white border border-gray-300 rounded-lg p-2.5">
                    <option value="">-- Elige una sucursal --</option>
                    @foreach($sucursales as $sucursal)
                        <option value="{{ $sucursal->IdSucursal }}" {{ $selectedSucursalId == $sucursal->IdSucursal ? 'selected' : '' }}>
                            {{ $sucursal->NombreSucursal }}
                        </option>
                    @endforeach
                </select>
            </div>
            <button type="submit" name="action_select_sucursal" value="1" class="px-4 py-2.5 bg-gray-600 text-white rounded-lg hover:bg-gray-700">Cargar</button>
        </div>

        @foreach ($medicamentosEnReceta as $index => $med)
            <input type="hidden" name="receta_items[{{ $index }}][id]" value="{{ $med->idMedicamento }}">
            <input type="hidden" name="receta_items[{{ $index }}][cantidad]" value="{{ $med->cantidad_receta }}">
        @endforeach

        @if ($selectedSucursalId && $medicamentosDisponibles->isNotEmpty())
            <div class="border-t pt-6">
                <h2 class="text-lg font-semibold mb-3 text-gray-600">Añadir Medicamento a la Receta</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end bg-gray-50 p-4 rounded-lg">
                    <div class="md:col-span-2">
                        <label for="nuevo-medicamento" class="block text-sm font-medium text-gray-700 mb-1">Medicamento Disponible</label>
                        <select name="nuevo_medicamento_id" id="nuevo-medicamento" class="w-full bg-white border border-gray-300 rounded-lg p-2.5">
                            @foreach ($medicamentosDisponibles as $med)
                                @if (!$medicamentosEnReceta->contains('idMedicamento', $med->idMedicamento))
                                    <option value="{{ $med->idMedicamento }}">{{ $med->nombreMedicamento }} ({{ $med->Gramaje }}mg)</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="cantidad" class="block text-sm font-medium text-gray-700 mb-1">Cantidad</label>
                        <input type="number" name="nuevo_medicamento_cantidad" value="1" min="1" class="w-full bg-white border border-gray-300 rounded-lg p-2.5">
                    </div>
                    <div class="md:col-span-3 text-right">
                        <button type="submit" name="action_add_medicamento" value="1" class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600">
                            + Añadir
                        </button>
                    </div>
                </div>
            </div>
        @elseif($selectedSucursalId)
             <p class="text-center text-red-500 border-t pt-4">No hay medicamentos con stock en la sucursal seleccionada.</p>
        @endif
    </form> 

    @if ($medicamentosEnReceta->isNotEmpty())
        <div class="border-t pt-6 mt-6">
             <h2 class="text-lg font-semibold mb-3 text-gray-600">Receta Actual</h2>
             <div class="space-y-2">
                @foreach ($medicamentosEnReceta as $med)
                    <div class="flex justify-between items-center bg-blue-50 p-3 rounded-lg">
                        <div>
                            <span class="font-bold">{{ $med->nombreMedicamento }} ({{ $med->Gramaje }}mg)</span>
                            - Cantidad: <span class="font-semibold">{{ $med->cantidad_receta }}</span>
                        </div>
                        <form action="{{ route('recetas.create') }}" method="POST">
                            @csrf
                            <input type="hidden" name="idSucursal" value="{{ $selectedSucursalId }}">
                             @foreach ($medicamentosEnReceta as $item_hidden)
                                <input type="hidden" name="receta_items[{{ $loop->index }}][id]" value="{{ $item_hidden->idMedicamento }}">
                                <input type="hidden" name="receta_items[{{ $loop->index }}][cantidad]" value="{{ $item_hidden->cantidad_receta }}">
                            @endforeach
                            <button type="submit" name="action_remove_medicamento" value="{{ $med->idMedicamento }}" class="text-red-500 hover:text-red-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" /></svg>
                            </button>
                        </form>
                    </div>
                @endforeach
             </div>
             
            <div class="text-center pt-8">
                <form action="{{ route('recetas.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="idSucursal" value="{{ $selectedSucursalId }}">
                    @foreach ($medicamentosEnReceta as $index => $med)
                        <input type="hidden" name="receta_items[{{ $index }}][id]" value="{{ $med->idMedicamento }}">
                        <input type="hidden" name="receta_items[{{ $index }}][cantidad]" value="{{ $med->cantidad_receta }}">
                    @endforeach
                    <button type="submit" class="px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 w-full md:w-auto">
                        Generar Receta final
                    </button>
                </form>
            </div>
        </div>
    @endif

</div>
</body>
</html>