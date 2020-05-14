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
            <?php if (!empty($d['child'])) { ?>
                <span class="fa fa-angle-double-right text-success" onclick="collapse(this)"></span>
            <?php } ?>
            <span class="title"><?php echo $d['name'] ?></span>
            <?php if ($activeModule['acc_update'] & empty($d['child'])) { ?> 
                <?php if ($role == 'pic' || $role = 'admin') { ?>
                    <span class="fa fa-info-circle text-primary" onclick="form1(<?php echo $k ?>)" title="Open Form 1">&nbsp;</span>
                <?php } ?>
                <span class="fa fa-bars text-success" onclick="form2(<?php echo $k ?>)" title="Open Form 2">&nbsp;</span>
            <?php } ?>
            <ul></ul>
        </li>
    <?php } ?>
</ul>
<!--DATA-->
<div class="d-none">            
    <?php foreach ($pemenuhan1 as $k => $p) { ?>
        <div class="item-pemenuhan" <?php echo 'id="item-pemenuhan' . $p['id'] . '"' ?>>            
            <div class="pasal card bg-heavy-rain mb-1">
                <div class="index"><?php echo $k ?></div>
                <div class="row m-1" >
                    <div class="col-sm-6 title">
                        <?php echo $p['name'] ?>
                    </div>
                    <div class="col-sm-3">
                        100 %
                    </div>
                    <div class="col-sm-3">
                        100 %
                    </div>
                </div>
            </div>
            <div class="child"></div>
        </div>
    <?php } ?>
</div>
<ul class="nav nav-tabs">
    <li class="nav-item"><a data-toggle="tab" href="#tab-pemenuhan1" class="nav-link">Pemenuhan</a></li>
    <li class="nav-item"><a data-toggle="tab" href="#tab-pasal" class="nav-link">Pasal</a></li>
    <li class="nav-item"><a data-toggle="tab" href="#tab-dokumen" class="nav-link">Dokumen</a></li>
    <li class="nav-item"><a data-toggle="tab" href="#tab-jadwal" class="nav-link">Jadwal</a></li>
    <li class="nav-item"><a data-toggle="tab" href="#tab-penerapan" class="nav-link">Penerapan</a></li>
</ul>
<div class="tab-content">
    <!--PEMENUHAN-->
    <div class="tab-pane" id="tab-pemenuhan1" role="tabpanel">
        <table class="table">
            <thead>
                <tr>
                    <th></th>
                    <th>Dokumen</th>
                    <th>Implementasi</th>
                </tr>
            </thead>
            <tbody id="table-pemenuhan">

            </tbody>
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
        <div class="row">
            <div class="col-sm-6" id="treeview-list">
                <ul class="list-group">
                    <li id="root" class="list-group-item">
                        <span class="-title">ROOT</span>
                        <ul></ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!--DOKUMEN-->
    <div class="tab-pane" id="tab-dokumen" role="tabpanel">
        <button class="btn btn-primary fa fa-plus"></button>
        <table class="table table-striped">
            <thead></thead>
            <tbody>
                <tr>
                    <td>No Dokumen</td>
                    <td>Keterangan</td>
                    <td>Level</td>
                    <td>detail</td>
                </tr>
            </tbody>
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
                        <span><?php // echo $data['file']                                              ?></span>
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
    var dataPemenuhan = JSON.parse('<?php echo json_encode($pemenuhan1) ?>');
    for (var i = 0; i < dataPemenuhan.length; i++) {
        if (dataPemenuhan[i].parent != null) {
            var parent = $('#item-pemenuhan' + dataPemenuhan[i].parent);
            var element = $('#item-pemenuhan' + dataPemenuhan[i].id);
            parent.children('.child').append(element);
            dataPemenuhan[i].fullname = parent.find('.title:first').text() + ' - ' + element.find('.title').text();
            element.find('.title').text(dataPemenuhan[i].fullname);
        } else {
            dataPemenuhan[i].fullname = dataPemenuhan[i].name;
        }
    }
    var listPasal = $('.pasal');
    var pasalSort = [];
    for (var i = 0; i < listPasal.length; i++) {
        var n = parseInt($(listPasal[i]).find('.index').text());
        if (Number.isInteger(n)) {
            pasalSort.push(n);
        } else {
            console.log('Error parsing: ' + n);
        }
    }
    for (var i = 0; i < pasalSort.length; i++) {
        var data = dataPemenuhan[pasalSort[i]];
        $('#table-pemenuhan').append('<tr><td>' + data.fullname + '</td><td>10%</td><td>10%</td></tr>');
        $('#table-pasal').append('<tr><td>' + data.fullname + '</td><td>' + data.sort_desc + '</td><td><span class="fa fa-info-circle text-primary" onclick="detailPasal(' + i + ')" title="Detail"></span></td></tr>');
    }
    function detailPasal(index) {
        var m = $('#modalDetailPasal');
        var d = dataPemenuhan[pasalSort[index]];
        m.modal('show');
        m.find('.modal-title').text(d.fullname);
        m.find('.item-sort-desc').val(d.sort_desc);
        m.find('.item-long-desc').text(d.long_desc);
    }
//    console.log(item-pasal);

//    console.log(pemenuhan[0]);
    var data = JSON.parse('<?php echo json_encode($data) ?>');
    var pasal = $('.list-pasal');
    var formIndex = null;
//    $(document).ready(function () {
//        $('#table-penerapan').DataTable();
//    });
    for (var p, i = 0; i < data.length; i++) {
        p = pasal[i];
        $('#' + $(p).children('.parent').text()).children('ul').append(p);
//        }
        if (post != null) {
            if (post.idForm != null) {
                if (post.idForm == data[i].id) {
                    formIndex = i;
                }
            }
        }
    }
    $('#treeview-list').addClass('collapse');
    $('#treeview-list').collapse('toggle');
    $('#treeview-list').collapse('toggle');
    function form1(i) {
        var d = data[i];
//        closeForm();
//        showCrud('#form1');
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
        $.post('<?php echo site_url($module); ?>/form2_edit2', $(this).serializeArray(), function (data) {
            if (data == 'success') {
                $('#standar').change();
            } else {
                $('#form2').empty();
                $('#form2').append(data);
            }
        });
    });
    function collapse(item) {
        $(item).parent('li').children('ul').collapse('toggle');
    }
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