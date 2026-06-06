@extends('layouts.student')

@section('title', 'Level ' . $level_id . ' - Penguasaan Kosakata')

@section('content')
<div class="p-4 sm:p-6 lg:p-10 flex-1 flex flex-col">
    
    <div class="mb-8 text-left">
        <h1 class="text-2xl sm:text-[28px] lg:text-3xl font-semibold font-ibm text-[#222222] tracking-tight mb-1">Level {{ $level_id }}</h1>
        <div class="flex items-center gap-2 text-sm font-medium text-[#666666] mt-2">
            <a href="{{ route('students.vocabulary-mastery') }}" class="hover:text-[#d62828] transition">Penguasaan Kosakata</a>
            <span class="text-gray-300">></span>
            <span class="text-[#d62828]">Level {{ $level_id }}</span>
        </div>
    </div>

    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 mb-6">
        <div class="flex flex-wrap items-center gap-3">
            <div class="text-sm font-bold text-[#444444] mr-2">Daftar Flashcard</div>
            <div class="relative">
                <svg class="w-4 h-4 absolute left-3.5 top-1/2 -translate-y-1/2 text-[#666666]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                <input id="search-input" type="text" placeholder="Cari kata..." class="pl-10 pr-4 py-2 bg-white border border-gray-200 rounded-full text-sm font-medium text-[#444444] focus:outline-none focus:border-gray-400 w-48 sm:w-64 transition-colors">
            </div>
            <div class="flex items-center gap-2">
                <div class="relative dropdown-container">
                    <button id="filter-toggle-btn" type="button" class="dropdown-btn bg-white text-[#d62828] border border-[#d62828] hover:bg-red-50 px-4 h-[38px] rounded-full text-xs font-bold flex items-center gap-2 shadow-sm transition active:scale-95 focus:outline-none">
                        Filter
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                    </button>
                    
                    <!-- Dropdown Menu Filter -->
                    <div class="dropdown-menu absolute left-0 sm:left-auto sm:right-0 top-[calc(100%+0.5rem)] w-56 bg-white rounded-2xl shadow-[0_10px_40px_-10px_rgba(0,0,0,0.12)] border border-gray-100 hidden opacity-0 transform scale-95 transition-all duration-200 origin-top-left sm:origin-top-right z-50 overflow-hidden">
                        <div class="px-5 py-4 border-b border-gray-100 bg-white">
                            <h3 class="text-[11px] font-bold text-[#666666] uppercase tracking-wider">Filter Berdasarkan</h3>
                        </div>
                        <div class="p-3 flex flex-col gap-1.5">
                        <label class="flex items-center gap-3 px-3 py-2 rounded-xl hover:bg-gray-50 cursor-pointer transition group">
                            <input type="radio" name="filter_status" value="semua" class="w-4 h-4 text-[#d62828] border-gray-300 focus:ring-[#d62828]" checked>
                            <span class="text-sm font-semibold text-slate-700 group-hover:text-[#d62828] transition-colors">Semua Kosakata</span>
                        </label>
                        <label class="flex items-center gap-3 px-3 py-2 rounded-xl hover:bg-gray-50 cursor-pointer transition group">
                            <input type="radio" name="filter_status" value="dikuasai" class="w-4 h-4 text-[#d62828] border-gray-300 focus:ring-[#d62828]">
                            <span class="text-sm font-semibold text-slate-700 group-hover:text-[#d62828] transition-colors">Sudah Dikuasai</span>
                        </label>
                        <label class="flex items-center gap-3 px-3 py-2 rounded-xl hover:bg-gray-50 cursor-pointer transition group">
                            <input type="radio" name="filter_status" value="belum" class="w-4 h-4 text-[#d62828] border-gray-300 focus:ring-[#d62828]">
                            <span class="text-sm font-semibold text-slate-700 group-hover:text-[#d62828] transition-colors">Belum Dikuasai</span>
                        </label>
                        <div class="h-px bg-gray-100 my-1 mx-2"></div>
                        <label class="flex items-center gap-3 px-3 py-2 rounded-xl hover:bg-gray-50 cursor-pointer transition group">
                            <input type="checkbox" name="filter_fav" class="w-4 h-4 text-[#FFB700] border-gray-300 focus:ring-[#FFB700] rounded">
                            <span class="text-sm font-semibold text-slate-700 group-hover:text-[#FFB700] transition-colors">Hanya Favorit</span>
                        </label>
                    </div>
                </div>
            </div>
            <!-- Active Filter Tags Container -->
            <div id="active-filters-container" class="flex items-center gap-2 hidden">
            </div>
        </div>
        </div>
        <div class="text-sm font-bold text-[#d62828]">
            Total: {{ $totalWords }} Kata
        </div>
    </div>

    <div id="flashcard-grid" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4 lg:gap-5 mb-8">
        </div>

    <div class="mt-auto flex justify-end">
        <div id="pagination-container" class="flex items-center gap-2">
            </div>
    </div>

</div>

</div>

@endsection

@push('modals')
<!-- Flashcard Modal -->
<div id="flashcard-modal" class="fixed inset-0 z-[100] hidden items-center justify-center p-4">
    <div id="modal-backdrop" onclick="closeFlashcardModal()" class="absolute inset-0 bg-gray-900/40 backdrop-blur-sm opacity-0 transition-opacity duration-300"></div>
    
    <div id="modal-content" class="bg-white rounded-[32px] w-full max-w-4xl p-8 lg:p-10 shadow-2xl relative z-[101] transform scale-95 opacity-0 transition-all duration-300">
        
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-xl font-bold text-[#444444] tracking-tight" id="modal-title">Detail Kata: -- (--)</h2>
            <button onclick="closeFlashcardModal()" class="w-8 h-8 rounded-full bg-[#FFDBDB] hover:bg-red-200 text-[#d62828] flex items-center justify-center transition focus:outline-none">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="3.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 lg:gap-10">
            
            <div id="flash-card-inner" class="border-[4px] bg-white border-[#FFB700] rounded-[32px] p-6 lg:p-8 relative flex flex-col justify-between aspect-square transition-colors duration-200">
                
                <div class="absolute top-4 right-4">
                    <button id="modal-fav-btn" onclick="toggleFavorite()" class="w-10 h-10 bg-white border border-gray-100 rounded-full shadow-sm flex items-center justify-center transition-all hover:scale-105">
                        <svg id="modal-fav-icon" class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
                    </button>
                </div>

                <div class="text-center flex-1 flex flex-col items-center justify-center mt-6">
                    <h1 id="modal-kanji" class="text-6xl font-bold text-[#444444] tracking-tight mb-3">--</h1>
                    <p id="modal-furigana" class="text-lg font-bold text-[#444444]">--</p>
                </div>

                <div class="space-y-3 mt-8">
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-[#666666] font-bold uppercase tracking-wider text-[11px]">JP</span>
                        <span id="modal-romaji" class="text-[#444444] font-bold">--</span>
                    </div>
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-[#666666] font-bold uppercase tracking-wider text-[11px]">EN</span>
                        <span id="modal-en" class="text-[#444444] font-bold">--</span>
                    </div>
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-[#666666] font-bold uppercase tracking-wider text-[11px]">ID</span>
                        <span id="modal-id" class="text-[#444444] font-bold">--</span>
                    </div>
                </div>
            </div>

            <div class="flex flex-col justify-between py-1">
                <div class="space-y-6 text-left">
                    
                    <div>
                        <p class="text-[10px] font-bold text-[#666666] uppercase tracking-widest mb-1">Definisi</p>
                        <p id="modal-definition" class="text-sm font-bold text-[#222222] leading-snug">--</p>
                    </div>
                    
                    <div>
                        <p class="text-[10px] font-bold text-[#666666] uppercase tracking-widest mb-1.5">Penggunaan Kontekstual (oleh Sensei)</p>
                        <p id="modal-usage" class="text-sm font-bold text-[#222222] mb-1 leading-snug tracking-tight">--</p>
                    </div>
                    
                    <div>
                        <p class="text-[10px] font-bold text-[#666666] uppercase tracking-widest mb-1">Progres Kartu</p>
                        <p id="modal-progress" class="text-sm font-bold text-[#222222]">--</p>
                    </div>
                    
                    <div>
                        <p class="text-[10px] font-bold text-[#666666] uppercase tracking-widest mb-1">Status</p>
                        <p id="modal-status" class="text-sm font-bold text-[#222222]">--</p>
                    </div>

                </div>

                <div class="flex items-center gap-3 mt-8">
                    <button id="modal-master-btn" onclick="toggleMastered()" class="flex-1 font-bold py-3.5 rounded-2xl text-sm transition shadow-sm flex items-center justify-center gap-2">
                    </button>
                    <button onclick="closeFlashcardModal()" class="px-8 py-3.5 bg-gray-200 hover:bg-gray-300 text-[#444444] font-bold rounded-2xl text-sm transition shadow-sm">
                        Tutup
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>
@endpush

@push('scripts')
<script>
    // Data dari backend dimasukkan ke variabel JS
    const allCards = @json($flashcards);
    const itemsPerPage = 18;
    let currentPage = 1;

    let filteredCards = [...allCards];
    let activeCardId = null; 

    function applyFilters() {
        const searchVal    = document.getElementById('search-input').value.toLowerCase().trim();
        const statusFilter = document.querySelector('input[name="filter_status"]:checked').value;
        const favOnly      = document.querySelector('input[name="filter_fav"]').checked;
 
        filteredCards = allCards.filter(card => {
            // Filter pencarian: cocokkan kanji, furigana, romaji, atau arti
            const matchSearch = !searchVal ||
                card.kanji.toLowerCase().includes(searchVal)    ||
                card.furigana.toLowerCase().includes(searchVal) ||
                card.romaji.toLowerCase().includes(searchVal)   ||
                card.en.toLowerCase().includes(searchVal)       ||
                card.id.toLowerCase().includes(searchVal);
 
            // Filter status: 'dikuasai' / 'belum' / 'semua'
            const matchStatus =
                statusFilter === 'semua'    ? true :
                statusFilter === 'dikuasai' ? card.status === 'Dikuasai' :
                statusFilter === 'belum'    ? card.status === 'Belum Dikuasai' :
                true;
 
            // Filter favorit
            const matchFav = !favOnly || card.is_fav;
 
            return matchSearch && matchStatus && matchFav;
        });
 
        currentPage = 1;
        renderGrid(currentPage);
    }

    function renderGrid(page) {
        const grid = document.getElementById('flashcard-grid');
        grid.innerHTML = '';
        
        const startIndex = (page - 1) * itemsPerPage;
        const endIndex   = startIndex + itemsPerPage;
        // [FIX] Render dari filteredCards, bukan allCards langsung
        const pageCards  = filteredCards.slice(startIndex, endIndex);
 
        if (pageCards.length === 0) {
            grid.innerHTML = `<div class="col-span-full text-center text-sm text-[#666666] font-semibold py-12">Tidak ada kata yang sesuai.</div>`;
            renderPagination(page);
            return;
        }
 
        pageCards.forEach((card, i) => {
            const actualIndex = startIndex + i;
            const bgClass = card.is_fav ? 'bg-[#FFEDB5] border-transparent' : 'bg-white border border-gray-200';
            
            grid.innerHTML += `
                <div onclick="openFlashcardModal(${actualIndex})" 
                        class="relative aspect-square ${bgClass} rounded-[24px] flex items-center justify-center group cursor-pointer hover:shadow-md transition-all overflow-hidden select-none">
                    
                    <h2 class="text-3xl lg:text-4xl font-black text-[#444444] group-hover:opacity-0 transition-opacity duration-200">
                        ${card.kanji}
                    </h2>
 
                    <div class="absolute inset-0 bg-[#d62828] flex flex-col items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-200 text-white">
                        <span class="text-sm font-semibold tracking-wide">Buka</span>
                        <span class="text-sm font-semibold tracking-wide">Flashcard</span>
                        <svg class="absolute bottom-4 right-4 w-2.5 h-2.5 fill-current" viewBox="0 0 24 24"><path d="M5 3l14 9-14 9V3z"/></svg>
                    </div>
                </div>
            `;
        });
        
        renderPagination(page);
    }

    function renderPagination(page) {
        const totalPages = Math.ceil(filteredCards.length / itemsPerPage);
        const container = document.getElementById('pagination-container');
        let html = '';

        const prevDisabled = page === 1;
        const prevClass = prevDisabled ? 'bg-gray-100 text-[#666666] cursor-not-allowed' : 'bg-[#FFDBDB] text-[#d62828] hover:bg-red-200 shadow-sm';
        html += `<button onclick="!${prevDisabled} && changePage(${page - 1})" class="w-8 h-8 rounded-lg ${prevClass} flex items-center justify-center transition font-black text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"></path></svg>
                    </button>`;
        
        for(let i = 1; i <= totalPages; i++) {
            if(i === page) {
                html += `<button class="w-8 h-8 rounded-lg bg-white border-2 border-[#444444] text-[#444444] flex items-center justify-center font-black text-sm shadow-sm">${i}</button>`;
            } else {
                html += `<button onclick="changePage(${i})" class="w-8 h-8 rounded-lg bg-white border border-gray-200 text-[#666666] hover:bg-gray-50 flex items-center justify-center transition font-black text-sm shadow-sm">${i}</button>`;
            }
        }

        const nextDisabled = page === totalPages;
        const nextClass = nextDisabled ? 'bg-gray-100 text-[#666666] cursor-not-allowed' : 'bg-[#d62828] text-white hover:bg-red-700 shadow-sm';
        html += `<button onclick="!${nextDisabled} && changePage(${page + 1})" class="w-8 h-8 rounded-lg ${nextClass} flex items-center justify-center transition font-black text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path></svg>
                    </button>`;

        container.innerHTML = html;
    }

    function changePage(newPage) {
        const totalPages = Math.ceil(filteredCards.length / itemsPerPage);
        if(newPage >= 1 && newPage <= totalPages) {
            currentPage = newPage;
            renderGrid(currentPage);
        }
    }

    const modal = document.getElementById('flashcard-modal');
    const modalBackdrop = document.getElementById('modal-backdrop');
    const modalContent = document.getElementById('modal-content');
    const innerCard = document.getElementById('flash-card-inner');
    const favIcon = document.getElementById('modal-fav-icon');
    const masterBtn = document.getElementById('modal-master-btn');

    function openFlashcardModal(index) {
        const card = filteredCards[index]; // Baca dari filteredCards
        activeCardId = card.id_vocabulary;
 
        document.getElementById('modal-title').innerText = `Detail Kata: ${card.kanji} (${card.romaji})`;
        document.getElementById('modal-kanji').innerText    = card.kanji;
        document.getElementById('modal-furigana').innerText = card.furigana;
        document.getElementById('modal-romaji').innerText   = card.romaji;
        document.getElementById('modal-en').innerText       = card.en;
        document.getElementById('modal-id').innerText       = card.id;
        document.getElementById('modal-definition').innerText = card.definition;
        document.getElementById('modal-usage').innerText    = card.usage;
        document.getElementById('modal-progress').innerText = card.progress;
        document.getElementById('modal-status').innerText   = card.status;

        updateFavUI(card.is_fav);
        updateMasterUI(card.status);
 
        modal.classList.replace('hidden', 'flex');
        setTimeout(() => {
            modalBackdrop.classList.replace('opacity-0', 'opacity-100');
            modalContent.classList.replace('opacity-0', 'opacity-100');
            modalContent.classList.replace('scale-95', 'scale-100');
        }, 10);
    }



    function closeFlashcardModal() {
        modalBackdrop.classList.replace('opacity-100', 'opacity-0');
        modalContent.classList.replace('opacity-100', 'opacity-0');
        modalContent.classList.replace('scale-100', 'scale-95');

        setTimeout(() => {
            modal.classList.replace('flex', 'hidden');
        }, 300);
    }

    function updateFavUI(isFav) {
        if (isFav) {
            favIcon.setAttribute('fill', 'currentColor');
            favIcon.classList.remove('text-gray-400');
            favIcon.classList.add('text-[#FFB700]');
            innerCard.classList.remove('bg-white');
            innerCard.classList.add('bg-[#FFFEE3]');
        } else {
            favIcon.setAttribute('fill', 'none');
            favIcon.classList.remove('text-[#FFB700]');
            favIcon.classList.add('text-gray-400');
            innerCard.classList.remove('bg-[#FFFEE3]');
            innerCard.classList.add('bg-white');
        }
    }

    function updateMasterUI(status) {
        if (status === 'Dikuasai') {
            masterBtn.innerHTML = `<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 6l12 12M6 18L18 6"></path></svg> Batal Dikuasai`;
            masterBtn.className = "flex-1 font-bold py-3.5 rounded-2xl text-sm transition shadow-sm flex items-center justify-center gap-2 bg-[#FFDBDB] hover:bg-red-200 text-[#d62828]";
        } else {
            masterBtn.innerHTML = `<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg> Tandai Dikuasai`;
            masterBtn.className = "flex-1 font-bold py-3.5 rounded-2xl text-sm transition shadow-sm flex items-center justify-center gap-2 bg-[#d62828] hover:bg-red-700 text-white";
        }
    }

    function toggleMastered() {
        if (!activeCardId) return;
        const card = allCards.find(c => c.id_vocabulary === activeCardId);
        if (!card) return;
 
        fetch(`/students/vocabulary/${card.id_vocabulary}/toggle-mastered`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            },
        })
        .then(async res => {
            if (!res.ok) {
                const text = await res.text();
                throw new Error(text || res.statusText);
            }
            return res.json();
        })
        .then(data => {
            // Update state di allCards dan filteredCards agar sinkron
            card.status = data.status;
            const originalCard = allCards.find(c => c.id_vocabulary === card.id_vocabulary);
            if (originalCard) originalCard.status = data.status;
 
            // Update tampilan modal tanpa menutupnya
            document.getElementById('modal-status').innerText = data.status;
            updateMasterUI(data.status);
 
            // Re-render grid agar perubahan status langsung tercermin (penting saat filter aktif)
            applyFilters();
        })
        .catch(error => {
            console.error("Gagal update status:", error);
            alert("Terjadi kesalahan sistem. " + error.message);
        });
    }

    function toggleFavorite() {
        if (!activeCardId) return;
        const card = allCards.find(c => c.id_vocabulary === activeCardId);
        if (!card) return;
 
        fetch(`/students/vocabulary/${card.id_vocabulary}/toggle-favorite`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            },
        })
        .then(async res => {
            if (!res.ok) {
                const text = await res.text();
                throw new Error(text || res.statusText);
            }
            return res.json();
        })
        .then(data => {
            // Update state di allCards dan filteredCards agar sinkron
            card.is_fav = data.is_favorite;
            const originalCard = allCards.find(c => c.id_vocabulary === card.id_vocabulary);
            if (originalCard) originalCard.is_fav = data.is_favorite;
 
            // Update tampilan modal tanpa menutupnya
            updateFavUI(data.is_favorite);
 
            // Re-render grid agar warna kartu (kuning/putih) langsung berubah
            applyFilters();
        })
        .catch(error => {
            console.error("Gagal update favorit:", error);
            alert("Terjadi kesalahan sistem. " + error.message);
        });
    }


    renderGrid(1);

    // Filter Interaction Logic
    const filterBtn = document.getElementById('filter-toggle-btn');
    const filterRadios = document.querySelectorAll('input[name="filter_status"]');
    const filterFav = document.querySelector('input[name="filter_fav"]');
    const activeFiltersContainer = document.getElementById('active-filters-container');

    document.getElementById('search-input').addEventListener('input', applyFilters);

    function updateFilterState() {
        let activeFilters = [];
        let hasActiveFilter = false;

        filterRadios.forEach(radio => {
            if (radio.checked && radio.value !== 'semua') {
                hasActiveFilter = true;
                const label = radio.nextElementSibling.innerText;
                activeFilters.push({ id: 'status', label: label });
            }
        });

        if (filterFav.checked) {
            hasActiveFilter = true;
            activeFilters.push({ id: 'fav', label: 'Hanya Favorit' });
        }

        // Update button appearance
        if (hasActiveFilter) {
            filterBtn.classList.remove('bg-white', 'text-[#d62828]', 'hover:bg-red-50');
            filterBtn.classList.add('bg-[#d62828]', 'text-white', 'hover:bg-red-700', 'border-transparent');
        } else {
            filterBtn.classList.add('bg-white', 'text-[#d62828]', 'hover:bg-red-50');
            filterBtn.classList.remove('bg-[#d62828]', 'text-white', 'hover:bg-red-700', 'border-transparent');
        }

        // Render active tags
        if (activeFilters.length > 0) {
            activeFiltersContainer.classList.remove('hidden');
            activeFiltersContainer.innerHTML = activeFilters.map(filter => `
                <button onclick="removeFilter('${filter.id}')" class="flex items-center gap-1.5 text-sm font-semibold text-[#444444] hover:text-[#d62828] transition bg-transparent h-[38px] px-1">
                    <svg class="w-4 h-4 text-[#d62828]" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path></svg>
                    ${filter.label}
                </button>
            `).join('');
        } else {
            activeFiltersContainer.classList.add('hidden');
            activeFiltersContainer.innerHTML = '';
        }
        applyFilters();
    }

    // Attach global window function for removing filter
    window.removeFilter = function(id) {
        if (id === 'status') {
            document.querySelector('input[name="filter_status"][value="semua"]').checked = true;
        } else if (id === 'fav') {
            filterFav.checked = false;
        }
        updateFilterState();
    };

    filterRadios.forEach(radio => radio.addEventListener('change', updateFilterState));
    filterFav.addEventListener('change', updateFilterState);

    // Initial check
    updateFilterState();
</script>
@endpush