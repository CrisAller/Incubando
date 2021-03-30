<x-app-layout>
<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Añadir información al Huevo "{{$egg->reference }}"
    </h2>
</x-slot>
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <form action="{{ route('projection.update', ['egg' => $egg, 'projection' => $projection]) }}" method="post">
                    @csrf
                    @foreach ($errors->all() as $error)
                        <p class="mb-0 bg-red-600">{{ $error }}</p>
                    @endforeach


                    <!-- weight -->
                    <div class="mt-4">
                        <x-label for="real_weight" :value="__('Peso')" />

                        <x-input id="real_weight" class="block mt-1 w-full" type="number" step="0.01" min="0" max="999,99" name="real_weight" value="{{old('real_weight')}}" autofocus />
                    </div>

                    <div class="flex justify-around">
                    <!-- Pick -->
                        <div class="mt-4 mr-2 w-1/2">
                            <x-input id="pic_date" class="inline-flex mt-1" type="checkbox" name="pic_date" :value="old('collection_date')" autofocus />
                            <x-label class="inline-flex mt-3" for="pic_date" :value="__('Pick')" />
                        </div>
                    <!-- Abort -->
                        <div class="mt-4 ml-2 w-1/2 ">
                            <x-input id="misbirth" class="inline-flex mt-1" type="checkbox" name="misbirth" :value="old('misbirth')" autofocus />
                            <x-label class="inline-flex mt-3" for="misbirth" :value="__('Abortado')" />
                        </div>
                    <!-- Birth -->
                    <div class="mt-4 ml-2 w-1/2 ">
                        <x-input id="birth" class="inline-flex mt-1 " type="checkbox" name="birth" :value="old('birth')" autofocus />
                        <x-label class="inline-flex mt-3" for="birth" :value="__('Nacido')" />
                    </div>
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <x-button class="ml-4">
                            {{ __('Añadir Peso') }}
                        </x-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</x-app-layout>
