<?php
use koolreport\dashboard\menu\Group;
?>
<li class="nav-item px-2 dropdown">
    <a class="nav-link dropdown-toggle" href="#" id="servicesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <?php echo $menu->_title(); ?>
    </a>
	<div class="dropdown-menu dropdown-menu-left dropdown-mega" aria-labelledby="servicesDropdown">
        <div class="d-md-flex align-items-start justify-content-start">
            <?php foreach($menu->getSubItems() as $group): ?>
                <?php if ($group instanceof Group): ?>
                    <div class="dropdown-mega-list">
                        <div class="dropdown-header"><?php echo $group->_title(); ?></div>
                        <?php foreach($group->getSubItems() as $item): ?>
                            <?php $this->innerView("menu/MenuItem",["item"=>$item,"aCssClass"=>"dropdown-item"]); ?>
                        <?php endforeach ?>
                    </div>
                <?php endif ?>
            <?php endforeach ?>
        </div>
    </div>
</li>