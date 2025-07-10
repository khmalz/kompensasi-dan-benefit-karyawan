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

        @if (session()->has('error'))
            <div class="mb-4 rounded-lg bg-red-50 p-4 text-sm text-red-800" id="password_berhasil" role="alert">
                {{ session('error') }}
            </div>
        @endif

        @if (session()->has('success'))
            <div class="mb-4 rounded-lg bg-green-50 p-4 text-sm text-green-800" id="password_berhasil" role="alert">
                {{ session('success') }}
            </div>
        @endif

        @if (\Illuminate\Support\Facades\Hash::check('password', auth()->user()->getAuthPassword()))
            <div class="w-full rounded-lg bg-white p-5">
                <h2 class="mb-3 text-xl font-semibold">Ganti Password</h2>

                <form action="{{ route('password.change') }}" method="POST">
                    @csrf
                    @method('PATCH')

                    <div class="mb-5">
                        <label class="mb-2 block text-sm font-medium text-gray-900" for="old_password">Password Lama</label>
                        <input
                            class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 shadow-sm focus:border-green-500 focus:ring-green-500"
                            id="old_password" name="old_password" type="password" placeholder="password" required>
                        <div class="mb-4 mt-1.5 flex items-center">
                            <input
                                class="h-4 w-4 rounded border-gray-300 bg-gray-100 text-green-600 focus:ring-2 focus:ring-green-500"
                                id="checkbox-old-password" type="checkbox"
                                onclick="togglePasswordVisibility('old_password', this)">
                            <label class="ms-1 text-sm font-medium text-gray-900 selection:normal-case"
                                for="checkbox-old-password">Show
                                Password</label>
                        </div>
                        @error('old_password')
                            <p class="mt-2 text-sm font-semibold text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-5">
                        <label class="mb-2 block text-sm font-medium text-gray-900" for="password">Password Baru</label>
                        <input
                            class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 shadow-sm focus:border-green-500 focus:ring-green-500"
                            id="password" name="password" type="password" placeholder="password" required>
                        <div class="mb-4 mt-1.5 flex items-center">
                            <input
                                class="h-4 w-4 rounded border-gray-300 bg-gray-100 text-green-600 focus:ring-2 focus:ring-green-500"
                                id="checkbox-password" type="checkbox" onclick="togglePasswordVisibility('password', this)">
                            <label class="ms-1 text-sm font-medium text-gray-900 selection:normal-case"
                                for="checkbox-password">Show
                                Password</label>
                        </div>
                        @error('password')
                            <p class="mt-2 text-sm font-semibold text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-5">
                        <label class="mb-2 block text-sm font-medium text-gray-900" for="password_confirmation">Konfirmasi
                            Password</label>
                        <input
                            class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 shadow-sm focus:border-green-500 focus:ring-green-500"
                            id="password_confirmation" name="password_confirmation" type="password" placeholder="password"
                            required>
                        <div class="mb-4 mt-1.5 flex items-center">
                            <input
                                class="h-4 w-4 rounded border-gray-300 bg-gray-100 text-green-600 focus:ring-2 focus:ring-green-500"
                                id="checkbox-password-confirmation" type="checkbox"
                                onclick="togglePasswordVisibility('password_confirmation', this)">
                            <label class="ms-1 text-sm font-medium text-gray-900 selection:normal-case"
                                for="checkbox-password-confirmation">Show
                                Password</label>
                        </div>
                        @error('password_confirmation')
                            <p class="mt-2 text-sm font-semibold text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <button
                        class="rounded-lg bg-green-700 px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-green-800 focus:outline-none focus:ring-4 focus:ring-green-300"
                        type="submit">Save Changes</button>
                </form>
            </div>
        @else
            <div class="w-full rounded-lg bg-white p-5">
                <h2 class="mb-3 text-xl font-semibold">Permintaan Tunjangan</h2>

                <form action="{{ route('benefit.store') }}" enctype="multipart/form-data" method="POST">
                    @csrf

                    <input name="employee_id" type="hidden" value="{{ auth()->user()->employee->id }}">
                    <input id="employeeNIK" name="employee_nik" type="hidden" value="{{ auth()->user()->employee->nik }}">

                    <div class="mb-5">
                        <label class="mb-2 block text-sm font-medium text-gray-900" for="jenis_tunjangan">Jenis
                            Tunjangan</label>
                        <select
                            class="decorated block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-green-500 focus:ring-green-500"
                            id="jenis_tunjangan" name="type">
                            <option selected disabled>Pilih Jenis</option>
                            <option value="kesehatan" @selected(old('type') == 'kesehatan')>
                                Kesehatan
                            </option>
                            <option value="bencana" @selected(old('type') == 'bencana')>
                                Bencana</option>
                            <option value="transportasi" @selected(old('type') == 'transportasi')>
                                Transportasi</option>
                            <option value="jabatan" @selected(old('type') == 'jabatan')>
                                Jabatan</option>
                            <option value="makanan" @selected(old('type') == 'makanan')>
                                Makanan</option>
                        </select>
                        @error('type')
                            <p class="mt-2 text-sm font-semibold text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-2">
                        <label class="mb-2 block text-sm font-medium text-gray-900" for="besar_tunjangan">Besar
                            Tunjangan</label>
                        <input
                            class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 shadow-sm focus:border-green-500 focus:ring-green-500"
                            id="besar_tunjangan" name="amount" type="text" value="{{ old('amount') }}"
                            placeholder="1.000.000" required>
                        @error('amount')
                            <p class="mt-2 text-sm font-semibold text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="text-xs md:text-sm" id="wadah"></div>
                    <div class="mb-5 text-xs md:text-sm" id="peringatan"></div>

                    <div class="mb-5">
                        <label class="mb-2 block text-sm font-medium text-gray-900" for="message">Pesan</label>
                        <textarea
                            class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-green-500 focus:ring-green-500"
                            id="message" name="message" rows="4" placeholder="Tulis pesan yang ingin disampaikan">{{ old('message') }}</textarea>
                        @error('message')
                            <p class="mt-2 text-sm font-semibold text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-5">
                        <div class="w-full md:w-1/2 lg:w-1/3">
                            <label class="mb-2 block text-sm font-medium text-gray-900" for="dropzone-file">File
                                Pendukung</label>
                            <label
                                class="flex h-52 w-full cursor-pointer flex-col items-center justify-center rounded-lg border-2 border-dashed border-gray-300 bg-gray-50 hover:bg-gray-100"
                                id="dropzone-label" for="dropzone-file">
                                <div class="flex flex-col items-center justify-center pb-6 pt-5">
                                    <svg class="mb-4 h-8 w-8 text-gray-500" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                                    </svg>
                                    <p class="mb-2 text-center text-sm text-gray-500" id="file-name"><span
                                            class="font-semibold">Click
                                            to
                                            upload</span> or drag and drop</p>
                                    <p class="text-xs text-gray-500">PNG|JPG|JPEG (MAX. 2 MB).</p>
                                </div>
                                <input class="hidden" id="dropzone-file" name="file" type="file"
                                    accept=".png,.jpg,.jpeg" />
                            </label>
                            @error('file')
                                <p class="mt-2 text-sm font-semibold text-rose-500">{{ $message }}</p>
                            @enderror

                            <div id="image-container">
                            </div>
                        </div>
                    </div>

                    <button
                        class="rounded-lg bg-green-700 px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-green-800 focus:outline-none focus:ring-4 focus:ring-green-300"
                        id="send-button" type="submit">Kirim</button>
                </form>

            </div>
        @endif
    </div>
@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-maskmoney/3.0.2/jquery.maskMoney.min.js"
        integrity="sha512-Rdk63VC+1UYzGSgd3u2iadi0joUrcwX0IWp2rTh6KXFoAmgOjRS99Vynz1lJPT8dLjvo6JZOqpAHJyfCEZ5KoA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" type="module"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if ($("#password_berhasil").length) {
                setTimeout(() => {
                    $("#password_berhasil").attr('hidden', true);
                }, 3000);
            }

            $("#besar_tunjangan").maskMoney({
                thousands: '.',
                decimal: ',',
                precision: 0,
                allowZero: true,
                allowNegative: false,
            });

            $("#jenis_tunjangan").on('change', function() {
                let data = $(this).val()
                tampilkanSisaTunjangan(data)
            })

            var selectedValue = $("#jenis_tunjangan").val();
            if (selectedValue) {
                $("#jenis_tunjangan").change();
            }
        })
    </script>
    <script>
        function convertRupiah(angka) {
            var reverse = angka.toString().split('').reverse().join(''),
                ribuan = reverse.match(/\d{1,3}/g);
            ribuan = ribuan.join('.').split('').reverse().join('');
            return ribuan;
        }

        function tampilkanSisaTunjangan(jenis) {
            const employeeNIK = $("#employeeNIK").val();

            axios.get(`/employee/benefits/${employeeNIK}`)
                .then(function(response) {
                    var res = response.data;
                    var $wadah = $("#wadah");
                    var $peringatan = $("#peringatan");
                    var $besarTunjangan = $("#besar_tunjangan");
                    var $sendButton = $("#send-button");
                    var $pemberitahuan = $('<span>', {
                        class: 'text-blue-500',
                        id: 'pemberitahuan'
                    });

                    $wadah.add($peringatan).empty();
                    $besarTunjangan.add($sendButton).removeAttr('disabled');

                    $wadah.html('Sisa Tunjangan Kamu ').append($pemberitahuan);
                    $pemberitahuan.text("Rp. " + convertRupiah(res[jenis]));

                    if (res[jenis] <= 0) {
                        $peringatan.html(
                            'Jatah Tunjangan Kamu <span class="text-rose-500">Sudah Habis, Tidak Bisa Pilih Tunjangan Tersebut</span>'
                        );
                        $besarTunjangan.add($sendButton).attr('disabled', 'true');
                    }
                })
                .catch(function(error) {
                    console.log(error);
                });
        }

        function togglePasswordVisibility(inputId, checkbox) {
            const inputElement = document.getElementById(inputId);
            if (checkbox.checked) {
                inputElement.type = 'text';
            } else {
                inputElement.type = 'password';
            }
        }

        const dt = new DataTransfer();

        function deleteImagePre() {
            const imageDiv = $("#image-container")

            dt.items.clear();

            imageDiv.html('');
        }

        function handleFileCount() {
            const fileCount = dt.files.length;
            $("#file-name").text(dt.items[0].getAsFile().name);
        }

        function handleFiles(files) {
            const dropzoneFileInput = $("#dropzone-file");
            const imageContainer = $("#image-container");
            const allowedExtensionsDesign = ["png", "jpg", "jpeg"];

            if (files.length > 0) {
                const file = files[0];

                const fileExtension = file.name.split(".").pop().toLowerCase();
                if (!allowedExtensionsDesign.includes(fileExtension)) {
                    const validationHtml =
                        `<p id="validationFile" class="mt-2 text-sm font-semibold text-rose-500">Hanya file dengan format yang diizinkan.</p>`
                    $("#dropzone-label").next(`#validationFile`).remove().end().val("").after(
                        validationHtml);
                } else {
                    deleteImagePre()

                    $("#dropzone-label").next(`#validationFile`).remove();

                    dt.items.add(file);

                    const blob = URL.createObjectURL(file);
                    const imageHTML = `
                        <div class="mt-2" id="image-pre">
                            <img class="w-full border rounded-md shadow-sm h-60"
                                src="${blob}"
                                alt="preview-image">
                        </div>
                    `;
                    imageContainer.html(imageHTML);

                    dropzoneFileInput[0].files = dt.files;
                    handleFileCount();
                }
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const dropzoneLabel = $("#dropzone-label");
            const dropzoneFileInput = $("#dropzone-file");

            dropzoneLabel.on('dragover', function(e) {
                e.preventDefault();
                $(this).addClass('border-primary-500');
            });

            dropzoneLabel.on('dragleave', function() {
                $(this).removeClass('border-primary-500');
            });

            dropzoneLabel.on('drop', function(e) {
                e.preventDefault();
                $(this).removeClass('border-primary-500');

                const droppedFiles = e.originalEvent.dataTransfer.files;
                handleFiles(droppedFiles);
            });

            dropzoneFileInput.change(function() {
                const selectedFiles = this.files;
                handleFiles(selectedFiles);
            });
        });
    </script>
@endpush
