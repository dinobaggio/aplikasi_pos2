<?php foreach($barang as $data) : ?>
<tr>
<td><?= $data->nama_barang ?></td>
<td><?= $data->harga_beli ?></td>
<td><?= $data->jumlah_barang ?></td>
<td><?= $data->jumlah_harga ?></td>
<td><?= $data->nama_produsen ?></td>
</tr>
<?php endforeach; ?>