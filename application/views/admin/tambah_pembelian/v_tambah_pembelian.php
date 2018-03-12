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

        <tr v-if='table_keranjang' >
            <td colspan='2' align='center'>
                <button class='btn btn-success btn-sm'>{{button_proses}}</button>
                <button v-on:click="clear()" class='btn btn-danger btn-sm'>Clear</button>
            </td>
        </tr>
    </table>
    

</div>

<script>

let data_produsen = <?= $data_produsen ?>;
let vm = new Vue({
    el : "#tambah_pembelian",
    data: {
        data_produsen : data_produsen,
        button_proses : 'Proses Keranjang',
        table_keranjang : false
    },
    methods : {
        cek_keranjang : function () {
            let keranjang = localStorage.keranjang;
            if (keranjang != null) {
                if (keranjang[0] =='[' && keranjang[keranjang.length-1] == ']') {
                    keranjang = JSON.parse(keranjang);
                    let filter = keranjang.filter(function (keranjang) {
                        return keranjang != null;
                    });
                    if (filter[0] != null) {
                        
                        this.table_keranjang = true;
                        this.button_proses = 'Proses Keranjang (' +filter.length+')';
                    }
                }
            } else {
                this.table_keranjang = false;
                this.button_proses = "Proses Keranjang";
            }
        },
        clear : function () {
            localStorage.removeItem('keranjang');
            this.cek_keranjang();
        }
    }
});

vm.cek_keranjang();

</script>