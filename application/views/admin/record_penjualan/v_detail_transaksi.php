<div id="detail_transaksi">
    <table>
        <tr>
            <th colspan='3' >ID Transaksi Penjualan : </th>
            <td colspan='2' ><?= $id_transaksi ?></td>
        </tr>
        <tr>
            <th colspan='5' >List Barang Transaksi</th>
        </tr>
        <tr>
            <th>Nama Barang</th>
            <th>Harga Jual</th>
            <th>Jumlah Barang</th>
            <th>Jumlah Harga</th>
            <th>Nama Produsen</th>
        </tr>
        <?php foreach ($data_transaksi as $data) : ?>
        <tr>
            <td><?= $data->nama_barang ?></td>
            <td><?= $data->harga_jual ?></td>
            <td><?= $data->jumlah_barang ?></td>
            <td><?= $data->jumlah_harga ?></td>
            <td><?= $data->nama_produsen ?></td>
        </tr>
        <?php endforeach ; ?>
    </table>
</div>