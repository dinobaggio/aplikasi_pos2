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
            <th scope="col">Jumlah Harga</th>
            <th scope="col" >Detail</th>
        </tr>

       
        <tr v-for="barang in keranjang_data">
        
            <td>{{barang.id_barang}}</td>
            <td>{{barang.nama_barang}}</td>
            <td>{{barang.stok_barang}}</td>
            <td>{{barang.harga_jual}}</td>
            <td>{{barang.jumlah_barang}}</td>
            <td>{{barang.jumlah_harga}}</td>
            <td><a v-bind:href="'<?= base_url('barang/detail_barang/') ?>'+barang.kode_barang" class='btn btn-secondary btn-sm'>Detail</a></td>

        </tr>

        <tr>
        <td colspan='7'><hr></td>
        </tr>
       
       <tr>
            
            <td colspan='4'><b>Total</b></td>
            <td>{{total_harga}}</td>
            <td colspan='3' ><input type='submit' v-on:click="transaksi_barang()" value='Prosess Transaksi' class='btn btn-primary btn-sm'></td>
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
        total_harga: null,
        total_barang: null,
        id_user: '<?= $id_user; ?>' ,
        pesan_kosong : '',
        table : false,
        clear: false,
        kosong : true
    }, 
    methods : {
        cek_keranjang : function () {

            if (this.keranjang_data != null) {

                let total_harga_keranjang = 0;
                let total_barang_keranjang = 0;
                let keranjang = this.keranjang_data;
                for(let i=0;i<keranjang.length;i++){
                    let harga_jual = Number(keranjang[i].harga_jual);
                    let jumlah_barang = Number(keranjang[i].jumlah_barang);
                    let total_harga = harga_jual*jumlah_barang;
                    keranjang[i].jumlah_harga = total_harga;
                    total_harga_keranjang += Number(total_harga);
                    total_barang_keranjang += Number(jumlah_barang);
                }

                this.total_harga = total_harga_keranjang;
                this.total_barang = total_barang_keranjang;

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
            window.open("<?= base_url('barang/keranjang_barang') ?>", "_self");
        },
        transaksi_barang : function () {
            let konfirmasi = confirm('yakin ingin memproses barang?');
            if (konfirmasi) {
                let data_keranjang = this.keranjang_data;
                let data_transaksi = {
                    'id_user' : this.id_user,
                    'total_barang' : this.total_barang,
                    'total_harga' : this.total_harga
                }

                data_keranjang = JSON.stringify(data_keranjang);
                data_transaksi = JSON.stringify(data_transaksi);

                $.post("<?= base_url('barang/transaksi_barang') ?>", {
                    data_keranjang: data_keranjang,
                    data_transaksi: data_transaksi
                }, function (respon) {
                    let data = JSON.parse(respon);
                    if(data.sukses) {
                        localStorage.removeItem('keranjang');
                        window.open("<?= base_url('barang/transaksi_sukses') ?>?id_transaksi_penjualan="+data.id_transaksi_penjualan, "_self");
                    }
                });
            }
        }
    }
});

vm.cek_keranjang();

</script>