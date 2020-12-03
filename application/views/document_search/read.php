<style>
    .select-parent{
        background-color: lightgray;
    }
</style>
<div class="row">
    <div class="col-sm-3">
        <div class="main-card card">
            <form id="form-search">
                <div class="card-body">
                    <div class="form-group">
                        <label>Standar</label>
                        <select class="form-control" name="standar" id="selectStandar">
                            <option value="">-- -- --</option>
                            <?php foreach ($standar as $s) { ?>
                                <option value="<?= $s['id'] ?>" <?= $this->input->get('standar') == $s['id'] ? 'selected' : '' ?>><?= $s['name'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Pasal</label>
                        <select id="select-pasal" class="form-control" name="pasal">
                            <option value="">-- -- --</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Perusahaan</label>
                        <select class="form-control" name="perusahaan" id="selectPerusahaan">
                            <option value="">-- -- --</option>
                            <?php foreach ($perusahaan as $p) { ?>
                                <option value="<?= $p['id'] ?>" <?= $this->input->get('perusahaan') == $p['id'] ? 'selected' : '' ?>><?= $p['name'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Pembuat Dokumen</label>
                        <select class="form-control select-ukp" name="creator"></select>
                    </div>
                    <div class="form-group">
                        <label>Penerima Dokumen</label>
                        <select class="form-control select-ukp" name="penerima"></select>
                    </div>
                    <div class="form-group">
                        <label>Judul Dokumen</label>
                        <input class="form-control" name="judul" value="<?php echo $this->input->get('judul') ?>">
                    </div>
                    <div class="form-group">
                        <label>Nomor Dokumen</label>
                        <input class="form-control" name="nomor" value="<?php echo $this->input->get('nomor') ?>">
                    </div>
                    <div class="form-group">
                        <label>Jenis Dokumen</label>
                        <select class="form-control" name="level">
                            <option value="">-- -- --</option>
                            <option value="1">Level I</option>
                            <option value="2">Level II</option>
                            <option value="3">Level III</option>
                            <option value="4">Level IV</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Klasifikasi Dokumen</label>
                        <select class="form-control" name="klasifikasi">
                            <option value="">-- -- --</option>
                            <option value="UMUM">Umum</option>
                            <option value="INTERNAL">Internal</option>
                            <option value="RAHASIA">Rahasia</option>
                            <option value="SANGAT RAHASIA">Sangat Rahasia</option>
                        </select>
                    </div>
                </div>
                <div class="card-footer ">
                    <button class="btn btn-outline-primary btn-sm fa fa-search" type="submit"> Cari</button>
                </div>
            </form>
        </div>
    </div>
    <div class="col-sm-9">
        <div class="main-card mb-3 card">
            <div class="card-body">
                <form method="post">
                    <table class="table data-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Judul</th>
                                <th>Creator</th>
                                <th class="text-center <?= $this->input->get('distribusi') | $this->input->get('unit_kerja_distribusi') ? 'd-none' : '' ?>">Distribusi</th>
                                <th>*</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data as $k => $r) { ?>
                                <tr>
                                    <td><?php echo $k + 1 ?></td>
                                    <td><?php echo $r['judul'] ?></td>
                                    <td><?php echo $r['fullname'] ?></td>
                                    <td class="text-center <?= $this->input->get('distribusi') | $this->input->get('unit_kerja_distribusi') ? 'd-none' : '' ?>"><div class="badge badge-<?= $r['distribusi'] == 0 ? 'danger' : 'success' ?>"><?= $r['distribusi'] ?></div></td>
                                    <td>
                                        <a class="btn btn-outline-primary btn-sm fa fa-search" href="<?= site_url('document_search/detail/' . $r['id']) ?>" title="Lihat Detail" name="detail"></a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
        <div class="d-none" id="list-pasal"></div>
    </div>
</div>
<script>
    function afterReady() {
        $('.dataTables_filter').addClass('d-none');
        $('#selectPerusahaan').change();
        $('#selectStandar').change();
        $('select[name=level]').val('<?= $this->input->get('level') ?>');
        $('select[name=klasifikasi]').val('<?= $this->input->get('klasifikasi') ?>');
    }
    $('.active-change').change(function () {
        $('#form-search').submit();
    });
    $('#selectPerusahaan').change(function () {
        $.getJSON('<?php echo site_url($module); ?>/company', {'id': $(this).val()}, function (data) {
            $('.select-ukp').empty();
            $('.select-ukp').append('<option value="">-- -- --</option>');
            for (var d of data) {
                if (d.type == 'uk') {
                    $('.select-ukp').append('<option class="select-parent"  value="' + d.type + '_' + d.id + '"><b>' + d.name.toUpperCase() + '</b></option>');
                } else {
                    $('.select-ukp').append('<option value="' + d.type + '_' + d.id + '">' + d.name + '</option>');
                }
            }
            $('select[name=creator]').val('<?= $this->input->get('creator') ?>');
            $('select[name=penerima]').val('<?= $this->input->get('penerima') ?>');
        });
    });
    $('#selectStandar').change(function () {
        $.getJSON('<?php echo site_url($module); ?>/get_pasal', {'id': $(this).val()}, function (data) {
            $('#list-pasal').empty();
            $('#select-pasal').empty();
            $('#select-pasal').append('<option value="">-- -- --</option>');
            if (data.length != 0) {
                for (var i = 0; i < data.length; i++) {
                    var p = data[i];
                    $('#list-pasal').append('<div id="pasal' + p.id + '"><b><span class="pasal-id">' + p.id + '</span><span class="pasal-name">' + p.name + '</span></b></div>');
                    if (p.parent != null) {
                        var item = $('#pasal' + p.id + ' .pasal-name');
                        var fullname = $('#pasal' + p.parent + ' .pasal-name').text() + ' - ' + item.text();
                        item.text(fullname);
                        data[i].fullname = fullname;
                    } else {
                        data[i].fullname = p.name;
                    }
                }
                $('#list-pasal').find('b').each(function (index) {
                    $('#select-pasal').append('<option value="' + $(this).find('.pasal-id').text() + '">' + $(this).find('.pasal-name').text() + '</option');
                });
            }
            $('#select-pasal').val(<?= $this->input->get('pasal') ?>);
        });
    });
</script>