
<div class="card">
    <div class="card-body">
        <form method="post">
            <table class="table">
                <thead>
                    <tr>
                        <th>File</th>
                        <th>Jumlah</th>
                        <th>Unused</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data as $k => $d) { ?>
                        <tr>
                            <td><?= $d['name'] ?></td>
                            <td><?php print_r($d['files']) ?></td>
                            <td><?php print_r($d['trash']) ?></td>
                            <td>
                                <?php if (!empty($d['trash'])) { ?>    
                                    <button class="btn btn-sm btn-outline-danger fa fa-trash" name="delete" value="<?= $k ?>"></button>
                                <?php } ?>    
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </form>
    </div>
</div>
