<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detalle del Huevo "{{ $egg->reference }}" - {{ $egg->specie->specie_name }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="text-right">
                <form action="{{ route('pdf',['egg' => $egg]) }}" method="post" id="formPdf">
                    @csrf
                    <input type="hidden" name="pdfProjection" id="pdfProjection" value="2">
                    <input type="submit" value="Generar PDF" id="generedPdf" class="bg-gray-700 text-white pl-5 pr-5 cursor-pointer">
                </form>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <table class="min-w-min md-w-1/2 table-auto mt-6 mx-auto">
                        <thead>
                            <tr class="bg-green-100 text-green-900 uppercase text-sm leading-normal mx-auto">
                                <th class="rounded-l-2xl py-3 px-6 text-center mx-auto">Comienzo de incubación <br />
                                    <span class="font-medium mx-auto">{{ $egg->starting_date->format('d-m-Y') }}</span>
                                </th>
                                <th class="py-3 px-6 text-center mx-auto">Peso inicial <br />
                                    <span class="font-medium mx-auto lowercase">{{ $egg->formatted_startingWeight }}</span>
                                </th>
                                <th class="rounded-r-2xl py-3 px-6 text-center mx-auto">Pic<br />
                                    <span class="font-medium mx-auto">{{ $egg->pic_date->format('d-m-Y') }}</span>
                                </th>
                            </tr>
                        </thead>
                    </table>

                    {{-- *********************** CHART *************************** --}}
                    <div class="flex items-center justify-center mt-6" >
                        <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.js" defer></script>
                        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>

                        <div class="w-full items-center justify-center px-5 py-5">
                            <div class="rounded shadow-xl w-full" x-data="{stockTicker:stockTicker()}" x-init="stockTicker.renderChart()">
                                <div class="w-full text-black items-center">
                                    <canvas id="chart2" class="w-full h-1/2"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- *********************** FIN CHART *************************** --}}

                    {{-- <div>
                        <div id="chart" style="height: 300px;"></div>

                    </div> --}}

                    <table class="min-w-max w-full table-auto mt-6">
                        <thead>
                            <tr class="bg-green-800 text-white uppercase text-sm leading-normal">
                                <th class="py-3 px-6 text-center">Incubación</th>
                                <th class="py-3 px-6 text-center">Fecha</th>
                                <th class="py-3 px-6 text-center">P. Estandar</th>
                                {{-- <th class="py-3 px-6 text-center">P. min</th>
                                <th class="py-3 px-6 text-center">P. max</th> --}}
                                <th class="py-3 px-6 text-center">P. Real</th>
                                <th class="py-3 px-6 text-center">Status</th>
                                <th class="py-3 px-6 text-center">Añadir Peso</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm font-light">
                            @foreach ($projections as $key => $projection)
                            <tr class="border-b border-gray-200 hover:bg-green-800 hover:bg-opacity-20">
                                <td class="py-3 px-6 text-left whitespace-nowrap">
                                    <div class="flex items-center">
                                        <span class="font-medium">{{ $projection->incubation_day }}</span>
                                    </div>
                                </td>
                                <td class="py-3 px-6 text-left">
                                    <div class="flex items-center">
                                        <span>{{ $projection->incubation_date->format('d-m-Y H:i') }}</span>
                                    </div>
                                </td>
                                <td class="py-3 px-6 text-left">
                                    <div class="flex items-center">
                                        <span>{{ $projection->formatted_weightStandard }}</span>
                                    </div>
                                </td>
                                {{-- <td class="py-3 px-6 text-left">
                                    <div class="flex items-center">
                                        <span>{{ $projection->ideal_weight_below }}</span>
                                    </div>
                                </td>
                                <td class="py-3 px-6 text-left">
                                    <div class="flex items-center">
                                        <span>{{ $projection->ideal_weight_above }}</span>
                                    </div>
                                </td> --}}
                                @if($projection->real_weight === null)
                                    <td class="py-3 px-6 text-left">
                                        <div class="flex items-center">
                                            <span></span>
                                        </div>
                                    </td>
                                @else
                                    <td class="py-3 px-6 text-left">
                                        <div class="flex items-center">
                                            <span>{{ $projection->formatted_realWeight }}</span>
                                        </div>
                                    </td>
                                @endif
                                {{-- states --}}

                                <td class="py-3 px-6 text-center">
                                    <span class="{{ $projection_controller->states($egg,$projection)['class'] }} py-1 px-3 rounded-full text-xs">{{ $projection_controller->states($egg,$projection)['state']}}</span>
                                </td>

                                <td class="py-3 px-6 text-center">
                                    <div class="flex item-center justify-center" >
                                        {{-- <a id="addWeight" href="{{ route('projection.addweight', ['egg' => $egg, 'projection' => $projection]) }}" abbr title="Añadir dato"> --}}
                                            <div class="addWeight w-4 mr-2 transform hover:text-purple-500 hover:scale-110">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                {{-- <div class="bg-yellow-200 relative w-full h-full"> --}}
                                    <div style="display:none"  class="formAddWeight w-1/4 h-auto bg-gray-50 border border-solid border-green-700 absolute left-1/2 p-6">
                                        <span>DÍA DE INCUBACIÓN: <span class="font-bold">{{ $projection->incubation_day }}</span> </span><br>
                                        <span>FECHA: <span class="font-bold">{{ $projection->incubation_date->format('d-m-Y') }}</span> </span>
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
                                                    @if($egg->real_pic_date == $projection->incubation_date)
                                                        <x-input id="pic_date" class="inline-flex mt-1" type="checkbox" name="pic_date" :value="old('collection_date')" autofocus checked />
                                                    @else
                                                        <x-input id="pic_date" class="inline-flex mt-1" type="checkbox" name="pic_date" :value="old('collection_date')" autofocus />
                                                    @endif
                                                    <x-label class="inline-flex mt-3" for="pic_date" :value="__('Pic')" />
                                                </div>
                                            <!-- Abort -->
                                                <div class="mt-4 ml-2 w-1/2 ">
                                                    @if($egg->misbirth == $projection->incubation_date)
                                                        <x-input id="misbirth" class="inline-flex mt-1" type="checkbox" name="misbirth" :value="old('misbirth')" autofocus checked />
                                                    @else
                                                        <x-input id="misbirth" class="inline-flex mt-1" type="checkbox" name="misbirth" :value="old('misbirth')" autofocus />
                                                    @endif
                                                    <x-label class="inline-flex mt-3" for="misbirth" :value="__('Abortado')" />
                                                </div>
                                            <!-- Birth -->
                                            <div class="mt-4 ml-2 w-1/2 ">
                                                @if($egg->birth == $projection->incubation_date)
                                                    <x-input id="birth" class="inline-flex mt-1 " type="checkbox" name="birth" :value="old('birth')" autofocus checked  />
                                                @else
                                                    <x-input id="birth" class="inline-flex mt-1 " type="checkbox" name="birth" :value="old('birth')" autofocus />
                                                @endif
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
                                {{-- </div> --}}
                                        {{-- </a> --}}
                                    </div>

                                </td>
                            </tr>

                            @endforeach
                        </tbody>

                    </table>

                </div>
            </div>
        </div>
    </div>
    <script>
        Number.prototype.m_formatter = function() {
            return this > 999999 ? (this / 1000000).toFixed(1) + 'M' : this
        };
        var real_weight = <?= $real_weight ?>;
        var ideal_weight_above = <?= $ideal_weight_above ?>;
        var ideal_weight_below = <?= $ideal_weight_below ?>;
        var misbirth = <?= $misbirth ?>;
        var real_pic_date = <?= $real_pic_date ?>;
        var birth = <?= $birth ?>;

        let stockTicker = function(){
            return {
                chartData: {
                    labels: [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36],
                    data: real_weight,
                    data2: ideal_weight_above,
                    data3: ideal_weight_below,
                    data4: misbirth,
                    data5: real_pic_date,
                    data6: birth,
                },
                renderChart: function(){
                    let c = false;

                    Chart.helpers.each(Chart.instances, function(instance) {
                        if (instance.chart.canvas.id == 'chart2') {
                            c = instance;
                        }
                    });

                    if(c) {
                        c.destroy();
                    }

                    var ctx = document.getElementById('chart2').getContext('2d');

// var dataUrl = ctx['canvas'].toDataURL('image/png');
// console.log(dataUrl);

                    var chart = new Chart(ctx, {
                        type: "line",
                        data: {
                            labels: this.chartData.labels,
                            datasets: [
                                {
                                    label: 'Peso máximo',
                                    backgroundColor: "rgba(180, 83, 9, 0.1)",
                                    borderColor: "rgba(180, 83, 9, 1)",
                                    pointBackgroundColor: "rgba(180, 83, 9, 1)",
                                    data: this.chartData.data3,
                                },
                                {
                                    label: 'Peso real',
                                    backgroundColor: "rgba(6, 95, 70, 0.1)",
                                    borderColor: "rgba(6, 95, 70, 1)",
                                    pointBackgroundColor: "rgba(6, 95, 70, 1)",
                                    data: this.chartData.data,
                                },
                                {
                                    label: 'Peso mínimo',
                                    backgroundColor: "rgba(29, 78, 216, 0.1)",
                                    borderColor: "rgba(29, 78, 216, 1)",
                                    pointBackgroundColor: "rgba(29, 78, 216, 1)",
                                    data: this.chartData.data2,
                                },
                                {
                                    type: 'bar',
                                    label: 'Abortado',
                                    backgroundColor: "rgba(255, 0, 0, 0.9)",
                                    borderColor: "rgba(255, 0, 0, 1)",
                                    pointBackgroundColor: "rgba(255, 0, 0, 1)",
                                    data: this.chartData.data4,
                                },
                                {
                                    type: 'bar',
                                    label: 'Pic',
                                    backgroundColor: "rgba(0, 0, 255, 0.9)",
                                    borderColor: "rgba(0, 0, 255, 1)",
                                    pointBackgroundColor: "rgba(0, 0, 255, 1)",
                                    data: this.chartData.data5,
                                },
                                {
                                    type: 'bar',
                                    label: 'Nacido',
                                    backgroundColor: "rgba(0, 255, 0, 0.9)",
                                    borderColor: "rgba(0, 255, 0, 1)",
                                    pointBackgroundColor: "rgba(0, 255, 0, 1)",
                                    data: this.chartData.data6,
                                },
                            ],
                        },
                        layout: {
                            padding: {
                                right: 10
                            }
                        },
                        options: {
                            legend: {
                                display: true,
                                position: 'bottom',
                            },
                            scales: {
                                yAxes: [{
                                    ticks: {
                                        fontColor: "rgba(6, 95, 70, 1)",
                                    },
                                    gridLines: {
                                        display: false,
                                    },
                                }],
                                xAxes: [{
                                    ticks: {
                                        fontColor: "rgba(6, 95, 70, 1)",
                                    },
                                    gridLines: {
                                        color: "rgba(6, 95, 70, .2)",
                                        borderDash: [5, 5],
                                        zeroLineColor: "rgba(6, 95, 70, .2)",
                                        zeroLineBorderDash: [5, 5]
                                    },
                                }]
                            }
                        }
                    });

                }
            }
        }



    // *********** FIN CHART **********

    $(document).ready(function(){

        $(".addWeight").click(function(e){
            $(this).next().toggle();
        })

        $("#generedPdf").click( function(){
            var canva = $('#chart2');
            var image = canva[0].toDataURL();
            $("#pdfProjection").val(image);
        })

    });

    </script>

</x-app-layout>
