<?php
$role = $this->session->userdata['user']['role'];
?>
<!--TAB-->
<ul class="nav nav-tabs">
    <li class="nav-item"><a data-toggle="tab" href="#tab-pemenuhan1" class="nav-link">Pemenuhan</a></li>
    <li class="nav-item"><a data-toggle="tab" href="#tab-pasal" class="nav-link">Pasal</a></li>
    <li class="nav-item"><a data-toggle="tab" href="#tab-dokumen" class="nav-link">Dokumen</a></li>
    <li class="nav-item"><a data-toggle="tab" href="#tab-distribusi" class="nav-link">Distribusi</a></li>
    <li class="nav-item"><a data-toggle="tab" href="#tab-jadwal" class="nav-link">Jadwal</a></li>
    <li class="nav-item"><a data-toggle="tab" href="#tab-penerapan" class="nav-link">Penerapan</a></li>
</ul>
<div class="tab-content">
    <!--PEMENUHAN-->
    <div class="tab-pane" id="tab-pemenuhan1" role="tabpanel">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Pasal</th>
                    <th>Dokumen</th>
                    <th>Implementasi</th>
                </tr>
            </thead>
            <tbody id="table-pemenuhan"></tbody>
        </table>
    </div>
    <!--PASAL-->
    <div class="tab-pane" id="tab-pasal" role="tabpanel">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Pasal</th>
                    <th>Topik</th>
                    <th>Detail</th>
                </tr>
            </thead>
            <tbody id="table-pasal"></tbody>
        </table>
    </div>
    <!--DOKUMEN-->
    <div class="tab-pane" id="tab-dokumen" role="tabpanel">
        <div class="text-right mb-2">
            <label>Tambah Dokumen</label>
            <button class="btn btn-outline-primary fa fa-plus" onclick="tambahDokumen()"></button>
        </div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Judul</th>
                    <th>Jenis</th>
                    <th>detail</th>
                </tr>
            </thead>
            <tbody id="table-dokumen">
            </tbody>
        </table>
    </div>
    <div class="tab-pane" id="tab-distribusi" role="tabpanel">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Pasal</th>
                    <th>Judul Dokumen</th>
                    <th>Pembuat dokumen</th>
                    <th>Distribusi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
    <!--JADWAL-->
    <div class="tab-pane" id="tab-jadwal" role="tabpanel">
        <table class="table">
            <thead>
                <tr>
                    <th>Pasal</th>
                    <th>Tanggal</th>
                    <th>Distribusi</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php $txtPasal = ''; ?>
                <?php foreach ($schedule as $k => $s) { ?>
                    <tr>
                        <td><?php echo $s['pasal']; ?></td>
                        <td><?php echo $s['date'] ?></td>
                        <td><?php echo $s['name'] . ' - ' . $s['division'] ?></td>
                        <td><?php echo $s['status'] ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <div class="tab-pane" id="tab-penerapan" role="tabpanel">
        <table class="table" id="table-penerapan">
            <thead>
                <tr>
                    <th>Pasal</th>
                    <th>Tanggal</th>
                    <th>Distribusi</th>
                    <th>Bukti</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php $txtPasal = ''; ?>
                <?php foreach ($schedule as $k => $s) { ?>
                    <tr>
                        <td><?php echo $s['pasal']; ?></td>
                        <td><?php echo $s['date'] ?></td>
                        <td><?php echo $s['name'] . ' - ' . $s['division'] ?></td>
                        <td>
                            <?php if (!$s['deadline'] | !empty($s['file'])) { ?>
                                <div class="dropdown d-inline-block">
                                    <button type="button" aria-haspopup="true" aria-expanded="false" data-toggle="dropdown" class="dropdown-toggle btn btn-primary btn-sm">Aksi</button>
                                    <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu">
                                        <?php if (!$s['deadline']) { ?>
                                            <button type="button" class="dropdown-item item-upload-penerapan" name="uploadPenerapan" value="<?php echo $s['id'] ?>">Upload</button>
                                        <?php } ?>
                                        <?php if (!empty($s['file'])) { ?>
                                            <a class="dropdown-item" href="<?php echo base_url('upload/penerapan/' . $s['file']) ?>">Download</a>
                                        <?php } ?>
                                    </div>
                                </div>
                            <?php } ?>
                        </td>
                        <td><?php echo $s['status'] ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <div class="tab-pane" id="tab-base" role="tabpanel">Base</div>
</div>
<!--MODAL-->
<div class="modal fade" id="modalUploadPenerapan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form method="post" id="formUploadBuktiPenerapan" enctype="multipart/form-data">            
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Upload Bukti</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!--<input name="idPerusahaan" class="inputPerusahaan" value=""/>-->
                    <!--<input name="idPasal" class="inputPasal" value=""/>-->
                    <input class="d-none input-schedule" name="jadwal">
                    <div class="form-group">
                        <input class="form-control" type="file" name="doc" required="">
                        <span><?php // echo $data['file']                                                                      ?></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    var sortData = [];
    $(document).ready(function () {
        $.get('<?php echo site_url($module); ?>/pasal', {perusahaan: perusahaan, standar: standar}, function (data) {
            data = JSON.parse(data);
            for (var i = 0; i < data.length; i++) {
                var d = data[i];
                var element = '<div class="item-base" id="item-base' + d.id + '"><span>' + d.name + '</span><span class="index">' + i + '</span><div class="child"></div></div>';
                var parent = null;
                if (d.parent == null) {
                    $('#tab-base').append(element);
                } else {
                    $('#item-base' + d.parent).children('.child').append(element);
                }
                data[i] = d;
            }
            var element = $('.item-base').children('.index').get();
            for (var i = 0; i < element.length; i++) {
                var e = element[i];
                var index = $(e).text();
                sortData.push(data[index]);
                $(e).text(i);
            }
            for (var i = 0; i < sortData.length; i++) {
                var s = sortData[i];
                if (s.parent == null) {
                    s.parentIndex = null;
                    s.fullname = s.name;
                } else {
                    s.parentIndex = $('#item-base' + s.parent).children('.index').text();
                    s.fullname = sortData[s.parentIndex].fullname + ' - ' + s.name;
                }
                sortData[i] = s;
            }
            $('.select-pasal').empty();
            $('.select-pasal').append('<option value="">-- pilih pasal --</option>');
            for (var i = 0; i < sortData.length; i++) {
                var d = sortData[i];
                $('#table-pemenuhan').append('<tr><td>' + d.fullname + '</td><td>10%</td><td>10%</td></tr>');
                $('#table-pasal').append('<tr><td>' + d.fullname + '</td><td>' + d.sort_desc + '</td><td><span class="fa fa-info-circle text-primary" onclick="detailPasal(' + i + ')" title="Detail"></span></td></tr>');
                $('.select-pasal').append('<option value="' + d.id + '">' + d.fullname + '</option>');
            }
        });
    });
    function detailPasal(index) {
        var m = $('#modalDetailPasal');
        var d = sortData[index];
        m.modal('show');
        m.find('.modal-title').text(d.fullname);
        m.find('.item-sort-desc').val(d.sort_desc);
        m.find('.item-long-desc').text(d.long_desc);
    }
//    ====================================
    $('#form2').on('submit', function (e) {
        e.preventDefault();
        $.post('<?php echo site_url($module); ?>/form2_edit2', $(this).serializeArray(), function (data) {
            if (data == 'success') {
                $('#standar').change();
            } else {
                $('#form2').empty();
                $('#form2').append(data);
            }
        });
    });
    $('.item-upload-penerapan').click(function () {
        $('.input-schedule').val($(this).val());
        $('#modalContainer').append($('#modalUploadPenerapan'));
        $('#modalUploadPenerapan').modal('show');
    });
    $('#formUploadBuktiPenerapan').submit(function (e) {
        e.preventDefault();
        console.log('submit');
        $.ajax({
            url: '<?php echo site_url($module . '/upload_bukti_penerapan') ?>',
            type: "post",
            data: new FormData(this),
            processData: false,
            contentType: false,
            cache: false,
            async: false,
            success: function (data) {
                $('#modalUploadPenerapan').modal('hide');
                modalStatus(data);
                getTab('penerapan');
            }
        });
    });
</script>