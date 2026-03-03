@extends('layouts.app')

@section('title', 'เพิ่มรายการ - ขายถั่วงอก')

@section('content')
<div class="row align-items-center mb-4">
    <div class="col-auto">
        <a href="{{ route('bean-sprout-sales.index') }}" class="btn btn-light shadow-sm text-secondary"><i class="fa-solid fa-arrow-left me-1"></i> กลับ</a>
    </div>
    <div class="col">
        <h4 class="fw-bold mb-0">บันทึกยอด ผลิต/ขาย ถั่วงอก</h4>
    </div>
</div>

<div class="card border-0 shadow-sm p-3 p-md-4 mx-auto" style="max-width: 700px;">
    <form action="{{ route('bean-sprout-sales.store') }}" method="POST">
        @csrf
        <div class="row mb-3">
            <div class="col-md-6 mb-3 mb-md-0">
                <label class="form-label fw-medium">วันที่ผลิต <span class="text-danger">*</span></label>
                <input type="date" name="production_date" class="form-control" value="{{ old('production_date', date('Y-m-d')) }}" required>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-medium">ยอดผลิต (กิโลกรัม) <span class="text-danger">*</span></label>
                <input type="number" step="0.01" name="quantity_produced_kg" class="form-control" value="{{ old('quantity_produced_kg') }}" placeholder="0.00" required>
            </div>
        </div>

        @php
            $defaultSprout = $products->first();
            $defaultCost = $defaultSprout ? $defaultSprout->cost_per_unit : '';
            $defaultPrice = $defaultSprout ? $defaultSprout->selling_price_per_unit : '';
        @endphp

        <div class="row mb-3">
            <div class="col-md-6 mb-3 mb-md-0">
                <label class="form-label fw-medium">ต้นทุนต่อกิโลกรัม (บาท) <span class="text-danger">*</span></label>
                <input type="number" step="0.01" name="cost_per_kg" class="form-control" value="{{ old('cost_per_kg', $defaultCost) }}" placeholder="0.00" required>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-medium">ราคาขายต่อกิโลกรัม (บาท) <span class="text-danger">*</span></label>
                <input type="number" step="0.01" name="selling_price_per_kg" class="form-control" value="{{ old('selling_price_per_kg', $defaultPrice) }}" placeholder="0.00" required>
            </div>
        </div>

        <div class="mb-5 border-top pt-4 mt-4">
            <label class="form-label fw-bold text-success"><i class="fa-solid fa-basket-shopping me-2"></i>จำนวนที่ขายได้จริง (กิโลกรัม) <span class="text-danger">*</span></label>
            <input type="number" step="0.01" name="quantity_sold_kg" class="form-control form-control-lg bg-light" value="{{ old('quantity_sold_kg', 0) }}" required>
            <div class="form-text text-muted">ระบบจะคำนวณกำไร-ขาดทุนให้โดยอัตโนมัติ</div>
        </div>

        <div class="d-grid">
            <button type="submit" class="btn btn-success py-3 fw-bold text-uppercase"><i class="fa-solid fa-save me-2"></i> บันทึกข้อมูลรายการ</button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    const producedInput = document.querySelector('input[name="quantity_produced_kg"]');
    const soldInput = document.querySelector('input[name="quantity_sold_kg"]');

    // Automatically update the "Quantity Sold" when "Quantity Produced" is typed,
    // ONLY IF the user hasn't manually changed the "Quantity Sold" yet.
    let userEditedSoldQuantity = false;

    soldInput.addEventListener('input', function() {
        userEditedSoldQuantity = true;
    });

    producedInput.addEventListener('input', function(e) {
        if (!userEditedSoldQuantity) {
            soldInput.value = e.target.value;
        }
    });
</script>
@endpush
