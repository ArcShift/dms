<?php ?>
<div class="card">
    <div class="card-body">
        <button class="btn btn-outline-primary pull-right m-1" id="btnAdd">Tambah</button>
        <a class="btn btn-outline-primary pull-right m-1" href="<?= site_url($module) ?>">Kembali</a>
        <h4></h4>
        <table class="table">
            <thead>
                <tr>
                    <th>Type</th>
                    <th>Path</th>
                    <th>Upload Date</th>
                    <th style="width: 100px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($uploads as $k => $u) { ?>
                    <tr>
                        <td><?= $u['type'] ?></td>
                        <td><?= $u['path'] ?></td>
                        <td><?= $u['created_at'] ?></td>
                        <td>
                            <button class="btn btn-sm btn-outline-danger fa fa-trash" onclick="initHapus(<?= $k ?>)"></button>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<!--MODAL UPLOAD-->
<div class="modal fade" id="modalUpload">
    <div class="modal-dialog">
        <form method="post" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
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
                    <button class="btn btn-primary" data-dismiss="modal">Tutup</button>
                    <button class="btn btn-primary" id="btnSubmit" name="tambah" value="ok">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!--MODAL HAPUS-->
<div class="modal fade" id="modalHapus">
    <div class="modal-dialog">
        <form method="post" id="formHapus">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Hapus Bukti</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="modal-body">
                        <input class="form-control input-id" name="id" hidden="" required="">
                        <div class="form-group">
                            <input class="form-control input-url" type="url" readonly="">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-outline-primary" data-dismiss="modal">Batal</button>
                    <button class="btn btn-outline-danger" name="hapus" value="ok">Hapus</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    var upl = <?php echo json_encode($uploads) ?>;
    $('#btnAdd').click(function () {
        var m = $('#modalUpload');
        m.modal('show');
        m.find('#btnSubmit').attr('name', 'tambah');
        m.find('#btnSubmit').html('Upload');
        m.find('.modal-title').html('Upload Bukti Implementasi');
        $('.input-file,.input-url').hide();
        $('.radio-bukti').prop('checked', false);
        $('.input-file,.input-url').prop('required', false);
    });
    function initHapus(idx) {
        var s = upl[idx];
        var m = $('#modalHapus');
        m.modal('show');
        m.find('.input-url').val(s.path);
        m.find('.input-id').val(s.id);
    }
    $('.radio-bukti').change(function () {
        var type = $(this).val();
        var m = $('#modalUpload');
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