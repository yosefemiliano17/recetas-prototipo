<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 py-10">
    <div class="max-w-3xl mx-auto bg-white p-8 rounded-2xl shadow-lg">
        <h1 class="text-2xl font-bold mb-6 text-gray-700 text-center">Registrar Receta</h1>

        <form action="" method="POST" class="space-y-6">
            @csrf

            <!-- Datos de la Sucursal -->
            <div>
                <h2 class="text-lg font-semibold mb-3 text-gray-600">Datos de la Sucursal</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nombre de la Sucursal</label>
                    <input type="text" name="sucursal" required 
                    class="w-full bg-white border border-gray-300 rounded-lg p-2.5 text-gray-800 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-100">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Cadena Farmacéutica</label>
                    <input type="text" name="cadena" required 
                    class="w-full bg-white border border-gray-300 rounded-lg p-2.5 text-gray-800 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-100">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Dirección</label>
                    <input type="text" name="direccion" required 
                    class="w-full bg-white border border-gray-300 rounded-lg p-2.5 text-gray-800 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-100">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Teléfono</label>
                    <input type="text" name="telefono"
                    class="w-full bg-white border border-gray-300 rounded-lg p-2.5 text-gray-800 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-100">
                </div>
                </div>
            </div>

            <!-- Medicamentos -->
            <div>
                <h2 class="text-lg font-semibold mb-3 text-gray-600">Medicamentos</h2>

                <div id="medicamentos" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 medicamento-item">
                    <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nombre del medicamento</label>
                    <input type="text" name="medicamentos[0][nombre]" required 
                        class="w-full bg-white border border-gray-300 rounded-lg p-2.5 text-gray-800 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-100">
                    </div>
                    <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Dosis</label>
                    <input type="text" name="medicamentos[0][dosis]" required 
                        class="w-full bg-white border border-gray-300 rounded-lg p-2.5 text-gray-800 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-100">
                    </div>
                </div>
                </div>

                <button type="button" id="agregarMedicamento" 
                class="mt-3 px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition">
                + Agregar medicamento
                </button>
            </div>

            <!-- Botón enviar -->
            <div class="pt-4 text-center">
                <button type="submit" 
                class="px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition">
                Enviar Receta
                </button>
            </div>
        </form>
  </div>

  <script>
    let contador = 1;
    const contenedor = document.getElementById('medicamentos');
    const btnAgregar = document.getElementById('agregarMedicamento');

    btnAgregar.addEventListener('click', () => {
      const nuevo = document.createElement('div');
      nuevo.classList.add('grid', 'grid-cols-1', 'md:grid-cols-2', 'gap-4', 'medicamento-item');
      nuevo.innerHTML = `
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Nombre del medicamento</label>
          <input type="text" name="medicamentos[${contador}][nombre]" required 
            class="w-full bg-white border border-gray-300 rounded-lg p-2.5 text-gray-800 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-100">
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Dosis</label>
          <input type="text" name="medicamentos[${contador}][dosis]" required 
            class="w-full bg-white border border-gray-300 rounded-lg p-2.5 text-gray-800 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-100">
        </div>
      `;
      contenedor.appendChild(nuevo);
      contador++;
    });
  </script>
</body>
</html>
