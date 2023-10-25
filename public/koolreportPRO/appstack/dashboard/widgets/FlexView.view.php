<?php
    foreach($this->items() as $item) {
        // echo get_class($item);
        echo $this->renderItem($item);
    } 
?>