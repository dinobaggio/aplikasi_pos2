

<div id='detail_transaksi' class='container' align="center">

    <table class='table-bordered'>
        <tr><td colspan='5' align='center'><h4><?= $title ?></h4></td></tr>
        <tr>
            <th>Penjualan</th>
            <th>Nama Barang</th>
            <th>Jumlah Barang</th>
            <th>Jumlah Harga</th>
            <th>Created</th>
        </tr>

        <tr v-for="transaksi in data_transaksi">
            <td>#{{transaksi.id_penjualan}}</td>
            <td>{{transaksi.nama_barang}}</td>
            <td>{{transaksi.jumlah_barang}}</td>
            <td>{{transaksi.jumlah_harga}}</td>
            <td>{{transaksi.created}}</td>
        </tr>
        
    </table>

    

</div>

<script>

let data_transaksi = <?= $detail_transaksi ?>

let vm = new Vue({
    el : "#detail_transaksi", 
    data : {
        data_transaksi: data_transaksi
    }
});


</script>