<div id="laporan_pembelian">
    <form action="<?= base_url('admin/laporan_pembelian') ?>" method="GET">
        <table>
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
            <br>
            <br>

        <?php 
        if (!empty($laporan)) :
        foreach ($laporan as $data) : 
            $id_transaksi = $data->id_transaksi_pembelian;
            
            ?>    
        <table  class='table-bordered'>
            <tbody id='barang<?= $id_transaksi ?>'>
                <tr>
                    <td colspan='5'><b>ID transaksi:</b> <?= $id_transaksi ?></td>
                </tr>
                <tr>
                    <td colspan='5'><b>Tanggal buat:</b> <?= $data->created ?></td>
                </tr>
                <tr>
                    <th>Nama Barang</th>
                    <th>Harga Beli</th>
                    <th>Jumlah Barang</th>
                    <th>Jumlah Harga</th>
                    <th>Nama Produsen</th>
                </tr>
                <tr></tr>
                <!-- before child 2 -->
                <tr>
                    <td colspan='5'><b>Total Barang:</b> <?= $data->total_barang ?></td>
                </tr>
                <tr>
                    <td colspan='5'><b>Total Harga:</b> <?= $data->total_harga ?></td>
                </tr>
            </tbody>
        </table>
        <br>
        <script>
            let barang<?= $id_transaksi ?> = document.getElementById("barang<?= $id_transaksi ?>");
            
            $.post("<?= base_url('admin/laporan_pembelian_barang') ?>", {
                id_transaksi_pembelian : <?= $id_transaksi ?>
            }, function (data) {
                let barang = JSON.parse(data);
                let node = 2;
                console.log(barang);
                for (let i=0; i<barang.length;i++) {
                    let newTr = document.createElement('tr');
                    let namaTd = document.createElement('td');
                    let hargaTd = document.createElement('td');
                    let jumlah_barangTd = document.createElement('td');
                    let jumlah_hargaTd = document.createElement('td');
                    let produsenTd = document.createElement('td');
                    
                    let namaTxt = document.createTextNode(barang[i].nama_barang);
                    let hargaTxt = document.createTextNode(barang[i].harga_beli);
                    let jumlah_barangTxt = document.createTextNode(barang[i].jumlah_barang);
                    let jumlah_hargaTxt = document.createTextNode(barang[i].jumlah_harga);
                    let produsenTxt = document.createTextNode(barang[i].nama_produsen);

                    namaTd.appendChild(namaTxt);
                    hargaTd.appendChild(hargaTxt);
                    jumlah_barangTd.appendChild(jumlah_barangTxt);
                    jumlah_hargaTd.appendChild(jumlah_hargaTxt);
                    produsenTd.appendChild(produsenTxt);

                    newTr.appendChild(namaTd);
                    newTr.appendChild(hargaTd);
                    newTr.appendChild(jumlah_barangTd);
                    newTr.appendChild(jumlah_hargaTd);
                    newTr.appendChild(produsenTd);

                    console.log();
                    barang<?= $id_transaksi ?>.insertBefore(newTr, barang<?= $id_transaksi ?>.childNodes[8] );
                    node++;
                }

            });
        </script>
        <?php 
            
            endforeach; 
        endif;?>
    </form>
</div>

