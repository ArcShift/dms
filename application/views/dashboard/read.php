<?php print_r($this->session->user) ?>
<div class="row">
    <div class="col-md-12">
        <img width="100%" class="rounded" align="right" src="<?php echo base_url('assets/images/dms-header.jpg') ?>" alt="no picture">
    </div>
</div>
<br/>
<div class="row">
    <?php foreach ($box as $key => $b) { ?>
        <?php if(empty($this->session->user['id_company']) | $b['company']=='Y'){ ?>
        <div class="col-md-6 col-xl-4">
            <div class="card mb-3 widget-content bg-<?= $b['color'] ?>">
                <div class="widget-content-wrapper text-white">
                    <!--                    <div>
                                            <i class="fa fa-<?php // $b['icon'] ?>"></i>&nbsp;
                                        </div>-->
                    <div class="widget-content-left">
                        <div class="widget-heading"><?= $b['title'] ?></div>
                        <div class="widget-subheading"><?= empty($b['subtitle']) ? '-' : $b['subtitle']; ?></div>
                    </div>
                    <div class="widget-content-right">
                        <div class="widget-numbers text-white"><span><?= $b['value'] ?></span></div>
                    </div>
                </div>
            </div>  
        </div>
        <?php } ?>
    <?php } ?>
</div>
<!-- Dashboard Klien: last 3 -->

