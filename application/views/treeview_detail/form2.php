<!--<pre>    <?php // print_r($member)  ?></pre>-->
<div class="modal-header">
    <h4 class="modal-title">Form 2: <span class="item-name"></span></h4>
    <button class="close" type="button" aria-label="Close" onclick="closeForm()">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <div class="form-group">
        <label>Catatan</label>
        <input class="form-control" name="keterangan">
    </div>
    <div class="form-group">
        <label>Anggota</label>
        <br/>
        <select class="form-control" multiple="multiple" id="anggota" name="anggota">
            <?php foreach ($member as $k => $m) { ?>
                <option value="<?php echo $m['id'] ?>"><?php echo $m['username'] ?></option>
            <?php } ?>
            <!--<option selected="selected">purple</option>-->
        </select>
    </div>
    <div class="form-group">
        <label>Dokumen & form terisi</label>
        <input class="form-control" name="doc" type="file">
    </div>
    <div class="form-group">
        <label>Jadwal</label>
        <input class="form-control" name="jadwal">
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
