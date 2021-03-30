<x-app-layout>
<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Datos Empresa') }}
    </h2>
</x-slot>
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">

                @if($company->name == "")

                <p>INTRODUCE LOS DATOS DE LA EMPRESA</p>

                <form action="{{ route('companies.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    @foreach ($errors->all() as $error)
                            <p class="mb-0 bg-red-600">{{ $error }}</p>
                        @endforeach
                            <input type="hidden" name="id" value="{{$company->id}}">
                         <!-- name company -->
                        <div class="mt-4">
                            <x-label for="name" :value="__('Nombre')" />
                            <input id="name" class="block mt-1 w-full" type="text" name="reference" value="{{$company->name }}" required autofocus />
                        </div>
                        <!-- address company -->
                        <div class="mt-4">
                            <x-label for="address" :value="__('Dirección')" />
                            <input id="address" class="block mt-1 w-full" type="text" name="reference" value="{{$company->address }}" required autofocus />
                        </div>
                        <!-- city company -->
                        <div class="mt-4">
                            <x-label for="city" :value="__('Ciudad')" />
                            <input id="city" class="block mt-1 w-full" type="text" name="reference" value="{{$company->city }}" required autofocus />
                        </div>
                        <!-- cif company -->
                        <div class="mt-4">
                            <x-label for="cif" :value="__('Dirección')" />
                            <input id="cif" class="block mt-1 w-full" type="text" name="reference" value="{{$company->cif }}" required autofocus />
                        </div>
                        <!-- logo company -->
                        <div class="mt-4">
                            <x-label for="logo" :value="__('Logotipo')" />
                            <x-input type="file"  class="block my-1 w-full " name="logo" id="logo" />
                        </div>
                        <div class="flex items-center justify-end mt-4">
                            <x-button class="ml-4">
                                    {{ __('Actualizar') }}
                            </x-button>
                        </div>
                </form>

                @else
                    <div class="flex mb-6">
                        <img src="{{ $company->getFullUrl() }}" alt="" width="60px">
                        <x-label for="name" class="mt-3 text-lg font-bold ml-3" :value="$company->name" />
                    </div>

                    <!-- address company -->
                    <div class="mt-4 flex">
                        <x-label for="address" class="" :value="__('Dirección: ')" />
                        <x-label for="address" class="ml-3 font-bold " :value="__($company->address)" />
                    </div>
                    <!-- city company -->
                    <div class="mt-4 flex">
                        <x-label for="city" class="" :value="__('Ciudad: ')" />
                        <x-label for="city" class="ml-3 font-bold " :value="__($company->city)" />
                    </div>
                    <!-- cif company -->
                    <div class="mt-4 flex">
                        <x-label for="cif" class="" :value="__('Cif: ')" />
                        <x-label for="cif" class="ml-3 font-bold " :value="__($company->cif)" />
                    </div>
                    <div class="flex items-center justify-end mt-4">
                        <x-button class="ml-4">
                            <a href="{{ route('companies.edit')}}">
                                {{ __('Modificar') }}
                            </a>
                        </x-button>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
</x-app-layout>
