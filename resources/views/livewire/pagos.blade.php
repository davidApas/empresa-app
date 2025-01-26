<div class="p-6 space-y-6">
    <div class="bg-white rounded-lg shadow-lg p-6">
        <h2 class="text-2xl font-bold text-gray-800 border-b pb-4 mb-6">Lista de Pagos</h2>

        <!-- Controles superiores -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
            <!-- Selector de Persona -->
            <div class="bg-white rounded-lg p-4 border border-gray-200">
                <label for="persona" class="block text-sm font-medium text-gray-700 mb-2">Seleccionar Persona:</label>
                <select 
                    wire:model.live="selectedPersonaId" 
                    wire:change="loadPagos" 
                    class="w-full border-gray-300 rounded-md shadow-sm">
                    <option value="">Todos</option>
                    @foreach($personas as $persona)
                        <option value="{{ $persona->id }}">{{ $persona->Nombre }} {{ $persona->Apellido }}</option>
                    @endforeach
                </select>
                
                <button 
                    type="button" 
                    class="mt-4 bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-700"
                    wire:click="loadPagos">
                    Buscar
                </button>
            </div>

            <!-- Botones principales -->
            <div class="flex items-center gap-4 justify-end">
                <button 
                    class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow transition-colors duration-150 ease-in-out"
                    wire:click="$set('modalFiltro', true)">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                    </svg>
                    Filtrar
                </button>
                <button         
                    class="inline-flex items-center px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg shadow transition-colors duration-150 ease-in-out"
                    wire:click="showModal">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Nuevo Pago
                </button>
                <button 
                    class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg shadow transition-colors duration-150 ease-in-out"
                    wire:click="descargarPDF">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Descargar PDF
                </button>
            </div>
        </div>
    </div>

    <h2 class="text-lg font-bold mt-8 mb-4">Lista de Pagos</h2>
    <table class="w-full border-collapse border border-gray-300">
        <thead>
            <tr class="bg-gray-100">
                <th class="border border-gray-300 px-2 py-1">Persona</th>
                <th class="border border-gray-300 px-2 py-1">Fecha</th>
                <th class="border border-gray-300 px-2 py-1">Tipo Pago</th>
                <th class="border border-gray-300 px-2 py-1">Cantidad</th>
                <th class="border border-gray-300 px-2 py-1">Precio Unitario</th>
                <th class="border border-gray-300 px-2 py-1">Total</th>
                <th class="border border-gray-300 px-2 py-1">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($pagos as $pago)
                <tr>
                    <td class="border border-gray-300 px-2 py-1">
                        {{ $pago->persona ? $pago->persona->Nombre . ' ' . $pago->persona->Apellido : 'N/A' }}
                    </td>
                    <td class="border border-gray-300 px-2 py-1">{{ $pago->fecha }}</td>
                    <td class="border border-gray-300 px-2 py-1">
                        {{ $pago->tipo_pago === 'horas' ? 'Por Horas' : 'Por Día' }}
                    </td>
                    <td class="border border-gray-300 px-2 py-1">
                        {{ $pago->tipo_pago === 'horas' ? $pago->nro_horas . ' hrs' : $pago->dias_trabajados . ' días' }}
                    </td>
                    <td class="border border-gray-300 px-2 py-1">
                        {{ $pago->tipo_pago === 'horas' ? $pago->precio_hora : $pago->precio_dia }}
                    </td>
                    <td class="border border-gray-300 px-2 py-1">{{ $pago->total }}</td>
                    <td class="border border-gray-300 px-2 py-1 text-center">
                        <div class="flex justify-center space-x-2">
                            <button 
                                wire:click="showModal({{ $pago->id }})" 
                                class="text-blue-500 hover:text-blue-700">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </button>
                            <button 
                                wire:click="confirmarBorrado({{ $pago->id }})" 
                                class="text-red-500 hover:text-red-700">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center py-4">No hay pagos registrados</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    @include('livewire.modal-filtro-adelantos')
    @include('livewire.modal-nuevo-pago')
</div>
