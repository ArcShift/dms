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
<?php if ($this->session->has_userdata('gapAnalisa')) { ?>
    <p class="text-center">Waktu Gap Analisa: <?= date('d M Y', strtotime($this->session->gapAnalisa['tanggal'])) ?></p>
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
                            <th>Unit</th>
                            <th>Bukti Implementasi</th>
                            <th>Aksi</th>
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
                                        <?php foreach ($v2['status'] as $k3 => $v3) { ?>
                                            <?= $k3 == 0 ? '' : '<tr>' ?>
                                            <td><?= $v3['unit_kerja'] ?></td>
                                            <td>
                                                <a target="_blank" href="<?= $v3['imp_type'] == 'URL' ? $v3['imp_path'] : base_url('upload/imp_gap_analisa/' . $v3['imp_path']) ?>"><?= substr($v3['imp_path'], 0, 30) ?></a>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-outline-primary fa fa-edit" onclick="detail(<?= $v3['id'] ?>)"></button>
                                            </td>
                                            <?= $k3 == 0 ? '' : '</tr>' ?>
                                        <?php } ?>
                                    <?php } ?>
                                    <?= $k2 == 0 ? '' : '</tr>' ?>
                                <?php } ?>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </form>
        </div>
    </div>
<?php } ?>
<!--MODAL DETAIL-->
<div class="modal fade" id="modalDetail">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                <button class="btn btn-primary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
<!--MODAL EDIT-->
<div class="modal fade" id="modalEdit">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title">Gap Analisa</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input class="input-id" name="id" hidden="">
                    <div class="form-group">
                        <label><b>Hasil Gap Analisa</b></label>
                        <textarea class="form-control input-hasil" name="hasil"></textarea>
                    </div>
                    <div class="form-group">
                        <label><b>Status</b></label><br>
                        <div class="badge badge-secondary badge-status"></div>
                    </div>
                    <div class="form-group">
                        <label><b>Saran Perbaikan</b></label>
                        <textarea class="form-control input-saran" name="saran"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-outline-primary" data-dismiss="modal">Tutup</button>
                    <button class="btn btn-outline-primary btn-simpan" name="edit2" value="ok">Simpan</button>
                </div>
            </form>
        </div>
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
    function detail(id) {
        var m = $('#modalEdit');
        m.modal('show');
        $.getJSON('<?= site_url($module . '/detail_pertanyaan') ?>', {id: id}, function (d) {
            m.find('.input-id').val(d.id);
            m.find('.badge-status').html(d.status);
            m.find('.input-hasil').val(d.hasil);
            m.find('.input-saran').val(d.saran_perbaikan);
        });
    }
</script>