<?php
$role = $this->session->userdata['user']['role'];
?>
<!--<pre>-->
<?php // print_r($data) ?>
<!--</pre>-->
<style>
    #root ul {
        list-style-type: none;
        padding-left: 15px;
    }
</style>
<ul>
    <?php foreach ($data as $d) { ?>
        <li id="pasal<?php echo $d['id'] ?>" class="-list-group-item list-pasal">
            <input class="desc d-none" name="desc" value="">
            <input class="filename d-none" name="desc" value="">
            <span class="parent d-none"><?php echo empty($d['parent']) ? 'root' : 'pasal' . $d['parent'] ?></span>
            <span class="title"><?php echo $d['name'] ?></span>
            <?php if ($activeModule['acc_update']) { ?>
                <?php if ($role == 'pic' || $role = 'admin') { ?>
                    <span class="fa fa-bars text-primary" onclick="form1(this)" title="Open Form">&nbsp;</span>
                <?php } ?>
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
                                <button type="button" class="btn btn-transition btn-outline-warning" onclick="closeForm()">Batal</button>
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
<script>
    var data= JSON.parse('<?php echo json_encode($data)?>');
    console.log(data);
    var pasal = $('.list-pasal');
    for (var p, i = 0; i < pasal.length; i++) {
        p = pasal[i];
        $('#' + $(p).children('.parent').text()).children('ul').append(p);
    }
//    console.log($('#root li'));
    function form1(item) {
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