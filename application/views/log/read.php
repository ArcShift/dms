<?php
//print_r($log);
?>
<div class="card">
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Role</th>
                    <th>Aktifitas</th>
                    <th>Waktu</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($log as $k => $v) { ?>
                    <tr>
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
//    $(document).ready(function () {
//        $('.table').DataTable({
//            order: [[4, "desc"]] //error
//        });
//    });
    $(document).ready(function () {
        $('.table').DataTable({
            "order": [[3, "desc"]]
        });
    });
</script>