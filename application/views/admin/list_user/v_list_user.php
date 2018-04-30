<h2><?= $title ?></h2>

<div id='list_user' >
    <table class="table-bordered" >
        <tr>
            <th scope="col">ID User</th>
            <th scope="col">Username</th>
            <th scope="col">Cookie</th>            
        </tr>

        <?php foreach ($all_user as $user) : ?>
        <tr>
            <td><?= $user->id_user ?></td>
            <td><?= $user->username ?></td>
            <td><?= $user->cookie ?></td>            
            <td><a class="btn btn-secondary btn-sm">Detail</a></td>
        </tr>
        <?php endforeach ; ?>
        
        <tr>
        <td colspan='5' align='center'> <?= $page_links ?></td>
        </tr>
    </table>


</div>