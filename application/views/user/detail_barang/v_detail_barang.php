<div id='detail_barang' class='container-fluid'>
<input type='hidden' id='string_data' value='<?= $json_data?>'>
<input type='hidden' id='kode_barang' value='<?= $kode_barang?>'>
<input type='hidden' id='user' value='<?= $user?>'>
    <h4><?= $title ?></h4>

    <table>
        
        <tr><th>ID Barang: </th><td><?= $barang->id_barang ?></td></tr>
        <tr><th>Nama Barang: </th><td><?= $barang->nama_barang ?></td></tr>
        <tr><th>Stok Barang: </th><td><?= $barang->stok_barang ?></td></tr>
        <tr><th>Harga: </th><td><?= $barang->harga_jual ?></td></tr>
        <tr><th>Jumlah: </th><td><input id='input_jumlah' v-model='jumlah' type='number' placeholder='Masukan Jumlah' /></td><td> {{error_jumlah}}</td></tr>
        <tr>
            <td><?= anchor('home/katalog_barang?halaman='.$halaman, 'Back', 'class="btn btn-info btn-sm"') ?></td>
            <td>
                <button id='add_keranjang' v-on:click='add_keranjang(<?= $json_data ?>)' class='btn btn-primary'>Masukan Keranjang</button>
                <button id='cancel_keranjang' v-on:click='cancel_keranjang(Number(<?= $barang->id_barang ?>)-1)' class='btn btn-danger' style='display:none;'>Cancel Barang</button>
            </td>
        </tr>
    </table>

</div>

<script>

let vm = new Vue({
    el: '#detail_barang',
    data: {
        jumlah : null,
        string_data : $('#string_data').val(),
        kode_barang : $('#kode_barang').val(),
        user : $('#user').val(),
        error_jumlah : ''
       
    },
    methods : {
        add_keranjang : function (data) {
            this.create_storage();

            let el_add_keranjang = $('#add_keranjang');
            let el_cancel_keranjang = $('#cancel_keranjang');
            let el_jumlah = $('#input_jumlah');

            let jumlah = Number(this.jumlah);
            let string_data = JSON.parse(this.string_data);
            let index = Number(string_data.id_barang) - 1;
            if (jumlah != null) {
                if (jumlah > 0) {
                    if (jumlah <= Number(string_data.stok_barang)) {
                        string_data.jumlah_beli = Number(jumlah);
                        string_data.kode_barang = this.kode_barang;
                        string_data.user = this.user;
                        let keranjang = localStorage.keranjang;
                        
                        keranjang = JSON.parse(keranjang);
                        keranjang[index] = string_data;
                        let data_keranjang = JSON.stringify(keranjang);
                        localStorage.keranjang = data_keranjang;
                        
                        el_add_keranjang.css('display', 'none');
                        el_cancel_keranjang.css('display', '');
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

            this.cek_keranjang();
            notif_keranjang();
            
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
        cancel_keranjang : function (index) {
            let keranjang = JSON.parse(localStorage.keranjang);
            let el_add_keranjang = $('#add_keranjang');
            let el_cancel_keranjang = $('#cancel_keranjang');
            let el_jumlah = $('#input_jumlah');
            keranjang[index] = null;
            let data_keranjang = JSON.stringify(keranjang);
            localStorage.keranjang = data_keranjang;

            el_add_keranjang.css('display', '');
            el_cancel_keranjang.css('display', 'none');
            el_jumlah.removeAttr('disabled');

            this.cek_keranjang();
            notif_keranjang();
        },

        cek_keranjang : function () {
            let keranjang = localStorage.keranjang;
            let el_add_keranjang = $('#add_keranjang');
            let el_cancel_keranjang = $('#cancel_keranjang');
            let el_jumlah = $('#input_jumlah');
            
            let string_data = JSON.parse(this.string_data);
            let index = Number(string_data.id_barang)-1;

            if(keranjang != null) {
                keranjang = JSON.parse(keranjang);
                let filter_data = keranjang.filter(function (keranjang) {
                    return keranjang != null;
                });
                if (keranjang[index] != null) {
                    el_jumlah.val(keranjang[index].jumlah_beli);
                    el_add_keranjang.css('display', 'none');
                    el_cancel_keranjang.css('display', '');
                    el_jumlah.attr('disabled', true);
                }
                if (filter_data[0] == null) {
                    localStorage.removeItem('keranjang');
                }
            }
        }
    }
});

vm.cek_keranjang();

</script>