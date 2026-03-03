@extends('layouts.app')

@section('title', 'รายรับ-รายจ่าย')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold"><i class="fa-solid fa-wallet text-primary me-2"></i>ระบบบันทึกรายรับ-รายจ่าย</h3>
    <a href="{{ route('transactions.create') }}" class="btn btn-primary fw-semibold"><i class="fa-solid fa-plus me-1"></i> เพิ่มรายการใหม่</a>
</div>

<!-- Summary Cards -->
<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="card bg-success text-white border-0 h-100">
            <div class="card-body">
                <h6 class="text-uppercase fw-semibold mb-2"><i class="fa-solid fa-arrow-down-short-wide me-2"></i>รายรับรวม</h6>
                <h4 class="fw-bold mb-0">฿{{ number_format($totalIncome, 2) }}</h4>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-danger text-white border-0 h-100">
            <div class="card-body">
                <h6 class="text-uppercase fw-semibold mb-2"><i class="fa-solid fa-arrow-up-short-wide me-2"></i>รายจ่ายรวม</h6>
                <h4 class="fw-bold mb-0">฿{{ number_format($totalExpense, 2) }}</h4>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-{{ $profit >= 0 ? 'info' : 'warning' }} text-white border-0 h-100">
            <div class="card-body">
                <h6 class="text-uppercase fw-semibold mb-2"><i class="fa-solid fa-scale-balanced me-2"></i>คงเหลือ / กำไร</h6>
                <h4 class="fw-bold mb-0">฿{{ number_format($profit, 2) }}</h4>
            </div>
        </div>
    </div>
</div>

<!-- Filter Form -->
<form action="{{ route('transactions.index') }}" method="GET" class="card p-3 mb-4">
    <div class="row g-3 align-items-end">
        <div class="col-12 col-md-4">
            <label class="form-label mb-1 text-muted small">ตั้งแต่วันที่</label>
            <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
        </div>
        <div class="col-12 col-md-4">
            <label class="form-label mb-1 text-muted small">ถึงวันที่</label>
            <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
        </div>
        <div class="col-12 col-md-4">
            <div class="d-grid d-md-block gap-2">
                <button type="submit" class="btn btn-secondary px-4"><i class="fa-solid fa-filter me-1"></i> ค้นหา</button>
                <a href="{{ route('transactions.index') }}" class="btn btn-light"><i class="fa-solid fa-rotate-right me-1"></i> ล้างค่า</a>
            </div>
        </div>
    </div>
</form>

<div class="card p-0 shadow-sm border-0">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="bg-light text-muted">
                <tr>
                    <th class="ps-4">วันที่</th>
                    <th>ประเภท</th>
                    <th>หมวดหมู่</th>
                    <th>หมายเหตุ</th>
                    <th class="text-end">จำนวนเงิน (฿)</th>
                    <th class="text-center pe-4" style="width: 150px;">จัดการ</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transactions as $tx)
                <tr>
                    <td class="ps-4">{{ \Carbon\Carbon::parse($tx->transaction_date)->format('d/m/Y') }}</td>
                    <td>
                        @if($tx->type === 'income')
                            <span class="badge bg-success text-white px-2 py-1"><i class="fa-solid fa-arrow-down me-1"></i> รายรับ</span>
                        @else
                            <span class="badge bg-danger text-white px-2 py-1"><i class="fa-solid fa-arrow-up me-1"></i> รายจ่าย</span>
                        @endif
                    </td>
                    <td class="fw-medium">{{ $tx->category }}</td>
                    <td class="text-muted small">{{ $tx->note ?? '-' }}</td>
                    <td class="text-end fw-bold {{ $tx->type === 'income' ? 'text-success' : 'text-danger' }}">
                        {{ $tx->type === 'income' ? '+' : '-' }}{{ number_format($tx->amount, 2) }}
                    </td>
                    <td class="text-center pe-4">
                        <a href="{{ route('transactions.edit', $tx) }}" class="btn btn-sm btn-outline-primary"><i class="fa-solid fa-pen"></i></a>
                        <form action="{{ route('transactions.destroy', $tx) }}" method="POST" class="d-inline" onsubmit="return confirm('ยืนยันการลบรายการนี้?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-5">
                        <i class="fa-solid fa-folder-open fa-3x mb-3 text-light"></i><br>ไม่มีข้อมูลรายการ
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-4 d-flex justify-content-center">
    {{ $transactions->links('pagination::bootstrap-5') }}
</div>
@endsection
