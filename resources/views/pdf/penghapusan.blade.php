<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>

        table#detail{
            border: 1px solid gray;
            border-collapse: collapse
        }
        table,tr,td{    
            border: 1px solid gray;
        }
    </style>
</head>
<body>
    <div>
        <h5>Informasi Detail Aset Penghapusan</h5>
        <p>tanggal : 12-12-2012</p>
    </div>
    <div>   
        <table>
            <tr>
                <td>Kode Masuk</td>
                <td>AST123123123123</td>
            </tr>
            <tr>
                <td>tanggal aset penghapusan</td>
                <td>12-02-2022</td>
            </tr>
            <tr>
                <td>verifikasi</td>
                <td>sudah</td>
            </tr>
            <tr>
                <td>keterangan</td>
                <td>
                    dasdsadsadasdsasdadkljds
                </td>
            </tr>
        </table>
    </div>
    <div >   
        <table id="detail">
            <thead>
                <th>kode</th>
                <th>aset</th>
                <th>kondisi</th>
                <th>asal</th>
                <th>tujuan</th>
            </thead>
            <tbody>
                @foreach ($data as $d)
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    
</body>
</html>