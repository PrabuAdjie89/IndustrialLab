<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">

    <style>
        body {
            font-family: sans-serif;
        }

        .container {
            width: 100%;
        }

        .label {
            width: 30%;
            border: 1px solid #000;
            padding: 10px;
            text-align: center;
            display: inline-block;
            margin: 5px;
            vertical-align: top;
            height: 180px;
        }

        .qr {
            margin-top: 10px;
            margin-bottom: 10px;
        }

        .kode {
            font-size: 12px;
            font-weight: bold;
            margin-top: 10px;
        }

        .nama {
            font-size: 11px;
            margin-top: 5px;
        }
    </style>
</head>

<body>

<div class="container">

    @foreach($barang->units as $unit)

        <div class="label">

            @php
                $qr = base64_encode(
                    QrCode::size(100)
                        ->generate(url('/inventory/' . $unit->kode_unit))
                );
            @endphp

            <div class="qr">
                <img src="data:image/svg+xml;base64,{{ $qr }}">
            </div>

            <div class="kode">
                {{ $unit->kode_unit }}
            </div>

            <div class="nama">
                {{ $barang->nama_barang }}
            </div>

        </div>

    @endforeach

</div>

</body>
</html>