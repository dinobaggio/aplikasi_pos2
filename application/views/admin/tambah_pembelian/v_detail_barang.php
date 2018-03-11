<div id="detail_barang_beli" align='center'>

    <h3><?= $data_barang->nama_barang ?></h3>

    <table>

        <tr>
            <td colspan='3'>
                <a href="<?= base_url('admin/tambah_pembelian/'.$id_produsen) ?>" class="btn btn-info btn-sm">Back</a>
            </td>
        </tr>

        <tr>
            <th>ID Barang</th><td>: #<?= $data_barang->id_barang ?></td>
        </tr>

        <tr>
            <th>Stok Barang</th><td>: <?= $data_barang->stok_barang ?></td>
        </tr>

        <tr>
            <th>Harga Beli</th><td>: <?= $data_barang->harga_beli ?></td>
        </tr>

        <tr>
            <th>Masukan Jumlah</th>
            <td>: <input v-model='jumlah_barang' type="number" name='jumlah_barang' id='jumlah_barang' ></td>
            <td>{{error_jumlah}}</td>
            
        </tr>

        <tr>
            <td>
                <button v-on:click="tambah_barang()" id='tambahkan' class="btn btn-info btn-sm">Tambahkan</button>
                <button v-on:click="cancel()" id='cancel' style='display:none' class="btn btn-danger btn-sm" >Cancel</button>
            </td>
        </tr>

    </table>


</div>

<script>

let vm = new Vue({
    el : '#detail_barang_beli',
    data : {
        jumlah_barang : 1,
        error_jumlah : '',
        id_barang : <?= $data_barang->id_barang ?>,
        nama_barang : '<?= $data_barang->nama_barang ?>',
        harga_beli : <?= $data_barang->harga_beli ?>,
        stok_barang : <?= $data_barang->stok_barang ?>,
        id_produsen : <?= $id_produsen ?>
    },
    methods : {
        tambah_barang : function () {

            this.create_storage();

            let jumlah_barang = Number(this.jumlah_barang);
            let harga_beli = Number(this.harga_beli);
            let stok_barang = Number(this.stok_barang);
            let jumlah_harga = (harga_beli * jumlah_barang);
            let index = Number(this.id_barang);
            let keranjang = JSON.parse(localStorage.keranjang);

            let el_jumlah = $('#jumlah_barang');
            let el_cancel = $('#cancel');
            let el_tambahkan = $('#tambahkan');

            if(jumlah_barang != null) {
                if(jumlah_barang >= 1) {
                    if (jumlah_barang <= stok_barang) {

                        data = {
                            id_produsen : this.id_produsen,
                            id_barang : this.id_barang,
                            nama_barang : this.nama_barang,
                            harga_beli : harga_beli,
                            stok_barang : stok_barang,
                            jumlah_barang : jumlah_barang,
                            jumlah_harga : jumlah_harga 
                        }

                        keranjang[index] = data;

                        localStorage.keranjang = JSON.stringify(keranjang);

                        el_tambahkan.css('display', 'none');
                        el_cancel.css('display', '');
                        el_jumlah.attr('disabled', true);
                        this.error_jumlah = '';
                    } else {
                        this.error_jumlah = '* '+'barang tidak boleh melebihi stok barang';
                    }
                } else {
                    this.error_jumlah = '* '+'jumlah terlalu kecil';
                }
            } else {
                this.error_jumlah = '* '+'harap isi jumlah';
            }

            
            

        },
        create_storage : function () {
            let keranjang = localStorage.keranjang;
            if (keranjang == null) {
                localStorage.setItem('keranjang', '[]');
                
            } else {
                if (keranjang[0] !== '[') {
                    localStorage.removeItem('keranjang');
                    localStorage.setItem('keranjang', '[]');
                    
                }

                if (keranjang[keranjang.length-1] !== ']'){
                    localStorage.removeItem('keranjang');
                    localStorage.setItem('keranjang', '[]');
                    
                }
            }
        },
        cancel : function () {

            let el_jumlah = $('#jumlah_barang');
            let el_cancel = $('#cancel');
            let el_tambahkan = $('#tambahkan');
            let index = Number(this.id_barang);
            let keranjang = JSON.parse(localStorage.keranjang);
            keranjang[index] = null;
            localStorage.keranjang = JSON.stringify(keranjang);
            el_tambahkan.css('display', '');
            el_cancel.css('display', 'none');
            el_jumlah.attr('disabled', false);

        },
        cek_keranjang : function () {
            
            let keranjang = localStorage.keranjang;
            let index = Number(this.id_barang);
            let el_jumlah = $('#jumlah_barang');
            let el_cancel = $('#cancel');
            let el_tambahkan = $('#tambahkan');

            if(keranjang != null) {
                if (keranjang[0] == '[' && keranjang[keranjang.length-1] == ']'){
                    keranjang = JSON.parse(keranjang);
                    let filter_data = keranjang.filter(function (keranjang) {
                        return keranjang != null;
                    });
                    if (keranjang[index] != null) {
                        this.jumlah_barang = keranjang[index].jumlah_barang;
                        el_tambahkan.css('display', 'none');
                        el_cancel.css('display', '');
                        el_jumlah.attr('disabled', true);
                    }
                    if (filter_data[0] == null) {
                        localStorage.removeItem('keranjang');
                    }
                }
            }

        }
    }
});

vm.cek_keranjang();


</script>