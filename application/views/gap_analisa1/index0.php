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
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($this->session->has_userdata('gapAnalisa')) {
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