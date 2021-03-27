<div class="card">
    <div class="card-body">
        <form>
            <table class="table">
                <thead >
                    <tr>
                        <th>Pasal</th>
                        <th>Judul</th>
                        <th>Deskripsi</th>
                        <th style="width:100px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pasal as $k => $v) { ?>
                        <tr <?= empty($v['parent']) ? 'class="table-success"' : '' ?>>
                            <td><?= $v['name'] ?></td>
                            <td><?= $v['sort_desc'] ?></td>
                            <td style="white-space: pre-wrap"><?= $v['long_desc'] ?></td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary fa fa-edit" title="Edit" name="edit" value="<?= $v['id'] ?>"></button>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </form>
    </div>
</div>
<?php ?>
