<div class="main-card mb-3 card">
    <div class="card-header">
        <?php if ($activeModule['acc_create']) { ?>
            <a class="btn btn-outline-primary btn-sm fa fa-plus" style="text-transform: none" title="Tambah" href="<?php echo site_url($module . '/create') ?>"> Tambah <?= $activeModule['title'] ?></a>
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
                        <th>Perusahaan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data as $k => $r) { ?>
                        <tr>
                            <td><?php echo $k + 1 ?></td>
                            <td><?php echo $r['fullname'] ?></td>
                            <td><?php echo $r['username'] ?></td>
                            <td><?php echo $r['unit_kerja'] ?></td>
                            <td><?php echo $r['company'] ?></td>
                            <td>
                                <?php if ($activeModule['acc_update']) { ?>
                                    <button class="btn btn-outline-primary btn-sm fa fa-edit" title="Edit" name="initEdit" value="<?php echo $r['id'] ?>" formaction="<?php echo site_url($module . '/edit') ?>"></button>
                                <?php } ?>
                                <?php if ($activeModule['acc_delete']& empty($r['username'])) { ?>
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
<script>
    function afterReady() {
        $('.data-table').DataTable({
            destroy: true,
            initComplete: function () {
                console.log(this.api().columns());
                this.api().columns().every(function () {
                    var column = this;
                    if (column[0][0] == 4) {
                        console.log();
                        var select = $('<select style="width:50%; margin-left:10px" class="form-control form-control-sm pull-right"><option value="">-- Perusahaan --</option></select>')
                                .prependTo($('.dataTables_filter'))
                                .on('change', function () {
                                    var val = $.fn.dataTable.util.escapeRegex($(this).val());
                                    column.search(val ? '^' + val + '$' : '', true, false).draw();
                                });
                        column.data().unique().sort().each(function (d, j) {
                            select.append('<option value="' + d + '">' + d + '</option>');
                        });
                    }
                });
            }
        });
    }
</script>