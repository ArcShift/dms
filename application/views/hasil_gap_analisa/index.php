<div class="card">
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Pasal</th>
                    <th>Pertanyaan</th>
                    <th>Unit</th>
                    <th>Hasil Gap Analisa</th>
                    <th>Saran Perbaikan</th>
                    <th>Target</th>
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
                        <?php foreach ($v2['unit'] as $k3 => $v3) { ?>
                            <tr>
                                <td><?= $v3['unit_kerja'] ?></td>
                                <td><?= '' ?></td>
                                <td><?= '' ?></td>
                                <td><?= '' ?></td>
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
<?php print_r($data) ?>