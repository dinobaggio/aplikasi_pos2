<div class="alert alert-info">
  <strong>Info!</strong> data tercatat secara dinamis, untuk sekarang Hanya maret yang ada datanya
</div>

<div id="laporan_pembelian">


    <form action="<?= base_url('admin/laporan_pembelian') ?>" method="GET">
        <table align="center">
            <tr>
                <th>Masukan</th>
                <td>: Bulan 
                <select name="bulan" style="max-height:50%;">
                    <option value="">None</option>
                    <option value="1">January</option>
                    <option value="2">February</option>
                    <option value="3">March</option>
                    <option value="4">April</option>
                    <option value="5">May</option>
                    <option value="6">June</option>
                    <option value="7">July</option>
                    <option value="8">August</option>
                    <option value="9">September</option>
                    <option value="10">October</option>
                    <option value="11">November</option>
                    <option value="12">December</option>
                </select>
                </td>
                <td>- Tahun <b>2018</b>
                </td>
                <td><input type="submit" value='Submit'></td>
            </tr>
            <tr><td></tr>
        </table>
    </form>
        <br>

    <table   align='center'>
        <?php 
        if (!empty($laporan)) : ?>
        
        <tr><td><button class="btn btn-success" onclick="cetak('<?= $bulan ?>')">Cetak</button></td></tr>
        

        <?php foreach ($laporan as $data) : 
            $id_transaksi = $data->id_transaksi_pembelian;
            ?>    
            
            <tbody >
                <tr>
                    <td colspan='5'><b>ID transaksi:</b> <?= $id_transaksi ?></td>
                </tr>
                <tr>
                    <td colspan='5'><b>Tanggal buat:</b> <?= $data->created ?></td>
                </tr>
                <tr id='barang<?= $id_transaksi ?>'>
                    <th>Nama Barang</th>
                    <th>Harga Beli</th>
                    <th>Jumlah Barang</th>
                    <th>Jumlah Harga</th>
                    <th>Nama Produsen</th>
                </tr>
                <tr>
                    <td colspan='5'><b>Total Barang:</b> <?= $data->total_barang ?></td>
                </tr>
                <tr>
                    <td colspan='5'><b>Total Harga :</b> <?= $data->total_harga ?></td>
                </tr>
                <tr><td colspan='5' ><br></td></tr>
            </tbody>
        
        <script>
            let barang<?= $id_transaksi ?> = document.getElementById("barang<?= $id_transaksi ?>");
            
            $.post("<?= base_url('admin/laporan_pembelian_barang') ?>", {
                id_transaksi_pembelian : <?= $id_transaksi ?>
            }, function (data) {
                let barang = JSON.parse(data);
                for (let i=0; i<barang.length;i++) {
                    
                    let nama = $("<td></td>").text(barang[i].nama_barang);
                    let harga = $("<td></td>").text(barang[i].harga_beli);
                    let jumlah_barang = $("<td></td>").text(barang[i].jumlah_barang);;
                    let jumlah_harga = $("<td></td>").text(barang[i].jumlah_harga);
                    let produsen = $("<td></td>").text(barang[i].nama_produsen);

                    let newTr = $("<tr></tr>").append(
                        nama,
                        harga,
                        jumlah_barang,
                        jumlah_harga,
                        produsen
                    );

                    $("#barang<?= $id_transaksi ?>").after(newTr);
                }

            });
        </script>
        <?php 
            
            endforeach; 
        endif;?>

        </table>
    
</div>


<script>

function cetak (bulan) {
    window.open("<?= base_url('admin/cetak_laporan_pembelian') ?>?bulan="+bulan, '_self');
}

</script>
