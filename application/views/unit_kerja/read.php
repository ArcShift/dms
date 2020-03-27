<div class="main-card mb-3 card">
    <div class="card-header">
        <?php if ($activeModule['acc_create']) { ?>
            <a class="btn btn-primary fa fa-plus" href="<?php echo site_url($module . '/create') ?>" title="Tambah"></a>
        <?php } ?>
    </div>
    <div class="card-body">
        <form method="post">            
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Perusahaan</th>
                        <th>Jenis</th>
                        <th>aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data as $k => $d) { ?>
                        <tr>
                            <td><?php echo $k + 1 ?></td>
                            <td><?php echo $d['name'] ?></td>
                            <td><?php echo $d['company'] ?></td>
                            <td><?php echo ucwords(strtolower($d['jenis'])).' Dokumen' ?></td>
                            <td>
                                <!--<button class="btn btn-primary fa fa-search" title="Detail" name="detail" value="<?php // echo $d['id'] ?>" formaction="<?php echo site_url($module . '/detail') ?>"></button>-->
                                <?php if ($activeModule['acc_delete']) { ?>
                                    <button class="btn btn-danger fa fa-trash" title="Hapus" name="initHapus" value="<?php echo $d['id'] ?>" formaction="<?php echo site_url($module . '/delete') ?>"></button>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
                <tfoot></tfoot>
            </table>
        </form>
    </div>
    <div class="box-footer"></div>
</div>