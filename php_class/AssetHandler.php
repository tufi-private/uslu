<?php
require_once dirname(__FILE__).'/DBClient.php';
/**
 * Includes class AssetHandler
 * Author: tufan özduman
 * Date: 04.08.12
 * Time: 18:52
 */

/**
 * Holds relevant methods for getting Assets from the database
 */
class AssetHandler
{
    /**
     * @var string page identifier
     */
    private $pageIdentifier;
    /**
     * @var \DBClient
     */
    private $dbObject;

    /**
     * @param          $pageIdentifier unique identifier of the page e.g. index
     * @param DBClient $dbObject
     *
     * @throws Exception
     */
    public function __construct($pageIdentifier, DBClient $dbObject)
    {
        if (is_null($dbObject)) {
            throw new \Exception('DBObject muss gesetzt werden');
        }

        $this->pageIdentifier = $pageIdentifier;
        $this->dbObject = $dbObject;
    }

    /**
     * assets in an array
     *
     * @param $contentId
     *
     * @throws Exception
     * @return array|mixed
     */
    public function getAssets($contentId)
    {
        if ((int) $contentId <= 0 ) {
            throw new Exception(
                'ContentId - id des Objektes muss angegeben werden!'
            );
        }

        $assetSql = "select
                     `id`,
                     `original_filename`, `thumbnail_filename`,
                     `width`, `height`,
                     `thumbnail_width`, `thumbnail_height`,
                     `path`, `thumbnail_path`,
                     `category`
                     from assets where contentPageId=". $contentId;
                    $assets = $this->dbObject->getRows($assetSql);
        return json_decode(json_encode($assets),true);
    }
}
