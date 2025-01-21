<div class="p-6">
    <h2 class="text-lg font-bold mb-4">Lista de Adelantos</h2>
 
    <div class="flex items-center space-x-2 mb-4">
    <!-- Lista desplegable de personas -->
    <div class="space-y-4 p-6 bg-white shadow-lg rounded-lg">
    <!-- Selector de Persona -->
    <div>
        <label for="persona" class="block text-sm font-medium text-gray-700">Seleccionar Persona:</label>
        <select 
            id="persona"
            class="form-select mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
            wire:model="selectedPersonaId">
            <option value="" class="text-gray-500">-- Seleccionar Persona --</option>
            @foreach ($personas as $persona)
                <option value="{{ $persona->id }}" class="text-gray-700">
                    {{ $persona->Nombre }} {{ $persona->Apellido }}
                    @if ($persona->trashed()) (Eliminado) @endif
                </option>
            @endforeach
        </select>
    </div>

    <!-- Filtros y Botones -->
    <div class="flex items-center gap-4">
        <!-- Botón para buscar adelantos -->
        <button 
            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow focus:outline-none focus:ring-2 focus:ring-blue-400"
            wire:click="buscarAdelantos">
            Buscar
        </button>

        <!-- Filtro por fecha -->
        <div>
            <label for="selectedDate" class="block text-sm font-medium text-gray-700">Filtrar por Fecha:</label>
            <input 
                type="date" 
                id="selectedDate" 
                class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
                wire:model="selectedDate">
        </div>

        <!-- Botones para filtrar y limpiar -->
        <div class="flex gap-2">
            <button 
                class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded shadow focus:outline-none focus:ring-2 focus:ring-green-400"
                wire:click="loadAdelantos">
                Filtrar
            </button>
            <button 
                class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded shadow focus:outline-none focus:ring-2 focus:ring-gray-400"
                wire:click="$set('selectedDate', null)">
                Limpiar Filtro
            </button>
        </div>
    </div>

    <!-- Botones principales -->
    <div class="flex justify-between items-center">
        <!-- Botón para agregar adelanto -->
        <button 
            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded shadow focus:outline-none focus:ring-2 focus:ring-blue-400"
            wire:click="showModal">
            Agregar Adelanto
        </button>

        <!-- Botón para descargar PDF -->
        <button 
            class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded shadow focus:outline-none focus:ring-2 focus:ring-red-400"
            wire:click="descargarPDF">
            Descargar PDF
        </button>
    </div>
</div>
</div>

    <!-- Tabla de adelantos -->
    <table class="table-auto w-full border-collapse border border-gray-200 mt-4">
        <thead>
            <tr>
                <th class="border border-gray-300 px-4 py-2">ID</th>
                <th class="border border-gray-300 px-4 py-2">Nombre</th>
                <th class="border border-gray-300 px-4 py-2">Apellido</th>
                <th class="border border-gray-300 px-4 py-2">Fecha</th>
                <th class="border border-gray-300 px-4 py-2">Monto</th>
                <th class="border border-gray-300 px-4 py-2">Entregado Por</th>
                <th class="border border-gray-300 px-4 py-2">Descripción</th>
                <th class="border border-gray-300 px-4 py-2">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($adelantos as $adelanto)
                <tr>
                    <td class="border border-gray-300 px-4 py-2">{{ $adelanto->id }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $adelanto->persona->Nombre }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $adelanto->persona->Apellido }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $adelanto->Fecha }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $adelanto->Monto }}</td>
                    <td class="border px-4 py-2">
                    {{ $adelanto->entregadoPor ? $adelanto->entregadoPor->Nombre . ' ' . $adelanto->entregadoPor->Apellido : 'Sin asignar' }}
                </td>
                    <td class="border border-gray-300 px-4 py-2">{{ $adelanto->Descripcion }}</td>
                    <td class="border border-gray-300 px-4 py-2">

                    <!-- Botón Editar -->

                    <button class="bg-yellow-500 text-white px-4 py-2 rounded" wire:click="showModal({{ $adelanto->id }})">
                        Editar
                    </button>

                    <!-- Botón Borrar -->
                    <button 
                        wire:click="borrarAdelanto({{ $adelanto->id }})" 
                        class="px-4 py-2 text-white bg-red-600 rounded hover:bg-red-700"
                    >
                    Borrar
                    </button>

                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center py-4">No hay adelantos disponibles.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <!-- Modal -->
    @if($modalVisible)
        <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
            <div class="bg-white p-6 rounded shadow-md w-1/3">
                <h2 class="text-lg font-bold mb-4">Agregar Adelanto</h2>

                <form wire:submit.prevent="store">
                    <div class="mb-4">
                    <label for="persona" class="block text-sm font-medium">Persona</label>
    <select wire:model="ID_Persona" class="w-full border-gray-300 rounded-md shadow-sm">
        <option value="">Seleccionar Persona</option>
        @foreach($personas as $persona)
            <option value="{{ $persona->id }}">{{ $persona->Nombre }} {{ $persona->Apellido }}</option>
        @endforeach
    </select>
    @error('ID_Persona') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium">Fecha</label>
                        <input type="datetime-local" wire:model="fecha" class="w-full border-gray-300 rounded-md shadow-sm">
                        @error('fecha') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium">Monto</label>
                        <input type="number" wire:model="monto" class="w-full border-gray-300 rounded-md shadow-sm">
                        @error('monto') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                    <label class="block text-sm font-medium">Entregado Por</label>
                    <select wire:model="entregadoPor" class="w-full border-gray-300 rounded-md shadow-sm">
                        <option value="">Seleccionar Líder</option>
                        @foreach($lideres as $lider)
                            <option value="{{ $lider->id }}">{{ $lider->Nombre }} {{ $lider->Apellido }}</option>
                        @endforeach
                    </select>
                    @error('entregadoPor') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium">Descripción</label>
                        <textarea wire:model="descripcion" class="w-full border-gray-300 rounded-md shadow-sm"></textarea>
                        @error('descripcion') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex justify-end">
                        <button type="button" class="bg-gray-300 text-black px-4 py-2 rounded mr-2" wire:click="hideModal">
                            Cancelar
                        </button>
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">
                            Guardar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

</div>
