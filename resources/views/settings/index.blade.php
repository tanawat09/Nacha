@extends('layouts.app')

@section('title', 'การตั้งค่าระบบ')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h3 class="fw-bold"><i class="fa-solid fa-gear text-secondary me-2"></i>การตั้งค่าระบบ</h3>
        <p class="text-muted">กำหนดราคาต้นทุน ราคาขาย และควบคุมสต๊อกน้ำเริ่มต้น</p>
    </div>
</div>

<div class="card border-0 shadow-sm p-4 mx-auto" style="max-width: 900px;">
    <form action="{{ route('settings.store') }}" method="POST">
        @csrf

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="fw-bold text-primary mb-0"><i class="fa-solid fa-boxes-stacked me-2"></i>จัดการสินค้า (ถั่วงอก / น้ำดื่ม)</h5>
            <button type="button" class="btn btn-sm btn-outline-primary" id="addProductBtn"><i class="fa-solid fa-plus"></i> เพิ่มสินค้าใหม่</button>
        </div>

        <div class="table-responsive border rounded mb-4">
            <table class="table table-bordered align-middle mb-0 text-nowrap" id="productsTable">
                <thead class="bg-light text-muted text-center">
                    <tr>
                        <th style="min-width: 120px;">หมวดหมู่</th>
                        <th style="min-width: 180px;">ชื่อสินค้า <span class="text-danger">*</span></th>
                        <th style="min-width: 120px;">ต้นทุน (฿)</th>
                        <th style="min-width: 120px;">ราคาขาย (฿)</th>
                        <th style="min-width: 120px;">สต๊อกปัจจุบัน</th>
                        <th style="min-width: 80px;">ลบ</th>
                    </tr>
                </thead>
                <tbody id="productsBody">
                    @foreach($products as $index => $p)
                    <tr>
                        <td>
                            <input type="hidden" name="products[{{ $index }}][id]" value="{{ $p->id }}">
                            <select name="products[{{ $index }}][category]" class="form-select form-select-sm">
                                <option value="sprout" {{ $p->category == 'sprout' ? 'selected' : '' }}>ถั่วงอก</option>
                                <option value="water" {{ $p->category == 'water' ? 'selected' : '' }}>น้ำดื่ม</option>
                                <option value="other" {{ $p->category == 'other' ? 'selected' : '' }}>อื่นๆ</option>
                            </select>
                        </td>
                        <td><input type="text" name="products[{{ $index }}][name]" class="form-control form-control-sm" value="{{ $p->name }}" required></td>
                        <td><input type="number" step="0.01" name="products[{{ $index }}][cost_per_unit]" class="form-control form-control-sm text-end" value="{{ $p->cost_per_unit }}"></td>
                        <td><input type="number" step="0.01" name="products[{{ $index }}][selling_price_per_unit]" class="form-control form-control-sm text-end" value="{{ $p->selling_price_per_unit }}"></td>
                        <td><input type="number" name="products[{{ $index }}][stock]" class="form-control form-control-sm text-end text-danger fw-bold" value="{{ $p->stock }}"></td>
                        <td class="text-center"><button type="button" class="btn btn-sm btn-danger remove-row"><i class="fa-solid fa-trash"></i></button></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="d-grid mt-4">
            <button type="submit" class="btn btn-dark py-3 fw-bold text-uppercase"><i class="fa-solid fa-save me-2"></i> บันทึกข้อมูลและสินค้าทั้งหมด</button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    let rowIndex = {{ count($products) }};

    document.getElementById('addProductBtn').addEventListener('click', function() {
        const tbody = document.getElementById('productsBody');
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td>
                <select name="products[${rowIndex}][category]" class="form-select form-select-sm">
                    <option value="water">น้ำดื่ม</option>
                    <option value="sprout">ถั่วงอก</option>
                    <option value="other">อื่นๆ</option>
                </select>
            </td>
            <td><input type="text" name="products[${rowIndex}][name]" class="form-control form-control-sm" required placeholder="ชื่อสินค้าใหม่"></td>
            <td><input type="number" step="0.01" name="products[${rowIndex}][cost_per_unit]" class="form-control form-control-sm text-end" value="0"></td>
            <td><input type="number" step="0.01" name="products[${rowIndex}][selling_price_per_unit]" class="form-control form-control-sm text-end" value="0"></td>
            <td><input type="number" name="products[${rowIndex}][stock]" class="form-control form-control-sm text-end fw-bold" value="0"></td>
            <td class="text-center"><button type="button" class="btn btn-sm btn-danger remove-row"><i class="fa-solid fa-trash"></i></button></td>
        `;
        tbody.appendChild(tr);
        rowIndex++;
    });

    document.getElementById('productsBody').addEventListener('click', function(e) {
        if(e.target.closest('.remove-row')) {
            if(confirm('ยืนยันการลบสินค้านี้?')) {
                e.target.closest('tr').remove();
            }
        }
    });
</script>
@endpush
