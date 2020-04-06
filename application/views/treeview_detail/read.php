<?php ?>
<div class="main-card mb-3 card">
    <div class="card-body">
        <div class="form-group">
            <label>Perusahaan</label>
            <select id="perusahaan" class="form-control" name="perusahaan" required="">
                <option value="">-- Perusahaan --</option>
                <?php foreach ($company as $c) { ?>
                    <option value="<?php echo $c['id'] ?>" <?php echo $c['id'] == $this->input->post('role') ? 'selected' : ''; ?>><?php echo $c['name'] ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="form-group">
            <label>Standar</label>
            <select id="standar" class="form-control" name="perusahaan" required=""></select>
        </div>
        <!--TAB-->
        <div class="main-card mb-3 card">
            <div class="card-body">
                <ul class="nav nav-tabs">
                    <li class="nav-item"><a data-toggle="tab" href="#tab-eg10-0" class="active nav-link">Pemenuhan</a></li>
                    <li class="nav-item"><a data-toggle="tab" href="#tab-eg10-1" class="nav-link">Pasal</a></li>
                    <li class="nav-item"><a data-toggle="tab" href="#tab-eg10-2" class="nav-link">Jadwal</a></li>
                    <li class="nav-item"><a data-toggle="tab" href="#tab-eg10-3" class="nav-link">Penerapan</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab-eg10-0" role="tabpanel">
                        <ul class="list-group">
                            <?php for ($i = 0; $i < 10; $i++) { ?>
                                <?php $r = rand(0, 100) ?>
                                <li class="list-group-item">
                                    <div class="row">    
                                        <div class="col-sm-5">
                                            Pasal
                                        </div>   
                                        <div class="col-sm-7">
                                            <div class="progress">
                                                <div class="progress-bar bg-success" role="progressbar" aria-valuenow="<?php echo $r ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $r ?>%;"><?php echo $r ?>%</div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                    <div class="tab-pane" id="tab-eg10-1" role="tabpanel">
                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,
                            when an unknown printer took a
                            galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. </p>
                    </div>
                    <div class="tab-pane" id="tab-eg10-2" role="tabpanel">
                        <p>Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a
                            type specimen book. It has
                            survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. </p>
                    </div>
                    <div class="tab-pane" id="tab-eg10-3" role="tabpanel">
                        <p>Penerapan</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $('#perusahaan').change(function (s) {
        $.post('<?php echo site_url($module); ?>/standard', {'id': $(this).val()}, function (data) {
            var d = JSON.parse(data);
            $('#standar').html('');
            $('#standar').append('<option value="">-- Standar --</option>');
            for (var i = 0; i < d.length; i++) {
                $('#standar').append('<option value="' + d[i].id + '">' + d[i].name + '</option>');
                console.log(d[i]);
            }
        });
    });
</script>
