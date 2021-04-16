<div class="card">
    <form method="post">
        <div class="card-body">
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Judul</label>
                <div class="col-sm-10">
                    <input class="form-control" name="judul" required="">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Ruang Lingkup</label>
                <div class="col-sm-10">
                    <input class="form-control" name="ruang_lingkup">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Pelaksana</label>
                <div class="col-sm-10">
                    <input class="form-control" name="pelaksana">
                </div>
            </div>
<!--            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Tim Pelaksana</label>
                <div class="col-sm-10">
                    <input class="form-control" name="">
                </div>
            </div>-->
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Tanggal</label>
                <div class="col-sm-10">
                    <input class="form-control" type="date" name="tanggal">
                </div>
            </div>
        </div>
        <div class="card-footer text-right d-block">
            <a class="btn btn-outline-primary" href="<?= site_url($module) ?>">Kembali</a>
            <button class="btn btn-outline-primary" name="simpan" value="ok">Simpan</button>
        </div>
    </form>
</div>