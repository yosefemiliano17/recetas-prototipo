<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Nueva Receta - Sucursal {{ $sucursal->getIdSucursal() }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 py-10">

    <div class="max-w-3xl mx-auto bg-white p-8 rounded-2xl shadow-lg">
        <h1 class="text-2xl font-bold mb-6 text-gray-700 text-center">Registrar Nueva Receta</h1>

       @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative mb-4" role="alert">
                <strong class="font-bold">¡Éxito!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative mb-4" role="alert">
                <strong class="font-bold">¡Error!</strong>
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative mb-4" role="alert">
                <strong class="font-bold">Por favor, corrige los siguientes errores:</strong>
                <ul class="mt-2 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <h2 class="text-lg font-semibold text-left text-gray-600 mb-2">Sucursal</h2>
        <input type="text" disabled value="Sucursal(ID: {{ $sucursal->getIdSucursal() }})"
            class="w-full bg-gray-100 border border-gray-300 rounded-lg p-2.5 mb-6">

        <form action="{{ route('recetas.store') }}" method="POST" id="receta-form">
            @csrf
            <input type="hidden" name="sucursal_id" value="{{ $sucursal->getIdSucursal() }}">

            <div class="border-t pt-4">
                <h2 class="text-lg font-semibold text-gray-600 mb-4">Medicamentos</h2>

                <div id="medicamentos-container" class="space-y-4">
                    <div class="medicamento-row grid grid-cols-12 gap-4 items-end">
                        <div class="col-span-8">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Medicamento 1</label>
                            <select name="medicamentos[0][id]"
                                class="w-full bg-white border border-gray-300 rounded-lg p-2.5" required>
                                <option value="">-- Selecciona un medicamento --</option>
                                @foreach($medicamentosDetalles as $id => $medicamento)
                                    <option value="{{ $id }}">
                                        {{ $medicamento->getNombre() }} ({{ $medicamento->getDosis() }}mg)
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-span-3">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Cantidad</label>
                            <input type="number" name="medicamentos[0][cantidad]" value="1" min="1"
                                class="w-full border border-gray-300 rounded-lg p-2.5" required>
                        </div>
                        <div class="col-span-1"></div>
                    </div>

                </div>

                <div class="mt-4">
                    <button type="button" id="add-medicamento-btn"
                        class="px-4 py-2 bg-green-500 text-white font-semibold rounded-lg hover:bg-green-600 transition">
                        + Agregar Medicamento
                    </button>
                </div>
            </div>

            <div class="flex justify-end items-center pt-6 mt-6 border-t space-x-4">
                <button type="reset"
                    class="px-6 py-3 bg-gray-500 text-white font-semibold rounded-lg hover:bg-gray-600 transition">
                    Limpiar
                </button>
                <button type="submit"
                    class="px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition">
                    Pedir
                </button>
            </div>
        </form>
    </div>


    <template id="medicamento-template">
        <div class="medicamento-row grid grid-cols-12 gap-4 items-end">
            <div class="col-span-8">
                <label class="block text-sm font-medium text-gray-700 mb-1">Medicamento</label>
                <select name="medicamentos[__INDEX__][id]"
                    class="w-full bg-white border border-gray-300 rounded-lg p-2.5" required>
                    <option value="">-- Selecciona un medicamento --</option>
                    @foreach($medicamentosDetalles as $id => $medicamento)
                        <option value="{{ $id }}">
                            {{ $medicamento->getNombre() }} ({{ $medicamento->getDosis() }}mg)
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-span-3">
                <label class="block text-sm font-medium text-gray-700 mb-1">Cantidad</label>
                <input type="number" name="medicamentos[__INDEX__][cantidad]" value="1" min="1"
                    class="w-full border border-gray-300 rounded-lg p-2.5" required>
            </div>
            <div class="col-span-1 flex items-end">
                <button type="button" class="remove-medicamento-btn p-2 text-red-500 hover:text-red-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </button>
            </div>
        </div>
    </template>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const addBtn = document.getElementById('add-medicamento-btn');
            const container = document.getElementById('medicamentos-container');
            const template = document.getElementById('medicamento-template');

            // Empezamos con el índice 1 porque el 0 ya está en el HTML
            let medicamentoIndex = 1;

            addBtn.addEventListener('click', () => {
                // Clonar el contenido del template
                const newRow = template.content.cloneNode(true);

                // Actualizar los nombres de los inputs y selects
                const newSelect = newRow.querySelector('select');
                newSelect.name = `medicamentos[${medicamentoIndex}][id]`;

                const newLabel = newRow.querySelector('label');
                newLabel.textContent = `Medicamento ${medicamentoIndex + 1}`;

                const newInput = newRow.querySelector('input[type="number"]');
                newInput.name = `medicamentos[${medicamentoIndex}][cantidad]`;

                // Añadir la nueva fila al contenedor
                container.appendChild(newRow);

                // Incrementar el índice para la próxima fila
                medicamentoIndex++;
            });

            // Delegación de eventos para los botones de eliminar
            container.addEventListener('click', function (e) {
                // Busca el botón de eliminar más cercano al elemento clickeado
                const removeBtn = e.target.closest('.remove-medicamento-btn');
                if (removeBtn) {
                    // Busca la fila padre más cercana y la elimina
                    removeBtn.closest('.medicamento-row').remove();

                    // Opcional: Re-numerar las etiquetas
                    const allLabels = container.querySelectorAll('.medicamento-row > div:first-child > label');
                    allLabels.forEach((label, index) => {
                        label.textContent = `Medicamento ${index + 1}`;
                    });
                }
            });

            // Lógica para el botón de limpiar
            const form = document.getElementById('receta-form');
            form.addEventListener('reset', () => {
                // Eliminar todas las filas excepto la primera
                const allRows = container.querySelectorAll('.medicamento-row');
                for (let i = 1; i < allRows.length; i++) {
                    allRows[i].remove();
                }
                // Resetear el contador
                medicamentoIndex = 1;
            });
        });
    </script>

</body>

</html>