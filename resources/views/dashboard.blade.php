@extends('layouts.app')

@section('title', 'หน้าแรก - แดชบอร์ด')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h3 class="fw-bold text-dark"><i class="fa-solid fa-chart-pie text-primary me-2"></i>ภาพรวมวันนี้ ({{ \Carbon\Carbon::now()->translatedFormat('d F Y') }})</h3>
        <p class="text-muted">สรุปยอดรวมประจำวัน สำหรับรายรับรายจ่าย ถั่วงอก และขายน้ำ</p>
    </div>
</div>

<div class="row g-4 mb-5">
    <!-- Daily Income/Expense -->
    <div class="col-md-3">
        <div class="card bg-white h-100 border-start border-success border-4">
            <div class="card-body">
                <h6 class="text-muted text-uppercase fw-semibold mb-2">รายรับวันนี้</h6>
                <h3 class="text-success fw-bold mb-0">฿{{ number_format($dailyIncome, 2) }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-white h-100 border-start border-danger border-4">
            <div class="card-body">
                <h6 class="text-muted text-uppercase fw-semibold mb-2">รายจ่ายวันนี้</h6>
                <h3 class="text-danger fw-bold mb-0">฿{{ number_format($dailyExpense, 2) }}</h3>
            </div>
        </div>
    </div>

    <!-- Daily Profit -->
    <div class="col-md-3">
        <div class="card bg-white h-100 border-start border-info border-4">
            <div class="card-body">
                <h6 class="text-muted text-uppercase fw-semibold mb-2">กำไร ถั่วงอก (วันนี้)</h6>
                <h3 class="text-info fw-bold mb-0">฿{{ number_format($dailySproutProfit, 2) }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-white h-100 border-start border-warning border-4">
            <div class="card-body">
                <h6 class="text-muted text-uppercase fw-semibold mb-2">กำไร น้ำดื่ม (วันนี้)</h6>
                <h3 class="text-warning fw-bold mb-0">฿{{ number_format($dailyWaterProfit, 2) }}</h3>
            </div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-12">
        <h4 class="fw-bold text-dark"><i class="fa-solid fa-calendar-days text-primary me-2"></i>สรุปยอดรายเดือน ({{ \Carbon\Carbon::now()->translatedFormat('F Y') }})</h4>
    </div>
</div>

<div class="row g-3 g-md-4 mb-5">
    <div class="col-6 col-md-3">
        <div class="card bg-success text-white">
            <div class="card-body p-3 p-md-4">
                <h6 class="text-uppercase fw-semibold mb-2" style="font-size: 0.85rem;"><i class="fa-solid fa-arrow-up me-1"></i>รายรับรวม</h6>
                <h5 class="fw-bold mb-0">฿{{ number_format($monthlyIncome, 0) }}</h5>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card bg-danger text-white">
            <div class="card-body p-3 p-md-4">
                <h6 class="text-uppercase fw-semibold mb-2" style="font-size: 0.85rem;"><i class="fa-solid fa-arrow-down me-1"></i>รายจ่ายรวม</h6>
                <h5 class="fw-bold mb-0">฿{{ number_format($monthlyExpense, 0) }}</h5>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card bg-info text-white">
            <div class="card-body p-3 p-md-4">
                <h6 class="text-uppercase fw-semibold mb-2" style="font-size: 0.85rem;"><i class="fa-solid fa-seedling me-1"></i>กำไรถั่วงอก</h6>
                <h5 class="fw-bold mb-0">฿{{ number_format($monthlySproutProfit, 0) }}</h5>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card bg-warning text-dark">
            <div class="card-body p-3 p-md-4">
                <h6 class="text-uppercase fw-semibold mb-2" style="font-size: 0.85rem;"><i class="fa-solid fa-bottle-water me-1"></i>กำไรน้ำดื่ม</h6>
                <h5 class="fw-bold mb-0">฿{{ number_format($monthlyWaterProfit, 0) }}</h5>
            </div>
        </div>
    </div>
</div>

<!-- Chart Section -->
<div class="row">
    <div class="col-12">
        <div class="card p-4">
            <h5 class="fw-bold mb-4 text-center">กราฟแสดงรายรับ-รายจ่ายย้อนหลัง 7 วัน</h5>
            <canvas id="incomeExpenseChart" height="100"></canvas>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const canvas = document.getElementById('incomeExpenseChart');
        if (!canvas) return;
        
        const ctx = canvas.getContext('2d');
        
        // Reverse arrays to show oldest first on the left
        const labels = {!! json_encode(array_reverse($chartDates)) !!};
        const incomeData = {!! json_encode(array_reverse($chartIncome)) !!};
        const expenseData = {!! json_encode(array_reverse($chartExpense)) !!};

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'รายรับ',
                        data: incomeData,
                        backgroundColor: 'rgba(25, 135, 84, 0.8)', // Bootstrap success
                        borderRadius: 4
                    },
                    {
                        label: 'รายจ่าย',
                        data: expenseData,
                        backgroundColor: 'rgba(220, 53, 69, 0.8)', // Bootstrap danger
                        borderRadius: 4
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return '฿' + value;
                            }
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed.y !== null) {
                                    label += new Intl.NumberFormat('en-US', { style: 'currency', currency: 'THB' }).format(context.parsed.y);
                                }
                                return label;
                            }
                        }
                    }
                }
            }
        });
    });
</script>
@endpush
