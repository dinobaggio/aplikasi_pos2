<div id='record_transaksi' class='container' align="center">

    <table class='table-bordered'>
        <tr><td colspan='5' align='center'><h4><?= $title ?></h4></td></tr>
        <tr>
            <th>Transaksi</th>
            <th>Total Barang</th>
            <th>Total Harga</th>
            <th>Time</th>
            <th>Detail</th>
        </tr>

        <tr v-for="data in data_transaksi">
            <td>#{{data.id_transaksi_penjualan}}</td>
            <td>{{data.total_barang}}</td>
            <td>{{data.total_harga}}</td>
            <td>{{data.created}}</td>
            <td><a v-bind:href="'<?= base_url('barang/detail_transaksi/') ?>'+data.id_transaksi_penjualan" class='btn btn-secondary btn-sm' >Detail</a></td>
        </tr>
        <tr><td colspan='5' align='center'><?= $page_links ?></td></tr>
    </table>

    

</div>

<script>
let data = <?= $data_transaksi ?>;

let vm = new Vue({
    el : '#record_transaksi',
    data : {
        data_transaksi : data
    }
});

</script>