<?php
//print_r($mod);
//print_r($this->input->post());
//print_r($access);
$crud = array('read', 'create', 'update', 'delete');
$icon = array('search', 'plus', 'edit', 'trash');
?>
<form method="post" name="f">
    <input name="set" value="ok" hidden="">
    <div class="panel panel-default">
        <div class="panel-heading table-responsive">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Module</th>
                            <?php foreach ($userRole as $u) { ?>
                                <th><?php echo $u['title'] ?></th>
                            <?php } ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($mod as $mkey => $m) { ?>
                            <tr>
                                <td><?php echo $m['title'] ?></td>
                                <?php foreach ($userRole as $ukey => $u) { ?>
                                    <td>
                                        <?php foreach ($crud as $ckey => $c) { ?>
                                            <?php
                                            $btn = isset($access[$mkey][$ukey]['acc_' . $c]) ? 'primary' : 'danger';
                                            $val = isset($access[$mkey][$ukey]['acc_' . $c]) ? '0' : '1';
                                            ?>
                                            <button class="btn btn-sm btn-outline-<?php echo $btn . ' fa fa-' . $icon[$ckey] ?>" title="<?php echo (isset($access[$mkey][$ukey]['acc_' . $c]) ? 'Disable ' : 'Enable ') . ucfirst($c) ?>" name="<?php echo $c ?>" value="<?php echo $m['id'] . '_' . $u['id'] . '_' . $val ?>"></button>
                                        <?php } ?>
                                    </td>
                                <?php } ?>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</form>
