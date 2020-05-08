<div class="main-card mb-3 card">
    <form method="post">
        <!--<div class="card-header"></div>-->
        <div class="card-body">
            <table class="table table-borderless table-striped table-hover data-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Perusahaan</th>
                        <th>Kota / Kab</th>
                        <th>Standar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data as $k => $r) { ?>
                        <tr>
                            <td><?php echo $k + 1 ?></td>
                            <td>
                                <div class="widget-content p-0">
                                    <div class="widget-content-wrapper">
                                        <div class="widget-content-left mr-3">
                                            <div class="widget-content-left">
                                                <img width="40" class="rounded-circle" src="<?php echo empty($r['photo'])?'https://upload.wikimedia.org/wikipedia/commons/thumb/1/12/User_icon_2.svg/220px-User_icon_2.svg.png': base_url('upload/profile_photo/'.$r['photo']);?>" alt="">
                                            </div>
                                        </div>
                                        <div class="widget-content-left flex2">
                                            <div class="widget-heading"><?php echo $r['name'] ?></div>
                                            <div class="widget-subheading opacity-7"><?php echo empty($r['fullname'])?'-': $r['fullname'] ?></div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <?php echo $r['city'] ?>
                            </td>
                            <td>
                                <div class="badge badge-info"><?php echo $r['count'] ?></div>
                            </td>
                            <td>
                                <?php if ($activeModule['acc_update']) { ?>
                                    <button class="btn btn-primary fa fa-edit" title="Edit" name="initEdit" value="<?php echo $r['id'] ?>" formaction="<?php echo site_url($module . '/edit') ?>"></button>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </form>
</div>