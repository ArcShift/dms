<div class="main-card mb-3 card">
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>Pasal</th>
                    <th>Alasan</th>
                    <th class="text-center">Status</th>
                </tr>
            </thead>
            <tbody id="table">
                <?php foreach ($data as $k => $d) { ?>
                    <tr>
                        <td><?= $d['name'] ?></td>
                        <td><?php echo $d['desc'] ?></td>
                        <td class="text-center"><i class="btn btn-outline-<?= $d['status'] == 'DISABLE' ? 'danger' : 'success' ?> fa fa-check-square" onclick="edit(<?= $k ?>)")></i></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<!--MODAL EDIT-->
<div class="modal fade" id="modalEdit">
    <form method="post">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Akses</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Pasal</label>
                        <input class="form-control input-pasal" disabled="">
                        <input class="form-control input-id-pasal" name="pasal" hidden="">
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <select class="form-control select-status" name="status">
                            <option value="ENABLE">Berlaku</option>
                            <option value="DISABLE">Tidak Berlaku</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Alasan</label>
                        <textarea class="form-control" name="desc"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-outline-danger" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-outline-primary btn-submit group-edit" name="submit">Simpan</button>
                </div>
            </div>
        </div>
    </form>
</div>
<script>
    var pasal = <?= json_encode($data) ?>;
    var perusahaan =<?= json_encode($this->session->activeCompany) ?>;
    function afterReady() {}
    function edit(index) {
        var m = $('#modalEdit');
        m.modal('show');
        m.find('.input-id-pasal').val(pasal[index].id);
        m.find('.input-pasal').val(pasal[index].name);
        m.find('.select-status').val(pasal[index].status == 'DISABLE' ? 'DISABLE' : 'ENABLE');
        m.find('.input-persentase').val(pasal[index].persentase == null ? 0 : pasal[index].persentase);
    }
</script>