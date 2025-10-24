<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Pengaduan Sarpras</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        th { background: #f2f2f2; }
        h2 { text-align: center; margin-bottom: 10px; }
    </style>
</head>
<body>
    <h2>Laporan Pengaduan Sarana & Prasarana</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Pengaduan</th>
                <th>Pelapor</th>
                <th>Lokasi</th>
                <th>Barang</th>
                <th>Status</th>
                <th>Tanggal Pengajuan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($laporan as $item)
                <tr>
                    <td>{{ $item->id_pengaduan }}</td>
                    <td>{{ $item->nama_pengaduan }}</td>
                    <td>{{ $item->user->name ?? '-' }}</td>
                    <td>{{ $item->lokasi->nama_lokasi ?? '-' }}</td>
                    <td>{{ $item->item->nama_item ?? '-' }}</td>
                    <td>{{ $item->status }}</td>
                    <td>{{ $item->tgl_pengajuan }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
