<div class="main-card mb-3 card">
    <form method="post">
        <div class="modal-header">
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label>Perusahaan</label>
                <select class="form-control" name="perusahaan" required="">
                    <option value="">-- Perusahaan --</option>
                    <?php foreach ($company as $c) { ?>
                        <option value="<?php echo $c['id'] ?>" <?php echo $c['id'] == $this->input->post('role') ? 'selected' : ''; ?>><?php echo $c['name'] ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label>Nama</label>
                <input class="form-control" name="nama" required="" placeholder="Nama">
            </div>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label>Jenis</label>
                <select class="form-control" name="jenis" required="">
                    <option value="">-- Jenis --</option>
                    <option value="PEMBUAT">Pembuat Dokumen</option>
                    <option value="PENERIMA">Penerima Dokumen</option>
                </select>
            </div>
        </div>
        <div class="modal-footer">
            <a class="btn btn-primary" href="<?php echo site_url($module) ?>">Batal</a>
            <button class="btn btn-primary" name="buat" value="ok">Tambah</button>
        </div>
    </form>
</div>