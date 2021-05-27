<div class="main-card mb-3 card">
    <form method="post">
        <div class="card-body">
            <div class="form-group" <?= $role == 'admin' ? '' : 'hidden' ?>>
                <label>Perusahaan</label>
                <select class="form-control" name="perusahaan" required="">
                    <?php if ($this->session->userdata('user')['role'] == 'admin') { ?>
                        <option value="">-- Perusahaan --</option>
                    <?php } ?>
                    <?php foreach ($company as $c) { ?>
                        <option value="<?php echo $c['id'] ?>" <?php echo $c['id'] == $this->input->post('role') ? 'selected' : ''; ?>><?php echo $c['name'] ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label>Nama</label>
                <input class="form-control" name="nama" required="" placeholder="Nama">
            </div>
        </div>
        <div class="d-block text-right card-footer">
            <a class="btn btn-outline-primary" href="<?php echo site_url($module) ?>">Kembali</a>
            <button class="btn btn-outline-primary" name="buat" value="ok">Simpan</button>
        </div>
    </form>
</div>
<div class="main-card mb-3 card">
    <div class="card-body">
        <span class="btn btn-outline-primary pull-right" onclick="add()">Tambah</span>
        <h5>Tugas Unit</h5>
        <br>
        <table class="table">
            <thead>
                <tr>
                    <th class="col-sm-2">No</th>
                    <th class="col-sm-8">Nama</th>
                    <th class="col-sm-2">Aksi</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
<script>
    function add() {
       var m = $('#modalNotif');
       m.modal('show');
       m.find('.modal-message').html('Simpan nama unit kerja terlebih dahulu');
    }
</script>