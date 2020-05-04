<?php
$role = $this->session->userdata['user']['role'];
?>
<style>
    #root ul {
        list-style-type: none;
        padding-left: 15px;
    }
</style>
<ul>
    <?php foreach ($data as $k => $d) { ?>
        <?php
        if ($this->input->post('pasal')) {
            if ($this->input->post('pasal') == $d['id']) {
                $activePasal = $k;
            }
        }
        ?>
        <li id="pasal<?php echo $d['id'] ?>" class="-list-group-item list-pasal">
            <input class="desc d-none" name="desc" value="">
            <input class="filename d-none" name="desc" value="">
            <span class="parent d-none"><?php echo empty($d['parent']) ? 'root' : 'pasal' . $d['parent'] ?></span>
            <span class="title"><?php echo $d['name'] ?></span>
            <?php if ($activeModule['acc_update']) { ?> 
                <?php if ($role == 'pic' || $role = 'admin') { ?>
                    <span class="fa fa-info-circle text-primary" onclick="form1(<?php echo $k ?>)" title="Open Form 1">&nbsp;</span>
                <?php } ?>
                <span class="fa fa-bars text-success" onclick="form2(<?php echo $k ?>)" title="Open Form 2">&nbsp;</span>
            <?php } ?>
            <ul></ul>
        </li>
    <?php } ?>
</ul>
<ul class="nav nav-tabs">
    <li class="nav-item"><a data-toggle="tab" href="#tab-pemenuhan" class="nav-link">Pemenuhan</a></li>
    <li class="nav-item"><a data-toggle="tab" href="#tab-pasal" class="nav-link">Pasal</a></li>
    <li class="nav-item"><a data-toggle="tab" href="#tab-jadwal" class="nav-link">Jadwal</a></li>
    <li class="nav-item"><a data-toggle="tab" href="#tab-penerapan" class="nav-link">Penerapan</a></li>
</ul>
<div class="tab-content">
    <!--PEMENUHAN-->
    <div class="tab-pane" id="tab-pemenuhan" role="tabpanel">
        <ul class="list-group">
            <?php foreach ($pemenuhan as $k => $p) { ?>
                <li class="list-group-item" id="template-pemenuhan">
                    <div class="row">
                        <div class="col-sm-5 title">
                            <?php echo $p['name'] ?>
                        </div>
                        <div class="col-sm-7">
                            <div class="progress">
                                <?php if (!empty($p['finish'])) { ?>
                                    <div class="progress-bar bg-success" role="progressbar" aria-valuenow="<?php echo $p['p_finish'] ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $p['p_finish'] ?>%"><?php echo $p['p_finish'] ?>%</div>
                                <?php } ?>
                                <?php if (!empty($p['terlambat'])) { ?>
                                    <div class="progress-bar bg-danger" role="progressbar" aria-valuenow="<?php echo $p['p_terlambat'] ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $p['p_terlambat'] ?>%"><?php echo $p['p_terlambat'] ?>%</div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </li>
            <?php } ?>
        </ul>
        <pre>
            <?php print_r($pemenuhan) ?>
            <?php // print_r($this->db->last_query()) ?>
        </pre>
    </div>
    <!--PASAL-->
    <div class="tab-pane" id="tab-pasal" role="tabpanel">
        <div class="row">
            <div class="col-sm-6" id="treeview-list">
                <ul class="list-group">
                    <li id="root" class="list-group-item">
                        <span class="-title">ROOT</span>
                        <ul></ul>
                    </li>
                </ul>
            </div>
            <div class="col-sm-6" id="treeview-crud">
                <!--FORM 1-->
                <form id="form1" class="d-none">
                    <div class="modal-header">
                        <h4 class="modal-title">Form 1</h4>
                        <button class="close" type="button" aria-label="Close" onclick="closeForm()">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>Nama</td>
                                    <td>:</td>
                                    <td class="item-name"></td>
                                </tr>
                                <tr>
                                    <td>Deskripsi</td>
                                    <td>:</td>
                                    <td class="item-desc"></td>
                                </tr>
                                <tr>
                                    <td>File</td>
                                    <td>:</td>
                                    <td><a class="item-file fa fa-download text-primary"></a></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-transition btn-outline-warning" onclick="closeForm()">Tutup</button>
                    </div>
                </form>
                <!--FORM 2-->
                <form id="form2" class="d-none"></form>
            </div>
        </div>
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
                <?php foreach ($schedule as $k => $s) { ?>
                    <tr>
                        <td><?php echo $s['pasal'] ?></td>
                        <td class="item-tgl"><?php echo $s['date'] ?></td>
                        <td class="col-sm-6"><?php echo $s['name'] . ' - ' . $s['division'] ?></td>
                        <td><?php echo $s['status'] ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <div class="tab-pane" id="tab-penerapan" role="tabpanel">
        <table class="table">
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
                <?php foreach ($schedule as $k => $s) { ?>
                    <tr>
                        <td><?php echo $s['pasal'] ?></td>
                        <td class="item-tgl"><?php echo $s['date'] ?></td>
                        <td class="col-sm-6"><?php echo $s['name'] . ' - ' . $s['division'] ?></td>
                        <td>
                            <?php if ($s['status'] == '-') { ?>
                                <button class="btn btn-success item-upload-penerapan" type="submit" name="uploadPenerapan" value="<?php echo $s['id'] ?>">Upload</button>
                            <?php } else { ?>
                                <span class="btn btn-danger">Upload</span>
                            <?php } ?>
                        </td>
                        <td><?php echo $s['status'] ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<div class="d-none">
    <ul>
        <li class="list-group-item" id="template-pemenuhan">
            <div class="row">
                <div class="col-sm-5 title">
                    Pasal
                </div>
                <div class="col-sm-7">
                    <div class="progress">
                    </div>
                </div>
            </div>
        </li>
    </ul>
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
                        <span><?php // echo $data['file']            ?></span>
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
    var data = JSON.parse('<?php echo json_encode($data) ?>');
    var pasal = $('.list-pasal');
    var formIndex = null;
    for (var p, i = 0; i < data.length; i++) {
//        var parent = l.parent == null ? 'root' : l.parent;
//        parent = $('#' + parent);
        p = pasal[i];
        $('#' + $(p).children('.parent').text()).children('ul').append(p);
//        if (parent.children('.fa-angle-double-right').length == 0) {
//            parent.children('.title').before('<span class="fa fa-angle-double-right text-success" onclick="collapse(this)"></span>');
//            parent.children('.ctrl-form1').remove();
//        }
        if (post != null) {
            if (post.idForm != null) {
                if (post.idForm == data[i].id) {
                    formIndex = i;
                }
            }
        }
    }
    function form1(i) {
        var d = data[i];
        closeForm();
        showCrud('#form1');
        $('.item-name').text(d.name);
        $('.item-desc').text(d.description);
        if (d.file != null) {
            $('.item-file').attr('href', '<?php echo base_url('upload/form1/') ?>' + d.file);
            $('.item-file').removeClass('d-none');
        } else {
            $('.item-file').addClass('d-none');
        }
    }
    function form2(i) {
        closeForm();
        $.post('<?php echo site_url($module); ?>/form2', {'idPasal': data[i].id, 'idPerusahaan': idPerusahaan, 'idStandar': idStandar}, function (data) {
            $('#form2').empty();
            $('#form2').append(data);
            showCrud('#form2');
        });
    }

    function closeForm() {
        $('#treeview-list').removeClass('col-sm-6');
        $('#treeview-list').addClass('col-sm-12');
        $('#treeview-crud').hide();
        $('form').addClass('d-none');
    }
    function showCrud(item) {
        $('#treeview-list').removeClass('col-sm-12');
        $('#treeview-list').addClass('col-sm-6');
        $('#treeview-crud').show();
        $(item).removeClass('d-none');
    }
    $('#form2').on('submit', function (e) {
        e.preventDefault();
        $.post('<?php echo site_url($module); ?>/form2_send', $(this).serializeArray(), function (data) {
            if (data == 'success') {
                $('#standar').change();
            } else {
                $('#form2').empty();
                $('#form2').append(data);
            }
        });
    });
//    $('#treeview-list li .title').each(function (index) {
//        PEMENUHAN
//        var r = Math.floor(Math.random() * 101);
//        var clone = $('#template-pemenuhan').clone();
//        clone.attr('id', 'pemenuhan-' + index);
//        clone.find('.title').text($(this).text());
//        var bar = '<div class="progress-bar bg-success" role="progressbar" aria-valuenow="' + r + '" aria-valuemin="0" aria-valuemax="100" style="width: ' + r + '%">' + r + '%</div>';
//        clone.find('.progress').append(bar);
//        $('#tab-pemenuhan .list-group').append(clone);
//    });
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
    if (post != null) {
        form2(formIndex);
        post = null;
    }
</script>