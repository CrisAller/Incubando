<x-app-layout>
<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Editar Huevo "{{ $egg->reference}}"
    </h2>
</x-slot>
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <form method="POST" action="{{ route('eggs.update', ['egg' => $egg]) }}">
                    @csrf
                    @foreach ($errors->all() as $error)
                        <p class="mb-0 bg-red-600">{{ $error }}</p>
                    @endforeach

                    <input type="hidden" id="company_id" name="company_id" min="0" max="35" required value="{{ auth()->user()->company->id }}" />

                    <!-- reference -->
                    <div class="mt-4">
                        <x-label for="reference" :value="__('Referencia Huevo')" />

                        <input id="reference" class="block mt-1 w-full rounded-md bg-gray-100 border-transparent focus:ring-0 focus:border-transparent focus:ring-transparent focus:ring-offset-transparent" type="text" name="reference" value="{{ $egg->reference }}" required readonly />
                    </div>

                    <!-- specie_id -->
                    <div class="mt-4">
                        <x-label for="specie_id" :value="__('Especie')" />

                        <select name="specie_id" id="specie_id" class="w-full rounded-md border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50'" autofocus >
                            <option value="null">Selecciona una especie</option>
                            @foreach ($species as $specie)
                                @if($specie->id === $egg->specie_id)
                                    <option value="{{$specie->id}}" selected>{{ $specie->specie_name }}</option>
                                @else
                                    <option value="{{$specie->id}}">{{ $specie->specie_name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <!-- weight -->
                    <div class="mt-4">
                        <x-label for="weight" :value="__('Peso')" />

                        <x-input id="weight" class="block mt-1 w-full" type="number" step="0.01" min="0" max="999,99" name="weight" value="{{old('weight') ?? $egg->weight}}" required autofocus />
                    </div>

                    <!-- collection_date -->
                    <div class="mt-4">
                        <x-label for="collection_date" :value="__('collection_date')" />

                        <x-input id="collection_date" class="block mt-1 w-full" type="date" name="collection_date" value="{{old('collection_date') ?? substr($egg->collection_date,0,10)}}" required autofocus />
                    </div>

                    <!-- incubation_day -->
                    <div class="mt-4">
                        <x-label for="incubation_day" :value="__('incubation_day')" />

                        <x-input id="incubation_day" class="block mt-1 w-full" type="number" min="0" max="35" name="incubation_day" :value="old('incubation_day') ?? $egg->incubation_day" required autofocus />
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <x-button class="ml-4">
                            {{ __('Actualizar Ficha') }}
                        </x-button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
</x-app-layout>
