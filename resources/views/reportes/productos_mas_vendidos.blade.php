@extends('layouts.plantilla')

@section('title', 'Productos Más Vendidos')

@section('content')
<style>
    body {
        background: linear-gradient(to right, #f0f9ff, #e0f7fa);
        font-family: 'Segoe UI', sans-serif;
    }

    h1 {
        text-align: center;
        margin-top: 40px;
        color: #2c3e50;
        font-weight: 700;
    }

    .table-container {
        max-width: 800px;
        margin: 30px auto;
        background-color: white;
        border-radius: 15px;
        padding: 25px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }

    table {
        width: 100%;
        border-collapse: collapse;
        font-size: 16px;
        margin-top: 10px;
    }

    thead th {
        background: linear-gradient(to right, #2c3e50, #34495e);
        color: white;
        padding: 12px;
        text-align: center;
    }

    tbody td {
        padding: 12px;
        border-bottom: 1px solid #ddd;
        text-align: center;
    }

    tbody tr:hover {
        background-color: #f1f8ff;
        transition: background-color 0.3s;
    }

    .highlight-product {
        font-weight: bold;
        color: #8e44ad;
    }

    .highlight-units {
        font-weight: bold;
        color: #27ae60;
    }

    .btn-volver {
        display: block;
        margin: 30px auto 60px;
        padding: 12px 30px;
        font-weight: bold;
        font-size: 16px;
        background: linear-gradient(to right, #3498db, #2c81ba);
        color: white;
        text-decoration: none;
        border-radius: 8px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        transition: transform 0.3s ease;
        text-align: center;
        max-width: 280px;
    }

    .btn-volver:hover {
        background: linear-gradient(to right, #5dade2, #3498db);
        transform: scale(1.05);
    }

    .top-ranking-container {
    max-width: 800px;
    margin: 40px auto 10px;
    background-color: #ffffff;
    border-radius: 15px;
    padding: 25px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }

    .ranking-cards {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .ranking-card {
        display: flex;
        align-items: center;
        background-color: #f9fbff;
        border-radius: 10px;
        padding: 15px 20px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
    }

    .ranking-medal {
        font-size: 28px;
        margin-right: 15px;
    }

    .ranking-nombre {
        font-weight: bold;
        font-size: 18px;
        color: #2c3e50;
    }

    .ranking-ventas {
        font-size: 14px;
        color: #555;
    }

</style>

<h1>🔥 Reporte de Productos Más Vendidos</h1>

<div class="top-ranking-container">
    <h2 style="text-align:center; color:#2c3e50; margin-bottom: 20px;">🏆 Top 3 Productos Más Vendidos</h2>
    <div class="ranking-cards">
        @php
            $top3 = $productosMasVendidos->sortByDesc('total_vendido')->take(3);
            $medallas = ['🥇', '🥈', '🥉'];
            $colores = ['#f39c12', '#95a5a6', '#cd7f32'];
        @endphp

        @foreach ($top3 as $index => $producto)
            <div class="ranking-card" style="border-left: 8px solid {{ $colores[$index] }};">
                <div class="ranking-medal">{{ $medallas[$index] }}</div>
                <div>
                    <div class="ranking-nombre">{{ strtoupper($producto->name) }}</div>
                    <div class="ranking-ventas">{{ $producto->total_vendido }} unidades</div>
                </div>
            </div>
        @endforeach
    </div>
</div>


<div class="table-container">
    <h2 style="text-align:center; margin-bottom: 20px;">📊 Gráfico de Productos Más Vendidos</h2>

    {{-- Spinner de carga --}}
    <div id="loading" style="text-align:center; display:none;">
        <p style="color:#2980b9; font-weight:bold;">⏳ Cargando datos...</p>
    </div>

    <div style="text-align:center; margin-bottom: 15px;">
        <label for="tipoGrafico"><strong>Tipo de gráfico:</strong></label>
        <select id="tipoGrafico" style="margin-left: 10px; padding: 5px 10px; border-radius: 5px;">
            <option value="bar" selected>📊 Barras</option>
            <option value="pie">🥧 Pastel</option>
            <option value="line">📈 Línea</option>
        </select>
    </div>
    

    <canvas id="graficoProductos" height="120"></canvas>
</div>

<div class="table-container">
    <table>
        <thead>
            <tr>
                <th>Producto</th>
                <th>Total Vendido (unidades)</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($productosMasVendidos as $producto)
                <tr>
                    <td class="highlight-product">{{ strtoupper($producto->name) }}</td>
                    <td class="highlight-units">{{ $producto->total_vendido }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<a href="{{ route('dashboard') }}" class="btn-volver">🏠 Volver al Dashboard</a>

{{-- 1. Primero carga Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

{{-- 2. Luego ejecuta tu script personalizado --}}
<script>
    document.addEventListener('DOMContentLoaded', async () => {
        const ctx = document.getElementById('graficoProductos').getContext('2d');
        const tipoGraficoSelect = document.getElementById('tipoGrafico');
        let chart;

        function generarColores(cantidad) {
            const colores = [
                '#3498db', '#e74c3c', '#2ecc71', '#9b59b6',
                '#f1c40f', '#1abc9c', '#e67e22', '#34495e'
            ];
            return Array.from({ length: cantidad }, (_, i) => colores[i % colores.length]);
        }

        async function cargarDatos() {
            const response = await fetch('{{ route('api.productos-mas-vendidos') }}');
            const data = await response.json();

            const labels = data.map(p => p.name.toUpperCase());
            const cantidades = data.map(p => parseInt(p.total_vendido));
            const colores = generarColores(cantidades.length);

            return { labels, cantidades, colores };
        }

        async function renderizarGrafico(tipo = 'bar') {
            document.getElementById('loading').style.display = 'block';

            const { labels, cantidades, colores } = await cargarDatos();

            if (chart) {
                chart.destroy();
            }

            chart = new Chart(ctx, {
                type: tipo,
                data: {
                    labels: labels,
                    datasets: [{
                        label: '📦 Unidades Vendidas',
                        data: cantidades,
                        backgroundColor: colores,
                        borderColor: '#2c3e50',
                        borderWidth: 1,
                        tension: tipo === 'line' ? 0.4 : 0,
                        fill: tipo === 'line',
                        pointBackgroundColor: '#2980b9'
                    }]
                },
                options: {
                    responsive: true,
                    animation: {
                        duration: 1000,
                        easing: 'easeOutBounce'
                    },
                    plugins: {
                        tooltip: {
                            backgroundColor: '#2c3e50',
                            titleColor: '#fff',
                            bodyColor: '#ecf0f1',
                            padding: 10
                        },
                        legend: {
                            display: tipo !== 'bar' // Oculta leyenda para barras
                        }
                    },
                    scales: tipo === 'pie' ? {} : {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1,
                                color: '#2c3e50',
                                font: { weight: 'bold' }
                            },
                            grid: {
                                color: 'rgba(0,0,0,0.05)'
                            }
                        },
                        x: {
                            ticks: {
                                color: '#2c3e50',
                                font: { weight: 'bold' }
                            }
                        }
                    }
                }
            });

            document.getElementById('loading').style.display = 'none';
        }

        await renderizarGrafico();

        tipoGraficoSelect.addEventListener('change', async () => {
            const tipoSeleccionado = tipoGraficoSelect.value;
            await renderizarGrafico(tipoSeleccionado);
        });

        setInterval(() => {
            renderizarGrafico(tipoGraficoSelect.value);
        }, 10000); // actualizar cada 10s con el tipo actual
    });
</script>



@endsection
