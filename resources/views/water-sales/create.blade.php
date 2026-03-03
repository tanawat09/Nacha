@extends('layouts.app')

@section('title', 'เพิ่มรายการ - ขายน้ำ')

@section('content')
<div class="row align-items-center mb-4">
    <div class="col-auto">
        <a href="{{ route('water-sales.index') }}" class="btn btn-light shadow-sm text-secondary"><i class="fa-solid fa-arrow-left me-1"></i> กลับ</a>
    </div>
    <div class="col">
        <h4 class="fw-bold mb-0">บันทึกยอด ขายน้ำ</h4>
    </div>
</div>

<div class="card border-0 shadow-sm p-3 p-md-4 mx-auto" style="max-width: 600px;">
    <form action="{{ route('water-sales.store') }}" method="POST">
        @csrf
        
        <div class="mb-3">
            <label class="form-label fw-medium">วันที่ขาย <span class="text-danger">*</span></label>
            <input type="date" name="sale_date" class="form-control" value="{{ old('sale_date', date('Y-m-d')) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label fw-medium">ประเภทน้ำ <span class="text-danger">*</span></label>
            <select name="product_type" class="form-select" required>
                <option value="">-- เลือกประเภทน้ำ --</option>
                @foreach($products as $p)
                    <option value="{{ $p->name }}" data-cost="{{ $p->cost_per_unit }}" data-price="{{ $p->selling_price_per_unit }}">{{ $p->name }} (สต๊อก: {{ $p->stock }})</option>
                @endforeach
            </select>
        </div>

        <div class="row mb-3">
            <div class="col-md-6 mb-3 mb-md-0">
                <label class="form-label fw-medium">ต้นทุน (บาท/หน่วย) <span class="text-danger">*</span></label>
                <input type="number" step="0.01" name="cost_per_unit" class="form-control" value="{{ old('cost_per_unit') }}" placeholder="0.00" required>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-medium">ราคาขาย (บาท/หน่วย) <span class="text-danger">*</span></label>
                <input type="number" step="0.01" name="selling_price_per_unit" class="form-control" value="{{ old('selling_price_per_unit') }}" placeholder="0.00" required>
            </div>
        </div>

        <div class="mb-4">
            <label class="form-label fw-bold"><i class="fa-solid fa-cart-shopping me-2"></i>จำนวนที่ขายได้ (ขวด/ถัง) <span class="text-danger">*</span></label>
            <input type="number" name="quantity_sold" class="form-control form-control-lg bg-light" value="{{ old('quantity_sold', 0) }}" required>
            <div class="form-text text-muted">กรอกเป็นจำนวนเต็ม ระบบจะคำนวณกำไร-ขาดทุนอัตโนมัติ</div>
        </div>

        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary py-3 fw-bold text-uppercase"><i class="fa-solid fa-save me-2"></i> บันทึกข้อมูลรายการ</button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    document.querySelector('select[name="product_type"]').addEventListener('change', function(e) {
        const selectedOption = e.target.options[e.target.selectedIndex];
        
        if (selectedOption.value) {
            document.querySelector('input[name="cost_per_unit"]').value = selectedOption.dataset.cost;
            document.querySelector('input[name="selling_price_per_unit"]').value = selectedOption.dataset.price;
        } else {
            document.querySelector('input[name="cost_per_unit"]').value = '';
            document.querySelector('input[name="selling_price_per_unit"]').value = '';
        }
    });
</script>
@endpush
