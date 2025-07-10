@extends('dashboard.layouts.main')

@section('content')
    <div class="mb-4 flex w-full justify-between">
        <h1 class="text-xl font-bold">Detail Tunjangan | <span class="text-blue-600">#{{ $benefit->code }}</span></h1>
        <div class="flex space-x-2">
            @if ($benefit->status == 'reject' || $benefit->status == 'done')
                <button
                    class="block rounded-lg bg-sky-500 px-4 py-2 text-center text-sm font-medium text-white hover:bg-sky-600 focus:outline-none focus:ring-1 focus:ring-sky-300"
                    data-modal-target="export-pdf-modal" data-modal-toggle="export-pdf-modal" type="button">
                    Ekspor ke PDF
                </button>
            @endif

            @role('admin')
                @if ($benefit->status !== 'done')
                    <button
                        class="inline-flex items-center rounded-lg bg-blue-700 px-4 py-2 text-center text-sm font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300"
                        id="dropdownDefaultButton" data-dropdown-toggle="dropdown" type="button">Aksi <svg
                            class="ms-2 h-2.5 w-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 4 4 4-4" />
                        </svg>
                    </button>

                    <div class="z-10 hidden w-44 divide-y divide-gray-100 rounded-lg bg-white shadow" id="dropdown">
                        <ul class="py-2 text-sm text-gray-700" aria-labelledby="dropdownDefaultButton">
                            <li>
                                <a class="block px-4 py-2 hover:bg-gray-100" data-modal-target="tanggapan-modal"
                                    data-modal-toggle="tanggapan-modal" href="#" role="button">Tanggapan</a>
                            </li>
                        </ul>
                    </div>
                @endif
            @endrole

            @role('employee')
                @if ($benefit->status == 'reject' || $benefit->status == 'pending')
                    <button
                        class="inline-flex items-center rounded-lg bg-blue-700 px-4 py-2 text-center text-sm font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300"
                        id="dropdownDefaultButton" data-dropdown-toggle="dropdown" type="button">Aksi <svg
                            class="ms-2 h-2.5 w-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 4 4 4-4" />
                        </svg>
                    </button>

                    <div class="z-10 hidden w-44 divide-y divide-gray-100 rounded-lg bg-white shadow" id="dropdown">
                        <ul class="py-2 text-sm text-gray-700" aria-labelledby="dropdownDefaultButton">
                            <li>
                                <a class="block px-4 py-2 hover:bg-gray-100" href="{{ route('request-edit', $benefit) }}">Edit
                                    Permintaan</a>
                            </li>
                            <li>
                                <button class="block px-4 py-2 hover:bg-gray-100" data-modal-target="delete-benefit-modal"
                                    data-modal-toggle="delete-benefit-modal" type="button">
                                    Hapus Permintaan
                                </button>
                            </li>
                        </ul>
                    </div>
                @endif
            @endrole
        </div>

    </div>
    <div class="flex w-full space-x-2">
        <div class="w-1/3 rounded-lg bg-white p-5">
            <div class="flex flex-col items-center">
                <img class="mb-3 h-24 w-24 rounded-full shadow-lg" src="{{ asset('images/Anon Bussines.png') }}"
                    alt="Bonnie image" />
                <h5 class="mb-1 text-xl font-medium text-gray-900">{{ $benefit->employee->user->name }}</h5>
                <span class="text-sm text-gray-500">{{ $benefit->employee->user->email }}</span>
                <span class="mt-2 text-sm font-medium text-gray-700">{{ $benefit->employee->nik }}</span>
            </div>
        </div>
        <div class="w-2/3">
            <div class="w-full rounded-lg bg-white p-5">
                <h2 class="text-lg font-medium">Detail Tunjangan</h2>
                <ul class="w-full rounded-lg border-none bg-white text-sm font-medium text-gray-900">
                    <li class="w-full rounded-t-lg border-b border-gray-200 py-2">
                        <div class="flex justify-between">
                            <span class="">Jenis Tunjangan</span>
                            <span class="font-normal capitalize">{{ $benefit->type }}</span>
                        </div>
                    </li>
                    <li class="w-full rounded-t-lg border-b border-gray-200 py-2">
                        <div class="flex justify-between">
                            <span class="">Status</span>
                            @php
                                $status = strtolower($benefit->status->value);
                                [$color, $text] = match ($status) {
                                    'pending' => ['text-purple-800', 'Menunggu'],
                                    'progress' => ['text-yellow-800', 'Proses'],
                                    'done' => ['text-green-800', 'Selesai'],
                                    'reject' => ['text-red-800', 'Ditolak'],
                                    default => ['text-gray-800', 'Unknown'],
                                };
                            @endphp
                            <span class="{{ $color }} font-medium">{{ $text }}</span>
                        </div>
                    </li>
                    <li class="w-full rounded-t-lg border-b border-gray-200 py-2">
                        <div class="flex justify-between">
                            <span class="">Tanggal</span>
                            <span class="font-normal">{{ $benefit->created_at->translatedFormat('d F Y') }}</span>
                        </div>
                    </li>
                    <li class="w-full rounded-t-lg border-b border-gray-200 py-2">
                        <div class="flex justify-between">
                            <span class="">Besar Tunjangan</span>
                            <span class="font-normal">Rp. {{ number_format($benefit->amount, 0, '', '.') }}</span>
                        </div>
                    </li>
                    <li class="w-full rounded-b-lg py-2">
                        <div class="flex flex-col">
                            <span>Pesan</span>
                            <span class="font-normal">{{ $benefit->message }}</span>
                        </div>
                    </li>
                    @isset($benefit->response)
                        <li class="w-full rounded-b-lg py-2">
                            <div class="flex flex-col">
                                <span>Pesan dari Admin</span>
                                <span class="font-normal">{{ $benefit->response->message }}</span>
                            </div>
                        </li>
                    @endisset

                </ul>
            </div>
        </div>
    </div>
    <div class="mt-2 flex w-full pe-2">
        <div class="w-1/3 flex-col">

            <div class="w-full rounded-lg bg-white p-5">
                <h2 class="text-lg font-medium">File Pendukung</h2>

                <div class="mt-2 max-w-sm rounded-lg border-none bg-white">
                    <a class="image-lightbox duration-700 ease-in-out" data-width="800px" data-height="800px"
                        href="{{ asset('images/' . $benefit->file) }}">
                        <img class="rounded-t-lg" src="{{ asset('images/' . $benefit->file) }}" alt="" />
                    </a>
                </div>

            </div>
        </div>
    </div>

    <div class="fixed left-0 right-0 top-0 z-50 hidden h-[calc(100%-1rem)] max-h-full w-full items-center justify-center overflow-y-auto overflow-x-hidden md:inset-0"
        id="export-pdf-modal" tabindex="-1">
        <div class="relative max-h-full w-full max-w-md p-4">
            <div class="relative rounded-lg bg-white py-2 shadow">
                <button
                    class="absolute end-2.5 top-3 ms-auto inline-flex h-8 w-8 items-center justify-center rounded-lg bg-transparent text-sm text-gray-400 hover:bg-gray-200 hover:text-gray-900"
                    data-modal-hide="export-pdf-modal" type="button">
                    <svg class="h-3 w-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <div class="p-4 text-center md:p-5">
                    <svg class="mx-auto mb-4 h-12 w-12 text-gray-400" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    <h3 class="mb-5 text-lg font-normal text-gray-500">Ekspor Data?</h3>

                    <form class="inline-block" action="{{ route('benefit.pdf', $benefit) }}" method="POST"
                        target="_blank">
                        @csrf

                        <button
                            class="inline-flex items-center rounded-lg bg-sky-600 px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-sky-800 focus:outline-none focus:ring-4 focus:ring-sky-300"
                            type="submit">
                            Ya
                        </button>
                    </form>
                    <button
                        class="ms-3 rounded-lg border border-gray-200 bg-white px-5 py-2.5 text-sm font-medium text-gray-900 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:outline-none focus:ring-4 focus:ring-gray-100"
                        data-modal-hide="export-pdf-modal" type="button">Tidak</button>
                </div>
            </div>
        </div>
    </div>

    <div class="fixed left-0 right-0 top-0 z-50 hidden h-[calc(100%-1rem)] max-h-full w-full items-center justify-center overflow-y-auto overflow-x-hidden md:inset-0"
        id="delete-benefit-modal" tabindex="-1">
        <div class="relative max-h-full w-full max-w-md p-4">
            <div class="relative rounded-lg bg-white py-2 shadow">
                <button
                    class="absolute end-2.5 top-3 ms-auto inline-flex h-8 w-8 items-center justify-center rounded-lg bg-transparent text-sm text-gray-400 hover:bg-gray-200 hover:text-gray-900"
                    data-modal-hide="delete-benefit-modal" type="button">
                    <svg class="h-3 w-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <div class="p-4 text-center md:p-5">
                    <svg class="mx-auto mb-4 h-12 w-12 text-gray-400" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    <h3 class="mb-5 text-lg font-normal text-gray-500">Hapus Permintaan Tunjangan?</h3>
                    <form class="inline-block" action="{{ route('benefit.destroy', $benefit) }}" method="POST">
                        @csrf
                        @method('DELETE')

                        <button
                            class="inline-flex items-center rounded-lg bg-rose-600 px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-rose-800 focus:outline-none focus:ring-4 focus:ring-rose-300"
                            type="submit">
                            Ya
                        </button>
                    </form>
                    <button
                        class="ms-3 rounded-lg border border-gray-200 bg-white px-5 py-2.5 text-sm font-medium text-gray-900 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:outline-none focus:ring-4 focus:ring-gray-100"
                        data-modal-hide="delete-benefit-modal" type="button">Tidak</button>
                </div>
            </div>
        </div>
    </div>

    <div class="fixed left-0 right-0 top-0 z-50 hidden h-[calc(100%-1rem)] max-h-full w-full items-center justify-center overflow-y-auto overflow-x-hidden md:inset-0"
        id="tanggapan-modal" aria-hidden="true" tabindex="-1">
        <div class="relative max-h-full w-full max-w-xl p-4">
            <div class="relative rounded-lg bg-white shadow">
                <div class="flex items-center justify-between rounded-t border-b p-4 md:p-5">
                    <h3 class="text-xl font-semibold text-gray-900">
                        Tanggapan
                    </h3>
                    <button
                        class="ms-auto inline-flex h-8 w-8 items-center justify-center rounded-lg bg-transparent text-sm text-gray-400 hover:bg-gray-200 hover:text-gray-900"
                        data-modal-hide="tanggapan-modal" type="button">
                        <svg class="h-3 w-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <form class="w-full" method="POST" action="{{ route('response.store', $benefit) }}">
                    @csrf
                    <div class="space-y-4 p-4 md:p-5">
                        @if ($isBenefitExceededLimit || session()->has('error'))
                            <div class="mb-4 rounded-lg bg-red-50 p-4 text-sm text-red-800 dark:bg-gray-800 dark:text-red-400"
                                role="alert">
                                {{ session('error', 'Jumlah tunjangan melebihi batas yang diizinkan.') }}
                            </div>
                        @endif

                        <div class="mb-5">
                            <label class="mb-2 block text-sm font-medium text-gray-900" for="status">Status</label>
                            <select
                                class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500"
                                id="status" name="status" required>
                                <option selected disabled>Pilih status</option>

                                @foreach (App\Enums\BenefitStatus::values() as $value => $name)
                                    <option value="{{ $value }}" @selected(old('status', $benefit->status->value) == $value)
                                        @disabled($value === 'reject' || ($value === 'progress' && $isBenefitExceededLimit))>
                                        {{ $name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-5">
                            <label class="mb-2 block text-sm font-medium text-gray-900" for="pesan">Pesan</label>
                            <textarea
                                class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500"
                                id="pesan" name="message" rows="2" placeholder="Tulis pesan" required>{{ old('message') }}</textarea>
                            @error('message')
                                <p class="mt-2 text-sm font-semibold text-rose-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="flex items-center justify-end rounded-b border-t border-gray-200 p-4 md:p-5">
                        <button
                            class="rounded-lg bg-blue-700 px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300"
                            type="submit">Kirim Tanggapan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endSection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const portfolioLightbox = GLightbox({
                selector: '.image-lightbox'
            });
        });
    </script>
@endpush
