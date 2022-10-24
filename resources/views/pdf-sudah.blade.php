<!DOCTYPE html>
<html>
   <head>
      <title>PDF | Tunjangan Selesai Proses</title>
      <style>
         table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
         }

         td,
         th {
            border: 1.5px solid #e9e8e8;
            text-align: left;
            padding: 12px;
            text-align: center !important;
         }

         tr:nth-child(even) {
            background-color: #e9e8e8;
         }

         .isi {
            font-size: 0.93rem !important;
         }
      </style>
   </head>
   <body>
      <h2 style="text-align: center;">Tunjangan Sudah Selesai</h2>

      <table>
         <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Tanggal</th>
            <th>Kode</th>
            <th>Jenis Tunjangan</th>
            <th>Besar Tunjangan</th>
         </tr>
         @foreach ($tunjangans as $tunjangan)
         <tr class="isi">
            <th>{{ $loop->iteration }}</th>
            <td >{{ $tunjangan->karyawan->nama }}</td>
            <td>{{ $tunjangan->created_at->translatedFormat('d M Y') }}</td>
            <td >{{ $tunjangan->kode }}</td>
            <td style="text-transform: capitalize">{{ str_replace("_", " ", $tunjangan->jenis_tunjangan) }}</td>
            <td>Rp. {{ number_format($tunjangan->besar_tunjangan, 0, '', '.') }}</td>
         </tr>
         @endforeach
         <tr class="isi">
            <td colspan="5" style="font-weight: 600">Jumlah Tunjangan</td>
            <td>Rp. {{ number_format($jumlahTunjangan, 0, '', '.') }}</td>
         </tr>
      </table>
   </body>
</html>
