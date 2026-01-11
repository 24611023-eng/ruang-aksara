@extends('layouts.app')

@section('title', 'Biaya Operasional - Ruang Aksara')

@section('content')
<div class="max-w-6xl mx-auto py-6">
    <!-- Header -->
    <div class="text-white rounded-2xl p-8 border-2 mb-8" style="background: rgba(45, 90, 61, 0.4); backdrop-filter: blur(15px); border-color: rgba(163, 230, 53, 0.3);">
        <div class="flex flex-col items-center justify-center gap-3">
            <h1 class="text-5xl font-bold" style="color: #a3e635;">💰 Biaya Operasional</h1>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
        <div class="col-span-3 bg-white rounded-lg shadow-md p-4">
            <div class="flex items-center justify-between mb-3">
                <h2 class="font-bold text-gray-800">Daftar Biaya Operasional</h2>
                <div class="flex items-center gap-3 flex-wrap">
                    <form method="GET" action="{{ route('admin.operational-costs') }}" class="flex items-center gap-2">
                        <input type="date" name="start_date" value="{{ request('start_date') ?? $start_date ?? '' }}" class="form-input" style="width:150px">
                        <input type="date" name="end_date" value="{{ request('end_date') ?? $end_date ?? '' }}" class="form-input" style="width:150px">
                        <button type="submit" class="px-3 py-2 bg-gray-200 rounded text-sm">Filter</button>
                        <a href="{{ route('admin.operational-costs') }}" class="px-3 py-2 text-sm text-gray-600">Reset</a>
                        <button id="export-btn" type="button" class="px-3 py-2 bg-blue-600 text-white rounded text-sm">Ekspor</button>
                    </form>

                    <form id="cost-form" method="POST" action="{{ route('admin.operational-costs.store') }}" class="flex items-center gap-2">
                        @csrf
                        <input id="form-date" name="date" type="date" class="form-input" style="width:160px" value="{{ date('Y-m-d') }}">
                        <input id="form-item" name="item" placeholder="Item singkat" class="form-input" style="width:200px" required>
                        <input id="form-amount" name="amount" placeholder="Jumlah (Rp)" class="form-input" style="width:140px" required>
                        <input id="form-category" name="category" type="hidden">
                        <button id="form-submit" type="submit" class="px-4 py-2 bg-green-700 text-white rounded">Tambah</button>
                        <button id="form-cancel" type="button" class="px-3 py-2 text-sm text-gray-600 hidden">Batal</button>
                    </form>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="text-xs text-gray-500 uppercase border-b">
                            <th class="py-2">Tanggal</th>
                            <th class="py-2">Item</th>
                            <th class="py-2">Kategori</th>
                            <th class="py-2">Jumlah</th>
                            <!-- Terkait Buku column removed -->
                            <th class="py-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($costs as $cost)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-2 align-top text-xs text-gray-600">{{ $cost->created_at->format('Y-m-d') }}</td>
                            <td class="py-2 align-top">{{ $cost->item }}</td>
                            <td class="py-2 align-top text-xs text-gray-600">{{ $cost->category }}</td>
                            <td class="py-2 align-top font-semibold">Rp {{ number_format($cost->amount,0,',','.') }}</td>
                            <td class="py-2 align-top text-xs">
                                <button data-id="{{ $cost->id }}" data-item="{{ e($cost->item) }}" data-amount="{{ $cost->amount }}" data-category="{{ e($cost->category) }}" data-date="{{ $cost->created_at->format('Y-m-d') }}" class="text-blue-600 mr-2 btn-edit">Edit</button>
                                <form method="POST" action="{{ route('admin.operational-costs.destroy', $cost) }}" class="inline-block" onsubmit="return confirm('Hapus biaya ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-600">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                        <tr class="bg-gray-100 font-bold">
                            <td class="py-2">Total</td>
                            <td class="py-2"></td>
                            <td class="py-2"></td>
                            <td class="py-2">Rp {{ number_format($total ?? $costs->sum('amount'),0,',','.') }}</td>
                            <td class="py-2" colspan="2"></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $costs->links() }}
            </div>
        </div>

        <!-- Ide & Optimasi panel removed per request -->
    </div>

    <!-- Bottom prompt removed per request -->
</div>
@push('scripts')
    <script>
document.addEventListener('DOMContentLoaded', function(){
    const form = document.getElementById('cost-form');
    const submitBtn = document.getElementById('form-submit');
    const cancelBtn = document.getElementById('form-cancel');
    const itemInput = document.getElementById('form-item');
    const amountInput = document.getElementById('form-amount');
    const categoryInput = document.getElementById('form-category');
    const dateInput = document.getElementById('form-date');

    let editingId = null;

    document.querySelectorAll('.btn-edit').forEach(btn => {
        btn.addEventListener('click', function(){
            editingId = this.getAttribute('data-id');
            itemInput.value = this.getAttribute('data-item') || '';
            amountInput.value = this.getAttribute('data-amount') || '';
            categoryInput.value = this.getAttribute('data-category') || '';
            const rawDate = this.getAttribute('data-date');
            if (rawDate) {
                dateInput.value = rawDate.slice(0,10);
            } else {
                dateInput.value = '{{ date('Y-m-d') }}';
            }

            form.action = '/admin/operational-costs/' + editingId;
            // add or set _method input to PATCH
            let methodInput = form.querySelector('input[name="_method"]');
            if (!methodInput) {
                methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                form.appendChild(methodInput);
            }
            methodInput.value = 'PATCH';

            submitBtn.textContent = 'Simpan';
            cancelBtn.classList.remove('hidden');
        });
    });

    cancelBtn.addEventListener('click', function(){
        editingId = null;
        form.action = '{{ route('admin.operational-costs.store') }}';
        const methodInput = form.querySelector('input[name="_method"]');
        if (methodInput) methodInput.remove();
        itemInput.value = '';
        amountInput.value = '';
        categoryInput.value = '';
        dateInput.value = '{{ date('Y-m-d') }}';
        submitBtn.textContent = 'Tambah';
        cancelBtn.classList.add('hidden');
    });

    // Export button: build URL using the visible filter inputs so users can export without pressing Filter
    const exportBtn = document.getElementById('export-btn');
    if (exportBtn) {
        exportBtn.addEventListener('click', function(){
            const startInput = document.querySelector('input[name="start_date"]');
            const endInput = document.querySelector('input[name="end_date"]');
            const start = startInput ? startInput.value : '';
            const end = endInput ? endInput.value : '';
            let url = '{{ route('admin.operational-costs.export') }}';
            const params = new URLSearchParams();
            if (start) params.set('start_date', start);
            if (end) params.set('end_date', end);
            const final = params.toString() ? (url + '?' + params.toString()) : url;
            window.location.href = final;
        });
    }
});
</script>
@endpush

@endsection
