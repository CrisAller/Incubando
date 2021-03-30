<x-app-layout>
<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Panel Inicial
    </h2>
</x-slot>
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                @if ($eggs->isEmpty())
                    <p>No hay Referencias</p>
                @else
                    <table class="min-w-max w-full table-auto mt-6">
                        <thead>
                            <tr class="bg-green-800 text-white uppercase text-sm leading-normal">
                                <th class="py-3 px-6 text-left">Referencia</th>
                                <th class="py-3 px-6 text-left">Especie</th>
                                <th class="py-3 px-6 text-center">Día de incubación</th>
                                <th class="py-3 px-6 text-center">Peso</th>
                                <th class="py-3 px-6 text-center">Fecha de recogida</th>
                                <th class="py-3 px-6 text-center">Pic</th>
                                <th class="py-3 px-6 text-center">Estado</th>
                                <th class="py-3 px-6 text-center">Acción</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm font-light">
                            @foreach($eggs as $key => $egg)

                            @if($key % 2 == 0)
                                <tr class="border-b border-gray-200 hover:bg-green-800 hover:bg-opacity-20">
                            @else
                                <tr class="border-b border-gray-200 bg-gray-50 hover:bg-green-800 hover:bg-opacity-20">
                            @endif

                                <td class="py-3 px-6 text-left whitespace-nowrap">
                                    <div class="flex items-center">
                                        <span class="font-medium">{{ $egg->reference }}</span>
                                    </div>
                                </td>
                                <td class="py-3 px-6 text-left">
                                    <div class="flex items-center">
                                        <span>{{ $egg->specie->specie_name }}</span>
                                    </div>
                                </td>
                                <td class="py-3 px-6">
                                    <div class="flex">
                                        <span class="mx-auto">{{ $egg->incubation_day }}</span>
                                    </div>
                                </td>
                                <td class="py-3 px-6 text-left">
                                    <div class="flex items-center">
                                        <span class="mx-auto">{{  $egg->formatted_startingWeight }}</span>
                                    </div>
                                </td>
                                <td class="py-3 px-6 text-left">
                                    <div class="flex items-center">
                                        <span class="mx-auto">{{ $egg->collection_date->format('d-m-Y') }}</span>
                                    </div>
                                </td>
                                <td class="py-3 px-6 text-left">
                                    <div class="flex items-center">
                                        <span>{{ $egg->pic_date->format('d-m-Y') }}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="{{ $eggController->states($egg)['class'] }} py-1 px-3 rounded-full text-xs text-center">
                                        <span>{{ $eggController->states($egg)['state'] }}</span>
                                    </div>
                                </td>
                                <td class="py-3 px-6 text-center">
                                    <div class="flex item-center justify-center" >
                                        <a href="{{ route('eggs.show', ['egg' => $egg]) }}" abbr title="Ver detalles">
                                            <div class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </div>
                                        </a>
                                        <a href="{{ route('eggs.edit', ['egg' => $egg]) }}" abbr title="Editar huevo">
                                            <div class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                </svg>
                                            </div>
                                        </a>
                                        <button class="delete-egg" data-ref="{{$egg->reference}}" data-href="{{ route('eggs.delete', ['egg' => $egg]) }}" abbr title="Eliminar huevo">
                                            <div for="delete" class="float-right w-4 mr-2 transform hover:text-purple-500 hover:scale-110">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </div>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    @endif
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        $(".delete-egg").click(function(){
            var link = $(this).data('href');
            var reference = $(this).data('ref');
            if(confirm('¿Estás seguro/a que quiere eliminar la referencia ' + reference + '?')){
                location.href = link;
            }
        });
    });
</script>
</x-app-layout>
