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
    <li class="nav-item"><a data-toggle="tab" href="#tab-pasal" class="nav-link active">Pasal</a></li>
    <li class="nav-item"><a data-toggle="tab" href="#tab-jadwal" class="nav-link">Jadwal</a></li>
    <li class="nav-item"><a data-toggle="tab" href="#tab-penerapan" class="nav-link">Penerapan</a></li>
</ul>
<div class="tab-content">
    <!--PEMENUHAN-->
    <div class="tab-pane" id="tab-pemenuhan" role="tabpanel">
        <ul class="list-group">
        </ul>
    </div>
    <!--PASAL-->
    <div class="tab-pane active" id="tab-pasal" role="tabpanel">
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
        <p>Jadwal</p>
    </div>
    <div class="tab-pane" id="tab-penerapan" role="tabpanel">
        <p>Penerapan</p>
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
<script>
    var data = JSON.parse('<?php echo json_encode($data) ?>');
    console.log(data);
    var pasal = $('.list-pasal');
    for (var p, i = 0; i < data.length; i++) {
        p = pasal[i]
        $('#' + $(p).children('.parent').text()).children('ul').append(p);
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
        $.post('<?php echo site_url($module); ?>/form2', {'idPasal': data[i].id, 'idPerusahaan':idPerusahaan}, function (data) {
            $('#form2').empty();
            $('#form2').append(data);
//            var d = JSON.parse(data);
//            $('#standar').html('');
//            $('#standar').append('<option value="">-- Standar --</option>');
//            for (var i = 0; i < d.length; i++) {
//                $('#standar').append('<option value="' + d[i].id + '">' + d[i].name + '</option>');
//            }
            showCrud('#form2');
        });
        //=====================
        var d = data[i];
//        $('.item-name').text(d.name);
//        $('.item-desc').text(d.description);
//        if (d.file != null) {
//            $('.item-file').attr('href', '<?php // echo base_url('upload/form1/')  ?>' + d.file);
//            $('.item-file').removeClass('d-none');
//        } else {
//            $('.item-file').addClass('d-none');
//        }
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
        console.log($(this).serialize());
    });
    $('#treeview-list li .title').each(function (index) {
//        PEMENUHAN
        var r = Math.floor(Math.random() * 101);
        var clone = $('#template-pemenuhan').clone();
        clone.attr('id', 'pemenuhan-' + index);
        clone.find('.title').text($(this).text());
        var bar = '<div class="progress-bar bg-success" role="progressbar" aria-valuenow="' + r + '" aria-valuemin="0" aria-valuemax="100" style="width: ' + r + '%">' + r + '%</div>';
        clone.find('.progress').append(bar);
        $('#tab-pemenuhan .list-group').append(clone);
        var clone2 = clone.clone();
//        JADWAL
        clone2.attr('id', 'jadwal-' + index);
        clone2.find('.progress').addClass('jadwal');
        clone2.find('.progress').removeClass('progress');
        clone2.find('.jadwal').text('00:00');
        $('#tab-jadwal').append(clone2);
//        PENERAPAN
        var clone3 = clone2.clone();
        clone3.attr('id', 'penerapan-' + index);
        clone3.find('.jadwal').text('-');
        $('#tab-penerapan').append(clone3);
    });
</script>