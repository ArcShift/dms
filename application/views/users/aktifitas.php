<div class="card">
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>Aktifitas</th>
                    <th>Waktu</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data as $k => $v) { ?>
                    <tr>
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
        "order": [[0, "desc"]],
        });
    });
</script>