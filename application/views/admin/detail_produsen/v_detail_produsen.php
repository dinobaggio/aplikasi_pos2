<div id="detail_produsen">

<h3><?= $title ?></h3>

            

    <table>
        <tr>
            <th >Nama Produsen</th><th>: <?= $data_produsen->nama_produsen ?></th>
        </tr>
        
        <tr>
            <th>List Barang</th>
            <th>
                <!-- <?= form_open("admin/tambah_barang") ?>
                <?= form_input(array( 'name'=> 'id_produsen', 'value' => $id_produsen, 'type'=>'hidden' )) ?>
                <?= form_submit(array( 'value'=>'Tambah Barang' )) ?>
                <?= form_close() ?> -->

                <a href="<?= base_url('admin/tambah_barang/'.$id_produsen) ?>">Tambah Barang</a>
            </th>
            
        </tr>

        <tr>
            <th>ID Barang</th>
            <th>Nama Barang</th>
            <th>Stok Barang</th>
            <th>Harga Jual</th>
            <th>Harga Beli</th>
        </tr>

        <tr v-if='tr_barang' v-for="barang in data_barang">
            <td>{{barang.id_barang}}</td>
            <td>{{barang.nama_barang}}</td>
            <td>{{barang.stok_barang}}</td>
            <td>{{barang.harga_jual}}</td>
            <td>{{barang.harga_beli}}</td>
        </tr>
    </table>

</div>

<script>

let data_barang = <?= $data_barang ?>;

let vm = new Vue({
    el : "#detail_produsen",
    data : {
        data_barnag : data_barang,
        tr_barang : false
    },
    methods : {
        cek_data_barang : function () {
            if (data_barang == null) {
                this.tr_barang = false;
            } else {
                this.tr_barang = true;
            }
        }
    }
});

vm.cek_data_barang();

</script>