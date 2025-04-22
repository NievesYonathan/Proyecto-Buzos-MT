<x-app-layout>
    <main class="full-box main-container">
        <section class="full-box page-content">

            <div class="full-box page-header">
                <h3 class="text-left">
                    <i class="fas fa-industry fa-fw"></i> &nbsp; INFORME PRODUCCIÓN
                </h3>
            </div>

            <div class="container-fluid">
                <ul class="full-box list-unstyled page-nav-tabs">
                    <li>
                        <a class="active" href="{{ route('reportes') }}">
                            <i class="fas fa-chart-bar fa-fw"></i> &nbsp; INFORME PRODUCCIÓN
                        </a>
                    </li>
                </ul>
            </div>

            <div class="container-fluid tile-container">
                <!-- Depuración de datos -->
                <div class="alert alert-info">
                    <p><strong>Estado de datos:</strong> 
                        @if(isset($datosProduccion) && count($datosProduccion) > 0)
                            Hay {{ count($datosProduccion) }} registros disponibles.
                        @else
                            No hay datos disponibles para mostrar.
                        @endif
                    </p>
                </div>

                <!-- Contenedor para el gráfico -->
                <div class="mb-4" style="min-height: 300px;">
                    <canvas id="graficoProduccion"></canvas>
                </div>

                <!-- Tabla de datos -->
                <div class="table-responsive">
                    <table class="table table-dark table-sm">
                        <thead>
                            <tr class="text-center roboto-medium">
                                <th>Tipo de Prenda</th>
                                <th>Cantidad Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($datosProduccion as $fila)
                                <tr class="text-center">
                                    <td>{{ $fila->reg_pf_tipo_prenda }}</td>
                                    <td>{{ $fila->cantidad_total }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="text-center">No hay datos disponibles.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log("DOM cargado completamente");
            
            // Obtener los datos
            const datos = @json($datosProduccion ?? []);
            console.log("Datos recibidos:", datos);
            
            // Verificar si el canvas existe
            const canvas = document.getElementById('graficoProduccion');
            if (!canvas) {
                console.error("No se encontró el elemento canvas con ID 'graficoProduccion'");
                return;
            }
            console.log("Canvas encontrado correctamente");
            
            // Verificar que tengamos datos antes de intentar crear el gráfico
            if (datos && datos.length > 0) {
                console.log("Iniciando creación de gráfico con " + datos.length + " registros");
                
                try {
                    // Extraer los valores para verificar que sean correctos
                    const etiquetas = datos.map(item => {
                        if (!item.reg_pf_tipo_prenda) {
                            console.warn("Encontrado un item sin propiedad reg_pf_tipo_prenda:", item);
                            return "Sin tipo";
                        }
                        return item.reg_pf_tipo_prenda;
                    });
                    
                    const valores = datos.map(item => {
                        if (item.cantidad_total === undefined || item.cantidad_total === null) {
                            console.warn("Encontrado un item sin propiedad cantidad_total:", item);
                            return 0;
                        }
                        // Convertir a número en caso de que sea string
                        return Number(item.cantidad_total);
                    });
                    
                    console.log("Etiquetas:", etiquetas);
                    console.log("Valores:", valores);
                    
                    // Generar colores aleatorios para cada barra
                    const colores = datos.map(() => {
                        const r = Math.floor(Math.random() * 255);
                        const g = Math.floor(Math.random() * 255);
                        const b = Math.floor(Math.random() * 255);
                        return `rgba(${r}, ${g}, ${b}, 0.7)`;
                    });
                    
                    // Crear el gráfico
                    const ctx = canvas.getContext('2d');
                    new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: etiquetas,
                            datasets: [{
                                label: 'Cantidad Total',
                                data: valores,
                                backgroundColor: colores,
                                borderColor: colores.map(color => color.replace('0.7', '1')),
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    position: 'top',
                                    labels: {
                                        font: {
                                            size: 14
                                        }
                                    }
                                },
                                title: {
                                    display: true,
                                    text: 'Cantidad de Prendas Fabricadas por Tipo',
                                    font: {
                                        size: 18
                                    }
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    title: {
                                        display: true,
                                        text: 'Cantidad'
                                    },
                                    ticks: {
                                        precision: 0
                                    }
                                },
                                x: {
                                    title: {
                                        display: true,
                                        text: 'Tipo de Prenda'
                                    }
                                }
                            }
                        }
                    });
                    console.log("Gráfico creado exitosamente");
                    
                } catch (error) {
                    console.error("Error al crear el gráfico:", error);
                    canvas.parentNode.innerHTML = `<div class="alert alert-danger">Error al crear el gráfico: ${error.message}</div>`;
                }
            } else {
                console.warn("No hay datos para graficar");
                canvas.parentNode.innerHTML = '<div class="alert alert-warning">No hay datos disponibles para graficar</div>';
            }
        });
    </script>
</x-app-layout>