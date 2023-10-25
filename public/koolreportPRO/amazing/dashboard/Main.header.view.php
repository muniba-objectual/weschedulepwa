<?php

use koolreport\dashboard\Client;
use \koolreport\dashboard\Lang;
use koolreport\dashboard\menu\MegaMenu;
use koolreport\dashboard\menu\MenuItem;

$page = $this->page();
$user = $page->app()->user();
$themeAssetsUrl = $this->themeAssetsUrl();
?>
<header class="app-header navbar">
    <button class="navbar-toggler mobile-sidebar-toggler d-lg-none" type="button">
    <span class="navbar-toggler-icon"></span>
    </button>
    <a onClick="loadDashboard('<?php echo $page->getDefaultDashboard()?$page->getDefaultDashboard()->name():null; ?>')" href="javascript: void 0" class="navbar-brand text-center" style="color:#fff;background-image:none;padding-top:10px" href="#">
        <?php echo $page->app()->logo(); ?>
    </a>
    <button class="navbar-toggler sidebar-toggler d-md-down-none" type="button">
        <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="nav navbar-nav d-md-down-none mr-auto">
        <?php 
        foreach($this->topMenu() as $item) {
            if($item instanceof MenuItem) {
                echo '<li class="nav-item px-3">';
                $this->innerView("menu/MenuItem",["item"=>$item,"aCssClass"=>"nav-link"]);
                echo '</li>';
            } else if ($item instanceof MegaMenu) {
                $this->innerView("menu/MegaMenu",["menu"=>$item]);
            }
        }
        ?>
    </ul>
    <ul class="nav navbar-nav ml-auto">
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
                        <span class="align-middle <?php echo ($language->name()==Lang::name())?"text-secondary":""; ?>"><?php echo $language->title(); ?></span>
                    </a>
                    <?php endforeach ?>
                </div>
            </li>
        <?php endif ?>
        <?php if($user!==null): ?>
            <li style="padding-right:1rem;" class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    <?php if($user->avatar()!==null): ?>
                        <img alt="<?php echo $user->_name(); ?>" src="<?php echo $user->_avatar(); ?>" class="img-avatar">
                    <?php else: ?>
                        <span><?php echo $user->_name(); ?></span>
                    <?php endif ?>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <div class="dropdown-header" style="padding-left:0.8rem">
                        <?php Lang::echo("Welcome") ?>, <strong><?php echo $user->_name(); ?></strong>!
                    </div>
                    <?php if(count($this->accountMenu())>0): ?>
                        <?php foreach($this->accountMenu() as $item): ?>
                            <?php $this->innerView("menu/MenuItem",["item"=>$item,"aCssClass"=>"dropdown-item"]); ?>
                        <?php endforeach ?>
                    <?php else: ?>
                        <a onClick="logout()" class="dropdown-item" href="javascript: void 0"><i class="fa fa-lock"></i> <?php Lang::echo("Logout"); ?></a>
                    <?php endif ?>
                </div>
            </li>
        <?php endif; ?>
    </ul>
</header>