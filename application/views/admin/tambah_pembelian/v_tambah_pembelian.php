<div id='tambah_pembelian' align="center" class='container'>

<table class='table-bordered'>
        <tr><td colspan='2' align='center'><h4><?= $title ?></h4></td></tr>
        <tr>
            <th scope="col" colspan='2' >Nama Produsen</th>
        </tr>

        <tr v-for="produsen in data_produsen">
            <td>{{produsen.nama_produsen}}</td> 
            <td><a v-bind:href="'<?= base_url('admin/tambah_pembelian/') ?>' + produsen.id_produsen"
            class="btn btn-success btn-sm">Pilih</a></td>
        </tr>
    </table>


</div>

<script>

let data_produsen = <?= $data_produsen ?>;
let vm = new Vue({
    el : "#tambah_pembelian",
    data: {
        data_produsen : data_produsen
    }
});

</script>