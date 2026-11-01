@php
    $participation = $totalVoters > 0 ? round(($totalVotes / $totalVoters) * 100, 1) : 0;
    $maxVotes = collect($candidates)->max('votes') ?? 0;
    $notYet = max($totalVoters - $totalVotes, 0);
@endphp

<div class="py-10">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Hasil Pemilihan</h1>
                <p class="text-sm text-slate-500 mt-1">Perolehan suara dihitung langsung dari suara yang tercatat.</p>
            </div>
            <span class="inline-flex items-center gap-2 self-start px-3 py-1.5 text-xs font-semibold text-emerald-700 bg-emerald-50 ring-1 ring-inset ring-emerald-600/20 rounded-full">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                Data langsung
            </span>
        </div>

        {{-- Ringkasan --}}
        <div class="grid sm:grid-cols-3 gap-4">
            <div class="bg-white rounded-2xl ring-1 ring-slate-100 shadow-sm p-5">
                <div class="flex items-center justify-between">
                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Total Pemilih</p>
                    <span class="flex items-center justify-center w-9 h-9 rounded-xl bg-slate-100 text-slate-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6-4.13a4 4 0 100-8 4 4 0 000 8z"/></svg>
                    </span>
                </div>
                <p class="mt-3 text-3xl font-extrabold text-slate-900">{{ number_format($totalVoters) }}</p>
            </div>

            <div class="bg-white rounded-2xl ring-1 ring-slate-100 shadow-sm p-5">
                <div class="flex items-center justify-between">
                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Suara Masuk</p>
                    <span class="flex items-center justify-center w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    </span>
                </div>
                <p class="mt-3 text-3xl font-extrabold text-emerald-600">{{ number_format($totalVotes) }}</p>
                <p class="mt-1 text-xs text-slate-400">{{ number_format($notYet) }} belum memilih</p>
            </div>

            <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-emerald-600 to-teal-700 shadow-lg shadow-emerald-900/15 p-5">
                <div class="absolute -top-10 -right-10 w-32 h-32 rounded-full bg-white/10 blur-2xl"></div>
                <p class="relative text-xs font-semibold uppercase tracking-wider text-emerald-100">Partisipasi</p>
                <p class="relative mt-3 text-3xl font-extrabold text-white">{{ $participation }}%</p>
                <div class="relative mt-3 h-2 rounded-full bg-white/20 overflow-hidden">
                    <div class="h-full rounded-full bg-white transition-all duration-700" style="width: {{ min($participation, 100) }}%"></div>
                </div>
            </div>
        </div>

        {{-- Perolehan suara --}}
        <div>
            <h2 class="text-lg font-bold text-slate-900 tracking-tight">Perolehan Suara</h2>

            <div class="mt-4 space-y-4">
                @forelse ($candidates as $item)
                    @php
                        $candidate = $item['candidate'];
                        $isLeading = $maxVotes > 0 && $item['votes'] === $maxVotes;
                    @endphp

                    <div wire:key="result-{{ $candidate->id }}"
                         class="relative bg-white rounded-3xl shadow-lg shadow-slate-200/60 p-5 sm:p-6 transition-all duration-200 hover:shadow-xl
                                {{ $isLeading ? 'ring-2 ring-emerald-500' : 'ring-1 ring-slate-100' }}">

                        @if ($isLeading)
                            <span class="absolute -top-3 right-6 inline-flex items-center gap-1 px-3 py-1 text-xs font-bold text-white bg-emerald-600 rounded-full shadow-md shadow-emerald-600/30">
                                Memimpin
                            </span>
                        @endif

                        <div class="flex items-center gap-4 sm:gap-5">
                            {{-- Foto --}}
                            <div class="relative shrink-0">
                                @if ($candidate->photo)
                                    <img src="{{ asset('storage/' . $candidate->photo) }}"
                                         alt="Foto {{ $candidate->name }}"
                                         loading="lazy"
                                         class="w-16 h-16 sm:w-20 sm:h-20 rounded-2xl object-cover object-top ring-1 ring-slate-200">
                                @else
                                    <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-600 text-white text-2xl font-extrabold flex items-center justify-center">
                                        {{ strtoupper(mb_substr($candidate->name, 0, 1)) }}
                                    </div>
                                @endif
                                <span class="absolute -bottom-2 -left-2 flex items-center justify-center w-8 h-8 rounded-xl bg-slate-900 text-white text-sm font-extrabold ring-2 ring-white">
                                    {{ $candidate->serial_number }}
                                </span>
                            </div>

                            {{-- Nama + bar --}}
                            <div class="flex-1 min-w-0">
                                <h3 class="font-bold text-lg text-slate-900 truncate">{{ $candidate->name }}</h3>
                                <p class="text-xs text-slate-400">No. Urut {{ $candidate->serial_number }}</p>

                                <div class="mt-3 h-2.5 rounded-full bg-slate-100 overflow-hidden">
                                    <div class="h-full rounded-full transition-all duration-700 {{ $isLeading ? 'bg-gradient-to-r from-emerald-500 to-teal-500' : 'bg-slate-400' }}"
                                         style="width: {{ min((float) $item['percentage'], 100) }}%"></div>
                                </div>
                            </div>

                            {{-- Angka --}}
                            <div class="text-right shrink-0">
                                <p class="text-3xl font-extrabold leading-none {{ $isLeading ? 'text-emerald-600' : 'text-slate-900' }}">
                                    {{ number_format($item['votes']) }}
                                </p>
                                <p class="mt-1 text-xs font-semibold text-slate-400">suara</p>
                                <p class="mt-1.5 inline-flex px-2 py-0.5 text-xs font-bold rounded-full {{ $isLeading ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-600' }}">
                                    {{ $item['percentage'] }}%
                                </p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="bg-white rounded-3xl ring-1 ring-slate-100 shadow-xl shadow-slate-200/60 py-16 px-6 text-center">
                        <div class="mx-auto w-16 h-16 rounded-2xl bg-slate-100 flex items-center justify-center text-3xl">📊</div>
                        <p class="mt-4 text-base font-semibold text-slate-700">Belum ada kandidat</p>
                        <p class="mt-1 text-sm text-slate-400">Hasil akan tampil setelah ada kandidat terverifikasi.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>