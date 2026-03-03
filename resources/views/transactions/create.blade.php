@extends('layouts.app')

@section('title', 'เพิ่มรายการ - รายรับรายจ่าย')

@section('content')
<div class="row align-items-center mb-4">
    <div class="col-auto">
        <a href="{{ route('transactions.index') }}" class="btn btn-light shadow-sm text-secondary"><i class="fa-solid fa-arrow-left me-1"></i> กลับ</a>
    </div>
    <div class="col">
        <h4 class="fw-bold mb-0">เพิ่มรายการรายรับ-รายจ่าย</h4>
    </div>
</div>

<div class="card border-0 shadow-sm p-3 p-md-4 mx-auto" style="max-width: 600px;">
    <form action="{{ route('transactions.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label fw-medium">วันที่รายการ <span class="text-danger">*</span></label>
            <input type="date" name="transaction_date" class="form-control" value="{{ old('transaction_date', date('Y-m-d')) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label fw-medium">ประเภท <span class="text-danger">*</span></label>
            <select name="type" class="form-select" required>
                <option value="income" {{ old('type') == 'income' ? 'selected' : '' }}>รายรับ (Income)</option>
                <option value="expense" {{ old('type') == 'expense' ? 'selected' : '' }}>รายจ่าย (Expense)</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label fw-medium">หมวดหมู่ <span class="text-danger">*</span></label>
            <input type="text" name="category" class="form-control" value="{{ old('category') }}" placeholder="เช่น ค่าอาหาร, ขายของ, ค่าน้ำมัน..." required>
        </div>

        <div class="mb-3">
            <label class="form-label fw-medium">จำนวนเงิน (บาท) <span class="text-danger">*</span></label>
            <input type="number" step="0.01" name="amount" class="form-control" value="{{ old('amount') }}" placeholder="0.00" required>
        </div>

        <div class="mb-4">
            <label class="form-label fw-medium">หมายเหตุ (เพิ่มเติม)</label>
            <textarea name="note" class="form-control" rows="3">{{ old('note') }}</textarea>
        </div>

        <div class="d-grid">
            <button type="submit" class="btn btn-primary py-2 fw-semibold">บันทึกข้อมูล</button>
        </div>
    </form>
</div>
@endsection
