<?php

use koolreport\dashboard\Client;
use \koolreport\dashboard\Lang;
use koolreport\dashboard\menu\MegaMenu;
use koolreport\dashboard\menu\MenuItem;
$page = $this->page();
$user = $page->app()->user();
$themeAssetsUrl = $this->themeAssetsUrl();
?>
<nav class="navbar navbar-expand navbar-light navbar-bg">
    <a class="sidebar-toggle">
        <i class="hamburger align-self-center"></i>
    </a>
    <ul class="navbar-nav">
        <?php 
        foreach($this->topMenu() as $item) {
            if($item instanceof MenuItem) {
                echo '<li class="nav-item px-2">';
                $this->innerView("menu/MenuItem",["item"=>$item,"aCssClass"=>"nav-link"]);
                echo '</li>';
            } else if ($item instanceof MegaMenu) {
                $this->innerView("menu/MegaMenu",["menu"=>$item]);
            }
        }
        ?>
    </ul>
    <div class="navbar-collapse collapse">
        <ul class="navbar-nav navbar-align">
            <?php if(count(Lang::instance()->allLanguages())>0):?>
                <?php 
                    $language = Lang::instance()->language();
                ?>
                <li class="nav-item dropdown">
                    <a title="<?php echo $language->title(); ?>" class="nav-flag dropdown-toggle" href="javascript:void 0" id="languageDropdown" data-toggle="dropdown">
                        <img src="<?php echo $themeAssetsUrl; ?>/flags/<?php echo $language->flag(); ?>" alt="<?php echo $language->title(); ?>">
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="languageDropdown">
                        <?php foreach(Lang::instance()->allLanguages() as $language):?>
                        <a class="dropdown-item" href="javascript:void 0" onclick="<?php echo ($language->name()!=Lang::name())?Client::exec(Client::app()->changeLanguage($language->name())):""; ?>">
                            <img src="<?php echo $themeAssetsUrl; ?>/flags/<?php echo $language->flag(); ?>" width="20" class="align-middle mr-1" />
                            <span class="align-middle <?php echo ($language->name()==Lang::name())?"text-success":""; ?>"><?php echo $language->title(); ?></span>
                        </a>
                        <?php endforeach ?>
                    </div>
                </li>
            <?php endif ?>
            <?php if($user!==null): ?>
                <li class="nav-item dropdown">

                    <a class="nav-icon dropdown-toggle d-inline-block d-sm-none" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                        <?php if($user->avatar()!==null): ?>
                            <img src="<?php echo $user->_avatar(); ?>" class="avatar img-fluid rounded-circle mr-1" alt="<?php echo $user->_name(); ?>" />
                        <?php else: ?>
                            <span class="text-dark"><?php echo $user->_name(); ?></span>
                        <?php endif?>
                    </a>
                    <a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-toggle="dropdown">
                        <?php if($user->avatar()!==null): ?>
                            <img src="<?php echo $user->_avatar(); ?>" class="avatar img-fluid rounded-circle mr-1" alt="<?php echo $user->_name(); ?>" />
                        <?php endif ?>
                        <span class="text-dark"><?php echo $user->_name(); ?></span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right">

                        <?php if(count($this->accountMenu())>0): ?>
                            <?php foreach($this->accountMenu() as $item): ?>
                                <?php $this->innerView("menu/MenuItem",["item"=>$item,"aCssClass"=>"dropdown-item"]); ?>
                            <?php endforeach ?>
                        <?php else: ?>
                            <a onClick="logout()" class="dropdown-item" href="javascript: void 0"><i class="fa fa-lock"></i> <?php Lang::echo("Logout"); ?></a>
                        <?php endif ?>
                    </div>
                </li>
            <?php endif ?>
        </ul>
    </div>
</nav>