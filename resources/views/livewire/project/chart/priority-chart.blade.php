<div class="card border-0 shadow-sm rounded-4">
    <!-- 🟦 هيدر فاخر -->
    <div class="card-header border-0 rounded-top-4"
        style="background: linear-gradient(135deg, #6610f2, #0dcaf0); box-shadow: inset 0 -1px 0 rgba(255,255,255,0.1);">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="card-title text-white fw-bold mb-0">
                <i class="las la-layer-group me-2 fs-4"></i>
                أولوية المشاريع
            </h4>
        </div>
        <small class="text-white mt-1 d-block">تحليل مرئي لأولويات مشاريعك</small>
    </div>

    <!-- 🎯 المحتوى -->
    <div class="card-body">
        <div class="row align-items-center">
            <!-- 🎨 الرسم -->
            <div class="col-md-5 text-center mb-3 mb-md-0">
                <canvas id="priorityChartCanvas" style="width: 120px;height: 120px;"></canvas>
            </div>

            <!-- 📊 الملخص -->
            <div class="col-md-7">
                @php use Carbon\Carbon; @endphp
                @if ($firstDate && $lastDate)
                    <h6 class="bg-light text-muted p-2 rounded-3 d-flex align-items-center justify-content-center mb-3">
                        <i class="las la-calendar-day me-1"></i>
                        {{ Carbon::parse($firstDate)->translatedFormat('Y-m') }}
                        إلى
                        {{ Carbon::parse($lastDate)->translatedFormat('Y-m') }}
                    </h6>
                @else
                    <h6 class="bg-light text-muted p-2 rounded-3 text-center mb-3">
                        <i class="las la-calendar-day me-1"></i>
                        لا توجد بيانات حالياً
                    </h6>
                @endif

                @php
                    $total = array_sum($priorityCounts);
                    $icons = ['la la-arrow-down', 'la la-adjust', 'la la-arrow-up'];
                    $colors = ['info', 'primary', 'danger'];
                @endphp

                <ul class="list-group shadow-sm rounded-4 overflow-hidden">
                    @foreach ($prioritySummary as $i => $item)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <i class="{{ $icons[$i % count($icons)] }} text-muted font-16 me-2"></i>
                                <span class="fw-semibold">{{ $item['label'] }}</span>
                            </div>
                            <span class="badge badge-outline-{{ $colors[$i % count($colors)] }} badge-pill">
                                {{ $item['count'] }} مشروع -
                                {{ $total ? round(($item['count'] / $total) * 100, 1) : 0 }}%
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
        let priorityChartInstance = null;

        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('priorityChartCanvas').getContext('2d');

            if (window.priorityChartInstance) {
                window.priorityChartInstance.destroy();
            }

            window.priorityChartInstance = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: @json($priorityLabels),
                    datasets: [{
                        data: @json($priorityCounts),
                        backgroundColor: ['#0dcaf0', '#0d6efd', '#dc3545'],
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
