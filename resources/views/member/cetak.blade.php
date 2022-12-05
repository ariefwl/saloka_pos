<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ config('app.name') }} | @yield('title')</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <style>
        .text-center {
            text-align: center;
        }
    </style>
</head>
<body>
    <section style="border: 1px solid">
        <table width="100%">
            @foreach ($datamember as $key => $data )
                <tr>
                    @foreach ($data as $item)
                        <td class="text-center" width="50%">
                            <div class="box">
                                <p>{{ $setting->nama_perusahaan }}</p>
                                <img src="{{ asset('/public/images/logo.png') }}" alt="logo">
                            </div>
                            <div class="nama">{{ $item->nama }}</div>
                            <div class="telepon">{{ $item->telepon }}</div>
                            <div class="barcode text-left">
                                <img src="data:image/png;base64, {{ DNS2D::getBarcodePNG("$item->kode_member", 'QRCODE') }}" alt="qrcode" height="45" width="45">
                            </div>
                        </td>

                        @if (count($datamember) == 1)
                            <td class="text-center" style="width: 50%"></td>
                        @endif
                    @endforeach
                </tr>
            @endforeach
        </table>
    </section>
</body>
</html>
