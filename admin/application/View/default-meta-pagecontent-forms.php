<div class="form" id="container-form">
    <form action="index.php?show=<?= $this->identifier; ?>&do=meta" method="post" class="ym-form ym-columnar" id="form-<?= $this->identifier; ?>-meta">
        <h6><?= App\Lang::getString(Bootstrap::getLang(), 'META_INFORMATION') ?></h6>

        <div class="ym-fbox-text">
            <label for="page-title"><?= App\Lang::getString(Bootstrap::getLang(), 'PAGE_TITLE') ?>:</label>
            <input type="text" name="page-title" id="page-title" size="32" maxlength="128" value="<?= $this->title; ?>" />
        </div>
        <div class="ym-fbox-text">
            <label for="page-keywords"><?= App\Lang::getString(Bootstrap::getLang(), 'PAGE_KEYWORDS') ?>:</label>
            <textarea title="Keywords Komma-separiert eingeben" name="page-keywords" id="page-keywords" cols="60" rows="2"><?= $this->keywords; ?></textarea>
        </div>
        <div class="ym-fbox-text">
            <label for="page-description"><?= App\Lang::getString(Bootstrap::getLang(), 'PAGE_DESCRIPTION') ?>:</label>
            <textarea name="page-description" id="page-description" cols="60" rows="5"><?= $this->description; ?></textarea>
        </div>
        <div class="ym-fbox-text">
            <label for="page-online" <?= ($this->identifier == 'index') ? 'title="'.App\Lang::getString(Bootstrap::getLang(), 'CANNOT_SET_INDEX_OFFLINE').'"' : '' ?>>
                <?= App\Lang::getString(Bootstrap::getLang(), 'SET_ONLINE') ?></label>
            <input type="checkbox" name="page-online" id="page-online" <?= ($this->identifier == 'index') ? 'disabled="true"' : '' ?> <?= ($this->online =='1') ? 'checked="checked"' : ''?> />
        </div>

        <div class="ym-fbox-button">
            <input type="submit" class="ym-button" name="form-<?= $this->identifier; ?>-submit-meta" id="form-<?= $this->identifier; ?>-submit-meta" value="<?= App\Lang::getString(Bootstrap::getLang(), 'SAVE') ?>" />
        </div>
    </form>

    <h3><?= App\Lang::getString(Bootstrap::getLang(), 'PAGE_CONTENT') ?>:</h3>
    <form class="ym-form linearize-form ym-full">
        <div class="ym-fbox-text">
            <label><?= App\Lang::getString(Bootstrap::getLang(), 'UPLOAD_PAGE_BG_IMAGE') ?>:</label>
            <div id="fsUploadProgress-bgImage"></div>
            <div style="padding-left: 5px;">
                <span id="button-placeholder-bgImage"></span>
            </div>
            <?php if (trim($this->backgroundImage) != ''): ?>
            <img src="/<?= Bootstrap::getFrontendBasePath();?>/<?= Bootstrap::getConfig()->backend->assets->foldername ?>/<?= $this->backgroundImage ?>" alt="<?= App\Lang::getString(Bootstrap::getLang(), 'CURRENT_BG_IMAGE') ?>: <?= $this->backgroundImage; ?>" class="thumbnail" id="page-bg-image" />
            <?php endif; ?>
        </div>
    </form>
    <form class="ym-form ym-full" action="/<?= Bootstrap::getBasePath() ?>index.php?show=<?= $this->identifier; ?>&do=setPageContent" method="post" id="form-<?= $this->identifier; ?>-content">
        <div class="ym-fbox-text">
            <label for="page-content"><?= App\Lang::getString(Bootstrap::getLang(), 'PAGE_CONTENT') ?></label>
            <textarea name="page-content" id="page-content" class="tinymce" cols="60" rows="45"><?= ($this->content); ?></textarea>
        </div>
        <div class="ym-fbox-button">
            <input type="submit" name="form-<?= $this->identifier; ?>-submit-content" id="form-<?= $this->identifier; ?>-submit-content" value="<?= App\Lang::getString(Bootstrap::getLang(), 'SAVE') ?>" class="ym-fbox-button" />
        </div>
     </form>
</div>