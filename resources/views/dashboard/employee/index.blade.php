@extends('dashboard.layouts.main')

@section('content')
    <div>
        @if (session()->has('success'))
            <div class="mb-4 rounded-lg bg-green-50 p-4 text-sm text-green-800" id="password_berhasil" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <div class="mb-4 flex w-full justify-between">
            <div class="w-1/3">
                <form class="flex w-full items-center">
                    <label class="sr-only" for="simple-search">Search</label>
                    <div class="w-full">
                        <input
                            class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500"
                            id="simple-search" type="text" placeholder="Cari nama/NIK" required />
                    </div>
                    <button
                        class="ms-2 rounded-lg border border-blue-700 bg-blue-700 p-2.5 text-sm font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300"
                        type="submit">
                        <svg class="h-4 w-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                        </svg>
                        <span class="sr-only">Search</span>
                    </button>
                    <button
                        class="ms-2 rounded-lg border border-red-600 bg-red-600 p-2.5 text-sm font-medium text-white hover:bg-red-800 focus:outline-none focus:ring-4 focus:ring-red-300"
                        type="submit">
                        <svg class="h-4 w-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                            height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.651 7.65a7.131 7.131 0 0 0-12.68 3.15M18.001 4v4h-4m-7.652 8.35a7.13 7.13 0 0 0 12.68-3.15M6 20v-4h4" />
                        </svg>

                        <span class="sr-only">Search</span>
                    </button>
                </form>
            </div>

            <a class="rounded-lg bg-green-500 px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-green-600 focus:outline-none focus:ring-4 focus:ring-green-300"
                href="{{ route('employee.create') }}">Tambah Data</a>
        </div>
        @if (count($employees) > 0)
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-center text-sm text-gray-500">
                    <thead class="0 bg-gray-50 text-xs uppercase text-gray-700">
                        <tr>
                            <th class="px-6 py-3" scope="col">
                                No
                            </th>
                            <th class="px-6 py-3" scope="col">
                                Nama
                            </th>
                            <th class="px-6 py-3" scope="col">
                                NIK
                            </th>
                            <th class="px-6 py-3" scope="col">
                                Status
                            </th>
                            <th class="px-6 py-3" scope="col">
                                Tunjangan Kesehatan
                            </th>
                            <th class="px-6 py-3" scope="col">
                                Tunjangan Bencana
                            </th>
                            <th class="px-6 py-3" scope="col">
                                Tunjangan Transportasi
                            </th>
                            <th class="px-6 py-3" scope="col">
                                Tunjangan Jabatan
                            </th>
                            <th class="px-6 py-3" scope="col">
                                Tunjangan Makanan
                            </th>
                            <th class="px-6 py-3" scope="col">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($employees as $employee)
                            <tr class="border-b bg-white font-medium hover:bg-gray-50">
                                <th class="whitespace-nowrap px-6 py-4 text-gray-900" scope="row">
                                    {{ $loop->iteration }}
                                </th>
                                <td class="px-6 py-4">
                                    {{ $employee->user->name }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $employee->nik }}
                                </td>
                                <td class="px-6 py-4 capitalize">
                                    {{ $employee->status }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $employee->kesehatan }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $employee->bencana }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $employee->transportasi }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $employee->jabatan }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $employee->makanan }}
                                </td>
                                <td class="flex items-center space-x-1 px-6 py-4">
                                    <a class="text-blue-600 hover:underline"
                                        href="{{ route('employee.show', $employee) }}">Detail</a>
                                    <a class="text-cyan-600 hover:underline"
                                        href="{{ route('employee.edit', $employee) }}">Edit</a>
                                    <form class="inline-block" action="{{ route('employee.destroy', $employee) }}"
                                        method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <a class="cursor-pointer text-rose-600 hover:underline"
                                            onclick="return confirm('Apakah kamu yakin untuk menghapus karyawan ini?') ? this.parentElement.submit() : null">Hapus</a>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="w-full rounded-lg bg-white p-5 text-center">
                Tidak ada data
            </div>
        @endif
    </div>
@endsection
