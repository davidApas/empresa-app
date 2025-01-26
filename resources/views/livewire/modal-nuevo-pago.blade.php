<x-dialog-modal wire:model="modalPago">
    <x-slot:title>
        <div class="bg-gradient-to-r from-blue-700 to-blue-900 text-white text-center py-5 -mt-4 -mx-6 rounded-t-lg shadow-md">
            <h2 class="text-2xl font-semibold">Crear Pago</h2>
        </div>
    </x-slot:title>

    <x-slot:content>
        <div class="space-y-6 px-6 py-4">
            <!-- Campo para la fecha -->
            <div>
                <x-label for="fecha" value="Fecha" />
                <x-input id="fecha" type="date" wire:model="fecha" class="mt-1 block w-full" />
                @error('fecha') <span class="text-red-600">{{ $message }}</span> @enderror
            </div>

            <!-- Campo para el número de horas -->
            <div>
                <x-label for="nro_horas" value="Número de Horas" />
                <x-input id="nro_horas" type="number" wire:model.lazy="nro_horas" class="mt-1 block w-full" />
                @error('nro_horas') <span class="text-red-600">{{ $message }}</span> @enderror
            </div>

            <!-- Campo para el precio por hora -->
            <div>
                <x-label for="precio_hora" value="Precio por Hora" />
                <x-input id="precio_hora" type="number" wire:model.lazy="precio_hora" step="0.01" class="mt-1 block w-full" />
                @error('precio_hora') <span class="text-red-600">{{ $message }}</span> @enderror
            </div>

            <!-- Campo para el total calculado dinámicamente -->
            <div>
                <x-label value="Total" />
                <x-input type="text" class="mt-1 block w-full bg-gray-100" value="{{ $this->total }}" disabled />
            </div>
        </div>
    </x-slot:content>

    <x-slot:footer>
        <div class="flex gap-4 justify-end">
            <x-button-blue wire:click="guardarPago">Guardar</x-button-blue>
            <x-button wire:click="cerrarModal">Cerrar</x-button>
        </div>
    </x-slot:footer>
</x-dialog-modal>

