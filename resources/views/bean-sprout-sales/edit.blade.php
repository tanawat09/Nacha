@extends('layouts.app')

@section('title', 'แก้ไขรายการ - ขายถั่วงอก')

@section('content')
<div class="row align-items-center mb-4">
    <div class="col-auto">
        <a href="{{ route('bean-sprout-sales.index') }}" class="btn btn-light shadow-sm text-secondary"><i class="fa-solid fa-arrow-left me-1"></i> กลับ</a>
    </div>
    <div class="col">
        <h4 class="fw-bold mb-0">แก้ไขข้อมูล ผลิต/ขาย ถั่วงอก</h4>
    </div>
</div>

<div class="card border-0 shadow-sm p-3 p-md-4 mx-auto" style="max-width: 700px;">
    <form action="{{ route('bean-sprout-sales.update', $beanSproutSale) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row mb-3">
            <div class="col-md-6 mb-3 mb-md-0">
                <label class="form-label fw-medium">วันที่ผลิต <span class="text-danger">*</span></label>
                <input type="date" name="production_date" class="form-control" value="{{ old('production_date', $beanSproutSale->production_date) }}" required>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-medium">ยอดผลิต (กิโลกรัม) <span class="text-danger">*</span></label>
                <input type="number" step="0.01" name="quantity_produced_kg" class="form-control" value="{{ old('quantity_produced_kg', floatval($beanSproutSale->quantity_produced_kg)) }}" required>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6 mb-3 mb-md-0">
                <label class="form-label fw-medium">ต้นทุนต่อกิโลกรัม (บาท) <span class="text-danger">*</span></label>
                <input type="number" step="0.01" name="cost_per_kg" class="form-control" value="{{ old('cost_per_kg', floatval($beanSproutSale->cost_per_kg)) }}" required>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-medium">ราคาขายต่อกิโลกรัม (บาท) <span class="text-danger">*</span></label>
                <input type="number" step="0.01" name="selling_price_per_kg" class="form-control" value="{{ old('selling_price_per_kg', floatval($beanSproutSale->selling_price_per_kg)) }}" required>
            </div>
        </div>

        <div class="mb-5 border-top pt-4 mt-4">
            <label class="form-label fw-bold text-success"><i class="fa-solid fa-basket-shopping me-2"></i>จำนวนที่ขายได้จริง (กิโลกรัม) <span class="text-danger">*</span></label>
            <input type="number" step="0.01" name="quantity_sold_kg" class="form-control form-control-lg bg-light" value="{{ old('quantity_sold_kg', floatval($beanSproutSale->quantity_sold_kg)) }}" required>
            <div class="form-text text-muted">ระบบจะคำนวณกำไร-ขาดทุนใหม่หลังจากอัปเดต</div>
        </div>

        <div class="d-grid">
            <button type="submit" class="btn btn-primary py-3 fw-bold text-uppercase"><i class="fa-solid fa-cloud-arrow-up me-2"></i> อัปเดตข้อมูลรายการ</button>
        </div>
    </form>
</div>
@endsection
