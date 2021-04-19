<div class="d-inline-block dropdown" id="menuGap">
    <button type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn-shadow dropdown-toggle btn btn-info">
        <span class="btn-icon-wrapper pr-2 opacity-7">
            <i class="fa fa-file fa-w-20"></i>
        </span>
        <?= empty($this->session->gapAnalisa) ? '-' : $this->session->gapAnalisa['judul'] ?>
    </button>
    <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu dropdown-menu-right">
        <ul class="nav flex-column">
            <?php foreach ($gap_analisa as $ga) { ?>
                <li class="nav-item">
                    <a class="nav-link" onclick="switchGapAnalisa(<?= $ga['id'] ?>)">
                        <i class="nav-link-icon lnr-inbox"></i>
                        <span>
                            <?= $ga['judul'] ?>
                        </span>
                    </a>
                </li>
            <?php } ?>
        </ul>
    </div>
</div>
<!--CARD-->
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
                    if ($this->session->has_userdata('gapAnalisa')) {
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
                                <td style="white-space: pre-wrap" rowspan="<?= $v['row'] ?>"><?= $v['bukti'] ?></td>
                                <?php if (empty($v['pertanyaan'])) { ?>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                <?php } ?>
                                <?php foreach ($v['pertanyaan'] as $k2 => $v2) { ?>
                                    <?= $k2 == 0 ? '' : '<tr>' ?>
                                    <td rowspan="<?= $v2['row'] ?>">
                                        <?php if ($role == 'pic') { ?>
                                            <button class="btn btn-sm btn-outline-primary fa fa-edit" name="edit_pertanyaan" value="<?= $v2['id'] ?>"></button>
                                        <?php } ?>
                                        <?= $v2['kuesioner'] ?>
                                    </td>
                                    <?php if ($role == 'pic') { ?>
                                        <?php
                                        foreach ($v2['status'] as $k3 => $v3) {
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
                                            <?= $k3 == 0 ? '' : '<tr>' ?>
                                            <td><?= $v3['unit_kerja'] ?></td>
                                            <td><span class="badge badge-<?= $color ?>"><?= $stt ?></span></td>
                                                <?= $k3 == 0 ? '' : '</tr>' ?>
                                            <?php } ?>
                                        <?php } ?>
                                        <?= $k2 == 0 ? '' : '</tr>' ?>
                                    <?php } ?>
                            </tr>
                        <?php } ?>
                    <?php } ?>
                </tbody>
            </table>
        </form>
    </div>
</div>
<script>
    $('.page-title-actions').append($('#menuGap'));
    function switchGapAnalisa(id) {
        console.log(id);
        $.get('<?= site_url($module . '/switch_gap_analisa') ?>', {id: id}, function (data) {
            if (data == 'success') {
                location.reload();
            }
        });
    }
</script>