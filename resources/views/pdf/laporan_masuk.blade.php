<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        table{
            border-collapse: collapse;  
            border: 1px solid black;
             width: 100%;
        }
        table
        tr
        td,th{ 
            border: 1px solid black;

        }
    </style>
</head>
<body>
    <div style="text-align: center">
        <h5>LAPORAN ASET MASUK</h5>
        <p>periode : {{$start_date }} - {{$end_date}}</p>
    </div>
    <table style="">
        <tr>
            <th>tanggal aset masuk</th>
            <th>kode masuk</th>
            <th>verifikasi</th>
            <th>keterangan</th>
            <th>list aset</th>
        </tr>
        @foreach ($data as $d)
        <tr>
            <td>{{$d->tanggal_masuk->format('d-m-Y')}}</td>
            <td>{{$d->kode_masuk}}</td>
            <td>{{$d->verifikasi ? 'sudah' : 'belum'}}</td>
            <td>{{$d->keterangan}}</td>
            <td>
                <table style=" ">
                    <tr>
                        <td>kode</td>
                        <td>aset</td>
                        <td>ruangan</td>
                    </tr>
                @foreach ($d->detail_asets as $aset)
                    <tr>
                        <td>{{$aset->kode_detail_aset}}</td>
                        <td>{{$aset->aset->nama}}</td>
                        <td>{{$aset->ruangan->ruangan}}</td>
                    </tr>    
                @endforeach
                </table>

            </td>
        </tr>
    
        @endforeach
     
    </table>
</body>
</html>
