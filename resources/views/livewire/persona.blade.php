<div class="p-6">
    <h2 class="text-lg font-bold mb-4">Lista de Personas</h2>

    <!-- Botón para agregar persona -->
    <button class="bg-blue-500 text-white px-4 py-2 rounded" wire:click="showModal">
        Agregar Persona
    </button>

    <!-- Tabla de personas -->
    <table class="table-auto w-full border-collapse border border-gray-200 mt-4">
        <thead>
            <tr>
                <th class="border border-gray-300 px-4 py-2">ID_Persona</th>
                <th class="border border-gray-300 px-4 py-2">Nombre</th>
                <th class="border border-gray-300 px-4 py-2">Apellido</th>
                <th class="border border-gray-300 px-4 py-2">DNI</th>
                <th class="border border-gray-300 px-4 py-2">Teléfono</th>
                <th class="border border-gray-300 px-4 py-2">Domicilio</th>
                <th class="border border-gray-300 px-4 py-2">Correo Electrónico</th>
                <th class="border border-gray-300 px-4 py-2">Puesto Trabajo</th>
                <th class="border border-gray-300 px-4 py-2">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($personas as $persona)
                <tr>
                    <td class="border border-gray-300 px-4 py-2">{{ $persona->id }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $persona->Nombre }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $persona->Apellido }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $persona->DNI }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $persona->Telefono }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $persona->Domicilio }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $persona->Correo_Electronico }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $persona->Puesto_Trabajo }}</td>
                    <td class="border border-gray-300 px-4 py-2"> 
                    <button class="bg-yellow-500 text-white px-4 py-2 rounded" wire:click="showModal({{ $persona->id }})">
                        Editar
                    </button>

                     <!-- Botón Borrar -->
                     <button wire:click="confirmarBorrado({{ $persona->id }})" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                        Borrar
                    </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Modal -->
    @if($modalVisible)
        <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
            <div class="bg-white p-6 rounded shadow-md w-1/3">
                <h2 class="text-lg font-bold mb-4">Agregar Persona</h2>

                <form wire:submit.prevent="store">
                    <div class="mb-4">
                        <label class="block text-sm font-medium">Nombre</label>
                        <input type="text" wire:model="nombre" class="w-full border-gray-300 rounded-md shadow-sm">
                        @error('nombre') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium">Apellido</label>
                        <input type="text" wire:model="apellido" class="w-full border-gray-300 rounded-md shadow-sm">
                        @error('apellido') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium">DNI</label>
                        <input type="text" wire:model="dni" class="w-full border-gray-300 rounded-md shadow-sm">
                        @error('dni') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium">Teléfono</label>
                        <input type="text" wire:model="telefono" class="w-full border-gray-300 rounded-md shadow-sm">
                        @error('telefono') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium">Domicilio</label>
                        <input type="text" wire:model="domicilio" class="w-full border-gray-300 rounded-md shadow-sm">
                        @error('domicilio') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium">Correo Electrónico</label>
                        <input type="email" wire:model="correoElectronico" class="w-full border-gray-300 rounded-md shadow-sm">
                        @error('correoElectronico') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium">Puesto Trabajo</label>
                        <input type="text" wire:model="puestoTrabajo" class="w-full border-gray-300 rounded-md shadow-sm">
                        @error('puestoTrabajo') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
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
