<?php $d = $data1[0] ?>
<div class="row">
    <div class="col-sm-8">
        <div class="box">
            <div class="box-body">
                <form class="form-horizontal" method="post">
                    <input type="hidden" name="id" value="<?php echo $d['id'] ?>">
                    <div class="form-group">
                        <label for="nama" class="col-sm-2 control-label">Nama</label>
                        <div class="col-sm-10">
                            <input class="form-control" id="nama" name="nama" value="<?php echo $d['nama'] ?>" placeholder="Nama">
                        </div>
                        <?php echo form_error('nama'); ?>
                    </div>
                    <div class="form-group">
                        <label for="type" class="col-sm-2 control-label">Type</label>
                        <div class="col-sm-10">
                            <input class="form-control" id="type" value="<?php echo $d['type'] ?>" placeholder="Type" disabled="">
                        </div>
                    </div>
                    <button type="submit" name="saveData" value="ok" class="btn btn-primary pull-right">Simpan</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="box">
            <form role="form" method="post">
                <div class="box-body">
                    <input type="hidden" name="id" value="<?php echo $d['id'] ?>">
                    <?php
                    $field = array(
                            ["f" => "pass", "l" => "Password Lama"],
                            ["f" => "newPass", "l" => "Password Baru"],
                            ["f" => "confirmPass", "l" => "Konfirmasi Password"]
                    );
                    ?>
                    <?php foreach ($field as $f) { ?>
                        <div class="form-group <?php echo form_error($f['f']) != "" ? "has-error" : "" ?>">
                            <?php echo '<label for="'.$f['f'].'" class="control-label">'.$f['l'].'</label>'?>
                            <?php echo '<input type="password" class="form-control" id="' . $f['f'] . '" name="' . $f['f'] . '" placeholder="' . $f['l'] . '">' ?>
                            <span class="help-block"><?php echo form_error($f['f']); ?></span>
                        </div>
                    <?php } ?>
                </div>
                <div class="box-footer">
                    <input type="submit" name="changePass" value="Simpan" class="btn btn-primary pull-right"/>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {

    });
</script>