<div id='tambah_pembelian' align="center" class='container'>
<h3>Pembelian barang</h3>
<p>pilih produsen lalu pilih barang yang ingin dibeli</p>

    <table class='table-bordered'>
        <tr><td colspan='2' align='center'><h4><?= $title ?></h4></td></tr>
        <tr>
            <th scope="col" colspan='2' >Nama Produsen</th>
        </tr>

        <tr v-for="produsen in data_produsen">
            <td>{{produsen.nama_produsen}}</td> 
            <td><a v-bind:href="'<?= base_url('admin/tambah_pembelian/') ?>' + produsen.id_produsen"
            class="btn btn-success btn-sm">Pilih</a></td>
            <td v-bind:id="'produsen'+produsen.id_produsen"></td>
        </tr>

        <tr>
            <td colspan='2' align='center'>
                <button id="proses_barang" class='btn btn-success btn-sm'>{{button_proses}}</button>
                <button v-on:click="clear()" class='btn btn-danger btn-sm'>Clear</button>
            </td>
        </tr>
    </table>
    

</div>

<script>

let data_produsen = <?= $data_produsen ?>;
let el_proses = $("#proses_barang");

let vm = new Vue({
    el : "#tambah_pembelian",
    data: {
        data_produsen : data_produsen,
        button_proses : 'Proses Keranjang'
    },
    methods : {
        cek_keranjang : function () {
            let keranjang = localStorage.keranjang;
            let jumlah_barang = 0;
            let el_proses = $("#proses_barang");
            if (keranjang != null) {
                // pengacekan localStorage.keranjang array atau bukan
                if (keranjang[0] =='[' && keranjang[keranjang.length-1] == ']') {
                    keranjang = JSON.parse(keranjang);
                    // memfilter index dengan nilai kosong pada keranjang
                    let filter = keranjang.filter(function (keranjang) {
                        return keranjang != null;
                    });
                    // pengecekan bahwasannya keranjang yang telah di filter tidak kosong
                    if (filter[0] != null) {
                        // mem memfilter data didalam keranajang[produsen][barang]
                        for (let i=0;i<filter.length;i++) {
                            let data_produsen = filter[i].filter(function(data){
                                return data != null;
                            });
                            let produsen_string = JSON.stringify(data_produsen);
                            // memastikan data barang berupa array
                            if (produsen_string[0] == '[' && produsen_string[produsen_string.length-1] == ']') {
                                for (let i=0;i<data_produsen.length;i++) {
                                    let el_select = $("#produsen"+data_produsen[i].id_produsen);
                                    el_select.html('selected('+data_produsen.length+')');
                                }
                                jumlah_barang += data_produsen.length;
                            }
                        }
                        el_proses.attr('disabled', false);
                        this.button_proses = 'Proses Keranjang (' +jumlah_barang+')';
                    }
                }
            } else {
                el_proses.attr('disabled', true);
                this.button_proses = "Proses Keranjang";
            }
        },
        clear : function () {
            localStorage.removeItem('keranjang');
            window.open("<?= base_url('admin/tambah_pembelian') ?>", "_self");
        }
    }
});

vm.cek_keranjang();

</script>