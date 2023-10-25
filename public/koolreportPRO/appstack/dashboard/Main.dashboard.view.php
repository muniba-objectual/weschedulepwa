<li class="sidebar-item<?php echo $dashboard->_hidden()===true?" d-none":"";?>">
    <a data-path="<?php echo htmlspecialchars(json_encode($path)); ?>" class="sidebar-link" onClick="navMove(this)" href="javascript:void 0" data-name="App/<?php echo $dashboard->page()->name(); ?>/<?php echo $dashboard->name(); ?>">
        <i class="<?php echo $dashboard->_icon(); ?>"></i><?php echo $dashboard->_title(); ?>
        <?php
            $badge = $dashboard->_badge();
            if($badge!==null) {
                if(!is_array($badge)) {
                    $badge = [$badge,"danger"];
                }
                echo "<span class='badge badge-$badge[1]'>$badge[0]</span>";
            }
        ?>
    </a>
</li>