<div class="card p-0 m-0 overflow-hidden rounded-3 rounded-bottom">
    <div class="card-header rounded-0" style="background: linear-gradient(135deg, #0d6efd, #6610f2); color: #fff;">
        <h4 class="text-white fw-bold mb-1">
            <i class="mdi mdi-chart-areaspline me-2"></i>
            المشاريع والميزانية شهريًا
        </h4>
        <small class="text-light">مقارنة تفاعلية بين عدد المشاريع وإجمالي الموازنة</small>
    </div>
    <!-- 🧾 محتوى الرسم -->
    <div class="card-body bg-white text-dark rounded-bottom-4">
        <div class="text-center mb-3">
            <canvas id="projectsBudgetChart" height="150"></canvas>
        </div>
        <div class="text-start text-secondary" style="font-size: 0.9rem;">
            <i class="mdi mdi-information me-1"></i>
            البيانات حسب تاريخ الإنشاء الشهري
        </div>
    </div>
</div>


@push('scripts')
    <script>
        let projectsBudgetChart;

        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('projectsBudgetChart').getContext('2d');

            if (projectsBudgetChart) projectsBudgetChart.destroy();

            projectsBudgetChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: @json($labels),
                    datasets: [{
                            label: 'عدد المشاريع',
                            data: @json($projectCounts),
                            borderColor: '#0d6efd',
                            backgroundColor: 'rgba(13,110,253,0.1)',
                            tension: 0.4,
                            fill: true
                        },
                        {
                            label: 'الميزانية ($)',
                            data: @json($budgets),
                            borderColor: '#198754',
                            backgroundColor: 'rgba(25,135,84,0.1)',
                            tension: 0.4,
                            fill: true,
                            yAxisID: 'y1'
                        }
                    ]
                },
                options: {
                    responsive: true,
                    interaction: {
                        mode: 'index',
                        intersect: false
                    },
                    stacked: false,
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(ctx) {
                                    return ctx.dataset.label + ': ' +
                                        (ctx.dataset.label.includes('ميزانية') ? `$${ctx.raw}` : ctx
                                            .raw + ' مشروع');
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            type: 'linear',
                            display: true,
                            position: 'left',
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'عدد المشاريع'
                            }
                        },
                        y1: {
                            type: 'linear',
                            display: true,
                            position: 'right',
                            beginAtZero: true,
                            grid: {
                                drawOnChartArea: false
                            },
                            title: {
                                display: true,
                                text: 'الميزانية $'
                            }
                        }
                    }
                }
            });
        });
    </script>
@endpush
