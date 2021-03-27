<div class="card">
    <div class="card-body">
        <form>
            <table class="table">
                <thead >
                    <tr>
                        <th>Pasal</th>
                        <th>Judul</th>
                        <th>Deskripsi</th>
                        <th>Penjelasan</th>
                        <th style="width:100px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pasal as $k => $v) { ?>
                        <tr <?= empty($v['parent']) ? 'class="table-success"' : '' ?>>
                            <td><?= $v['name'] ?></td>
                            <td><?= $v['sort_desc'] ?></td>
                            <td style="white-space: pre-wrap"><?= $v['long_desc'] ?></td>
                            <td style="white-space: pre-wrap"><?= $v['penjelasan'] ?></td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary fa fa-search" title="Detail" name="detail" value="<?= $v['id'] ?>"></button>
                                <button class="btn btn-sm btn-outline-primary fa fa-edit" title="Edit" name="edit" value="<?= $v['id'] ?>"></button>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </form>
    </div>
</div>
<div id="btm"></div>
<!--MODAL EDIT-->
<div class="modal fade" id="modalEdit" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-xl" role="document">
        <form id="formEdit">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Pasal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input class="form-control input-id" name="id" readonly="" hidden="">
                    <div class="form-group">
                        <label>Judul</label>
                        <input class="form-control input-judul" readonly="">
                    </div>
                    <div class="form-group">
                        <label>Deskripsi</label>
                        <textarea class="form-control input-desc" name="desc"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary btn-submit">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!--MODAL STATUS-->
<div class="modal fade" id="modalStatus2">
    <div class="modal-dialog">
        <div class="modal-header">
            <h5 class="modal-title">Loading</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="modal-content">
                Menyimpan data
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        </div>
    </div>
</div>    
<script>
    function edit(idx) {
        var p = pasal[idx];
        var m = $('#modalEdit');
        m.modal('show');
        m.find('.input-id').val(p.id);
        m.find('.modal-title').text(p.name);
        m.find('.input-judul').val(p.sort_desc);
        m.find('.input-desc').val(p.long_desc);
    }
    pasal = <?= json_encode($pasal) ?>;
    $('#formEdit').submit(function (e) {
        e.preventDefault();
        $('#modalEdit').modal('hide');
        var m = $('#modalStatus2').modal('show');
//        console.log($(this).serialize());
//        console.log(new FormData(this));
        $.post('<?= site_url($module . '/edit') ?>', $(this).serialize(), function (data) {
            console.log(data);
            window.location = window.location;
        });
    });
</script>
<?php ?>