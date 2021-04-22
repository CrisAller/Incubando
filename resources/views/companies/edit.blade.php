<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Datos Empresa') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <form action="{{ route('companies.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @foreach ($errors->all() as $error)
                            <p class="mb-0 bg-red-600">{{ $error }}</p>
                        @endforeach
                            <input type="hidden" name="id" value="{{$company->id}}">
                         <!-- name company -->
                        <div class="mt-4">
                            <x-label for="name" :value="__('Nombre')" />
                            <input id="name" class="block mt-1 w-full" type="text" name="name" value="{{$company->name }}" required autofocus />
                        </div>
                        <!-- address company -->
                        <div class="mt-4">
                            <x-label for="address" :value="__('Dirección')" />
                            <input id="address" class="block mt-1 w-full" type="text" name="address" value="{{$company->address }}" required autofocus />
                        </div>
                        <!-- city company -->
                        <div class="mt-4">
                            <x-label for="city" :value="__('Ciudad')" />
                            <input id="city" class="block mt-1 w-full" type="text" name="city" value="{{$company->city }}" required autofocus />
                        </div>
                        <!-- cif company -->
                        <div class="mt-4">
                            <x-label for="cif" :value="__('Dirección')" />
                            <input id="cif" class="block mt-1 w-full" type="text" name="cif" value="{{$company->cif }}" required autofocus />
                        </div>
                        <!-- logo company -->
                        <div class="mt-4">
                            <x-label for="logo" :value="__('Logotipo')" />
                            <x-input type="file"  class="block my-1 w-full " name="logo" id="logo" />
                            <x-label for="logo" :value="__('*Seleccione un logotipo solo si desea cambiar el actual')" />
                            <img src="{{ $company->getFullUrl() }}" class="mt-1" alt="" width="100px">
                        </div>
                        <div class="flex items-center justify-end mt-4">
                            <x-button class="ml-4">
                                    {{ __('Actualizar') }}
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

