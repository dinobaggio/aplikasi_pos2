<div id='list_barang_produsen' align="center" class='container'>
<h3><?= $title ?></h3>
    <table class='table-bordered'>
        <tr>
            <th colspan='3'><a href="<?= base_url('admin/tambah_pembelian') ?>" class="btn btn-info btn-sm">Back</a></th>
        </tr>

        <tr>
            <th>ID Barang</th>
            <th>Nama Barang</th>
            <th>Pilih Barang</th>
        </tr>

        <tr v-for="barang in data_barang">
            <td>{{barang.id_barang}}</td>
            <td>{{barang.nama_barang}}</td>
            <td><a 
            v-bind:href="'<?= base_url('admin/detail_barang_beli/') ?>'+barang.id_barang+'produsen'+'<?= $id_produsen ?>'" 
            class="btn btn-success btn-sm">Pilih</a></td>   
        </tr>
            
    </table>


</div>

<script>
let data_barang = <?= $data_barang ?>;
let vm = new Vue({
    el: '#list_barang_produsen',
    data : {
        data_barang : data_barang
    }
});

</script>