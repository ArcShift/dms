<div class="main-card mb-3 card">
    <div class="card-header">
        <?php if ($activeModule['acc_create']) { ?>
            <a class="btn btn-outline-primary" style="text-transform: none" href="<?php echo site_url($module . '/create') ?>"> Tambah <?= $activeModule['title'] ?></a>
        <?php } ?>
    </div>
    <div class="card-body">
        <form method="post">
            <table class="table table-borderless table-striped table-hover data-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Perusahaan</th>
                        <th>Kota / Kab</th>
                        <th class="text-center">Jumlah Unit Kerja</th>
                        <th class="text-center">Standard Aktif</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data as $k => $r) { ?>
                        <tr>
                            <td><?php echo $k + 1 ?></td>
                            <td><?php echo $r['name'] ?></td>
                            <td><?php echo $r['city'] ?></td>
                            <td class="text-center"><span class="badge badge-<?= $r['count'] == 0 ? 'danger' : 'info' ?>"><?php echo $r['count'] ?></span></td>
                            <td class="text-center"><span class="badge badge-<?= $r['standard'] == 0 ? 'danger' : 'info' ?>"><?php echo $r['standard'] ?></span></td>
                            <td>
                                <button class="btn btn-outline-primary btn-sm fa fa-info-circle" title="Detail" name="initDetail" value="<?php echo $r['id'] ?>" formaction="<?php echo site_url($module . '/detail') ?>"></button>
                                <?php if ($activeModule['acc_update']) { ?>
                                    <button class="btn btn-outline-primary btn-sm fa fa-edit" title="Edit" name="initEdit" value="<?php echo $r['id'] ?>" formaction="<?php echo site_url($module . '/edit') ?>"></button>
                                <?php } ?>
                                <?php if ($r['count'] == 0 & $r['standard'] == 0) { ?>
                                    <?php if ($activeModule['acc_delete']) { ?>
                                        <button class="btn btn-outline-danger fa fa-trash" title="Hapus" name="initHapus" value="<?php echo $r['id'] ?>" formaction="<?php echo site_url($module . '/delete') ?>"></button>
                                    <?php } ?>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </form>
    </div>
</div>