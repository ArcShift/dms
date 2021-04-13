<div class="card">
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Pasal</th>
                    <th>Pertanyaan</th>
                    <th>Unit</th>
                    <th>Saran Perbaikan</th>
                    <th>Bukti Perbaikan</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data as $k => $v) { ?>
                    <tr>
                        <td rowspan="<?= $v['row'] ?>"><?= $v['name'] ?></td>
                    </tr>
                    <?php foreach ($v['pertanyaan'] as $k2 => $v2) { ?>
                        <tr>
                            <td rowspan="<?= $v2['row'] ?>"><?= $v2['kuesioner'] ?></td>
                        </tr>
                        <?php foreach ($v2['unit'] as $k3 => $v3) { 
                            switch ($v3['status']) {
                            case 100: {
                                    $stt = 'OK';
                                    $color = 'success';
                                } break;
                            case 0: {
                                    $stt = 'NOK';
                                    $color = 'danger';
                                } break;
                            default: {
                                    $stt = $v3['status'] . '%';
                                    $color = 'warning';
                                } break;
                        }
                        ?>
                            <tr>
                                <td><?= $v3['unit_kerja'] ?></td>
                                <td><?= '' ?></td>
                                <td><?= '' ?></td>
                                <td><span class="badge badge-<?= $color ?>"><?= $stt ?></span></td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary fa fa-edit"></button>
                                </td>
                            </tr>
                        <?php } ?>
                    <?php } ?>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>