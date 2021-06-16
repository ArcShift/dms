<div class="main-card mb-3 card">
    <div class="card-header">
        <?php if ($activeModule['acc_create']) { ?>
            <a class="btn btn-outline-primary" style="text-transform: none" title="Tambah" href="<?php echo site_url($module . '/create') ?>"> Tambah <?= $activeModule['title'] ?></a>
        <?php } ?>
    </div>
    <div class="card-body">
        <form method="post">
            <table class="table data-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Username</th>
                        <th>Unit Kerja</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data as $k => $r) { ?>
                        <tr>
                            <td><?php echo $k + 1 ?></td>
                            <td><?php echo $r['fullname'] ?></td>
                            <td><?php echo $r['username'] ?></td>
                            <td>
                                <?php foreach ($r['unit_kerja'] as $uk) { ?>
                                <div class="badge badge-secondary"><?= $uk['name']?></div>
                                   <?php } ?>
                            </td>
                            <td>
                                <?php if ($activeModule['acc_update']) { ?>
                                    <button class="btn btn-outline-primary btn-sm fa fa-edit" title="Edit" name="initEdit" value="<?php echo $r['id'] ?>" formaction="<?php echo site_url($module . '/edit') ?>"></button>
                                <?php } ?>
                                <?php if ($activeModule['acc_delete']) { ?>
                                    <button class="btn btn-outline-danger btn-sm fa fa-trash" title="Hapus" name="initHapus" value="<?php echo $r['id'] ?>" formaction="<?php echo site_url($module . '/delete') ?>"></button>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </form>
    </div>
</div>