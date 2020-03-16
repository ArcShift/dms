<div class="box">
    <div class="box-body">
        <button class="btn btn-primary fa fa-plus" data-toggle="modal" data-target="#modalCreate" title="Tambah"></button>
        <table class="table">
            <thead>
                <tr>
                    <td>Urutan</td>
                    <td>Nama</td>
                    <td>Induk</td>
                    <td>Aksi</td>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data1 as $row) { ?>
                    <tr>
                        <td></td>
                        <td><?php echo $row['nama'] ?></td>
                        <td><?php echo $row['induk'] ?></td>
                        <td>
                            <button class="btn btn-danger fa fa-trash" onclick="deleteInit(<?php echo $row['id'] ?>, '<?php echo $row['nama'] ?>')"></button>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <ul id="module"></ul>
    </div>
</div>
<!--MODAL TAMBAH-->
<div class="modal fade" id="modalCreate" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <form role="form" id="formTambah">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Tambah Modul</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="namaModule">Nama</label>
                        <input class="form-control" id="namaModule" name="nama" placeholder="Nama Module" required="">
                    </div>
                    <div class="form-group">
                        <label for="namaModule">Modul Induk</label>
                        <select class="form-control" id="modulInduk" name="induk">
                            <option value="">--ROOT--</option>
                            <?php foreach ($data1 as $row) { ?>
                                <option value="<?php echo $row['id'] ?>">
                                    <?php echo $row['nama'] ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="iconModule">Icon</label>
                        <input class="form-control" id="namaModule" name="icon" placeholder="Nama Icon">
                        <button type="button" data-toggle="modal" data-target="#modalIcon">find</button>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--MODAL LIST ICON-->
<div class="modal fade" id="modalIcon" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Icon Modul</h4>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</div>
<!--MODAL DELETE CONFIRMATION-->
<div class="modal fade modal-danger" id="modalDelete" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Hapus Modul</h4>
            </div>
            <div class="modal-body">

                Anda yakin ingin menghapus modul <b id="modulHapus"></b>?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success pull-left" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" onclick="deleteConfirm()">Hapus</button>
            </div>
        </div>
    </div>
</div>
<script>
    var idHapus = 0;
    $(document).ready(function () {
        getData();
    });
    $("#formTambah").submit(function (e) {
        e.preventDefault();
        console.log($(this).serialize());
        $.post('<?php echo site_url("adminconfig/module/create"); ?>', $(this).serialize(), function (resp) {
            if (resp === 'success') {
                location.reload();
            }
        });
    });
    function deleteInit(id, nama) {
        $("#modalDelete").modal("show");
        console.log(id + '-' + nama);
        idHapus = id;
        $("#modulHapus").text(nama);
    }
    function deleteConfirm() {
        $.post("<?php echo site_url("adminconfig/module/delete") ?>", {
            id: idHapus
        }, function (resp) {
            if (resp === 'success') {
                location.reload();
            }
        });
    }
    function getData() {
        $.getJSON("<?php echo site_url("adminconfig/module/getList") ?>", null, function (r) {
            console.log(r);
            for (var i = 0; i < r.length; i++) {
                var list = "<li>" + r[i].nama + "<ul id='module" + r[i].id + "'></ul></li>";
                if (r[i].indukId == null) {
                    $("#module").append(list);
                } else {
                    $("#module"+r[i].indukId).append(list);
                }
            }
        });
    }
//            function getStyle() {//GET ALL FONT AWESOME LIST
//                var index = 0; //index of stylesheet declare in head tage
//                var classesList = document.styleSheets[index].rules || document.styleSheets[index].cssRules
//                for (var x = 0; x < classesList.length; x++)
//                {
//                    if (classesList[x].cssText.match(/fa-/g) && classesList[x].cssText.match(/::/g))
//                    {
//                        var cc = classesList[x].cssText.split(' ')[0].split('::')[0];
//                        console.log(cc);
//                    }
//                }
//            }
//            getStyle();//blocked by security cross origin
</script>