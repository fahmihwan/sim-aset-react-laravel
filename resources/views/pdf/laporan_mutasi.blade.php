<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        *{
            margin: 0;
            padding: 5px;
        }
        table#first{
            border: 1px solid gray;
            border-collapse: collapse;
            width:100%
        }
        table#first th,td{
            text-align: center; 
            border: 1px solid gray;
        }
        table.second{
            width: 100%;
            border-collapse: collapse;
        }

        table.second  td{
            text-align: left;
            font-size: 12px;
            padding: 0px;
            border: 0px;
        }         
    </style>
</head>
<body>
    <div style="text-align: center; padding: 20px;">
        <h5>LAPORAN ASET MUTASI</h5>
        <p>periode : {{$start_date }} - {{$end_date}}</p>
    </div>
    <table id="first">
        <tr>
            <th >tanggal mutasi</th>
            <th >kode mutasi</th>
            <th>verifikasi</th>
            <th >keterangan</th>
            <th >list aset</th>
        </tr>
        @foreach ($data as $d)
        <tr>
            <td>{{$d->tanggal_mutasi}}</td>
            <td>{{$d->kode_mutasi}}</td>
            <td>{{$d->verifikasi ? 'sudah' : 'belum'}}</td>
            <td>{{$d->keterangan}}</td>
            <td>
                <table class="second">
                @foreach ($d->detail_aset_mutasis as $aset)
                <tr>
                    <td style="border-bottom: 1px solid gray;">{{$aset->detail_aset->kode_detail_aset}}</td>
                    <td style="border-bottom: 1px solid gray;">{{$aset->detail_aset->aset->nama}}</td>
                    <td style="border-bottom: 1px solid gray;">{{$aset->asal_ruangan->ruangan }} - {{$aset->tujuan_ruangan->ruangan}}</td>
                </tr>
                @endforeach
                </table>

            </td>
        </tr>
    
        @endforeach
     
    </table>
</body>
</html>
