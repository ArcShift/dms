<?php
$tabs = array(
    array('title' => 'Pemenuhan', 'url' => ''),
    array('title' => 'Pasal', 'url' => 'pasal'),
    array('title' => 'Jadwal', 'url' => 'schedule'),
    array('title' => 'Penerapan', 'url' => 'implementation'),
);
?>
<div class="main-card mb-3 card">
    <div class="card-body">
        <ul class="nav nav-tabs">
            <?php foreach ($tabs as $t) { ?>
                <li class="nav-item"><a href="<?php echo site_url($module . '/' . $t['url']) ?>" class="nav-link <?php echo $this->uri->segment(2)==$t['url']?'active':''?>"><?php echo $t['title'] ?></a></li>
            <?php } ?>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="tab-eg10-0" role="tabpanel">
                <?php $this->load->view($module.'/'.$tab)?>
            </div>
        </div>
    </div>
</div>
