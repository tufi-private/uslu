<div class="form" id="container-form">
    <form action="index.php?show=<?= $this->identifier; ?>&do=meta" method="post" class="ym-form ym-columnar" id="form-<?= $this->identifier; ?>-meta">
        <h6>Meta Informationen</h6>

        <div class="ym-fbox-text">
            <label for="page-title">Seitentitel:</label>
            <input type="text" name="page-title" id="page-title" size="32" maxlength="128" value="<?= $this->title; ?>" />
        </div>
        <div class="ym-fbox-text">
            <label for="page-keywords">Keywords:</label>
            <textarea title="Keywords Komma-separiert eingeben" name="page-keywords" id="page-keywords" cols="60" rows="2"><?= $this->keywords; ?></textarea>
        </div>
        <div class="ym-fbox-text">
            <label for="page-description">Description:</label>
            <textarea name="page-description" id="page-description" cols="60" rows="5"><?= $this->description; ?></textarea>
        </div>
        <div class="ym-fbox-text">
            <label for="page-online" <?= ($this->identifier == 'index') ? 'title="Index.html kann nicht offline gestellt werden."' : '' ?>>Seite online</label>
            <input type="checkbox" name="page-online" id="page-online" <?= ($this->identifier == 'index') ? 'disabled="true"' : '' ?> <?= ($this->online =='1') ? 'checked="checked"' : ''?> />
        </div>

        <div class="ym-fbox-button">
            <input type="submit" class="ym-button" name="form-<?= $this->identifier; ?>-submit-meta" id="form-<?= $this->identifier; ?>-submit-meta" value="Speichern" />
        </div>
    </form>

    <h3>Seiteninhalt:</h3>
    <form class="ym-form linearize-form ym-full">
        <div class="ym-fbox-text">
            <label>Hintergrundbild Hochladen:</label>

            <div id="fsUploadProgress-bgImage"></div>
            <div style="padding-left: 5px;">
                <span id="button-placeholder-bgImage"></span>
            </div>
            <?php if (trim($this->backgroundImage) != ''): ?>
            <img src="/<?= Bootstrap::getFrontendBasePath();?>/<?= Bootstrap::getConfig()->backend->assets->foldername ?>/<?= $this->backgroundImage ?>" alt="aktuelles Hintergrundbild: <?= $this->backgroundImage; ?>" class="thumbnail" id="page-bg-image" />
            <?php endif; ?>
        </div>
    </form>
    <form class="ym-form ym-full" action="/<?= Bootstrap::getBasePath() ?>index.php?show=<?= $this->identifier; ?>&do=setPageContent" method="post" id="form-<?= $this->identifier; ?>-content">
        <div class="ym-fbox-text">
            <label for="page-content">Seiteninhalt</label>
            <textarea name="page-content" id="page-content" class="tinymce" cols="60" rows="45"><?= ($this->content); ?></textarea>
        </div>
        <div class="ym-fbox-button">
            <input type="submit" name="form-<?= $this->identifier; ?>-submit-content" id="form-<?= $this->identifier; ?>-submit-content" value="Speichern" class="ym-fbox-button" />
        </div>
     </form>
</div>