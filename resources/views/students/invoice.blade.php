<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice - {{ $activeBill->invoice_number }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @media print {
            body { background: white !important; }
            .no-print { display: none !important; }
            .print-border { border: 1px solid #e5e7eb !important; }
        }
    </style>
</head>
<body class="bg-gray-50 text-slate-800 font-sans p-6 min-h-screen flex flex-col items-center">
    
    <!-- Action Bar (Hidden when printing) -->
    <div class="w-full max-w-3xl flex justify-between items-center mb-6 no-print">
        <a href="{{ route('students.payment') }}" class="text-sm font-bold text-slate-500 hover:text-slate-800 flex items-center gap-2 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali
        </a>
        <button onclick="window.print()" class="bg-[#d62828] text-white px-5 py-2.5 rounded-xl text-sm font-bold shadow-sm hover:bg-[#b01e1e] transition flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
            Cetak Invoice (PDF)
        </button>
    </div>

    <!-- Invoice Paper -->
    <div class="bg-white w-full max-w-3xl p-10 sm:p-14 rounded-2xl shadow-sm print-border">
        
        <!-- Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center border-b border-gray-100 pb-8 mb-8">
            <div class="flex items-center gap-4 mb-6 sm:mb-0">
                <div class="w-14 h-14 bg-[#d62828] rounded-xl flex items-center justify-center text-white font-bold text-xl">
                    LS
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-slate-800 tracking-tight">LPK Seishin</h1>
                    <p class="text-sm text-slate-500 font-medium">Lembaga Pelatihan Bahasa Jepang</p>
                </div>
            </div>
            <div class="text-left sm:text-right">
                <h2 class="text-3xl font-bold text-[#d62828] mb-1">INVOICE</h2>
                <p class="text-sm font-bold text-slate-600">No: {{ $activeBill->invoice_number }}</p>
                <p class="text-xs font-medium text-slate-400 mt-1">Tanggal: {{ date('d M Y') }}</p>
            </div>
        </div>

        <!-- Info -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-8 mb-10 relative">
            @if($activeBill->is_paid ?? false)
            <!-- Paid Stamp -->
            <div class="absolute inset-0 flex items-center justify-center opacity-[0.08] pointer-events-none z-0">
                <div class="border-8 border-emerald-500 text-emerald-500 font-black text-6xl uppercase tracking-widest px-8 py-4 rounded-xl rotate-[-15deg]">
                    L U N A S
                </div>
            </div>
            @endif

            <div class="relative z-10">
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Ditagihkan Kepada:</p>
                <h3 class="text-lg font-bold text-slate-800">{{ $user->name }}</h3>
                <p class="text-sm text-slate-500 font-medium mt-1">Siswa - {{ $user->level ?? 'Program Bahasa' }}</p>
                <p class="text-sm text-slate-500 mt-1">{{ $user->email }}</p>
            </div>
            <div class="sm:text-right">
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Jatuh Tempo:</p>
                <h3 class="text-lg font-bold text-slate-800">{{ $activeBill->due_date }}</h3>
            </div>
        </div>

        <!-- Items Table -->
        <div class="overflow-hidden rounded-xl border border-gray-200 mb-8">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-gray-200 text-xs font-bold text-slate-500 uppercase tracking-wider">
                        <th class="px-6 py-4">Deskripsi Tagihan</th>
                        <th class="px-6 py-4 text-right">Jumlah</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <tr>
                        <td class="px-6 py-5">
                            <p class="font-bold text-slate-800">{{ $activeBill->description }}</p>
                            @if($activeBill->is_paid ?? false)
                                <p class="text-sm text-slate-500 mt-1">Metode: {{ $activeBill->payment_method }}</p>
                                <p class="text-sm text-slate-500">Tanggal Bayar: {{ $activeBill->payment_date }}</p>
                            @else
                                <p class="text-sm text-slate-500 mt-1">Periode pembayaran sesuai kontrak program pendidikan.</p>
                            @endif
                        </td>
                        <td class="px-6 py-5 text-right font-bold text-slate-800">
                            Rp {{ number_format($activeBill->total, 0, ',', '.') }}
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr class="bg-slate-50">
                        <td class="px-6 py-4 text-right font-bold text-slate-600 uppercase text-xs tracking-wider">Total Tagihan</td>
                        <td class="px-6 py-4 text-right font-bold text-[#d62828] text-xl">
                            Rp {{ number_format($activeBill->total, 0, ',', '.') }}
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <!-- Payment Instructions (Only show if not paid) -->
        @if(!($activeBill->is_paid ?? false))
        <div class="bg-amber-50 border border-amber-100 rounded-xl p-5 mb-8 relative z-10">
            <h4 class="text-sm font-bold text-amber-800 mb-2">Instruksi Pembayaran</h4>
            <p class="text-xs font-medium text-amber-700 leading-relaxed mb-3">
                Silakan lakukan pembayaran melalui transfer bank ke salah satu rekening di bawah ini sebelum tanggal jatuh tempo. Setelah transfer, harap upload bukti pembayaran melalui menu <span class="font-bold">Bayar Manual</span> di sistem.
            </p>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                @foreach($bankAccounts as $bank)
                <div class="bg-white p-3 rounded-lg border border-amber-100/50">
                    <p class="text-xs font-bold text-slate-400 uppercase">Bank {{ $bank->bank_name }}</p>
                    <p class="text-sm font-bold text-slate-800 mt-0.5">{{ $bank->account_number }}</p>
                    <p class="text-xs font-medium text-slate-500">a/n {{ $bank->account_name }}</p>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Footer -->
        <div class="text-center pt-8 border-t border-gray-100 text-xs text-slate-400 font-medium">
            <p>Invoice ini dibuat secara otomatis oleh sistem LPK Seishin dan sah tanpa tanda tangan.</p>
            <p class="mt-1">Jika ada pertanyaan, silakan hubungi admin di info@lpkseishin.com.</p>
        </div>

    </div>

</body>
</html>
