@extends('layouts.admin')

@section('header_title', 'Buat Pesanan Baru')

@section('content')
<div class="card" style="max-width: 900px;">
    <div class="flex justify-between items-center mb-6">
        <h2 class="display-md" style="font-size: 20px;">Form Pesanan Toko (Walk-in)</h2>
        <a href="{{ route('admin.orders.index') }}" class="caption text-muted"><i class="fa-solid fa-chevron-left"></i> Kembali</a>
    </div>

    <form action="{{ route('admin.orders.store') }}" method="POST" class="flex-col gap-6">
        @csrf

        <div class="grid grid-cols-2 gap-6">
            <div>
                <label for="customer_name" class="form-label">Nama Pelanggan</label>
                <input type="text" id="customer_name" name="customer_name" class="form-input" value="{{ old('customer_name', 'Pelanggan Toko') }}" required>
                @error('customer_name') <p class="caption text-danger mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="customer_phone" class="form-label">Nomor Telepon (Opsional)</label>
                <input type="text" id="customer_phone" name="customer_phone" class="form-input" value="{{ old('customer_phone') }}">
                @error('customer_phone') <p class="caption text-danger mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div>
            <label class="form-label">Metode Pembayaran</label>
            <div class="flex gap-4 mt-2">
                @foreach(['Virtual Akun', 'Cash', 'E-Wallet', 'Qris'] as $method)
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" name="payment_method" value="{{ $method }}" {{ old('payment_method') == $method || ($loop->first && !old('payment_method')) ? 'checked' : '' }} style="accent-color: var(--primary);">
                        <span class="body-small">{{ $method }}</span>
                    </label>
                @endforeach
            </div>
            @error('payment_method') <p class="caption text-danger mt-1">{{ $message }}</p> @enderror
        </div>

        <hr style="border: 0; border-top: 1px solid var(--hairline);">

        <div>
            <div class="flex justify-between items-center mb-4">
                <h3 class="body-strong">Daftar Produk</h3>
                <button type="button" id="add-product" class="btn btn-secondary" style="padding: 4px 12px; font-size: 12px;">+ Tambah Baris</button>
            </div>

            <!-- Global Product Filter -->
            <div class="flex gap-4 mb-4 p-4 bg-canvas-parchment rounded-lg items-end">
                <div style="flex: 1;">
                    <label class="caption text-muted mb-1 block">Filter Kategori</label>
                    <select id="global-category" class="form-input">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div style="flex: 2;">
                    <label class="caption text-muted mb-1 block">Cari Produk</label>
                    <input type="text" id="global-search" class="form-input" placeholder="Ketik nama buah...">
                </div>
                <div style="flex: 0.5;">
                    <button type="button" id="reset-filter" class="btn btn-utility w-full" style="padding: 10px;"><i class="fa-solid fa-rotate-left"></i></button>
                </div>
            </div>

            <div id="product-list" class="flex-col gap-3">
                <div class="product-row grid grid-cols-12 gap-3 items-end">
                    <div class="col-span-7">
                        <label class="caption text-muted mb-1 block">Pilih Produk</label>
                        <select name="products[0][id]" class="form-input product-select" required>
                            <option value="">-- Pilih --</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}" data-category="{{ $product->category_id }}" data-price="{{ $product->price }}" data-stock="{{ $product->stock }}">{{ $product->name }} (Stok: {{ $product->stock }}) - Rp {{ number_format($product->price, 0, ',', '.') }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-span-3">
                        <label class="caption text-muted mb-1 block">Qty</label>
                        <input type="number" name="products[0][qty]" class="form-input product-qty" value="1" min="1" required>
                    </div>
                    <div class="col-span-2">
                        <button type="button" class="btn btn-danger remove-row w-full" style="padding: 9px; display: none;"><i class="fa-solid fa-trash"></i></button>
                    </div>
                </div>
            </div>
            @error('products') <p class="caption text-danger mt-4">{{ $message }}</p> @enderror
        </div>

        <div class="flex justify-between items-center p-4 bg-canvas-parchment rounded-lg mt-4">
            <span class="display-sm" style="font-size: 18px;">Total Bayar:</span>
            <span id="grand-total" class="display-md" style="color: var(--primary);">Rp 0</span>
        </div>

        <button type="submit" class="btn btn-primary mt-4" style="padding: 12px;">Simpan dan Selesaikan Pesanan</button>
    </form>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const productList = document.getElementById('product-list');
        const addButton = document.getElementById('add-product');
        const grandTotalEl = document.getElementById('grand-total');
        const globalCategory = document.getElementById('global-category');
        const globalSearch = document.getElementById('global-search');
        const resetFilter = document.getElementById('reset-filter');
        
        // Store all products for filtering
        const allProducts = @json($products);
        let rowCount = 1;

        function updateProductOptions(selectEl) {
            const currentVal = selectEl.value;
            const catId = globalCategory.value;
            const search = globalSearch.value.toLowerCase();

            // Clear options except first
            const firstOption = selectEl.options[0];
            selectEl.innerHTML = '';
            selectEl.appendChild(firstOption);

            allProducts.forEach(product => {
                const matchesCategory = !catId || product.category_id == catId;
                const matchesSearch = !search || product.name.toLowerCase().includes(search);

                if (matchesCategory && matchesSearch) {
                    const opt = document.createElement('option');
                    opt.value = product.id;
                    opt.dataset.category = product.category_id;
                    opt.dataset.price = product.price;
                    opt.dataset.stock = product.stock;
                    opt.textContent = `${product.name} (Stok: ${product.stock}) - Rp ${new Intl.NumberFormat('id-ID').format(product.price)}`;
                    if (product.id == currentVal) opt.selected = true;
                    selectEl.appendChild(opt);
                }
            });
            
            // If current value is not in filtered list but was selected, re-add it or keep it
            if (currentVal && !selectEl.value) {
                const product = allProducts.find(p => p.id == currentVal);
                if (product) {
                    const opt = document.createElement('option');
                    opt.value = product.id;
                    opt.dataset.category = product.category_id;
                    opt.dataset.price = product.price;
                    opt.dataset.stock = product.stock;
                    opt.textContent = `${product.name} (Stok: ${product.stock}) - Rp ${new Intl.NumberFormat('id-ID').format(product.price)}`;
                    opt.selected = true;
                    selectEl.appendChild(opt);
                }
            }
        }

        function applyFilters() {
            document.querySelectorAll('.product-select').forEach(select => {
                updateProductOptions(select);
            });
            calculateTotal();
        }

        function calculateTotal() {
            let total = 0;
            document.querySelectorAll('.product-row').forEach(row => {
                const select = row.querySelector('.product-select');
                const qtyInput = row.querySelector('.product-qty');
                const option = select.options[select.selectedIndex];
                
                if (option && option.value) {
                    const price = parseFloat(option.dataset.price);
                    const qty = parseInt(qtyInput.value) || 0;
                    total += price * qty;
                }
            });
            grandTotalEl.innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(total);
        }

        addButton.addEventListener('click', function() {
            const firstRow = document.querySelector('.product-row');
            const newRow = firstRow.cloneNode(true);
            
            const select = newRow.querySelector('.product-select');
            const qtyInput = newRow.querySelector('.product-qty');
            
            select.name = `products[${rowCount}][id]`;
            qtyInput.name = `products[${rowCount}][qty]`;
            select.value = '';
            qtyInput.value = 1;
            
            const removeBtn = newRow.querySelector('.remove-row');
            removeBtn.style.display = 'block';
            
            productList.appendChild(newRow);
            rowCount++;
            
            updateProductOptions(select);
            attachListeners(newRow);
        });

        function attachListeners(row) {
            row.querySelector('.product-select').addEventListener('change', calculateTotal);
            row.querySelector('.product-qty').addEventListener('input', calculateTotal);
            row.querySelector('.remove-row').addEventListener('click', function() {
                row.remove();
                calculateTotal();
            });
        }

        globalCategory.addEventListener('change', applyFilters);
        globalSearch.addEventListener('input', applyFilters);
        resetFilter.addEventListener('click', function() {
            globalCategory.value = '';
            globalSearch.value = '';
            applyFilters();
        });

        attachListeners(document.querySelector('.product-row'));
        calculateTotal();
    });
</script>
@endpush
@endsection
