<div id='tamba_produsen'>
<h3><?= $title ?></h3>

<table>
    <?= form_open('admin/tambah_produsen', $form_att) ?>
    <tr><td>Nama Produsen</td><td>: <?= form_input($input_nama_produsen) ?></td><td><?= form_error('nama_produsen') ?></td></tr>
    <tr><td><?= form_submit($input_submit) ?></td></tr>
    <?= form_close() ?>

</table>

</div>