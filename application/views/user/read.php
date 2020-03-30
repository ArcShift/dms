<div class="main-card mb-3 card">
    <div class="card-header">
        <a class="btn btn-primary fa fa-plus" title="Tambah" href="<?php echo site_url($module . '/create') ?>"></a>
    </div>
    <div class="card-body">
        <form method="post">
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Username</th>
                        <th>Nama</th>
                        <th>Role</th>
                        <th>Unit Kerja</th>
                        <th>Company</th>                        
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data as $k => $r) { ?>
                        <tr>
                            <td><?php echo $k + 1 ?></td>
                            <td><?php echo $r['username'] ?></td>
                            <td><?php echo $r['fullname'] ?></td>
                            <td><?php echo $r['role'] ?></td>
                            <td><?php echo $r['unit_kerja'] ?></td>
                            <td><?php echo $r['company'] ?></td>
                            <td>
                                <button class="btn btn-primary fa fa-edit" title="Edit" name="initEdit" value="<?php echo $r['id']?>" formaction="<?php echo site_url($module.'/edit') ?>"></button>
                                <button class="btn btn-danger fa fa-trash" title="Hapus" name="initHapus" value="<?php echo $r['id']?>" formaction="<?php echo site_url($module.'/delete') ?>"></button>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </form>
    </div>
</div>