<!-- Modal de Creacion-Edicion -->
<x-dialog-modal wire:model="modalVisible">
        <x-slot:title>
            <div class="bg-gradient-to-r from-blue-700 to-blue-900 text-white text-center py-5 -mt-4 -mx-6 rounded-t-lg shadow-md">
                <h2 class="text-2xl font-semibold">Crear Adelanto</h2>
            </div>
        </x-slot:title>
        
        <x-slot:content>
            <div class="space-y-6 px-6 py-4">
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
                        <label class="block text-sm font-medium text-gray-600">Fecha</label>
                        <input type="datetime-local" wire:model="fecha" class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
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
                </form>
            </div>
        </x-slot:content>
        
        <x-slot:footer>
        <div class="flex gap-4 justify-end">
            <x-button-blue wire:click="store">Guardar</x-button-blue>
            <x-button wire:click="hideModal">Cerrar</x-button>
        </div>
        </x-slot:footer>
    </x-dialog-modal>