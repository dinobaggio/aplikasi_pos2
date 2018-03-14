<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cetak Pembelian</title>
    <script src='<?= base_url('../assets/js/jquery-3.3.1.min.js') ?>'></script>
</head>

<style type="text/css">
    #outtable{
      padding: 20px;
      border:1px solid #e3e3e3;
      width: 650px;
      border-radius: 5px;
    }
 
    .short{
      width: 50px;
    }
 
    .normal{
      width: 150px;
    }
 
    table{
      border-collapse: collapse;
      font-family: arial;
      color:#5E5B5C;
    }
 
    thead th{
      text-align: left;
      padding: 10px;
    }
 
    tbody td{
      border-top: 1px solid #e3e3e3;
      padding: 10px;
    }
 
    tbody tr:nth-child(even){
      background: #F6F5FA;
    }
 
    tbody tr:hover{
      background: #EAE9F5
    }
</style>
<body>

    <div id="outtable">
    <?php
    foreach ($laporan as $data) : 
            $id_transaksi = $data->id_transaksi_pembelian;
            ?>  
        <table>
            <thead>
            <tr>
                <td colspan='5'><b>ID transaksi:</b> <?= $id_transaksi ?></td>
            </tr>
            <tr>
                <td colspan='5'><b>Tanggal buat:</b> <?= $data->created ?></td>
            </tr>
            <tr>
                <th>Nama Barang</th>
                <th>Harga Beli</th>
                <th>Jumlah Barang</th>
                <th>Jumlah Harga</th>
                <th>Nama Produsen</th>
            </tr>
            </thead>
            <tbody>
            <?php 
                $list_barang = $this->admin_model->detail_transaksi($id_transaksi);
                foreach ($list_barang as $barang) :
            ?>
                    <tr>
                    <td><?= $barang->nama_barang ?></td>
                    <td><?= $barang->harga_beli ?></td>
                    <td><?= $barang->jumlah_barang ?></td>
                    <td><?= $barang->jumlah_harga ?></td>
                    <td><?= $barang->nama_produsen ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <table>
            <thead>
                <tr>
                    <td><b>Total Barang:</b> <?= $data->total_barang ?></td>
                </tr>
                <tr>
                    <td><b>Total Harga:</b> <?= $data->total_harga ?></td>
                </tr>
            </thead>
        </table>
        <br>
        
        <?php endforeach; ?>
    </div>
    
</body>
</html>