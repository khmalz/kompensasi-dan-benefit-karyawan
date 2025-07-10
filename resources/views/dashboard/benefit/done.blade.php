@extends('dashboard.layouts.main')

@section('content')
    <div>
        @if (session()->has('fail'))
            <div class="mb-4 flex items-center rounded-lg bg-red-50 p-4 text-red-800" id="alert-2" role="alert">
                <svg class="h-4 w-4 flex-shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                    viewBox="0 0 20 20">
                    <path
                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                </svg>
                <span class="sr-only">Info</span>
                <div class="ms-3 text-sm font-medium">
                    {{ session('fail') }}
                </div>
                <button
                    class="-mx-1.5 -my-1.5 ms-auto inline-flex h-8 w-8 items-center justify-center rounded-lg bg-red-50 p-1.5 text-red-500 hover:bg-red-200 focus:ring-2 focus:ring-red-400"
                    data-dismiss-target="#alert-2" type="button" aria-label="Close">
                    <span class="sr-only">Close</span>
                    <svg class="h-3 w-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                </button>
            </div>
        @endif

        <div class="mb-4 flex w-full items-center justify-between">
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

            <div>
                <button
                    class="ms-2 inline-flex items-center rounded-lg border border-teal-500 bg-teal-500 px-4 py-2 text-sm font-medium text-white hover:bg-teal-600 focus:outline-none focus:ring-4 focus:ring-cyan-300"
                    data-modal-target="ekspor-modal" data-modal-toggle="ekspor-modal" type="button">
                    Ekspor Data
                </button>

                <a class="ms-2 inline-flex items-center rounded-lg border border-amber-500 bg-amber-500 px-4 py-2 text-sm font-medium text-white hover:bg-amber-600 focus:outline-none focus:ring-4 focus:ring-cyan-300"
                    href="{{ route('benefit.index') }}" role="button">
                    Tunjangan Lainnya
                </a>
            </div>

            <div class="fixed left-0 right-0 top-0 z-50 hidden h-[calc(100%-1rem)] max-h-full w-full items-center justify-center overflow-y-auto overflow-x-hidden md:inset-0"
                id="ekspor-modal" aria-hidden="true" tabindex="-1">
                <div class="relative max-h-full w-full max-w-xl p-4">
                    <div class="relative rounded-lg bg-white shadow">
                        <div class="flex items-center justify-between rounded-t border-b p-4 md:p-5">
                            <h3 class="text-xl font-semibold text-gray-900">
                                Ekspor ke PDF
                            </h3>
                            <button
                                class="ms-auto inline-flex h-8 w-8 items-center justify-center rounded-lg bg-transparent text-sm text-gray-400 hover:bg-gray-200 hover:text-gray-900"
                                data-modal-hide="ekspor-modal" type="button">
                                <svg class="h-3 w-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                </svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                        </div>
                        <form id="export-data" action="{{ route('benefit.pdf.done') }}" method="POST" target="_blank">
                            @csrf
                            <div class="p-4 md:p-5">
                                <div class="mb-2">
                                    <label class="mb-2 block text-sm font-medium text-gray-900" for="started_at">Dari
                                        Tanggal
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
                                            id="inp-started_at" name="started_at" type="text"
                                            value="{{ old('started_at') }}" autocomplete="off" datepicker-buttons
                                            datepicker datepicker-autohide placeholder="Pilih dari tanggal" required>
                                    </div>
                                </div>
                                <div class="mb-2">
                                    <label class="mb-2 block text-sm font-medium text-gray-900" for="ended_at">Sampai
                                        Tanggal
                                    </label>
                                    <div class="relative">
                                        <div class="pointer-events-none absolute inset-y-0 start-0 flex items-center ps-3">
                                            <svg class="h-4 w-4 text-gray-500" aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                                viewBox="0 0 20 20">
                                                <path
                                                    d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                            </svg>
                                        </div>
                                        <input
                                            class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 ps-10 text-sm text-gray-900 focus:border-green-500 focus:ring-green-500"
                                            id="inp-ended_at" name="ended_at" type="text"
                                            value="{{ old('ended_at') }}" required autocomplete="off" datepicker-buttons
                                            datepicker datepicker-autohide placeholder="Pilih sampai tanggal">
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center justify-between rounded-b border-t border-gray-200 p-4 md:p-5">
                                <button
                                    class="rounded-lg bg-blue-700 px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300"
                                    type="button" onclick="document.getElementById('export-all-data').submit()">Semua
                                    Data</button>
                                <button
                                    class="rounded-lg bg-cyan-700 px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-cyan-800 focus:outline-none focus:ring-4 focus:ring-cyan-300"
                                    type="submit">Pencarian</button>
                            </div>
                        </form>

                        <form class="hidden" id="export-all-data" action="{{ route('benefit.pdf.done') }}"
                            method="POST" target="_blank">
                            @csrf
                            <input name="all" type="hidden" value="all">
                        </form>
                    </div>
                </div>
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
                                <svg class="h-3 w-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                </svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                        </div>
                        <form class="w-full">
                            <div class="space-y-4 p-4 md:p-5">

                                <div class="mb-2">
                                    <label class="mb-2 block text-sm font-medium text-gray-900"
                                        for="cari">Nama</label>
                                    <input
                                        class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                        id="cari" name="nama" type="text" value="{{ request('nama') }}"
                                        placeholder="nama">
                                </div>

                                <div class="mb-2">
                                    <label class="mb-2 block text-sm font-medium text-gray-900" for="tanggal">Tanggal
                                    </label>
                                    <div class="relative">
                                        <div class="pointer-events-none absolute inset-y-0 start-0 flex items-center ps-3">
                                            <svg class="h-4 w-4 text-gray-500" aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                                viewBox="0 0 20 20">
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

            <div class="mb-4 border-b border-gray-200">
                <ul class="-mb-px flex flex-wrap text-center text-sm font-medium text-gray-500" id="tabs-example"
                    role="tablist">
                    <li class="me-2" role="presentation">
                        <button
                            class="inline-block rounded-t-lg border-b-2 !border-blue-600 border-transparent p-4 text-blue-600 hover:border-gray-300 hover:text-blue-600"
                            id="selesai-tab-example" type="button" role="tab" aria-controls="selesai-example"
                            aria-selected="false">
                            Selesai
                        </button>
                    </li>
                </ul>
            </div>
            <div id="tabContentExample">
                <div class="rounded-lg bg-gray-50" id="selesai-example" role="tabpanel"
                    aria-labelledby="selesai-tab-example">
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
                                            <th class="whitespace-nowrap px-6 py-4 font-medium text-gray-900"
                                                scope="row">
                                                {{ $benefit->created_at->translatedFormat('d F Y') }}
                                            </th>
                                            <td class="px-6 py-4">
                                                {{ $benefit->code }}
                                            </td>
                                            <td class="px-6 py-4 capitalize">
                                                {{ $benefit->type }}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ number_format($benefit->amount, 0, '', '.') }}
                                            </td>
                                            <td class="px-6 py-4">
                                                <span
                                                    class="me-2 rounded bg-green-400 px-2.5 py-0.5 text-xs font-medium text-green-800">Selesai</span>
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
                                    'nama' => request('nama'),
                                    'tanggal' => request('tanggal'),
                                    'jenis' => request('jenis'),
                                ])->links() }}
                        </div>
                    @else
                        <p class="my-4 text-sm text-gray-500">Tidak ada data</p>
                    @endif
                </div>
            </div>

        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const datepickerOptions = {
                language: "id",
                weekStart: 1,
                autohide: true,
                clearBtn: true,
                todayBtn: true,
                todayBtnMode: 1,
                format: "dd-mm-yyyy",
            };

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

            const datepicker = new Datepicker(document.getElementById('inp-tanggal'), datepickerOptions);
            new Datepicker(document.getElementById('inp-started_at'), datepickerOptions);
            new Datepicker(document.getElementById('inp-ended_at'), datepickerOptions);

            if (parsedDate) {
                datepicker.setDate(parsedDate);
            }
        });
    </script>
@endpush
