<div class="card">   
    <div class="card-body">
        <form method="post">
            <table class="table">
                <thead>
                    <tr>
                        <th>Pasal</th>
                        <th>Bukti</th>
                        <th>Pertanyaan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($data as $k => $v) {
                        $row = count($v['pertanyaan']);
                        if (empty($row)) {
                            ?>
                            <tr>
                                <td><?= $v['name'] ?></td>
                                <td style="white-space: pre-wrap"><?= $v['bukti'] ?></td>
                                <td>-</td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary fa fa-edit" name="edit" value="<?= $v['id'] ?>"></button>
                                </td>
                            </tr>
                        <?php } else { ?>
                            <tr>
                                <td rowspan="<?= $row ?>"><?= $v['name'] ?></td>
                                <td rowspan="<?= $row ?>" style="white-space: pre-wrap"><?= $v['bukti'] ?></td>
                                <td><?= $v['pertanyaan'][0]['kuesioner'] ?></td>
                                <td rowspan="<?= $row ?>">
                                    <button class="btn btn-sm btn-outline-primary fa fa-edit" name="edit" value="<?= $v['id'] ?>"></button>
                                </td>
                            </tr>
                            <?php foreach ($v['pertanyaan'] as $k2 => $v2) { ?>
                                <?php if ($k2 != 0) { ?>
                                    <tr>
                                        <td><?= $v2['kuesioner'] ?></td>
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