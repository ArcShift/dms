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
                            <th>Aksi</th>
                        <?php } ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data as $k => $v) {
                        switch ($v['status']) {
                            case 100: {
                                    $stt = 'OK';
                                    $color = 'success';
                                } break;
                            case 0: {
                                    $stt = 'NOK';
                                    $color = 'danger';
                                } break;
                            default: {
                                    $stt = $v['status'].'%';
                                    $color = 'warning';
                                } break;
                        }?>
                    <tr>
                        <td><?= $v['name'] ?></td>
                        <td style="white-space: pre-wrap"><?= $v['bukti'] ?></td>
                        <td><span class="badge badge-secondary"><?= $v['pertanyaan'] ?></span></td>
                        <td><span class="badge badge-secondary"><?= $v['unit'] ?></span></td>
                        <td><span class="badge badge-<?= $color ?>"><?= $stt ?></span></td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary  fa fa fa-search" name="detail" value="<?= $v['id'] ?>"></button>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </form>
    </div>
</div>
<?php // print_r($data) ?>