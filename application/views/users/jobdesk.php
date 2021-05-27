<div class="card">
    <div class="card-header">
        <div class="col-sm-9"></div>
        <div class="col-sm-3">
            <select class="form-control" id="selectUK">
                <?php foreach ($unit_kerja as $k => $uk) { ?>
                    <option value="<?= $uk->id ?>"><?= $uk->name ?></option>
                <?php } ?>
            </select>
        </div>
    </div>
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>Tugas Unit</th>
                    <th>Tugas Personil</th>
                </tr>
            </thead>
            <tbody id="tbMain">

            </tbody>
        </table>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('#selectUK').change();
    })
    $('#selectUK').change(function () {
        $.getJSON('jobdesk/get_data', {id: $(this).val()}, function (data) {
            $('#tbMain').empty();
            var title = 0;
            var write = false;
            for (var d of data) {
                console.log(title);
                console.log(d.id_jobdesk);
                if (title != d.id_jobdesk) {
                    title = d.id_jobdesk;
                    write = true;
                }
                $('#tbMain').append('<tr>'
                        + '<td>' + (write ? d.jobdesk_unit : '') + '</td>'
                        + '<td>' + (d.jobdesk_personil == null ? '-' : d.jobdesk_personil) + '</td>'
                        + '</tr>');
            }
        });
    });
</script>