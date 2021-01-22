<?php
$company = $this->db->get('company')->result_array();
?>
<div class="main-card mb-3 card">   
    <div class="card-body">
        <div class="row">
            <div class="col-sm-6"></div>
            <div class="col-sm-3">
                <select class="form-control" id="selectCompany">
                    <option>~ Pilih Perusahaan ~</option>
                    <?php foreach ($company as $k => $c) { ?>
                        <option value="<?= $c['id'] ?>"><?= $c['name'] ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-sm-3">
                <select class="form-control" id="selectStandar">
                    <option>~ Pilih Standar ~</option>
                </select>
            </div>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>Pasal Induk</th>
                    <th  class="text-center">Harapan (%)</th>
                    <th  class="text-center" style="width: 100px">Aksi</th>
                </tr>
            </thead>
            <tbody id="table"></tbody>
        </table>
    </div>
</div>
<!--MODAL EDIT-->
<div class="modal fade" id="modalEdit">
    <form id="formEdit">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Harapan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Perusahaan</label>
                        <input class="form-control input-company" disabled="">
                        <input class="form-control input-id-company" name="id-company" hidden="">
                    </div>
                    <div class="form-group">
                        <label>Pasal</label>
                        <input class="form-control input-pasal" disabled="">
                        <input class="form-control input-id-pasal" name="id-pasal" hidden="">
                    </div>
                    <div class="form-group">
                        <label>Persentase</label>
                        <input class="form-control input-persentase" name="persentase" type="number" max="100" min="0" required="">                            
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary btn-submit group-edit" name="submit">Simpan</button>
                </div>
            </div>
        </div>
    </form>
</div>
<script>
    var pasal;
    var idPerusahaan;
    var perusahaan;
    function afterReady() {}
    $('#selectCompany').change(function () {
        idPerusahaan = $(this).val();
        perusahaan = $(this).find('option:selected').text();
        $.getJSON('<?= site_url($module . '/standard') ?>', {company: $(this).val()}, function (data) {
            $('#selectStandar').empty();
            $('#selectStandar').append('<option>~ pilih standar ~</option>');
            for (var i = 0; i < data.length; i++) {
                $('#selectStandar').append('<option value="' + data[i].id + '">' + data[i].name + '</option>');
            }
            $('#selectStandar').change();
        });
    });
    $('#selectStandar').change(function () {
        $('#table').empty();
        $.getJSON('<?= site_url($module . '/pasal') ?>', {
            company: $('#selectCompany').val(),
            standard: $(this).val()
        }, function (data) {
            pasal = data;
            for (var i = 0; i < data.length; i++) {
                var d = data[i];
                $('#table').append('<tr>'
                        + '<td>' + d.name + '</td>'
                        + '<td class="text-center">' + (d.persentase==null?'70':d.persentase) + '</td>'
                        + '<td class="text-center"><i class="text-primary fa fa-edit" onclick="edit(' + i + ')")></i></td>'
                        + '</tr>');
            }
        });
    });
    function edit(index) {
        var m = $('#modalEdit');
        m.modal('show');
        m.find('.input-id-company').val(idPerusahaan);
        m.find('.input-company').val(perusahaan);
        m.find('.input-id-pasal').val(pasal[index].id);
        m.find('.input-pasal').val(pasal[index].name);
        m.find('.input-persentase').val(pasal[index].persentase == null ? 0 : pasal[index].persentase);
    }
    $('#formEdit').submit(function (e) {
        e.preventDefault();
        $('#modalEdit').modal('hide');
        $.post('<?= site_url($module . '/edit') ?>', $(this).serialize(), function (data) {
            $('#selectStandar').change();
        });
    });
</script>