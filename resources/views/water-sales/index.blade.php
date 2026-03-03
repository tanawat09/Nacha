@extends('layouts.app')

@section('title', 'ระบบขายน้ำ')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold"><i class="fa-solid fa-bottle-water text-primary me-2"></i>ระบบบันทึกการขายน้ำ</h3>
    <a href="{{ route('water-sales.create') }}" class="btn btn-primary fw-semibold"><i class="fa-solid fa-plus me-1"></i> เพิ่มรายการใหม่</a>
</div>

<!-- Summary Cards -->
<div class="row mb-4">
    <div class="col-md-4 mb-3 mb-md-0">
        <div class="card bg-success text-white border-0 shadow-sm h-100">
            <div class="card-body py-4">
                <h6 class="text-uppercase fw-semibold mb-2"><i class="fa-solid fa-coins me-2"></i>ยอดขายรวม (ก่อนหักทุน)</h6>
                <h3 class="fw-bold mb-0">฿{{ number_format($totalRevenue, 2) }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-warning text-dark border-0 shadow-sm h-100">
            <div class="card-body py-4">
                <h6 class="text-uppercase fw-semibold mb-2"><i class="fa-solid fa-money-bill-trend-up me-2"></i>กำไรสะสมรวม (น้ำดื่ม)</h6>
                <h3 class="fw-bold mb-0">฿{{ number_format($totalProfit, 2) }}</h3>
            </div>
        </div>
    </div>
</div>

<!-- Filter Form -->
<form action="{{ route('water-sales.index') }}" method="GET" class="card p-3 mb-4 shadow-sm border-0">
    <div class="row g-3 align-items-end">
        <div class="col-12 col-md-4">
            <label class="form-label mb-1 text-muted small">ตั้งแต่วันที่ขาย</label>
            <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
        </div>
        <div class="col-12 col-md-4">
            <label class="form-label mb-1 text-muted small">ถึงวันที่</label>
            <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
        </div>
        <div class="col-12 col-md-4">
            <div class="d-grid d-md-block gap-2">
                <button type="submit" class="btn btn-secondary px-4"><i class="fa-solid fa-filter me-1"></i> ค้นหา</button>
                <a href="{{ route('water-sales.index') }}" class="btn btn-light"><i class="fa-solid fa-rotate-right me-1"></i> ล้างค่า</a>
            </div>
        </div>
    </div>
</form>

<div class="card p-0 shadow-sm border-0">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0 text-center text-nowrap">
            <thead class="bg-light text-muted">
                <tr>
                    <th class="ps-4 text-start">วันที่ขาย</th>
                    <th class="text-start">ประเภทน้ำ</th>
                    <th>ต้นทุน (฿/หน่วย)</th>
                    <th>ราคาขาย (฿/หน่วย)</th>
                    <th>จำนวนขาย</th>
                    <th class="text-success fw-bold">ยอดขาย (฿)</th>
                    <th class="text-warning fw-bold bg-dark text-white rounded-end" style="width:150px">กำไร (฿)</th>
                    <th class="pe-4" style="width: 120px;">จัดการ</th>
                </tr>
            </thead>
            <tbody>
                @forelse($sales as $sale)
                <tr>
                    <td class="ps-4 text-start fw-medium">{{ \Carbon\Carbon::parse($sale->sale_date)->format('d/m/Y') }}</td>
                    <td class="text-start">
                        <span class="badge bg-secondary px-2 py-1"><i class="fa-solid fa-bottle-droplet me-1"></i> {{ $sale->product_type }}</span>
                    </td>
                    <td>{{ number_format($sale->cost_per_unit, 2) }}</td>
                    <td>{{ number_format($sale->selling_price_per_unit, 2) }}</td>
                    <td class="fw-bold">{{ number_format($sale->quantity_sold) }}</td>
                    <td class="fw-bold text-success">{{ number_format($sale->total_revenue, 2) }}</td>
                    <td class="fw-bold fs-6 {{ $sale->profit >= 0 ? 'text-success' : 'text-danger' }}">
                        {{ number_format($sale->profit, 2) }}
                    </td>
                    <td class="pe-4">
                        <a href="{{ route('water-sales.edit', $sale) }}" class="btn btn-sm btn-outline-primary"><i class="fa-solid fa-pen"></i></a>
                        <form action="{{ route('water-sales.destroy', $sale) }}" method="POST" class="d-inline" onsubmit="return confirm('ยืนยันการลบรายการนี้?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-5">
                        <i class="fa-solid fa-folder-open fa-3x mb-3 text-light"></i><br>ไม่มีข้อมูลรายการขายน้ำ
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-4 d-flex justify-content-center">
    {{ $sales->links('pagination::bootstrap-5') }}
</div>
@endsection
