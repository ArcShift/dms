<div class="card">   
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>Pasal</th>
                    <th>Bukti</th>
                    <th>Pertanyaan</th>
                    <th>Unit</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data as $k => $v) { ?>
                    <tr>
                        <td><?= $v['name'] ?></td>
                        <td style="white-space: pre-wrap"><?= $v['bukti'] ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<?php // print_r($data) ?>