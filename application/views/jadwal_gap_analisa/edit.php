<div class="card">
    <form method="post">
        <div class="card-body">
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Judul</label>
                <div class="col-sm-10">
                    <input class="form-control" name="judul" required="" value="<?= $data['judul'] ?>">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Ruang Lingkup</label>
                <div class="col-sm-10">
                    <input class="form-control" name="ruang_lingkup" value="<?= $data['ruang_lingkup'] ?>">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Pelaksana</label>
                <div class="col-sm-10">
                    <input class="form-control" name="pelaksana" value="<?= $data['pelaksana'] ?>">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Tim Pelaksana</label>
                <div class="col-sm-10">
                    <select class="form-control select-2" name="tim[]" multiple="">
                        <?php foreach ($personil as $k => $v) { ?>
                            <option value="<?= $v['id'] ?>"><?= $v['fullname'] ?></option>    
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Tanggal</label>
                <div class="col-sm-10">
                    <input class="form-control" type="date" name="tanggal" value="<?= $data['tanggal'] ?>">
                </div>
            </div>
        </div>
        <div class="card-footer text-right d-block">
            <a class="btn btn-outline-primary" href="<?= site_url($module) ?>">Kembali</a>
            <button class="btn btn-outline-primary" name="simpan" value="ok">Simpan</button>
        </div>
    </form>
</div>
<script>
    var data = <?= json_encode($data) ?>;
    var personil = [];
    for (var i = 0; i < data.tim_pelaksana.length; i++) {
        personil.push(data.tim_pelaksana[i].id_personil)
    }
    $('.select-2').select2();
    $('.select-2').val(personil);
    $('.select-2').trigger('change'); // Notify any J
</script>