<div id='record_pembelian' align="center" class='container'>
<h3>Record Penjualan</h3>

    
    <table class='table-bordered'>
    <tr>
        <th>ID Penjualan</th>
        <th>ID User</th>
        <th>Total Barang</th>
        <th>Total Harga</th>
        <th>Created</th>
        <th>Detail</th>
    </tr>
    
    <?php foreach ($data_transaksi as $data) : ?>
    <tr>
        <td>#<?= $data->id_transaksi_penjualan ?></td>
        <td>#<?= $data->id_user ?></td>
        <td><?= $data->total_barang ?></td>
        <td><?= $data->total_harga ?></td>
        <td> <?php
            $date = strtotime($data->created);
            echo date("Y-m-d h:i:s", $date);
        ?></td>
        <td>
            <a href="<?= base_url('admin/detail_transaksi_penjualan/') . $data->id_transaksi_penjualan?>" class="btn btn-info btn-sm">Detail</a>
        </td>
    </tr>
    <?php endforeach; ?>

    <tr>
        <td colspan="5" align="center"><?= $page_links ?></td>
    </tr>

    </table>
    

</div>