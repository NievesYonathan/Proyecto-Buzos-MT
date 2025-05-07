<x-app-layout>
    <div class="container-fluid">
        <section class="">
            <div class="mt-2">
                <h3 class="text-left">
                    <i class="fas fa-industry fa-fw"></i> &nbsp; REPORTE USO DE MATERIAS PRIMAS
                </h3>
            </div>

            <div class="container-fluid tile-container">
                <div class="alert alert-info">
                    <p><strong>Estado de datos:</strong> 
                        @if(isset($materiasPrimas) && count($materiasPrimas) > 0)
                            Hay {{ count($materiasPrimas) }} registros disponibles.
                        @else
                            No hay datos disponibles para mostrar.
                        @endif
                    </p>
                </div>

                <!-- Contenedor para el gráfico -->
                <div class="mb-4" style="min-height: 300px;">
                    <canvas id="graficoMateriasPrimas"></canvas>
                </div>

                <!-- Tabla detallada -->
                <div class="table-overflow-x">
                    <table class="table table-dark table-sm">
                        <thead>
                            <tr class="text-center roboto-medium">
                                <th>Materia Prima</th>
                                <th>Producción</th>
                                <th>Cantidad Usada</th>
                                <th>Fecha de Uso</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($registrosUso as $registro)
                                <tr class="text-center table-light">
                                    <td>{{ $registro->mat_pri_nombre }}</td>
                                    <td>{{ $registro->pro_nombre }}</td>
                                    <td>{{ $registro->reg_pmp_cantidad_usada }}</td>
                                    <td>{{ $registro->reg_pmp_fecha_registro }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">No hay datos disponibles.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const datos = @json($materiasPrimas ?? []);
            const canvas = document.getElementById('graficoMateriasPrimas');
            
            if (datos && datos.length > 0 && canvas) {
                try {
                    const etiquetas = datos.map(item => item.nombre_materia_prima);
                    const valores = datos.map(item => item.cantidad_total_usada);
                    
                    const colores = datos.map(() => {
                        const r = Math.floor(Math.random() * 255);
                        const g = Math.floor(Math.random() * 255);
                        const b = Math.floor(Math.random() * 255);
                        return `rgba(${r}, ${g}, ${b}, 0.7)`;
                    });
                    
                    const ctx = canvas.getContext('2d');
                    new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: etiquetas,
                            datasets: [{
                                label: 'Cantidad Total Usada',
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
                                },
                                title: {
                                    display: true,
                                    text: 'Uso Total de Materias Primas',
                                    font: { size: 18 }
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    title: {
                                        display: true,
                                        text: 'Cantidad Usada'
                                    },
                                    ticks: {
                                        precision: 0
                                    }
                                },
                                x: {
                                    title: {
                                        display: true,
                                        text: 'Materia Prima'
                                    }
                                }
                            }
                        }
                    });
                } catch (error) {
                    console.error("Error al crear el gráfico:", error);
                    canvas.parentNode.innerHTML = `<div class="alert alert-danger">Error al crear el gráfico: ${error.message}</div>`;
                }
            }
        });
    </script>
</x-app-layout>