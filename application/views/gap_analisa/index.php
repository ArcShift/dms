<div class="card">   
    <div class="card-body">
        <form method="post">
            <table class="table">
                <thead>
                    <tr>
                        <th>Pasal</th>
                        <th>Bukti</th>
                        <th>Pertanyaan</th>
                        <?php if ($role != 'admin') { ?>
                            <th>Unit</th>
                            <th>Status</th>
                        <?php } ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($data as $k => $v) {
                        $row = count($v['pertanyaan']) + 1;
                        ?>
                        <tr>  
                            <td rowspan="<?= $v['row'] ?>">
                                <?php if ($role == 'admin') { ?>
                                    <button class="btn btn-sm btn-outline-primary fa fa-edit" name="edit" value="<?= $v['id'] ?>"></button>
                                <?php } ?>
                                <?= $v['name'] ?>
                            </td>
                            <td rowspan="<?= $v['row'] ?>"><?= $v['bukti'] ?></td>
                        </tr>
                        <?php foreach ($v['pertanyaan'] as $k2 => $v2) { ?>
                            <tr>  
                                <td rowspan="<?= $v2['row'] ?>">
                                    <?php if ($role == 'pic') { ?>
                                        <button class="btn btn-sm btn-outline-primary fa fa-edit" name="edit_pertanyaan" value="<?= $v2['id'] ?>"></button>
                                    <?php } ?>
                                    <?= $v2['kuesioner'] ?>
                                </td>
                            </tr>
                            <?php if ($role == 'pic') { ?>
                                <?php foreach ($v2['status'] as $k3 => $v3) { ?>
                                    <tr>
                                        <td><?= $v3['unit_kerja'] ?></td>
                                        <td><?= $v3['status'] ?></td>
                                    </tr>
                                <?php } ?>
                            <?php } ?>
                        <?php } ?>
                    <?php } ?>
                </tbody>
            </table>
        </form>
    </div>
</div>
<?php
// print_r($data) ?>