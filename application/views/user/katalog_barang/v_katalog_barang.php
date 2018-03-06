<div id='katalog_barang' class='container' align="center">

    <table class='table-bordered'>
        <tr><td colspan='4' align='center'><h4><?= $title ?></h4></td><td>Page: <?= $page ?></td></tr>
        <tr>
            <th scope="col" >Id Barang</th>
            <th scope="col" >Nama Barang</th>
            <th scope="col" >Stok Barang</th>
            <th scope="col" >Harga</th>
            <th scope="col" >Detail</th>
        </tr>

        <tr v-for='barang in all_barang'>
            <td>{{barang.id_barang}}</td>
            <td>{{barang.nama_barang}}</td>
            <td>{{barang.stok_barang}}</td>
            <td>{{barang.harga_jual}}</td>
            <td><a v-bind:href="'<?= base_url('home/detail_barang/') ?>'+barang.id_barang+'hal<?= $page ?>'" class='btn btn-secondary btn-sm'>Detail</a></td>
            <td v-bind:id="'barang'+barang.id_barang"></td>
        </tr>
       
        <tr>
            <td colspan='5' align='center'> <?= $page_links ?></td>
        </tr>
    </table>

    

</div>

<script>

    let data = <?= $json_data ?> ;
    let katalog = new Vue({
        el : '#katalog_barang',
        data : {
            all_barang : data
        },
        methods : {
            cek_keranjang : function () {
                let keranjang = localStorage.keranjang;
                if (keranjang != null) {
                    if (keranjang[0] == '[' && keranjang[keranjang.length-1] == ']') {
                        let data_keranjang = JSON.parse(keranjang);
                        let filter_data = data_keranjang.filter(function (keranjang) {
                            return keranjang != null;
                        });
                        if (filter_data[0] != null) {
                            for(let i=0;i<filter_data.length;i++) {
                                if (filter_data[i].id_barang != null) {
                                    let selected = $('#barang'+filter_data[i].id_barang).html('selected');
                                }
                            }
                        }
                    }
                }
            }
        }
    });

    katalog.cek_keranjang();

</script>