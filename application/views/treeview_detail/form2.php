<div class="modal-header">
    <h4 class="modal-title">Form 2: <?php echo $data['name'] ?><span class="item-name"></span></h4>
    <button class="close" type="button" aria-label="Close" onclick="closeForm()">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <input class="d-none" name="perusahaan" value="<?php echo $this->input->post('idPerusahaan') ?>">
    <input class="d-none" name="pasal" value="<?php echo $this->input->post('idPasal') ?>">
    <input class="d-none" name="standar" value="<?php echo $data['id_standard'] ?>">
    <div class="form-group">
        <label>Catatan</label>
        <input class="form-control" name="catatan" value="<?php echo $data['note'] ?>">
    </div>
    <div class="form-group">
        <label>Anggota</label>
        <br/>
        <select class="form-control" multiple="multiple" id="anggota" name="anggota[]">
            <?php foreach ($member as $k => $m) { ?>
            <option value="<?php echo $m['id'] ?>" <?php echo empty($m['member'])?'':'selected'?>><?php echo $m['username'] ?></option>
            <?php } ?>
        </select>
    </div>
    <div class="form-group">
        <label>Dokumen & form terisi</label>
        <input id="fileupload" type="file" name="doc[]" data-url="server/php/" multiple>
        <div id="progress">
            <div class="bar" style="width: 0%;"></div>
        </div>
    </div>
    <div class="form-group">
        <label>Jadwal</label>
        <input class="form-control" name="jadwal" type="date" value="<?php echo $data['jadwal'] ?>">
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-transition btn-outline-warning" onclick="closeForm()">Batal</button>
    <button type="submit" class="btn btn-transition btn-outline-info">Simpan</button>
</div>
<script>
    $(document).ready(function () {
        $('#anggota').select2();
    });
</script>
