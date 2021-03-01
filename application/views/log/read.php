<?php 
print_r($log);
?>
<div class="card">
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>User</th>
                    <th>Waktu</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($log as $k => $v) { ?>
                <tr>
                    <td></td>
                    <td></td>
                    <td><?= $v['waktu']?></td>
                </tr>
                <?php }?>
            </tbody>
        </table>
    </div>
</div>