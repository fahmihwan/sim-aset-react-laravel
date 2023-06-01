<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        *{
            margin: 0px;
            padding: 0px;
        }
        body{
            padding: 10px;
        }
            table#detail{
                border: 1px solid gray;
                border-collapse: collapse;
            }
            table#detail tr td,th{
                border: 1px solid gray;
            }
    
            table,tr,td{   
                margin-top: 10px; 
                padding: 0  10px;
                border-collapse: collapse;
                border: 0px;
            }
        </style>
</head>
<body>
    <div>
        <h5>Informasi Detail Aset Pemeliharaan</h5>
        <p>tanggal : {{date('d-m-Y')}}</p>
    </div>
    <div>   
        <table>
            <tr>
                <td>Kode Pemeliharaan</td>
                <td>{{$data->kode_pemeliharaan}}</td>
            </tr>
            <tr>
                <td>tanggal aset pemeliharaan</td>
                <td>{{$data->tanggal_pemeliharaan}}</td>
            </tr>
            <tr>
                <td>verifikasi</td>
                <td>{{$data->verifikasi ? 'sudah':'belum'}}</td>
            </tr>
            <tr>
                <td>keterangan</td>
                <td>{{$data->keterangan}}</td>
            </tr>
        </table>
    </div>
    <div >   
        <table id="detail">
            <thead>
                <th>kode</th>
                <th>aset</th>
                <th>kondisi</th>
                <th>ruangan</th>
            </thead>
            <tbody>
                @foreach ($data->detail_aset_pemeliharaans as $d)
                <tr>
                    <td>{{$d->detail_aset->kode_detail_aset}}</td>
                    <td>{{$d->detail_aset->aset->nama}}</td>
                    <td>{{$d->kondisi}}</td>
                    <td>{{$d->detail_aset->ruangan->ruangan}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    
</body>
</html>