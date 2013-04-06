<h2><?= App\Lang::getString(Bootstrap::getLang(), 'SETTINGS_FOR') ?> <?= $this->htmlPage ?></h2>
<?php include_once 'default-meta-pagecontent-forms.php'; ?>

<h2><?=$this->innerPageDefinition ?>:</h2>
<div id="objects-tab-container">
    <?php if (is_array($this->innerPages) && !empty($this->innerPages)): ?>
    <ul>
        <?php foreach ($this->innerPages as $key => $innerPage) : ?>
        <li><a href="#tabs-<?= $key ?>"><?= $key + 1 ?></a></li>
        <?php endforeach; ?>
    </ul>
    <?php foreach ($this->innerPages as $key => $innerPage) : ?>
        <div id="tabs-<?= $key ?>">
            <h5 id="title-object-<?=$innerPage['id']?>" title="Zum Bearbeiten anklicken." class="editable"><?= $innerPage['title'] ?></h5>
            <form method="post" class="ym-form linearize-form ym-full" action="index.php?show=<?= $this->identifier; ?>&do=updateObjectPageContent" enctype="multipart/form-data">
                <input type="hidden" name="contentId" value="<?= $innerPage['id']?>"/>

                <div class="ym-fbox-text">
                            <label for="page-menu-abbr">Menü Text:</label>
                            <input type="text" name="page-menu-abbr" id="page-menu-abbr" size="8" maxlength="8" value="<?= $innerPage['menuAbbr']?>">
                        </div>
                <div class="ym-fbox-text">
                            <label for="page-upload-customBgImage">Eigenes Hintergrundbild:</label>
                            <input type="file" name="page-upload-customBgImage" id="page-upload-customBgImage" >
                        </div>
                <?php
                if (!empty($innerPage['customPageBackground'])) : ?>
                    <div class="ym-fbox-text">
                        <label>Aktuelles Hintergrundbild für <?= $innerPage['title'] ?>:</label>
                        <img src="/<?= Bootstrap::getFrontendBasePath();?>/<?= Bootstrap::getConfig()->backend->assets->foldername ?>/<?= $innerPage['customPageBackground'] ?>" alt="aktuelles Hintergrundbild: <?= $innerPage['customPageBackground']; ?>" class="thumbnail" id="page-customBgImage" />
                    </div>
                <?php endif; ?>
                <div class="ym-fbox-text">
                    <textarea name="page-content-object" id="page-content-object-<?= $innerPage['id']?>" class="tinymce" cols="60" rows="65"><?= ($innerPage['content']); ?></textarea>
                </div>


                <div class="ym-fbox-button">
                    <input type="submit" class="ym-button" name="form-<?= $this->identifier; ?>-submit" id="form-<?= $this->identifier; ?>-submit-meta" value="Speichern"/>
                </div>
            </form>

            <form class="ym-form linearize-form ym-full" >
                <h5>Bilder Hochladen:</h5>
                <div id="fsUploadProgress<?= $key ?>"></div>
                <div style="padding-left: 5px;">
                    <span id="spanButtonPlaceholder<?= $key ?>"></span>
                </div>
            </form>
            <form action="index.php?show=<?= $this->identifier; ?>&do=upload" class="ym-form ym-full"
                  method="post" style="margin-bottom: 1em;" enctype="multipart/form-data">
                <h5>PDF Hochladen:</h5>
                <input type="hidden" name="contentId" value="<?= $innerPage['id'] ?>" />

                <div class="ym-fbox-text">
                    <label for="input-upload-pdf">PDF:</label>
                    <input type="file" id="input-upload-pdf" name="pdf-file" />
                </div>
                <div class="ym-fbox-text">
                    <label style="width: 340px;" for="input-upload-pdf-thumbnail">PDF Vorschau-Image:</label>
                    <input type="file" id="input-upload-pdf-thumbnail" name="pdf-thumbnail-file" />
                </div>
                <div class="ym-fbox-button">
                    <input type="submit" name="form-<?= $this->identifier; ?>-submit-pdf"
                           id="form-<?= $this->identifier; ?>-submit-pdf" value="Speichern" />
                </div>
            </form>

            <h3>Zugehörige Assets:</h3>
            <div id="asset-list-<?= $innerPage['id'] ?>" class="asset-list">
                <?php foreach ($innerPage['assets'] as $assetKey => $assetDetails) : ?>
                    <div style="overflow:hidden;font-size: 0.7em;border-bottom: 1px dotted #333333; clear: right; margin-bottom: 1em; padding-bottom: 1em;">
                        <?php if (!empty($assetDetails['path'])): ?>
                        <?php if (\App\Lib\Image\ImageHandler::isImage( $assetDetails['path'])): ?>
                            <img src="/<?= Bootstrap::getFrontendBasePath();?><?= $assetDetails['path']?>"
                                 alt="<?= $assetDetails['path'] ?>"
                                 style="float: right;" class="thumbnail">
                            <?php else: ?>
                            <a href="/<?= Bootstrap::getFrontendBasePath();?><?= $assetDetails['path']?>" style="float: right;">
                                <?php if (!empty($assetDetails['thumbnail_path'])): ?>
                                <img src="/<?= Bootstrap::getFrontendBasePath();?><?= $assetDetails['thumbnail_path']?>"
                                     alt="<?= $assetDetails['path'] ?>"
                                     style="float: right;"
                                     class="thumbnail">
                                <?php else: ?> /<?= Bootstrap::getFrontendBasePath(); ?><?= $assetDetails['path'] ?>
                                <?php endif; ?>
                            </a>
                            <?php endif; ?>
                        <?php endif; ?>
                        <?php
                        foreach ($assetDetails as $property => $value) : ?>
                            <?php if ($property == 'id') {continue;} ?>

                            <p style="margin:0;"><strong><?= ucfirst(str_replace('_', ' ', $property)) ?>:</strong> <?= $value ?></p>

                            <?php endforeach; ?>
                        <p style="margin:0;"><strong>URL:</strong> <?= Bootstrap::getFrontendURI() .  $assetDetails['path']  ?></p>
                            <form action="index.php?show=<?= $this->identifier ?>&do=deleteAssets" method="post">
                                <input type="hidden" name="assetId[]" value="<?= $assetDetails['id'] ?>" />
                                <button name="delete_asset" style="float: right;" class="ym-button ym-delete"> Löschen </button>
                            </form>
                    </div>
                    <?php endforeach; ?>
            </div>
        </div>
        <?php endforeach; ?>
    <?php else: ?>
    <p>Es sind noch keine Objekte zu konfigurieren vorhanden.</p>
    <?php endif; ?>
</div>
