<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Chart -->
        <link href="https://unpkg.com/tailwindcss@1.4.6/dist/tailwind.min.css" rel="stylesheet">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <style>
            #header{display: flex;}
            p#title{text-align: left;}
            p#dateTime{text-align: right;}

            h2{
                text-align: center;
                margin-top: -15px;
            }

            #divimg{
                margin: 20px 0px;
                text-align: center;
                border: solid 1px #f0f0f0;
            }
            img{
                background-color: #f7f7f7;
                max-width: 100%;
            }

            table#initialData{
                /* border: solid 1px rgba(209, 250, 229); */
                border-collapse: collapse;
                border-radius: 50%;
                width: 75%;
                margin: 10px auto;
                padding: 10px 0px;
                background-color:rgb(197, 248, 222);
                color: rgb(0, 46, 0);
            }
            table#initialData span{
                display: block;
                padding-top: 10px;
                color:  rgb(62, 73, 62);
            }

            table#projectionEgg{
                margin-top: 20px;
                min-width: 100%;
                border: solid 1px #f0f0f0;
                border-collapse: collapse;
                text-align: center;
            }
            tr:nth-child(even){background-color: #f7f7f7;}
            table#projectionEgg th{
                background-color: green;
                padding: 20px 0px;
                color: #fff;
            }
            td{padding: 10px 0px;}

            /* states */
            .birth{ background-color: rgb(211, 255, 211);color: rgb(0, 97, 0); border-radius: 50%; width: 75%; margin: auto;}
            .misbirth{ background-color: rgb(255, 187, 187);color: rgb(150, 0, 0); border-radius: 50%; width: 75%; margin: auto; }
            .pic{ background-color: rgb(198, 198, 255); color: rgb(0, 0, 129); border-radius: 50%; width: 75%; margin: auto; }
            .in_nest{ color:rgb(66, 66, 66); background-color: rgb(189, 189, 189); border-radius: 50%; width: 75%; margin: auto;}
            .incubating{ background-color: rgb(255, 255, 184); color: rgb(88, 88, 0); border-radius: 50%; width: 75%; margin: auto; }

        </style>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>


    </head>
    <body>
        <div id="header">
            <p id="title">Avianvet</p>
            <p id="dateTime">{{ $today }}</p>
        </div>
        <div>
            <!-- Page Content -->
            <main>
                <h2>
                    Detalle del Huevo "{{ $egg->reference }}" - {{ $egg->specie->specie_name }}
                </h2>
                <div>
                    <div id="divimg">
                        <img src="{{ $imgChart }}" alt="gráfica de proyección del huevo {{ $egg->reference }}">
                    </div>
                    <div>
                        <div>
                            <div>
                                <table id="initialData">
                                    <thead>
                                        <tr>
                                            <th>Comienzo de incubación
                                                <span>{{ $egg->starting_date->format('d-m-Y') }}</span>
                                            </th>
                                            <th>Peso inicial
                                                <span>{{ $egg->formatted_startingWeight }}</span>
                                            </th>
                                            <th>Pic
                                                <span>{{ $egg->pic_date->format('d-m-Y') }}</span>
                                            </th>
                                        </tr>
                                    </thead>
                                </table>

                                {{-- *********************** CHART *************************** --}}

                                {{-- *********************** FIN CHART *************************** --}}


                                <table id="projectionEgg">
                                    <thead>
                                        <tr>
                                            <th>Incubación</th>
                                            <th>Fecha</th>
                                            <th>P. Estandar</th>
                                            <th>P. Real</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($projections as $key => $projection)
                                        <tr>
                                            <td>
                                                <div>
                                                    <span>{{ $projection->incubation_day }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    <span>{{ $projection->incubation_date->format('d-m-Y H:i') }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    <span>{{ $projection->formatted_weightStandard }}</span>
                                                </div>
                                            </td>
                                            @if($projection->real_weight === null)
                                                <td>
                                                    <div>
                                                        <span></span>
                                                    </div>
                                                </td>
                                            @else
                                                <td>
                                                    <div>
                                                        <span>{{ $projection->formatted_realWeight }}</span>
                                                    </div>
                                                </td>
                                            @endif
                                            {{-- states --}}

                                            <td>
                                                <div class="{{ $projection_controller->states($egg,$projection)['class'] }}">
                                                    <span class=" py-1 px-3 rounded-full text-xs">{{ $projection_controller->states($egg,$projection)['state']}}</span>
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
            </main>
        </div>
    </body>
</html>
