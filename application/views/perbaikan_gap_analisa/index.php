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
<p class="text-center">Waktu Gap Analisa: <?= date('d M Y', strtotime($this->session->gapAnalisa['tanggal'])) ?></p>
<div class="card">
    <div class="card-body">
        <form method="post">
            <table class="table">
                <thead>
                    <tr>
                        <th>Pertanyaan</th>
                        <th>Unit</th>
                        <th>Saran Perbaikan</th>
                        <th>Target</th>
                        <th>Bukti Perbaikan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data as $k2 => $v2) { ?>
                        <tr>
                            <td rowspan="<?= $v2['row'] ?>"><?= $v2['kuesioner'] ?></td>
                        </tr>
                        <?php
                        foreach ($v2['unit'] as $k3 => $v3) {
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
                                <td style="white-space: pre-wrap"><?= $v3['saran_perbaikan'] ?></td>
                                <td><?= $v3['target'] ?></td>
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
                                <td><span class="badge badge-<?= $v3['deadline'] ?>"><?= $stt ?></span></td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary fa fa-upload" name="upload" value="<?= $v3['id'] ?>" title="Upload Bukti Perbaikan"></button>
                                    <button type="button" class="btn btn-sm btn-outline-primary fa fa-edit" onclick="edit(<?= $v3['id'] ?>)"></button>
                                </td>
                            </tr>
                        <?php } ?>
                    <?php } ?>
                </tbody>
            </table>
        </form>
    </div>
</div>
<!--MODAL EDIT-->
<div class="modal fade" id="modalEdit">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Perbaikan Gap Analisa</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input class="input-id" name="id" hidden="">
                    <div class="form-group">
                        <label><b>Pasal</b></label>
                        <input class="form-control input-pasal" readonly="">
                    </div>
                    <div class="form-group">
                        <label><b>Bukti Pasal</b></label>
                        <textarea class="form-control input-bukti" readonly=""></textarea>
                    </div>
                    <label><b>Bukti Perbaikan</b></label>
                    <div class="form-group group-link">
                        <div class="input-group">
                            <input class="form-control input-path" readonly="">
                            <div class="input-group-append">
                                <button type="button" class="btn btn-outline-danger fa fa-trash link-bukti" onclick="initUpload()"></button>
                            </div>
                        </div>
                    </div>
                    <div class="form-group group-upload">
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="customRadio1" name="type" value="file" class="custom-control-input radio-bukti">
                            <label class="custom-control-label" for="customRadio1">File</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="customRadio2" name="type" value="url" class="custom-control-input radio-bukti">
                            <label class="custom-control-label" for="customRadio2">Url</label>
                        </div>
                    </div>
                    <div class="form-group group-upload">
                        <input class="form-control input-file" type="file" name="userfile">
                        <input class="form-control input-url" type="url" name="url">
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-outline-primary" data-dismiss="modal">Tutup</button>
                    <button class="btn btn-outline-primary btn-simpan" name="edit" value="ok">Simpan</button>
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
    function edit(id) {
        $.getJSON('<?= site_url($module . '/detail') ?>', {id: id}, function (d) {
            var m = $('#modalEdit');
            m.modal('show');
            m.find('.input-id').val(d.id);
            m.find('.input-pasal').val(d.pasal);
            m.find('.input-bukti').val(d.bukti_pasal);
            if (d.path == null) {
                initUpload();
            } else {
                $('.group-link').show();
                $('.group-upload').hide();
                m.find('.input-path').val(d.path);
            }
            $('.input-file,.input-url').hide();
            $('.radio-bukti').prop('checked', false);
            $('.input-file,.input-url').prop('required', false);
            console.log(d);
        });
    }
    function initUpload() {
        $('.group-link').hide();
        $('.group-upload').show();
    }
    $('.radio-bukti').change(function () {
        var type = $(this).val();
        var m = $('#modalEdit');
        $('.btn-simpan').show();
        if (type == 'file') {
            m.find('.input-file').show();
            m.find('.input-file').prop('required', true);
            m.find('.input-url').hide();
            m.find('.input-url').prop('required', false);
        } else if (type == 'url') {
            m.find('.input-file').hide();
            m.find('.input-file').prop('required', false);
            m.find('.input-url').show();
            m.find('.input-url').prop('required', true);
        }
    });
</script>