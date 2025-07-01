<div class="card border-0 shadow-sm rounded-4">
    <!-- 🟦 هيدر فاخر -->
    <div class="card-header border-0 rounded-top-4"
        style="background: linear-gradient(135deg, #007bff, #6610f2); box-shadow: inset 0 -1px 0 rgba(255,255,255,0.1);">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="card-title text-white fw-bold mb-0">
                <i class="las la-chart-pie me-2 fs-4"></i> حالة المشاريع
            </h4>
        </div>
        <small class="text-white mt-1 d-block">تحليل مرئي لأحدث الحالات</small>
    </div>

    <!-- 🎯 محتوى الكارد -->
    <div class="card-body">
        <div class="row align-items-center">
            <!-- 🎨 الرسم -->
            <div class="col-md-5 text-center mb-3 mb-md-0">
                <canvas id="projectStatusChart" style="width: 120px;height: 120px;"></canvas>
            </div>

            <!-- 📊 الملخص -->
            <div class="col-md-7">
                <h6 class="bg-light text-muted p-2 rounded-3 d-flex align-items-center justify-content-center mb-3">
                    <i class="las la-calendar-day me-1"></i>
                    {{ $dateRange ?? 'لا توجد بيانات' }}
                </h6>

                @php
                    $total = array_sum($statusCounts);
                    $icons = ['la la-bolt', 'la la-spinner', 'la la-check-circle'];
                    $colors = ['primary', 'warning', 'success'];
                @endphp

                <ul class="list-group shadow-sm rounded-4 overflow-hidden">
                    @foreach ($statusSummary as $i => $item)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <i class="{{ $icons[$i % count($icons)] }} text-muted font-16 me-2"></i>
                                <span class="fw-semibold">{{ $item['label'] }}</span>
                            </div>
                            <span class="badge badge-outline-{{ $colors[$i % count($colors)] }} badge-pill">
                                {{ $item['count'] }} مشروع -
                                {{ $total > 0 ? round(($item['count'] / $total) * 100, 1) : 0 }}%
                            </span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        let statusChartInstance = null;

        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('projectStatusChart').getContext('2d');

            if (window.statusChartInstance) {
                window.statusChartInstance.destroy();
            }

            window.statusChartInstance = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: @json($statusLabels),
                    datasets: [{
                        data: @json($statusCounts),
                        backgroundColor: ['#0d6efd', '#ffc107', '#28a745'],
                        borderColor: '#fff',
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: ctx => `${ctx.label}: ${ctx.raw} مشروع`
                            }
                        }
                    }
                }
            });
        });
    </script>
@endpush
