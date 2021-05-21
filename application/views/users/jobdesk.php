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
                    <th>Jobdesk</th>
                    <th>Jobdesk Saya</th>
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
            for (var d of data) {
                $('#tbMain').append('<tr>'
                        + '<td>' + d.jobdesk_unit + '</td>'
                        + '<td>' + (d.jobdesk_personil==null?'-':d.jobdesk_personil) + '</td>'
                        + '</tr>');
            }
        });
    });
</script>