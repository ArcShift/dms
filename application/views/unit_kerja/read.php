<div class="main-card mb-3 card">
    <div class="card-header">
        <?php if ($activeModule['acc_create']) { ?>
            <a class="btn btn-outline-primary btn-sm fa fa-plus" style="text-transform: none" href="<?php echo site_url($module . '/create') ?>"> Tambah <?= $activeModule['title'] ?></a>
        <?php } ?>
    </div>
    <div class="card-body">
        <form method="post">            
            <table class="table data-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Unit Kerja</th>
                        <th>Perusahaan</th>
                        <th>Tugas</th>
                        <th class="text-center">Jumlah Personil</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data as $k => $d) { ?>
                        <tr>
                            <td><?php echo $k + 1 ?></td>
                            <td><?php echo $d['name'] ?></td>
                            <td><?= $d['company'] ?></td>
                            <td>
                                <?php foreach ($d['jobdesk'] as $jd) { ?>
                                    <div><?= $jd['name'] ?></div>
                                <?php } ?>
                            </td>
                            <td class="text-center"><span class="badge badge-<?= $d['personil'] == 0 ? 'danger' : 'info' ?>"><?php echo $d['personil'] ?></span></td>
                            <td>
                                <?php if ($activeModule['acc_update']) { ?>
                                    <button class="btn btn-outline-primary btn-sm fa fa-edit" title="Edit" name="initEdit" value="<?php echo $d['id'] ?>" formaction="<?php echo site_url($module . '/edit') ?>"></button>
                                <?php } ?>
                                <?php if ($activeModule['acc_delete'] & $d['personil'] == 0) { ?>
                                    <button class="btn btn-outline-danger btn-sm fa fa-trash" title="Hapus" name="initHapus" value="<?php echo $d['id'] ?>" formaction="<?php echo site_url($module . '/delete') ?>"></button>
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
<script>
    function afterReady() {
        $('.data-table').DataTable({
            destroy: true,
//            "columnDefs": [
//                {
//                    "targets": [2],
//                    "visible": false
//                }
//            ],
            initComplete: function () {
                console.log(this.api().columns());
                this.api().columns().every(function () {
                    var column = this;
                    if (column[0][0] == 2) {
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