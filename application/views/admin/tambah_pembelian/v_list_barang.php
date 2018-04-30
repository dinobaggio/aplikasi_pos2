<h2><?= $title ?></h2>
<div id='list_barang_produsen' class=''>

    <table class=''>
        

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
            <td v-bind:id="'barang'+barang.id_barang" ></td> 
        </tr>

        <tr>
            <th colspan='3'></th>
        </tr>
            
    </table>

    <br>   
    <a href="<?= base_url('admin/tambah_pembelian') ?>" class="btn btn-secondary btn-sm">Back</a>

</div>

<script>
let data_barang = <?= $data_barang ?>;
let vm = new Vue({
    el: '#list_barang_produsen',
    data : {
        data_barang : data_barang
    },
    methods : {
        cek_barang : function () {
            let keranjang = localStorage.keranjang;
            if (keranjang != null) {
                if (keranjang[0] == '[' && keranjang[keranjang.length-1] == ']') {
                    keranjang = JSON.parse(keranjang);
                    let ob_keranjang = keranjang.filter(function (keranjang) {
                        return keranjang != null;
                    });
                    if (ob_keranjang[0] != null) {
                        for (let i=0;i<ob_keranjang.length;i++) {
                            let filter = ob_keranjang[i].filter(function (data) {
                                return data != null;
                            });
                            
                            if (filter[0] != null) {
                                for(let i=0;i< filter.length;i++) {
                                    let el_select = $('#barang'+filter[i].id_barang);
                                    el_select.html('selected');
                                } 
                            }
                        }
                    }
                }
            }
        }
    }
});

vm.cek_barang();

</script>