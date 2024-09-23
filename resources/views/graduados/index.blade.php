@extends('adminlte::page')

@section('title', 'Lista de Graduados')

@section('content_header')
    <h1>Graduados</h1>
@stop

@section('content')
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title text-center">Satisfacción con el Programa</h3>
                </div>
                <div class="card-body">
                    <label for="satisfaccion_promedio" class="form-label">Satisfacción General:</label>
                    <div class="rating" id="satisfaccion_promedio">
                        @for ($i = 5; $i >= 1; $i--)
                            <input type="radio" name="satisfaccion_promedio" value="{{ $i }}"
                                id="star{{ $i }}" {{ $satisfaccion_promedio == $i ? 'checked' : '' }}
                                style="display:none;" onchange="updateRating(this.value);">
                            <label for="star{{ $i }}" class="star"
                                style="{{ $satisfaccion_promedio >= $i ? 'color: gold;' : 'color: gray;' }}">★</label>
                        @endfor
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title text-center">Tasa de Empleo (%)</h3>
                </div>
                <div class="card-body">
                    <canvas id="tasaEmpleoChart" width="200" height="200"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title text-center">Relevancia del Empleo (%)</h3>
                </div>
                <div class="card-body">
                    <canvas id="relevanciaEmpleoChart" width="200" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title text-center">Experiencia Profesional (Años)</h3>
                </div>
                <div class="card-body">
                    <canvas id="experienciaChart" width="200" height="200"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title text-center">Continuidad en la Formación (%)</h3>
                </div>
                <div class="card-body">
                    <canvas id="continuidadFormacionChart" width="200" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title text-center">Pertinencia de la Formación (%)</h3>
                </div>
                <div class="card-body">
                    <canvas id="pertinenciaFormacionChart" width="200" height="200"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title text-center">Participación en Desarrollo Profesional (%)</h3>
                </div>
                <div class="card-body">
                    <canvas id="desarrolloProfesionalChart" width="200" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-header">
            <h3 class="card-title">Lista de Graduados</h3>
        </div>
        <div class="card-body table-responsive">
            <table id="graduadosTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Foto</th>
                        <th>Cedula/Pasaporte</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Email</th>
                        <th>Ciudad</th>
                        <th>Celular</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Los datos serán cargados por DataTables -->
                </tbody>
            </table>
        </div>
    </div>
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        $(document).ready(function() {
            $('#graduadosTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('usuarios.graduados') }}',
                columns: [{
                        data: 'image',
                        name: 'image',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'dni',
                        name: 'dni'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'apellidop',
                        name: 'apellidop'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'ciudad',
                        name: 'ciudad'
                    },
                    {
                        data: 'celular',
                        name: 'celular'
                    },
                    {
                        data: 'actions',
                        name: 'actions',
                        orderable: false,
                        searchable: false
                    }
                ],
                language: {
                    url: "https://cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json"
                }
            });

            // Opciones comunes para los gráficos
            var chartOptions = {
                maintainAspectRatio: false,
                responsive: true, // Hace que los gráficos sean responsivos
                title: {
                    display: true
                }
            };

            // Graficos
            var empleados = {{ $empleados }};
            var noEmpleados = {{ $total_graduados - $empleados }};
            var tasaEmpleo = {{ $tasa_empleo }};
            var ctx1 = document.getElementById('tasaEmpleoChart').getContext('2d');

            new Chart(ctx1, {
                type: 'doughnut',
                data: {
                    labels: [
                        `Empleados: ${empleados} (${tasaEmpleo.toFixed(2)}%)`,
                        `No Empleados: ${noEmpleados} (${(100 - tasaEmpleo).toFixed(2)}%)`
                    ],
                    datasets: [{
                        data: [tasaEmpleo, 100 - tasaEmpleo],
                        backgroundColor: ['#e61bec', '#ff6384']
                    }]
                },
                options: Object.assign({}, chartOptions, {
                    title: {
                        display: true,
                        text: 'Tasa de Empleo (%)'
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(tooltipItem) {
                                    var label = tooltipItem.label || '';
                                    var value = tooltipItem.raw || 0;
                                    return `${label} (${value.toFixed(2)}%)`;
                                }
                            }
                        }
                    }
                })
            });


            var relacionados = {{ $trabajo_relacionado }};
            var noRelacionados = {{ $no_relacionado }};
            var relevanciaEmpleo = {{ $relevancia_empleo }};
            var ctx2 = document.getElementById('relevanciaEmpleoChart').getContext('2d');

            new Chart(ctx2, {
                type: 'pie',
                data: {
                    labels: [
                        `Relacionado: ${relacionados} (${relevanciaEmpleo.toFixed(2)}%)`,
                        `No Relacionado: ${noRelacionados} (${(100 - relevanciaEmpleo).toFixed(2)}%)`
                    ],
                    datasets: [{
                        data: [relevanciaEmpleo, 100 - relevanciaEmpleo],
                        backgroundColor: ['#4bc0c0', '#ff9f40']
                    }]
                },
                options: Object.assign({}, chartOptions, {
                    title: {
                        display: true,
                        text: 'Relevancia del Empleo (%)'
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(tooltipItem) {
                                    var label = tooltipItem.label || '';
                                    var value = tooltipItem.raw || 0;
                                    return `${label} (${value.toFixed(2)}%)`;
                                }
                            }
                        }
                    }
                })
            });

            var ctx3 = document.getElementById('experienciaChart').getContext('2d');
            new Chart(ctx3, {
                type: 'bar',
                data: {
                    labels: Object.keys({!! json_encode($experiencia_rangos) !!}),
                    datasets: [{
                        label: 'Cantidad de Graduados',
                        data: Object.values({!! json_encode($experiencia_rangos) !!}),
                        backgroundColor: ['#ffcd56', '#ff9f40', '#36a2eb', '#4bc0c0', '#ff6384']
                    }]
                },
                options: Object.assign({}, chartOptions, {
                    title: {
                        display: true, // Asegúrate de que esto esté en true para mostrar el título
                        text: 'Experiencia Profesional por Rangos'
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                })
            });

            var estudiosAdicionales = {{ $estudios_adicionales }};
            var totalGraduados = {{ $total_graduados }};
            var noEstudiosAdicionales = {{ $no_estudios_adicionales }};
            var continuidadFormacion = {{ $continuidad_formacion }};
            var ctx4 = document.getElementById('continuidadFormacionChart').getContext('2d');

            new Chart(ctx4, {
                type: 'pie', // Cambia el tipo a 'pie'
                data: {
                    labels: [
                        `Continuación: ${estudiosAdicionales} (${continuidadFormacion.toFixed(2)}%)`,
                        `No Continuación: ${noEstudiosAdicionales} (${(100 - continuidadFormacion).toFixed(2)}%)`
                    ],
                    datasets: [{
                        label: 'Continuidad en la Formación',
                        data: [estudiosAdicionales, noEstudiosAdicionales],
                        backgroundColor: ['#9966ff', '#ff6384']
                    }]
                },
                options: Object.assign({}, chartOptions, {
                    title: {
                        display: true,
                        text: 'Continuidad en la Formación (%)'
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(tooltipItem) {
                                    var label = tooltipItem.label || '';
                                    var value = tooltipItem.raw || 0;
                                    return `${label} (${value})`; // Muestra el valor exacto
                                }
                            }
                        }
                    }
                })
            });

            function updateRating(value) {
                const stars = document.querySelectorAll('.star');
                stars.forEach((star, index) => {
                    star.style.color = (5 - index) <= value ? 'gold' : 'gray';
                });
            }

            var pertinenciaFormacion = {{ $pertinencia_formacion }};
            var noPertinencia = {{ $no_pertinencia }};
            var pertinenciaFormacionP = {{ $pertinencia_formacion_p }}; // Asegúrate de pasar esta variable también

            var ctx6 = document.getElementById('pertinenciaFormacionChart').getContext('2d');
            new Chart(ctx6, {
                type: 'doughnut',
                data: {
                    labels: [
                        `Pertinente: ${pertinenciaFormacion} (${pertinenciaFormacionP.toFixed(2)}%)`,
                        `No Pertinente: ${noPertinencia} (${(100 - pertinenciaFormacionP).toFixed(2)}%)`
                    ],
                    datasets: [{
                        data: [pertinenciaFormacion, noPertinencia],
                        backgroundColor: ['#2de114', '#ff6384']
                    }]
                },
                options: Object.assign({}, chartOptions, {
                    title: {
                        display: true,
                        text: 'Pertinencia de la Formación (%)'
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(tooltipItem) {
                                    var label = tooltipItem.label || '';
                                    var value = tooltipItem.raw || 0;
                                    return `${label} (${value})`; // Muestra el valor exacto
                                }
                            }
                        }
                    }
                })
            });

            var desarrolloProfesional = {{ $desarrollo_profesional_continuo }};
            var noDesarrolloProfesional = {{ $no_desarrollo_profesional_continuo }};
            var porcentajeDesarrolloProfesional = {{ $porcentaje_desarrollo_profesional }};

            var ctx = document.getElementById('desarrolloProfesionalChart').getContext('2d');
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: [
                        `Con Desarrollo Profesional: ${desarrolloProfesional} (${porcentajeDesarrolloProfesional.toFixed(2)}%)`,
                        `Sin Desarrollo Profesional: ${noDesarrolloProfesional} (${(100 - porcentajeDesarrolloProfesional).toFixed(2)}%)`
                    ],
                    datasets: [{
                        data: [desarrolloProfesional, noDesarrolloProfesional],
                        backgroundColor: ['#36a2eb', '#d6210f']
                    }]
                },
                options: Object.assign({}, chartOptions, {
                    title: {
                        display: true,
                        text: 'Desarrollo Profesional Continuo (%)'
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(tooltipItem) {
                                    var label = tooltipItem.label || '';
                                    var value = tooltipItem.raw || 0;
                                    return `${label} (${value})`; // Muestra el valor exacto
                                }
                            }
                        }
                    }
                })
            });


        });
    </script>
@stop

@section('css')
    <style>
        .rating {
            direction: rtl;
            display: inline-block;
            font-size: 24px;
        }

        .rating input {
            display: none;
        }

        .rating label {
            color: #ddd;
            cursor: pointer;
        }

        .rating input:checked~label,
        .rating label:hover,
        .rating label:hover~label {
            color: gold;
        }
    </style>
@stop
