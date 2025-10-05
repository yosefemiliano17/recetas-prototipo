<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seleccionar Sucursal</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 py-10">

    <div class="max-w-xl mx-auto bg-white p-8 rounded-2xl shadow-lg">
        <h1 class="text-2xl font-bold mb-6 text-gray-700 text-center">Seleccionar Sucursal</h1>

        @if (session('error'))
            <div class="bg-red-100 border-red-400 text-red-700 px-4 py-3 rounded-lg mb-4">
                {{ session('error') }}
            </div>
        @endif

        <div class="space-y-6">
            <div>
                <label for="sucursal-select" class="block text-sm font-medium text-gray-700 mb-1">Sucursal</label>
                <select id="sucursal-select" class="w-full bg-white border border-gray-300 rounded-lg p-2.5 shadow-sm">
                    <option value="">-- Elige una sucursal --</option>
                    {{-- Asumiendo que tus objetos SucursalDomain tienen getId() y getNombre() --}}
                    @foreach($sucursales as $sucursal)
                        <option value="{{ $sucursal->getId() }}">{{ $sucursal->getNombre() }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const sucursalSelect = document.getElementById('sucursal-select');

            sucursalSelect.addEventListener('change', function () {
                const sucursalId = this.value;

                // Si se selecciona una sucursal válida, redirige a la página de detalle
                if (sucursalId) {
                    // Construye la URL usando la ruta 'recetas.show'
                    // y redirige al usuario a esa nueva página.
                    window.location.href = `/sucursal/${sucursalId}`;
                }
            });
        });
    </script>

</body>

</html>