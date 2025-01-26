<x-dialog-modal wire:model="modalPago">
    <x-slot:title>
        <div class="bg-gradient-to-r from-blue-700 to-blue-900 text-white text-center py-5 -mt-4 -mx-6 rounded-t-lg shadow-md">
            <h2 class="text-2xl font-semibold">{{ $pagoId ? 'Editar' : 'Crear' }} Pago</h2>
        </div>
    </x-slot:title>

    <x-slot:content>
        <div class="space-y-6">
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

            <div>
                <x-label for="fecha">Fecha</x-label>
                <x-input id="fecha" type="date" wire:model="fecha" class="mt-1 block w-full" />
                @error('fecha') <span class="text-red-600">{{ $message }}</span> @enderror
            </div>

            <div>
                <x-label for="tipo_pago">Tipo de Pago</x-label>
                <select wire:model.live="tipo_pago" id="tipo_pago" class="mt-1 block w-full">
                    <option value="">Seleccione</option>
                    <option value="horas">Por Horas</option>
                    <option value="dia">Por Día</option>
                </select>
                @error('tipo_pago') <span class="text-red-600">{{ $message }}</span> @enderror
            </div>

            @if($tipo_pago == 'horas')
                <div>
                    <x-label for="nro_horas">Número de Horas</x-label>
                    <x-input id="nro_horas" type="number" wire:model="nro_horas" class="mt-1 block w-full" />
                    @error('nro_horas') <span class="text-red-600">{{ $message }}</span> @enderror
                </div>
                <div>
                    <x-label for="precio_hora">Precio por Hora</x-label>
                    <x-input id="precio_hora" type="number" wire:model="precio_hora" step="0.01" class="mt-1 block w-full" />
                    @error('precio_hora') <span class="text-red-600">{{ $message }}</span> @enderror
                </div>
            @elseif($tipo_pago == 'dia')
                <div>
                    <x-label for="dias_trabajados">Días Trabajados</x-label>
                    <x-input id="dias_trabajados" type="number" wire:model="dias_trabajados" class="mt-1 block w-full" />
                    @error('dias_trabajados') <span class="text-red-600">{{ $message }}</span> @enderror
                </div>
                <div>
                    <x-label for="precio_dia">Precio por Día</x-label>
                    <x-input id="precio_dia" type="number" wire:model="precio_dia" step="0.01" class="mt-1 block w-full" />
                    @error('precio_dia') <span class="text-red-600">{{ $message }}</span> @enderror
                </div>
            @endif

            <div>
                <x-label for="descripcion">Descripción (Opcional)</x-label>
                <textarea wire:model="descripcion" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" rows="3"></textarea>
            </div>

            <div>
                <x-label>Total</x-label>
                <x-input type="text" class="mt-1 block w-full bg-gray-100" value="{{ $total }}" disabled />
            </div>
        </div>
    </x-slot:content>

    <x-slot:footer>
        <div class="flex gap-4 justify-end">
            <x-button-blue wire:click="store">Guardar</x-button-blue>
            <x-button wire:click="$set('modalPago', false)">Cerrar</x-button>
        </div>
    </x-slot:footer>
</x-dialog-modal>