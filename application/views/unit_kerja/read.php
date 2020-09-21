<div class="main-card mb-3 card">
    <div class="card-header">
        <?php if ($activeModule['acc_create']) { ?>
            <a class="btn btn-primary fa fa-plus" href="<?php echo site_url($module . '/create') ?>" title="Tambah"></a>
        <?php } ?>
    </div>
    <div class="card-body">
        <form method="post">            
            <table class="table data-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Perusahaan</th>
                        <th>Jenis</th>
                        <th>Personil</th>
                        <th>aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data as $k => $d) { ?>
                        <tr>
                            <td><?php echo $k + 1 ?></td>
                            <td><?php echo $d['name'] ?></td>
                            <td><?php echo $d['company'] ?></td>
                            <td><?php echo ucwords(strtolower($d['jenis'])) . ' Dokumen' ?></td>
                            <td class="text-center"><span class="badge badge-<?= $d['personil']==0?'danger':'info'?>"><?php echo $d['personil'] ?></span></td>
                            <td>
                                <?php if ($activeModule['acc_update']) { ?>
                                    <button class="btn btn-primary fa fa-edit" title="Edit" name="initEdit" value="<?php echo $d['id'] ?>" formaction="<?php echo site_url($module . '/edit') ?>"></button>
                                <?php } ?>
                                <?php if ($activeModule['acc_delete']&$d['personil']==0) { ?>
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