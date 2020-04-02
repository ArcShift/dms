<div class="main-card mb-3 card">
    <form method="post">
        <div class="card-header">
            <div class="card-header-title">
                <?php echo $company['name'] ?>
                <input class="d-none" name="perusahaan" value="<?php echo $company['id'] ?>" />
            </div>
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Standard</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data as $k => $d) { ?>
                        <tr>
                            <td><?php echo $k + 1 ?></td>
                            <td><?php echo $d['name'] ?></td>
                            <td>
                                <?php if ($activeModule['acc_update']) { ?>
                                    <button class="btn btn-<?php echo $d['count']?'success':'danger'; ?> fa fa-check-square" title="Toggle" name="toggle" value="<?php echo $d['id'] ?>" formaction="<?php echo site_url($module . '/edit') ?>"></button>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </form>
    <div class="d-block text-right card-footer">
        <a class="mr-2 btn btn-primary" href="<?php echo site_url($module) ?>">Kembali</a>
    </div>
</div>