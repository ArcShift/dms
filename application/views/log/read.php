<?php
//print_r($log);
?>
<div class="card">
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>Perusahaan</th>
                    <th>Nama</th>
                    <th>Role</th>
                    <th>Aktifitas</th>
                    <th>Waktu</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($log as $k => $v) { ?>
                    <tr>
                        <td><?= $v['perusahaan'] ?></td>
                        <td><?= $v['fullname'] ?></td>
                        <td><?= $v['title'] ?></td>
                        <td><?= $v['desc'] ?></td>
                        <td><?= $v['created_at'] ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('.table').DataTable({
        "order": [[4, "desc"]],
        "columnDefs": [
                {
                    "targets": [0],
                    "visible": false
                }
            ],
<?php if (empty($this->session->user['id_company'])) { ?>
            initComplete: function () {
            console.log(this.api().columns());
                    this.api().columns().every(function () {
            var column = this;
                    if (column[0][0] == 0) {
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
<?php } ?>
        });
    });
</script>