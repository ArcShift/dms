<style>
    #root ul {
        list-style-type: none;
    }
</style>
<div class="main-card mb-3 card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-12" id="treeview-list">
                <ul class="list-group">
                    <li id="root" class="list-group-item">
                        <span><?php echo $treeview['name'] ?></span>
                        <?php if ($activeModule['acc_create']) { ?>
                            <span class="fa fa-plus text-primary" onclick="add(this)" title="Tambah"></span>
                        <?php } ?>
                        <ul></ul>
                    </li>
                </ul>
            </div>
            <div class="col-sm-6" id="treeview-crud">
                <!--FORM TAMBAH-->
                <form class="d-none" id="formAdd" method="post">
                    <div class="modal-header">
                        <h4 class="modal-title">Tambah Modul</h4>
                        <button class="close" data-dismiss="modal" aria-label="Close" onclick="closeForm()">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group d-none">
                            <label for="parent-id">Parent ID</label>
                            <input class="form-control" id="parent-id" name="id" required="" readonly="">
                        </div>
                        <div class="form-group">
                            <label for="parent">Parent Name</label>
                            <input class="form-control" id="parent" required="" readonly="">
                        </div>
                        <div class="form-group">
                            <label for="namaModule">Nama</label>
                            <input class="form-control" id="namaModule" name="nama" placeholder="Nama" required="">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <span class="btn btn-transition btn-outline-warning" onclick="closeForm()">Batal</span>
                        <button type="submit" class="btn btn-transition btn-outline-info" name="add" value="ok">Tambah</button>
                    </div>
                </form>
                <!--FORM EDIT-->
                <form id="formEdit" class="d-none" method="post">
                    <div class="modal-header">
                        <h4 class="modal-title">Ubah Item</h4>
                        <span class="close" aria-label="Close" onclick="closeForm()">
                            <span aria-hidden="true">&times;</span>
                        </span>
                    </div>
                    <div class="modal-body">
                        <div class="form-group d-none">
                            <label for="id">ID</label>
                            <input class="form-control item-id" name="id" required="" readonly="">
                        </div>
                        <div class="form-group">
                            <label>Nama</label>
                            <input class="form-control item-name" name="nama" placeholder="Nama" required="">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <span class="btn btn-transition btn-outline-warning" onclick="closeForm()">Batal</span>
                        <button type="submit" class="btn btn-transition btn-outline-info" name="modify" value="ok">Ubah</button>
                    </div>
                </form>
                <!--FORM REMOVE-->
                <form id="formDelete" class="d-none" method="post">
                    <div class="modal-header">
                        <h4 class="modal-title">Hapus Item</h4>
                        <button class="close" aria-label="Close" onclick="closeForm()">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group d-none">
                            <label for="parent-id">ID</label>
                            <input class="form-control item-id" name="id" required="" readonly="">
                        </div>
                        <div class="form-group">
                            <label for="namaModule">Nama</label>
                            <input class="form-control item-name" name="nama" placeholder="Nama" required="" readonly="">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <span class="btn btn-transition btn-outline-warning" onclick="closeForm()">Batal</span>
                        <button type="submit" class="btn btn-transition btn-outline-info" name="remove" value="ok">Hapus</button>
                    </div>
                </form>
                <!--FORM 1-->
                <form id="formDetail" class="d-none" method="post" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h4 class="modal-title" id="form-title"></h4>
                        <button class="close" aria-label="Close" onclick="closeForm()">
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
    <div class="box-footer"></div>
</div>
<!--TEMPLATE-->
<div class="invisible">
    <ul class="-list-group">
        <li id="tree" class="-list-group-item">
            <input class="desc d-none" name="desc" value="">
            <input class="filename d-none" name="desc" value="">
            <span class="title"></span>
            <?php if ($activeModule['acc_create']) { ?>
                <span class="fa fa-plus text-primary" onclick="add(this)" title="Tambah"></span>
            <?php } ?>
            <?php if ($activeModule['acc_update']) { ?>
                <span class="fa fa-edit text-primary" onclick="edit(this)" title="Ubah"></span>
            <?php } ?>
            <?php if ($activeModule['acc_delete']) { ?>
                <span class="fa fa-trash text-danger" onclick="remove(this)" title="Hapus"></span>
            <?php } ?>
            <?php if ($activeModule['acc_update']) { ?>
                <span class="fa fa-bars text-primary" onclick="detail(this)" title="Open Form">&nbsp;</span>
            <?php } ?>
                <span class="fa fa-download text-primary" onclick="download(this)" title="Download">&nbsp;</span>
            <?php if ($this->session->userdata('user')['role']=='anggota') { ?>
                <span class="fa fa-upload text-primary" onclick="download(this)" title="Upload">&nbsp;</span>
            <?php } ?>
            <ul></ul>
        </li>
    </ul>
</div>
<script>
    list = <?php echo $list ?>;
    for (var l of list) {
        var parent = l.parent == null ? 'root' : l.parent;
        parent = $('#' + parent);
        var clone = $('#tree').clone();
        clone.attr('id', l.id);
        clone.children('.title').text(' ' + l.name);
        clone.children('.desc').val(l.description);
        clone.children('.filename').val(l.file);
        parent.children('ul').append(clone);
        parent.children('.fa-trash').remove();
        if (parent.children('.fa-angle-double-right').length == 0) {
            parent.children('.title').before('<span class="fa fa-angle-double-right text-success" onclick="collapse(this)"></span>');
        }
        if (l.file != null) {
            clone.children('.fa-upload').after('<a class="fa fa-download text-success" href="<?php echo base_url('assets/') ?>' + l.file + '" title="Download"></a>');
        }
    }
    console.log(list);
    $('#root ul').addClass('collapse');
    $('#root ul').collapse('toggle');
    $('#root ul').collapse('toggle');
    $('#root .button').click(function () {
        $(this).parent('li').children('ul').collapse('toggle');
    });
    function collapse(item) {
        $(item).parent('li').children('ul').collapse('toggle');
    }
    function add(item) {
        closeForm();
        showCrud('#formAdd');
        $('#parent-id').val($(item).parent().attr('id'));
        $('#parent').val($(item).parent().children('span').text());
    }
    function edit(item) {
        closeForm();
        showCrud('#formEdit');
        $('.item-id').val($(item).parent().attr('id'));
        $('.item-name').val($(item).parent().children('span').text().trimLeft().trimRight());
    }
    function remove(item) {
        closeForm();
        showCrud('#formDelete');
        $('.item-id').val($(item).parent().attr('id'));
        $('.item-name').val($(item).parent().children('span').text());
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
    $('.file').change(function () {
        $('.filename').val($(this).val().split('\\').pop());
    });
</script>