@extends('layouts.app')

@section('title', 'แก้ไขรายการ - ขายน้ำ')

@section('content')
<div class="row align-items-center mb-4">
    <div class="col-auto">
        <a href="{{ route('water-sales.index') }}" class="btn btn-light shadow-sm text-secondary"><i class="fa-solid fa-arrow-left me-1"></i> กลับ</a>
    </div>
    <div class="col">
        <h4 class="fw-bold mb-0">แก้ไขข้อมูล ขายน้ำ</h4>
    </div>
</div>

<div class="card border-0 shadow-sm p-4 mx-auto" style="max-width: 600px;">
    <form action="{{ route('water-sales.update', $waterSale) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="mb-3">
            <label class="form-label fw-medium">วันที่ขาย <span class="text-danger">*</span></label>
            <input type="date" name="sale_date" class="form-control" value="{{ old('sale_date', $waterSale->sale_date) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label fw-medium">ประเภทน้ำ (ขวดเล็ก, ขวดใหญ่, ถัง) <span class="text-danger">*</span></label>
            <input type="text" name="product_type" class="form-control" value="{{ old('product_type', $waterSale->product_type) }}" list="waterTypes" required>
            <datalist id="waterTypes">
                <option value="ขวดเล็ก">
                <option value="ขวดใหญ่">
                <option value="แบบถัง">
            </datalist>
        </div>

        <div class="row mb-3">
            <div class="col-md-6 mb-3 mb-md-0">
                <label class="form-label fw-medium">ต้นทุน (บาท/หน่วย) <span class="text-danger">*</span></label>
                <input type="number" step="0.01" name="cost_per_unit" class="form-control" value="{{ old('cost_per_unit', floatval($waterSale->cost_per_unit)) }}" required>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-medium">ราคาขาย (บาท/หน่วย) <span class="text-danger">*</span></label>
                <input type="number" step="0.01" name="selling_price_per_unit" class="form-control" value="{{ old('selling_price_per_unit', floatval($waterSale->selling_price_per_unit)) }}" required>
            </div>
        </div>

        <div class="mb-4">
            <label class="form-label fw-bold"><i class="fa-solid fa-cart-shopping me-2"></i>จำนวนที่ขายได้ (ขวด/ถัง) <span class="text-danger">*</span></label>
            <input type="number" name="quantity_sold" class="form-control form-control-lg bg-light" value="{{ old('quantity_sold', $waterSale->quantity_sold) }}" required>
            <div class="form-text text-muted">กรอกเป็นจำนวนเต็ม ระบบจะคำนวณกำไรใหม่หลังจากอัปเดต</div>
        </div>

        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-dark py-3 fw-bold text-uppercase"><i class="fa-solid fa-cloud-arrow-up me-2"></i> อัปเดตข้อมูลรายการ</button>
        </div>
    </form>
</div>
@endsection
