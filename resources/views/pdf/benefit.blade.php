<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PDF | Tunjangan</title>
    <style>
        body {
            font-family: 'Helvetica', sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 90%;
            margin: auto;
            padding: 20px;
        }

        .tunjangan-details {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        .list-group-item {
            border: none;
            border-bottom: 1.5px solid #e9e8e8;
            padding: 10px 0;
        }

        .list-group-item p {
            margin: 0;
            padding: 0;
        }

        .list-group-item:first-child {
            border-bottom: 1.5px solid #e9e8e8;
        }

        .d-sm-flex {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .h5 {
            font-size: 1.25rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
        }

        .fw-bold {
            font-weight: bold;
        }

        .text-primary {
            color: #0d6efd;
        }

        .text-warning {
            color: #ffc107;
        }

        .text-danger {
            color: #dc3545;
        }

        .text-capitalize {
            text-transform: capitalize;
        }

        .card {
            border: none;
            margin-top: 30px;
        }

        .card-img-top {
            width: 100%;
            border-radius: 10px;
            max-width: 400px;
            max-height: 400px;
            border: 2px solid #e9e8e8;
            padding: 5px;
        }

        .rounded-4 {
            border-radius: 10px;
        }
    </style>
</head>

<body>
    <div class="container">
        <p>Tunjangan / Kode : #{{ $benefit->code }}</p>

        <div class="row" style="display: flex; justify-content: space-between;">
            <div class="col" style="flex: 1;">
                <ul class="list-group tunjangan-details">
                    <li class="list-group-item">
                        <p class="h5">Tunjangan Detail</p>
                    </li>
                    <li class="list-group-item mt-3">
                        <div class="d-sm-flex justify-content-between">
                            <p class="fw-bold">Jenis Tunjangan</p>
                            <p class="text-capitalize">{{ str_replace('_', ' ', $benefit->type) }}</p>
                        </div>
                    </li>
                    <li class="list-group-item mt-2">
                        <div class="d-sm-flex justify-content-between">
                            <p class="fw-bold">Status</p>
                            @php
                                $status = strtolower($benefit->status->value);
                                [$color, $text] = match ($status) {
                                    'done' => ['text-primary', 'Selesai'],
                                    'progress' => ['text-warning', 'Proses'],
                                    'pending' => ['text-warning', 'Menunggu'],
                                    'reject' => ['text-danger', 'Ditolak'],
                                    default => ['text-gray-800', 'Unknown'],
                                };
                            @endphp

                            <p class="{{ $color }}">{{ $text }}</p>

                        </div>
                    </li>
                    <li class="list-group-item mt-2">
                        <div class="d-sm-flex justify-content-between">
                            <p class="fw-bold">Tanggal</p>
                            <p class="text-capitalize">{{ $benefit->created_at->translatedFormat('d F Y') }}</p>
                        </div>
                    </li>
                    <li class="list-group-item mt-2">
                        <div class="d-sm-flex justify-content-between">
                            <p class="fw-bold">Besar Tunjangan</p>
                            <p class="text-capitalize">Rp {{ number_format($benefit->amount, 0, '', '.') }}
                            </p>
                        </div>
                    </li>
                    <li class="list-group-item mt-2">
                        <p class="fw-bold">Pesan</p>
                        <p class="text-capitalize">{{ $benefit->message }}</p>
                    </li>
                </ul>
            </div>
            <div class="col" style="flex: 1;">
                <div class="card">
                    <img class="card-img-top rounded-4" src="{{ public_path("images/$benefit->file") }}">
                </div>
            </div>
        </div>
    </div>
</body>

</html>
