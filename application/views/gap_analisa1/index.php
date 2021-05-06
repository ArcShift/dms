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
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Pasal</th>
                                <th>Judul Pasal</th>
                                <th>Pertanyaan</th>
                                <th>Unit</th>
                                <th>Bukti Implementasi</th>
                                <th>Status</th>
                                <th style="min-width: 90px">Aksi</th>
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
                                    <td style="white-space: pre-wrap" rowspan="<?= $v['row'] ?>"><?= $v['sort_desc'] ?></td>
                                    <?php if (empty($v['pertanyaan'])) { ?>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                    <?php } ?>
                                    <?php foreach ($v['pertanyaan'] as $k2 => $v2) { ?>
                                        <?= $k2 == 0 ? '' : '<tr>' ?>
                                        <td rowspan="<?= $v2['row'] ?>">
                                            <?= $v2['kuesioner'] ?>
                                            <?php if ($role == 'pic') { ?>
                                                <button class="btn p-0 btn-link" name="edit_pertanyaan" value="<?= $v2['id'] ?>">Kelola Unit</button>
                                            <?php } ?>
                                        </td>
                                        <?php if ($role == 'pic') { ?>
                                            <?php foreach ($v2['status'] as $k3 => $v3) { ?>
                                                <?=
                                                $k3 == 0 ? '' : '<tr>';
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
                                                <td><?= $v3['unit_kerja'] ?></td>
                                                <td>
                                                    <ul>
                                                        <?php
                                                        foreach ($v3['implementasi'] as $k => $v4) {
                                                            switch (strtolower($v4['type'])) {
                                                                case 'file':
                                                                    $href = base_url('gap_analisa/' . $v4['path']);
                                                                    $txt = substr($v4['path'], 0, 30);
                                                                    break;
                                                                case 'url':
                                                                    $href = $v4['path'];
                                                                    $txt = substr($v4['path'], 0, 30);
                                                                    break;
                                                                case 'doc':
                                                                    $href = site_url('document_search/detail/' . $v4['id_document']);
                                                                    $txt = $v4['judul'];
                                                                    break;
                                                            }
                                                            ?>
                                                            <li>
                                                                <a target="_blank" href="<?= $href ?>"><?= $txt ?></a>
                                                            </li>
                                                        <?php } ?>
                                                    </ul>
                                                </td>
                                                <td><span class="badge badge-<?= $color ?>"><?= $stt ?></span></td>
                                                <td>
                                                    <button class="btn btn-sm btn-outline-primary fa fa-upload" name="upload" value="<?= $v3['id'] ?>"></button>
                                                    <button type="button" class="btn btn-sm btn-outline-primary fa fa-edit" onclick="edit(<?= $v3['id'] ?>)"></button>
                                                    <button type="button" class="btn btn-sm btn-outline-primary fa fa-search" onclick="detail(<?= $v3['id'] ?>)"></button>
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
                </div>
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
                        <label><b>Pasal</b></label>
                        <textarea class="form-control input-deskripsi" readonly=""></textarea>
                    </div>

                    <div class="form-group">
                        <label><b>Deskripsi Pasal</b></label>
                        <textarea class="form-control input-deskripsi" readonly=""></textarea>
                    </div>
                    <div class="form-group">
                        <label><b>Bukti yang diinginkan</b></label>
                        <textarea class="form-control input-bukti" readonly=""></textarea>
                    </div>
                    <div class="form-group">
                        <label><b>Hasil Gap Analisa</b></label>
                        <textarea class="form-control inp input-hasil" name="hasil"></textarea>
                    </div>
                    <div class="form-group">
                        <label><b>Status</b></label>
                        <select class="form-control inp input-status" name="status" required="">
                            <option value="">~ status ~</option>
                            <option value="100">OK</option>
                            <option value="75">75%</option>
                            <option value="50">50%</option>
                            <option value="25">25%</option>
                            <option value="0">NOK</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label><b>Saran Perbaikan</b></label>
                        <textarea class="form-control inp input-saran" name="saran"></textarea>
                    </div>
                    <div class="form-group">
                        <label><b>Target</b></label>
                        <input class="form-control inp input-target" name="target" type="date">
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
    function initUpload() {
        var m = $('#modalUpload');
        m.modal('show');
    }
    function edit(id) {
        var m = $('#modalEdit');
        m.modal('show');
        m.find('.inp').prop('disabled', false);
        m.find('.btn-simpan').show();
        $.getJSON('<?= site_url($module . '/detail_pertanyaan') ?>', {id: id}, function (d) {
            console.log(d);
            m.find('.input-id').val(d.id);
            m.find('.input-status').val(d.status);
            m.find('.input-hasil').val(d.hasil);
            m.find('.input-saran').val(d.saran_perbaikan);
            m.find('.input-deskripsi').val(d.long_desc);
            m.find('.input-bukti').val(d.bukti);
            m.find('.input-target').val(d.target);
        });
    }
    function detail(id) {
        edit(id);
        var m = $('#modalEdit');
        m.find('.inp').prop('disabled', true);
        m.find('.btn-simpan').hide();
    }
</script>