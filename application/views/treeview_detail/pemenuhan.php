<ul class="list-group">
    <?php for ($i = 0; $i < 10; $i++) { ?>
    <?php $r= rand(0,100)?>
        <li class="list-group-item">
            <div class="row">    
                <div class="col-sm-5">
                    Pasal
                </div>   
                <div class="col-sm-7">
                    <div class="progress">
                        <div class="progress-bar bg-success" role="progressbar" aria-valuenow="<?php echo $r?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $r?>%;"><?php echo $r?>%</div>
                    </div>
                </div>
            </div>
        </li>
    <?php } ?>
</ul>
