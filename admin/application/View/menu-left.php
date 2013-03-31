<?php
    if (\Bootstrap::verifySession() !== true) {
        return;
    }
?>
<nav id="accordion">
    <h3><a id="header_index" href="/<?= Bootstrap::getBasePath() ?>index.php?show=index">Startseite</a></h3>
    <div>
        <p>
            Die Seite index.html bearbeiten.
        </p>
    </div>
    <h3><a id="header_company" href="/<?= Bootstrap::getBasePath() ?>index.php?show=company">Unternehmen</a></h3>
    <div>
        <p>
            Die Seite unternehmen.html bearbeiten.
        </p>
    </div>
    <h3><a id="header_objects" href="/<?= Bootstrap::getBasePath() ?>index.php?show=objects">Objekte</a></h3>
    <div>
        <p>
            Die Seite objekte.html bearbeiten.
        </p>
    </div>
    <h3><a id="header_projects" href="/<?= Bootstrap::getBasePath() ?>index.php?show=projects">Projekte</a></h3>
    <div>
        <p>
            Die Seite objekte.html bearbeiten.
        </p>
    </div>
    <h3><a id="header_jobs" href="/<?= Bootstrap::getBasePath() ?>index.php?show=jobs">Karriere</a></h3>
    <div>
        <p>
            Die Seite karriere.html bearbeiten.
        </p>
    </div>
    <h3><a id="header_contact" href="/<?= Bootstrap::getBasePath() ?>index.php?show=contact">Kontakt</a></h3>
    <div>
        <p>
            Die Seite kontakt.html bearbeiten.
        </p>
    </div>


    <h3><a id="header_imprint" href="/<?= Bootstrap::getBasePath() ?>index.php?show=imprint">Impressum</a></h3>
    <div>
        <p>
            Die Seite impressum.html bearbeiten.
        </p>
    </div>
    <h3><a id="header_siteinfo" href="/<?= Bootstrap::getBasePath() ?>index.php?show=siteinfo">Site Info</a></h3>
    <div>
        <p>
            Allgemeine Site Informationen bearbeiten.
        </p>
    </div>
</nav>
<form action="/<?= Bootstrap::getBasePath() ?>index.php?show=login&do=logout" method="post">
    <input type="submit" value="Logout" id="form-logout-submit" name="form-logout-submit" class="ym-button">
</form>
