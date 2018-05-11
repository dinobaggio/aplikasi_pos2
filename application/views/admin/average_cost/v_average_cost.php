<div id='average_cost' align="center" class='container'>
<h3><?= $title ?></h3>

<form action="<?= base_url('admin/average_cost') ?>" method="GET">
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


    <?php if ($datanya) : ?>
    
    <table class="table-bordered" style="margin-bottom: 50px;">
    <tr>
        <th>ID</th>
        <th>Total Barang</th>
        <th>Total Harga</th>
        <th>Kategori</th>
        <th>created</th>
    </tr>
    
    
    <?php foreach ($datanya as $data) : ?>
    <tr>
        <td>#<?= $data->id ?></td>
        <td><?= $data->total_barang ?></td>
        <td><?= $data->total_harga ?></td>
        <?php if ($data->kategori == 0) : ?>
            <td>Pembelian</td>
        <?php else : ?>
            <td>Penjualan</td>
        <?php endif ?>
        <td><?= $data->created ?></td>
    </tr>
    <?php endforeach; ?>

    <tr>
    
    </tr>

    </table>

    <?php endif ?>
    

</div>