<?php
    if (\Bootstrap::verifySession() !== true) {
        return;
    }
?>
<nav id="accordion">
    <h3><a id="header_index" href="/<?= Bootstrap::getBasePath() ?>index.php?show=index">
            <?= App\Lang::getString(Bootstrap::getLang(), 'MENU_START') ?>
        </a></h3>
    <div>
        <p>
            <?= sprintf(App\Lang::getString(Bootstrap::getLang(), 'MENU_EDIT_PAGE'), 'index.html') ?>
        </p>
    </div>
    <h3><a id="header_company" href="/<?= Bootstrap::getBasePath() ?>index.php?show=company">
            <?= App\Lang::getString(Bootstrap::getLang(), 'MENU_COMPANY') ?>
    </a></h3>
    <div>
        <p>
            <?= sprintf(App\Lang::getString(Bootstrap::getLang(), 'MENU_EDIT_PAGE'), 'unternehmen.html') ?>
        </p>
    </div>
    <h3><a id="header_objects" href="/<?= Bootstrap::getBasePath() ?>index.php?show=objects">
            <?= App\Lang::getString(Bootstrap::getLang(), 'MENU_OBJECTS') ?>
    </a></h3>
    <div>
        <p>
            <?= sprintf(App\Lang::getString(Bootstrap::getLang(), 'MENU_EDIT_PAGE'), 'objekte.html') ?>
        </p>
    </div>
    <h3><a id="header_projects" href="/<?= Bootstrap::getBasePath() ?>index.php?show=projects">
            <?= App\Lang::getString(Bootstrap::getLang(), 'MENU_PROJECTS') ?>
    </a></h3>
    <div>
        <p>
            <?= sprintf(App\Lang::getString(Bootstrap::getLang(), 'MENU_EDIT_PAGE'), 'projekte.html') ?>
        </p>
    </div>
    <h3><a id="header_jobs" href="/<?= Bootstrap::getBasePath() ?>index.php?show=jobs">
            <?= App\Lang::getString(Bootstrap::getLang(), 'MENU_JOBS') ?>
    </a></h3>
    <div>
        <p>
            <?= sprintf(App\Lang::getString(Bootstrap::getLang(), 'MENU_EDIT_PAGE'), 'karriere.html') ?>
        </p>
    </div>
    <h3><a id="header_contact" href="/<?= Bootstrap::getBasePath() ?>index.php?show=contact">
            <?= App\Lang::getString(Bootstrap::getLang(), 'MENU_CONTACT') ?>
    </a></h3>
    <div>
        <p>
            <?= sprintf(App\Lang::getString(Bootstrap::getLang(), 'MENU_EDIT_PAGE'), 'kontakt.html') ?>
        </p>
    </div>


    <h3><a id="header_imprint" href="/<?= Bootstrap::getBasePath() ?>index.php?show=imprint">
            <?= App\Lang::getString(Bootstrap::getLang(), 'MENU_IMPRINT') ?>
    </a></h3>
    <div>
        <p>
            <?= sprintf(App\Lang::getString(Bootstrap::getLang(), 'MENU_EDIT_PAGE'), 'impressum.html') ?>
        </p>
    </div>
    <h3><a id="header_siteinfo" href="/<?= Bootstrap::getBasePath() ?>index.php?show=siteinfo">
            <?= App\Lang::getString(Bootstrap::getLang(), 'MENU_SITEINFO') ?>
    </a></h3>
    <div>
        <p>
            <?= App\Lang::getString(Bootstrap::getLang(), 'MENU_EDIT_SITEINFO') ?>
        </p>
    </div>
</nav>

<p>
    <a href="/<?= Bootstrap::getBasePath() ?>index.php?show=index&lang=<?= Bootstrap::getLang()== 'DE' ? 'en' : 'de' ?>">
        <?= Bootstrap::getLang()== 'DE' ? 'English Pages' : 'Deutsche Seiten' ?>
    </a>
</p>

<form action="/<?= Bootstrap::getBasePath() ?>index.php?show=login&do=logout" method="post">
    <input type="submit" value="Logout" id="form-logout-submit" name="form-logout-submit" class="ym-button">
</form>
