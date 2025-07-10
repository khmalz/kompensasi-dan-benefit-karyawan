@extends('dashboard.layouts.main')

@section('content')
    <div>
        <div class="mb-4 w-full">
            <div>
                <button
                    class="ms-2 inline-flex items-center rounded-full border border-blue-700 bg-blue-700 px-4 py-2 text-sm font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300"
                    data-modal-target="search-modal" data-modal-toggle="search-modal" type="button">
                    <svg class="me-2 h-4 w-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                    </svg> Pencarian
                </button>
                <a class="ms-2 inline-flex items-center rounded-full border border-rose-700 bg-rose-700 px-4 py-2 text-sm font-medium text-white hover:bg-rose-800 focus:outline-none focus:ring-4 focus:ring-rose-300"
                    href="{{ request()->url() }}" role="button">
                    <svg class="me-2 h-4 w-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                        height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18 17.94 6M18 18 6.06 6" />
                    </svg> Clear
                </a>
            </div>

            <div class="fixed left-0 right-0 top-0 z-50 hidden h-[calc(100%-1rem)] max-h-full w-full items-center justify-center overflow-y-auto overflow-x-hidden md:inset-0"
                id="search-modal" aria-hidden="true" tabindex="-1">
                <div class="relative max-h-full w-full max-w-xl p-4">
                    <div class="relative rounded-lg bg-white shadow">
                        <div class="flex items-center justify-between rounded-t border-b p-4 md:p-5">
                            <h3 class="text-xl font-semibold text-gray-900">
                                Cari
                            </h3>
                            <button
                                class="ms-auto inline-flex h-8 w-8 items-center justify-center rounded-lg bg-transparent text-sm text-gray-400 hover:bg-gray-200 hover:text-gray-900"
                                data-modal-hide="search-modal" type="button">
                                <svg class="h-3 w-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                </svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                        </div>
                        <form class="w-full">
                            <div class="p-4 md:p-5">
                                <input name="status" type="hidden" value="{{ request('status') }}">

                                <div class="mb-2">
                                    <label class="mb-2 block text-sm font-medium text-gray-900" for="tanggal">Tanggal
                                    </label>
                                    <div class="relative">
                                        <div class="pointer-events-none absolute inset-y-0 start-0 flex items-center ps-3">
                                            <svg class="h-4 w-4 text-gray-500" aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                                <path
                                                    d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                            </svg>
                                        </div>
                                        <input
                                            class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 ps-10 text-sm text-gray-900 focus:border-green-500 focus:ring-green-500"
                                            id="inp-tanggal" name="tanggal" data-date="{{ request('tanggal') }}"
                                            type="text" autocomplete="off" datepicker-buttons datepicker
                                            datepicker-autohide placeholder="Pilih Tanggal">
                                    </div>
                                </div>

                                <div class="mb-2">
                                    <label class="mb-2 block text-sm font-medium text-gray-900" for="jenis">Jenis
                                        Tunjangan</label>
                                    <select
                                        class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500"
                                        id="jenis" name="jenis">
                                        <option value="" selected>Semua</option>
                                        <option value="kesehatan" @selected(request('jenis') == 'kesehatan')>
                                            Kesehatan
                                        </option>
                                        <option value="bencana" @selected(request('jenis') == 'bencana')>
                                            Bencana</option>
                                        <option value="transportasi" @selected(request('jenis') == 'transportasi')>
                                            Transportasi</option>
                                        <option value="jabatan" @selected(request('jenis') == 'jabatan')>
                                            Jabatan</option>
                                        <option value="makanan" @selected(request('jenis') == 'makanan')>
                                            Makanan</option>
                                    </select>
                                </div>
                            </div>
                            <div class="flex items-center justify-end rounded-b border-t border-gray-200 p-4 md:p-5">
                                <button
                                    class="rounded-lg bg-blue-700 px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300"
                                    type="submit">Pencarian</button>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="w-full rounded-lg bg-white p-5">
            <form method="GET">
                <div class="relative mb-2 inline-block">
                    <select
                        class="appearance-none border-0 border-b-2 border-blue-500 !bg-none py-2.5 text-sm text-blue-500 focus:outline-none focus:ring-0"
                        id="status" name="status" onchange="this.form.submit()">
                        <option class="text-gray-900" value="menunggu" @selected(request('status') == 'menunggu')>Menunggu</option>
                        <option class="text-gray-900" value="proses" @selected(request('status') == 'proses')>
                            Proses</option>
                        <option class="text-gray-900" value="selesai" @selected(request('status') == 'selesai')>
                            Selesai</option>
                        <option class="text-gray-900" value="ditolak" @selected(request('status') == 'ditolak')>Ditolak</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-blue-500">
                        <svg class="h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path d="M5.5 7l5 5 5-5H5.5z" />
                        </svg>
                    </div>
                </div>
            </form>
            @if ($benefits->isNotEmpty())
                <div class="relative overflow-x-auto">
                    <table class="w-full text-left text-sm text-gray-500">
                        <thead class="0 bg-gray-50 text-xs uppercase text-gray-700">
                            <tr>
                                <th class="px-6 py-3" scope="col">
                                    Tanggal
                                </th>
                                <th class="px-6 py-3" scope="col">
                                    Kode
                                </th>
                                <th class="px-6 py-3" scope="col">
                                    Nama
                                </th>
                                <th class="px-6 py-3" scope="col">
                                    Jenis Tunjangan
                                </th>
                                <th class="px-6 py-3" scope="col">
                                    Besar Tunjangan
                                </th>
                                <th class="px-6 py-3" scope="col">
                                    Status
                                </th>
                                <th class="px-6 py-3" scope="col">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($benefits as $benefit)
                                <tr class="border-b bg-white hover:bg-gray-50">
                                    <th class="whitespace-nowrap px-6 py-4 font-medium text-gray-900" scope="row">
                                        {{ $benefit->created_at->translatedFormat('d F Y') }}
                                    </th>
                                    <td class="px-6 py-4">
                                        {{ $benefit->code }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $benefit->employee->user->name }}
                                    </td>
                                    <td class="px-6 py-4 capitalize">
                                        {{ $benefit->type }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ number_format($benefit->amount, 0, '', '.') }}
                                    </td>
                                    <td class="px-6 py-4">
                                        @php
                                            $status = strtolower($benefit->status->value);
                                            [$color, $text] = match ($status) {
                                                'pending' => ['bg-purple-500 text-purple-800', 'Menunggu'],
                                                'progress' => ['bg-yellow-300 text-yellow-800', 'Proses'],
                                                'done' => ['bg-green-500 text-green-800', 'Selesai'],
                                                'reject' => ['bg-red-500 text-red-800', 'Ditolak'],
                                                default => ['bg-gray-500 text-gray-800', 'Unknown'],
                                            };
                                        @endphp
                                        <span
                                            class="{{ $color }} me-2 rounded px-2.5 py-0.5 text-xs font-medium text-white">{{ ucfirst($text) }}</span>
                                    </td>
                                    <td class="flex items-center px-6 py-4">
                                        <a class="font-medium text-blue-600 hover:underline"
                                            href="{{ route('benefit.show', $benefit) }}">Detail</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-2">
                    {{ $benefits->appends([
                            'status' => request('status'),
                            'tanggal' => request('tanggal'),
                            'jenis' => request('jenis'),
                        ])->links() }}
                </div>
            @else
                <p class="my-4 text-sm text-gray-500">Tidak ada data</p>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
    <script type="module">
        const urlParams = new URLSearchParams(window.location.search);
        const statusParam = urlParams.get('status');

        if (!statusParam) {
            const newUrl = window.location.pathname + '?status=menunggu';
            window.location.replace(newUrl);
        }

        const defaultDate = $('#inp-tanggal').data('date');
        let parsedDate = null;

        if (defaultDate) {
            const parts = defaultDate.split('-');
            if (parts.length === 3) {
                const day = parseInt(parts[0], 10);
                const month = parseInt(parts[1], 10) - 1; // Month is 0-based
                const year = parseInt(parts[2], 10);
                parsedDate = new Date(year, month, day);
            }
        }

        const datepicker = new Datepicker(document.getElementById('inp-tanggal'), {
            language: "id",
            weekStart: 1,
            autohide: true,
            clearBtn: true,
            todayBtn: true,
            todayBtnMode: 1,
            format: "dd-mm-yyyy",
        });

        if (parsedDate) {
            datepicker.setDate(parsedDate);
        }
    </script>
@endpush
