<div class="flex flex-col">
    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <div class="grid grid-cols-4">
                                <div class=" col-span-1 flex px-2 py-2 bg-white border-t border-gray-200 sm:px-3">
                                    <select wire:model='perPage'
                                        class=" border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm mr-4">
                                        <option value="5">5 por página</option>
                                        <option value="10">10 por página</option>
                                        <option value="25">25 por página</option>
                                        <option value="50">50 por página</option>
                                        <option value="100">100 por página</option>
                                    </select>
                                </div>
                                <div class=" col-span-3 flex px-2 py-2 bg-white border-t border-gray-200 sm:px-3">
                                    <input wire:model="search" type="text" placeholder="Buscar"
                                        class="w-full col-span-3 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                </div>
                            </div>
                        </tr>
                        @if ($vehiculos->count())
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <div class="flex justify-center text-center">
                                    No. Colaborador
                                </div>
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <div class="flex text-left">
                                    Placa
                                </div>
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <div class="flex text-left">
                                    Datos del vehículo
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <div class="flex text-left">
                                    Tipo de vehículo
                                </div>
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                No. Marbete
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($vehiculos as $vehiculo)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 text-center">
                                {{ $vehiculo->no_colaborador }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                {{ $vehiculo->placa }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <p><a class="text-black">Marca:</a> {{ $vehiculo->marca }}</p>
                                <p><a class="text-black">Modelo:</a> {{ $vehiculo->modelo }}</p>
                                <p><a class="text-black">Año:</a> {{ $vehiculo->fecha_modelo }}</p>
                                <p><a class="text-black">Modelo:</a> {{ $vehiculo->color }}</p>
                            </td>
                            <td class="px-8 py-4 whitespace-nowrap text-left text-sm text-gray-800">
                                {{ $vehiculo->tipo_vehiculo }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-800">
                                @if($vehiculo->tipo_vehiculo == 'Automóvil')
                                A-{{ $vehiculo->no_marbete }}
                                @else
                                M-{{ $vehiculo->no_marbete }}
                                @endif

                            </td>
                        </tr>
                        @endforeach
                        <!-- More items... -->
                    </tbody>
                </table>
                <div class="px-4 py-3 bg-white border-t border-gray-200 sm:px-6">
                    {{ $vehiculos->links() }}
                </div>
                @else
                <div class="px-4 py-3 bg-white border-t border-gray-200 sm:px-6">
                    <h6 class="text-center text-gray-500">No se encontró a ningún campo que coincida con:
                        "{{ $search }}"</h6>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>