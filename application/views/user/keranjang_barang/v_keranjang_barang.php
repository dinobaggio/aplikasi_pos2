<div id='keranjang_barang' class='container' align="center">
    <table >
        <td><h4><?= $title ?></h4></td>
        <td><button v-if='clear' v-on:click='clear_keranjang()'>Clear</button></td>
    </table>
    <td v-if='kosong' ><p>{{pesan_kosong}}</p></td>
    
    
    

    <table class='table-bordered' v-if='table'>
        <tr>
            <th scope="col" >Id Barang</th>
            <th scope="col" >Nama Barang</th>
            <th scope="col" >Stok Barang</th>
            <th scope="col" >Harga</th>
            <th scope="col" >Jumlah</th>
            <th scope="col" >Detail</th>
        </tr>

        <tr v-for="barang in keranjang_data">
            <td>{{barang.id_barang}}</td>
            <td>{{barang.nama_barang}}</td>
            <td>{{barang.stok_barang}}</td>
            <td>{{barang.harga_jual}}</td>
            <td>{{barang.jumlah_beli}}</td>
            <td><a v-bind:href="'<?= base_url('home/detail_barang/') ?>'+barang.kode_barang" class='btn btn-secondary btn-sm'>Detail</a></td>
        </tr>
       
    </table>

</div>

<script>
let data = null;
let keranjang = localStorage.keranjang;
if (keranjang != null) {   
    if (keranjang[0] == '[' && keranjang[keranjang.length-1] == ']') {
        data = JSON.parse(keranjang);
        filter_data = data.filter(function(keranjang) {
            return keranjang != null;
        });
        data = filter_data;
    }
}

let vm = new Vue({
    el : '#keranjang_barang',
    data : {
        keranjang_data : data,
        pesan_kosong : '',
        table : false,
        clear: false,
        kosong : true
    }, 
    methods : {
        cek_keranjang : function () {
            if (this.keranjang_data != null) {
                this.table = true;
                this.clear = true;
                this.kosong = false;
            } else {
                this.pesan_kosong = 'Tidak ada barang yang di pilih!';
                this.kosong = true;
                this.table = false;
                this.clear = false;
            }
        }, 
        clear_keranjang : function () {
            localStorage.removeItem('keranjang');
            window.open("<?= base_url('home/keranjang_barang') ?>", "_self");
        }
    }
});

vm.cek_keranjang();

</script>