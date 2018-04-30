<h2><?= $title ?></h2>

<div id='list_barang' >
    <table class="table-bordered" >
        <tr>
            <th scope="col">ID Barang</th>
            <th scope="col">Nama Barang</th>
            <th scope="col">Stok Barang</th>
            <th scope="col">Harga Jual</th>
            <th scope="cole">Harga Beli</th>
            <th scope="col">Detail</th>
        </tr>

        <?php foreach ($all_barang as $barang) : ?>
        <tr>
            <td><?= $barang->id_barang ?></td>
            <td><?= $barang->nama_barang ?></td>
            <td><?= $barang->stok_barang ?></td>
            <td><?= $barang->harga_jual ?></td>
            <td><?= $barang->harga_beli ?></td>
            <td><a class="btn btn-secondary btn-sm">Detail</a></td>
        </tr>
        <?php endforeach ; ?>
        
        <tr>
        <td colspan='5' align='center'> <?= $page_links ?></td>
        </tr>
    </table>


</div>