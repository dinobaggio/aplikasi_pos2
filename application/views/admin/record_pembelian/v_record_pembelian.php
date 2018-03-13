<div id='record_pembelian' align="center" class='container'>
<h3>Record pembelian</h3>

    
    <table class='table-bordered'>
    <tr>
        <th>ID</th>
        <th>Total Barang</th>
        <th>Total Harga</th>
        <th>Created</th>
        <th>Detail</th>
    </tr>
    
    <?php foreach ($data_transaksi as $data) : ?>
    <tr>
        <td>#<?= $data->id_transaksi_pembelian ?></td>
        <td><?= $data->total_barang ?></td>
        <td><?= $data->total_harga ?></td>
        <td> <?php
            $date = strtotime($data->created);
            echo date("Y-m-d h:i:s", $date);
        ?></td>
        <?= form_open(base_url('admin/detail_transaksi'))?>
        <td>
            <?= form_input(array('value'=>$data->id_transaksi_pembelian, 'type'=>'hidden', 'name'=>'id_transaksi_pembelian')); ?>
            <?= form_submit(array('value'=>'Detail')) ?>
        </td>
        <?= form_close(); ?>
    </tr>
    <?php endforeach; ?>

    </table>
    

</div>