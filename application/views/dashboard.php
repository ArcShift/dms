<div class="row">
    <div class="col-md-12">
        <img width="100%" class="rounded" align="right" src="<?php echo base_url('assets/images/dms-header.jpg') ?>" alt="no picture">
    </div>
</div>
<br/>
<div class="row">
    <?php foreach ($box as $key => $b) { ?>
        <div class="col-md-6 col-xl-4">
            <div class="card mb-3 widget-content bg-<?php echo $b['color']?>">
                <div class="widget-content-wrapper text-white">
                    <div class="widget-content-left">
                        <div class="widget-heading"><?php echo $b['title']?></div>
                        <div class="widget-subheading"><?php echo empty($b['subtitle'])?'-':$b['subtitle']; ?></div>
                    </div>
                    <div class="widget-content-right">
                        <div class="widget-numbers text-white"><span><?php echo $b['value']?></span></div>
                    </div>
                </div>
            </div>  
        </div>
    <?php } ?>
</div>
<!-- Dashboard Klien: last 3 -->

