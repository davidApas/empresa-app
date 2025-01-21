<!-- Modal de Filtros -->
<x-dialog-modal wire:model="modalFiltro">
        <x-slot:title>
            <div class="bg-gradient-to-r from-blue-700 to-blue-900 text-white text-center py-5 -mt-4 -mx-6 rounded-t-lg shadow-md">
                <h2 class="text-2xl font-semibold">Filtro Avanzado</h2>
            </div>
        </x-slot:title>
        
        <x-slot:content>
            <div class="space-y-6 px-6 py-4">
                <div>
                    <label for="fechaDesde" class="block text-sm font-medium text-gray-600">Fecha Desde:</label>
                    <input 
                        type="date" 
                        id="fechaDesde" 
                        wire:model="filtro.fechaDesde" 
                        class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>
                <div>
                    <label for="fechaHasta" class="block text-sm font-medium text-gray-600">Fecha Hasta:</label>
                    <input 
                        type="date" 
                        id="fechaHasta" 
                        wire:model="filtro.fechaHasta" 
                        class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>
            </div>
        </x-slot:content>
        
        <x-slot:footer>
            <div class="flex justify-end space-x-3">
                <x-button-blue 
                    wire:click="aplicarFiltros"
                    class="bg-blue-600 hover:bg-blue-700">
                    Filtrar
                </x-button-blue>
                <x-button 
                    wire:click="limpiarFiltros"
                    class="bg-gray-300 hover:bg-gray-400 text-gray-700">
                    Limpiar
                </x-button>
                <x-button 
                    wire:click="$set('modalFiltro', false)"
                    class="bg-red-500 hover:bg-red-600">
                    Cerrar
                </x-button>
            </div>
        </x-slot:footer>
    </x-dialog-modal>