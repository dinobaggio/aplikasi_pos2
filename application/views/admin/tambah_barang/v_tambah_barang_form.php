<div id='tambah_barang'>

<h3><?= $title ?></h3>

<table>
    <?= form_open('admin/tambah_barang/', $form_att) ?>
    <tr>
    <td>ID Produsen</td>
    <td>:
        <select name="id_produsen" placeholder='isi produsen' >
            <option value="">None</option>
            <?php foreach($produsen_value as $value) : ?>
                <option value="<?= $value->id_produsen ?>"><?= $value->nama_produsen ?></option>
            <?php endforeach; ?>
        </select>
    </td>
    <td><?= form_error('id_produsen') ?></td>
    </tr>
    <tr><td>Nama Barang</td><td>: <?= form_input($input_nama_barang) ?></td><td v-if='error' ><?= form_error('nama_barang') ?></td></tr>
    <tr><td>Stok Barang</td><td>: <?= form_input($input_stok_barang) ?></td><td v-if='error' ><?= form_error('stok_barang') ?></td></tr>
    <tr><td>Harga Jual</td><td>: <?= form_input($input_harga_jual) ?></td><td v-if='error' ><?= form_error('harga_jual') ?></td></tr>
    <tr><td>Harga Beli</td><td>: <?= form_input($input_harga_beli) ?></td><td v-if='error' ><?= form_error('harga_beli') ?></td></tr>
    <tr><td><?= form_submit($form_submit) ?></td></tr>
    <?= form_close() ?>
</table>

</div>

<script>


</script>