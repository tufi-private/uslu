<h2>Einstellungen der objekte.html</h2>
<div class="form" id="container-form">
    <form id="form-<?= $this->identifier; ?>-meta" action="index.php?show=<?= $this->identifier; ?>&do=meta"
          method="post" style="margin-bottom: 1em;">
        <fieldset>
            <legend>Meta Informationen</legend>
            <table>
                <tr>
                    <td style="width:25%;"><label for="page-title">Title:</label></td>
                    <td><input type="text" name="page-title" id="page-title"
                               size="32" maxlength="128" style="width: 400px"
                               value="<?= $this->title; ?>"/></td>
                </tr>
                <tr>
                    <td><label for="page-description">Description:</label></td>
                    <td><textarea name="page-description" id="page-description"
                                  cols="60" style="width: 400px"
                                  rows="5"><?= $this->description; ?></textarea></td>
                </tr>
                <tr>
                    <td colspan="2" class="right-align">
                        <input type="submit" name="form-<?= $this->identifier; ?>-submit-meta" id="form-<?= $this->identifier; ?>-submit-meta" value="Speichern"/>
                    </td>
                </tr>
            </table>
        </fieldset>
    </form>

    <h2>Objekte:</h2>
    <div id="objects-tab-container">
        <?php if (is_array($this->innerPages) && !empty($this->innerPages)): ?>
        <ul>
            <?php foreach ($this->innerPages as $key => $innerPage) : ?>
            <li><a href="#tabs-<?= $key ?>"><?= $key + 1 ?></a></li>
            <?php endforeach; ?>
        </ul>
        <?php foreach ($this->innerPages as $key => $innerPage) : ?>
            <div id="tabs-<?= $key ?>">
                <h2 id="title-object-<?=$innerPage['id']?>" title="Zum Bearbeiten anklicken." class="editable"><?= $innerPage['title'] ?></h2>
                <form method="POST"
                      action="index.php?show=<?= $this->identifier; ?>&do=updateObjectPageContent">
                    <textarea name="page-content-object"
                              id="page-content-object-<?= $innerPage['id']?>"
                              class="tinymce" cols="60"
                              rows="25"><?= ($innerPage['content']); ?></textarea>
                    <input type="hidden" name="contentId" value="<?= $innerPage['id']?>"/>

                    <div class="right-align">
                        <input type="submit" name="form-<?= $this->identifier; ?>-submit" id="form-<?= $this->identifier; ?>-submit-meta" value="Speichern"/>
                    </div>
                </form>

                <form class="">
                    <fieldset>
                        <legend>Bilder Hochladen:</legend>

                        <div id="fsUploadProgress<?= $key ?>"></div>
                        <div style="padding-left: 5px;">
                            <span id="spanButtonPlaceholder<?= $key ?>"></span>
                        </div>
                    </fieldset>
                </form>
                <form action="index.php?show=<?= $this->identifier; ?>&do=upload"
                      method="post" style="margin-bottom: 1em;" enctype="multipart/form-data">
                    <fieldset>
                        <legend>PDF Hochladen:</legend>
                        <input type="hidden" name="contentId" value="<?= $innerPage['id'] ?>"/>
                        <table>
                            <tr>
                                <td style="width: 50%"">
                                    <label for="input-upload-pdf">PDF:</label>
                                </td>
                                <td>
                                    <input type="file" id="input-upload-pdf" name="pdf-file"/>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label style="width: 340px;" for="input-upload-pdf-thumbnail">
                                        PDF Vorschau-Image:
                                    </label>
                                </td>
                                <td>
                                    <input type="file" id="input-upload-pdf-thumbnail" name="pdf-thumbnail-file" />
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" class="right-align">
                                    <input type="submit" name="form-<?= $this->identifier; ?>-submit-pdf"
                                           id="form-<?= $this->identifier; ?>-submit-pdf" value="Speichern"/>
                                </td>
                            </tr>
                        </table>
                    </fieldset>
                </form>

                <h3>Zugehörige Assets:</h3>

                <div id="asset-list-<?= $innerPage['id'] ?>">
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
                                <form action="index.php?show=<?= $this->identifier ?>>&do=deleteAssets"method="post">
                                    <input type="hidden" name="assetId[]" value="<?= $assetDetails['id'] ?>" />
                                    <input type="submit" name="delete_asset" value="Löschen" style="float: right;" />
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

    <h2>Seiteninhalt:</h2>    <br />
    <form action="/<?= Bootstrap::getBasePath() ?>index.php" method="post"
          id="form-<?= $this->identifier; ?>-content"
          enctype="multipart/form-data">
        <fieldset>
            <legend>Inhalt</legend>
            <dl>
                <dt>
                    <label for="page-uploadBgImage">Hintergrundbild: </label>
                </dt>
                <dd>
                    <input type="file" name="page-uploadBgImage" id="page-uploadBgImage" />
                </dd>
            </dl>
            <p>
                <?php if (trim($this->backgroundImage) != ''): ?>
                <img src="/<?= Bootstrap::getBasePath() ?><?= $this->backgroundImage ?>"
                     alt="aktuelles Hintergrundbild: <?= $this->backgroundImage; ?>"
                     class="thumbnail"/>
                <?php endif; ?>
            </p>
            <label for="page-content">Seiteninhalt</label>
            <textarea name="page-content" id="page-content" class="tinymce"
                      cols="60" rows="25"><?= ($this->content); ?></textarea>
        </fieldset>
        <fieldset class="action right-align">
            <img class="NFButtonLeft" src="img/niceforms/0.png">
            <input type="submit" name="form-<?= $this->identifier; ?>-submit"
                   id="form-<?= $this->identifier; ?>-submit-content"
                   value="Speichern" class="NFButton"/>
            <img class="NFButtonRight" src="img/niceforms/0.png">
        </fieldset>
    </form>
</div>