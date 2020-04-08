<?php ?>
<style>
    #root ul {
        list-style-type: none;
    }
</style>
<div class="main-card mb-3 card">
    <div class="card-body">
        <div class="form-group">
            <label>Perusahaan</label>
            <select id="perusahaan" class="form-control" name="perusahaan" required="">
                <option value="">-- Perusahaan --</option>
                <?php foreach ($company as $c) { ?>
                    <option value="<?php echo $c['id'] ?>" <?php echo $c['id'] == $this->input->post('role') ? 'selected' : ''; ?>><?php echo $c['name'] ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="form-group">
            <label>Standar</label>
            <select id="standar" class="form-control" name="perusahaan" required=""></select>
        </div>
        <!--TAB-->
        <div class="main-card mb-3 card">
            <div class="card-body">
                <ul class="nav nav-tabs">
                    <li class="nav-item"><a data-toggle="tab" href="#tab-pemenuhan" class="nav-link active">Pemenuhan</a></li>
                    <li class="nav-item"><a data-toggle="tab" href="#tab-pasal" class="nav-link">Pasal</a></li>
                    <li class="nav-item"><a data-toggle="tab" href="#tab-jadwal" class="nav-link">Jadwal</a></li>
                    <li class="nav-item"><a data-toggle="tab" href="#tab-penerapan" class="nav-link">Penerapan</a></li>
                </ul>
                <div class="tab-content">
                    <!--PEMENUHAN-->
                    <div class="tab-pane active" id="tab-pemenuhan" role="tabpanel">
                        <ul class="list-group">
                        </ul>
                    </div>
                    <!--PASAL-->
                    <div class="tab-pane" id="tab-pasal" role="tabpanel">
                        <div class="row">
                            <div class="col-sm-6" id="treeview-list">
                                <ul class="list-group">
                                    <li id="root" class="list-group-item">
                                        <span class="title"></span>
                                        <ul></ul>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-sm-6" id="treeview-crud">
                                <form id="formDetail" class="d-none" method="post" enctype="multipart/form-data">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="form-title"></h4>
                                        <button class="close" type="button" aria-label="Close" onclick="closeForm()">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group d-none">
                                            <label for="parent-id">ID</label>
                                            <input class="form-control item-id" name="id" required="" readonly="">
                                        </div>
                                        <div class="form-group">
                                            <label for="parent">Deskripsi</label>
                                            <input class="form-control item-desc" name="desc">
                                        </div>
                                        <div class="form-group">
                                            <label>File</label>
                                            <input type="file" accept=".pdf" class="form-control file" name="file" placeholder="Nama">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default pull-left" onclick="closeForm()">Batal</button>
                                        <button type="submit" class="btn btn-default" name="form1" value="ok">Simpan</button>
                                    </div>
                                </form>
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
            </div>
        </div>
    </div>
</div>
<!--TEMPLATE-->
<div class="invisible">
    <ul class="-list-group">
        <li id="tree" class="-list-group-item">
            <input class="desc d-none" name="desc" value="">
            <input class="filename d-none" name="desc" value="">
            <span class="title"></span>
            <?php if ($activeModule['acc_update']) { ?>
                <span class="fa fa-bars text-primary" onclick="detail(this)" title="Open Form">&nbsp;</span>
            <?php } ?>
            <ul></ul>
        </li>
    </ul>
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
    $('#perusahaan').change(function (s) {
        if ($(this).val()) {
            $.post('<?php echo site_url($module); ?>/standard', {'id': $(this).val()}, function (data) {
                var d = JSON.parse(data);
                $('#standar').html('');
                $('#standar').append('<option value="">-- Standar --</option>');
                for (var i = 0; i < d.length; i++) {
                    $('#standar').append('<option value="' + d[i].id + '">' + d[i].name + '</option>');
                }
            });
        }
    });
    $('#standar').change(function (s) {
        if ($(this).val()) {
            $('#root span').text($('#standar option:selected').text());
            $('#root').children('ul').html('');
            $('#tab-pemenuhan .list-group').html('');
            $('#tab-jadwal').html('');
            $('#tab-penerapan').html('');
            $.post('<?php echo site_url($module); ?>/get', {'id': $(this).val()}, function (data) {
                var d = JSON.parse(data);
                for (var l of d) {
//                    PASAL
                    var parent = l.parent == null ? 'root' : l.parent;
                    parent = $('#' + parent);
                    var clone = $('#tree').clone();
                    clone.attr('id', l.id);
                    clone.children('.title').text(' ' + l.name);
                    clone.children('.desc').val(l.description);
                    parent.children('ul').append(clone);
                    parent.children('.fa-trash').remove();
                    if (parent.children('.fa-angle-double-right').length == 0) {
                        parent.children('.title').before('<span class="fa fa-angle-double-right text-success" onclick="collapse(this)"></span>');
                    }
                    if (l.file != null) {
                        clone.children('.fa-upload').after('<a class="fa fa-download text-success" href="<?php echo base_url('assets/') ?>' + l.file + '" title="Download"></a>');
                    }
                }
                $('#root ul').addClass('collapse');
                $('#root ul').collapse('toggle');
                $('#root ul').collapse('toggle');
                $('#treeview-list li .title').each(function (index) {
//                PEMENUHAN
                    var r = Math.floor(Math.random() * 101);
                    var clone = $('#template-pemenuhan').clone();
                    clone.attr('id', 'pemenuhan-' + index);
                    clone.find('.title').text($(this).text());
                    var bar = '<div class="progress-bar bg-success" role="progressbar" aria-valuenow="' + r + '" aria-valuemin="0" aria-valuemax="100" style="width: ' + r + '%">' + r + '%</div>';
                    clone.find('.progress').append(bar);
                    $('#tab-pemenuhan .list-group').append(clone);
                    var clone2 = clone.clone();
//                    JADWAL
                    clone2.attr('id', 'jadwal-' + index);
                    clone2.find('.progress').addClass('jadwal');
                    clone2.find('.progress').removeClass('progress');
                    clone2.find('.jadwal').text('00:00');
                    $('#tab-jadwal').append(clone2);
//                    PENERAPAN
                    var clone3 = clone2.clone();
                    clone3.attr('id', 'penerapan-' + index);
                    clone3.find('.jadwal').text('-');
                    $('#tab-penerapan').append(clone3);
                });
            });
        }
    });
    function collapse(item) {
        $(item).parent('li').children('ul').collapse('toggle');
    }
    function detail(item) {
        closeForm();
        showCrud('#formDetail');
        $('#form-title').text($.trim($(item).parent().children('.title').text()));
        $('.item-id').val($(item).parent().attr('id'));
        console.log($(item).parent().children('.desc'));
        $('.item-desc').val($(item).parent().children('.desc').val());
        $('#treeview-list').removeClass('col-sm-12');
        $('#treeview-list').addClass('col-sm-6');
        $('#treeview-crud').show();
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
</script>
