<div>
    <div class="p-4">
    <!-- <h2 class="text-lg font-bold mb-4">Registrar Pago</h2>

    @if (session()->has('message'))
        <div class="bg-green-200 text-green-800 p-2 rounded mb-4">
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit.prevent="guardarPago" class="space-y-4">
        <div>
            <label class="block text-sm font-medium">Fecha</label>
            <input type="date" wire:model="fecha" class="w-full border-gray-300 rounded-md shadow-sm">
            @error('fecha') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium">Nro de Horas</label>
            <input type="number" wire:model="nro_horas" class="w-full border-gray-300 rounded-md shadow-sm">
            @error('nro_horas') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium">Precio por Hora</label>
            <input type="number" step="0.01" wire:model="precio_hora" class="w-full border-gray-300 rounded-md shadow-sm">
            @error('precio_hora') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Guardar Pago</button>
    </form> -->

    <h2 class="text-lg font-bold mt-8 mb-4">Lista de Pagos</h2>
    <table class="w-full border-collapse border border-gray-300">
        <thead>
            <tr>
                <th class="border border-gray-300 px-2 py-1">ID</th>
                <th class="border border-gray-300 px-2 py-1">Fecha</th>
                <th class="border border-gray-300 px-2 py-1">Nro de Horas</th>
                <th class="border border-gray-300 px-2 py-1">Precio por Hora</th>
                <th class="border border-gray-300 px-2 py-1">Deuda</th>
                <th class="border border-gray-300 px-2 py-1">Relevos</th>
                <th class="border border-gray-300 px-2 py-1">Precio por Relevo</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pagos as $pago)
                <tr>
                    <td class="border border-gray-300 px-2 py-1">{{ $pago->ID_Pago }}</td>
                    <td class="border border-gray-300 px-2 py-1">{{ $pago->Fecha }}</td>
                    <td class="border border-gray-300 px-2 py-1">{{ $pago->Nro_Horas }}</td>
                    <td class="border border-gray-300 px-2 py-1">{{ $pago->Precio_Hora }}</td>
                    <td class="border border-gray-300 px-2 py-1">{{ $pago->deuda }}</td>
                    <td class="border border-gray-300 px-2 py-1">{{ $pago->relevo }}</td>
                    <td class="border border-gray-300 px-2 py-1">{{ $pago->precio_relevo }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div>
    <h2 class="text-lg font-bold mb-4">Registrar Pago</h2>

    @if (session()->has('message'))
        <div class="bg-green-200 text-green-800 p-2 rounded mb-4">
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit.prevent="guardarPago" class="space-y-4">
        <!-- Otros campos -->
        <div>
            <label class="block text-sm font-medium">Deuda</label>
            <input type="number" step="0.01" wire:model="deuda" class="w-full border-gray-300 rounded-md shadow-sm">
        </div>
        <div>
            <label class="block text-sm font-medium">Relevos</label>
            <input type="number" wire:model="relevo" class="w-full border-gray-300 rounded-md shadow-sm">
        </div>
        <div>
            <label class="block text-sm font-medium">Precio por Relevo</label>
            <input type="number" step="0.01" wire:model="precio_relevo" class="w-full border-gray-300 rounded-md shadow-sm">
        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Guardar Pago</button>
    </form>

    <h2 class="text-lg font-bold mt-8 mb-4">Operaciones</h2>
    <ul class="list-disc pl-5">
        @foreach ($operaciones as $operacion)
            <li>{{ $operacion }}</li>
        @endforeach
    </ul>
</div>
    <!-- Boton Para Crear Adelano -->
    <button         
        class="inline-flex items-center px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg shadow transition-colors duration-150 ease-in-out"
        wire:click="mostrarModal">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        Nuevo Adelanto
    </button>
    @include('livewire.modal-nuevo-pago')
</div>
