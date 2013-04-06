<?php
namespace App;
/**
 * Includes language constant strings
 * User: tufi
 * Date: 09.09.12
 * Time: 18:57
 */
class Lang
{
    const DE_SETTINGS = 'Einstellungen';
    const DE_SETTINGS_FOR = 'Einstellungen für';
    const DE_SAVE= 'Speichern';
    const DE_UPLOAD_PAGE_BG_IMAGE = 'Hintergrundbild für die Seite hochladen';
    const DE_CURRENT_BG_IMAGE = 'Aktuelles Hintergrundbild';
    const DE_PAGE_CONTENT= 'Seiteninhalt';
    const DE_CANNOT_SET_INDEX_OFFLINE= 'Index.html kann nicht offline gestellt werden';
    const DE_SET_ONLINE= 'Seite online';
    const DE_META_INFORMATION= 'Meta Informationen';
    const DE_PAGE_TITLE= 'Titel der Seite';
    const DE_PAGE_DESCRIPTION= 'Beschreibung der Seite';
    const DE_PAGE_KEYWORDS= 'Keywords der Seite';

    const DE_MENU_EDIT_PAGE = 'Die Seite %s bearbeiten';
    const DE_MENU_EDIT_SITEINFO = 'Allgemeine Site Informationen bearbeiten';
    const DE_MENU_START = 'Startseite';
    const DE_MENU_COMPANY = 'Unternehmen';
    const DE_MENU_OBJECTS = 'Objekte';
    const DE_MENU_PROJECTS = 'Projekte';
    const DE_MENU_JOBS = 'Karriere';
    const DE_MENU_CONTACT = 'Kontakt';
    const DE_MENU_IMPRINT = 'Impressum';
    const DE_MENU_SITEINFO = 'Site Info';

    const DE_MSG_SAVE_OK = 'Daten wurden erfolgreich gespeichert';
    const DE_MSG_META_SAVE_OK = 'Meta-Daten wurden erfolgreich gespeichert';
    const DE_MSG_SAVED_NOTHING = 'Keine Datensätze betroffen.';
    const DE_UPLOAD_OK = 'Datei(en) wurden erfolgreich hochgeladen.';

    const DE_UNLINK_OK = 'Datei erfolgreich gelöscht: %s';
    const DE_DELETE_OK = 'Datensatz erfolgreich gelöscht: %s';
    const DE_UNLINK_ERROR = '<span class="errorLabel">Datei konnte nicht gelöscht werden:</span> %s';
    const DE_DELETE_ERROR = '<span class="errorLabel">Datensatz konnte nicht gelöscht werden:</span> Table: %s, ID: %s';
    const DE_FILE_NOT_FOUND = '<span class="errorLabel">Datei nicht gefunden:</span> %s';

    /***** DEFINED CONSTANTS *****/
    const DE_NOGDLIB = 'erforderliche (\'GD\') Bibliothek ist nicht installiert oder nicht geladen';
    const DE_NOURL = 'bild url string ist leer';
    const DE_NOIMAGE = 'es konnte keine Bilddatei gefunden werden, aus der Informationen gelesen werden konnten ';
    const DE_NOMIME = 'Bild mime type unbekannt';
    const DE_NOWIDTH = 'Bild breite (width) unbekannt';
    const DE_NOHEIGHT = 'Bild hoehe (height) unbekannt';
    const DE_NODEPTH = 'Bild Bittiefe unbekannt';
    const DE_NOCHANNELS = 'Anzahl der Farbkanaele im Bild unbekannt';
    const DE_NOTYPE = 'Bildtyp unbekannt';
    const DE_NOTTHUMBDIR = 'thumbnail-Verzeichnis existiert nicht';
    const DE_NODIR = 'verzeichnis existiert nicht';
    const DE_NOIMGDATA = 'kein Bild-Data';
    const DE_FAILEDSAVETHUMB = 'konnte Thumbnail nicht speichern';
    const DE_FAILEDSAVE = 'konnte Bilddatei nicht speichern';
    const DE_FAILEDLOADIMAGE = 'laden des Bildes fehlgeschlagen';
    const DE_FAILEDCROP = 'Ausschneiden fehlgeschlagen';
    const DE_FAILEDROTATE = 'Rotieren fehlgeschlagen';
    const DE_FAILEDRESIZE = 'Bildgroesse aendern fehlgeschlagen';
    const DE_FAILEDINFO = 'konnte Bildinformationen nicht erhalten';
    const DE_FAILEDTHUMB = 'Thumbnailerstellung fehlgeschlagen';
    const DE_FAILEDTHMBSIZE = 'Setzen des Klassen Objects thumb size fehlgeschlagen';
    const DE_INVALIDPARAM = 'ungueltige Parameter liste für Methode';
    const DE_OUTOFBOUNDS = 'Bilddimensionen ueberschritten';

    const DE_UPLOAD_ERR_1 = 'Zulässige Dateigröße ist überschritten. Maximale Dateigröße beträgt: 2MB';
    const DE_UPLOAD_ERR_2 = 'Zulässige Dateigröße ist überschritten. Maximale Dateigröße beträgt: 2MB';
    const DE_UPLOAD_ERR_3 = 'Datei konnte nicht vollständig hochgeladen werden';
    const DE_UPLOAD_ERR_4 = 'Es wurde keine Datei hochgeladen';
    const DE_UPLOAD_ERR_6 = 'Es konnte kein Temporärverzeichnis gefunden werden';
    const DE_UPLOAD_ERR_7 = 'Datei konnte nicht gespeichert werden';
    const DE_UPLOAD_ERR_8 = 'Upload wurde durch eine Erweiterung gestoppt';
    const DE_UPLOAD_ERR_9 = 'Dieser Dateityp wird nicht unterstützt.';

    // TODO: Enlish translation
    const EN_SETTINGS = 'Settings';
    const EN_SETTINGS_FOR = 'Settings for';
    const EN_SAVE = 'Save';
    const EN_UPLOAD_PAGE_BG_IMAGE = 'Upload background image for the page';
    const EN_CURRENT_BG_IMAGE = 'Aktuelles Hintergrundbild';
    const EN_PAGE_CONTENT= 'Page content';
    const EN_CANNOT_SET_INDEX_OFFLINE= 'You cannot set index.html offline';
    const EN_SET_ONLINE= 'Page online';
    const EN_META_INFORMATION= 'Meta information';
    const EN_PAGE_TITLE= 'Page title';
    const EN_PAGE_DESCRIPTION= 'Page description';
    const EN_PAGE_KEYWORDS= 'Page keywords';

    const EN_MENU_EDIT_PAGE = 'Edit page %s';
    const EN_MENU_EDIT_SITEINFO = 'Edit general site information';
    const EN_MENU_START = 'Startpage';
    const EN_MENU_COMPANY = 'Company';
    const EN_MENU_OBJECTS = 'Objects';
    const EN_MENU_PROJECTS = 'Projects';
    const EN_MENU_JOBS = 'Career';
    const EN_MENU_CONTACT = 'Contact';
    const EN_MENU_IMPRINT = 'Imprint';
    const EN_MENU_SITEINFO = 'Site Info';

    const EN_MSG_SAVE_OK = 'Daten wurden erfolgreich gespeichert';
    const EN_MSG_META_SAVE_OK = 'Meta-Daten wurden erfolgreich gespeichert';
    const EN_MSG_SAVED_NOTHING = 'Keine Datensätze betroffen.';
    const EN_UPLOAD_OK = 'Datei(en) wurden erfolgreich hochgeladen.';

    const EN_UNLINK_OK = 'Datei erfolgreich gelöscht: %s';
    const EN_DELETE_OK = 'Datensatz erfolgreich gelöscht: %s';
    const EN_UNLINK_ERROR = '<span class="errorLabel">Datei konnte nicht gelöscht werden:</span> %s';
    const EN_DELETE_ERROR = '<span class="errorLabel">Datensatz konnte nicht gelöscht werden:</span> Table: %s, ID: %s';
    const EN_FILE_NOT_FOUND = '<span class="errorLabel">Datei nicht gefunden:</span> %s';

    /***** DEFINED CONSTANTS *****/
    const EN_NOGDLIB = 'erforderliche (\'GD\') Bibliothek ist nicht installiert oder nicht geladen';
    const EN_NOURL = 'bild url string ist leer';
    const EN_NOIMAGE = 'es konnte keine Bilddatei gefunden werden, aus der Informationen gelesen werden konnten ';
    const EN_NOMIME = 'Bild mime type unbekannt';
    const EN_NOWIDTH = 'Bild breite (width) unbekannt';
    const EN_NOHEIGHT = 'Bild hoehe (height) unbekannt';
    const EN_NODEPTH = 'Bild Bittiefe unbekannt';
    const EN_NOCHANNELS = 'Anzahl der Farbkanaele im Bild unbekannt';
    const EN_NOTYPE = 'Bildtyp unbekannt';
    const EN_NOTTHUMBDIR = 'thumbnail-Verzeichnis existiert nicht';
    const EN_NODIR = 'verzeichnis existiert nicht';
    const EN_NOIMGDATA = 'kein Bild-Data';
    const EN_FAILEDSAVETHUMB = 'konnte Thumbnail nicht speichern';
    const EN_FAILEDSAVE = 'konnte Bilddatei nicht speichern';
    const EN_FAILEDLOADIMAGE = 'laden des Bildes fehlgeschlagen';
    const EN_FAILEDCROP = 'Ausschneiden fehlgeschlagen';
    const EN_FAILEDROTATE = 'Rotieren fehlgeschlagen';
    const EN_FAILEDRESIZE = 'Bildgroesse aendern fehlgeschlagen';
    const EN_FAILEDINFO = 'konnte Bildinformationen nicht erhalten';
    const EN_FAILEDTHUMB = 'Thumbnailerstellung fehlgeschlagen';
    const EN_FAILEDTHMBSIZE = 'Setzen des Klassen Objects thumb size fehlgeschlagen';
    const EN_INVALIDPARAM = 'ungueltige Parameter liste für Methode';
    const EN_OUTOFBOUNDS = 'Bilddimensionen ueberschritten';

    const EN_UPLOAD_ERR_1 = 'Zulässige Dateigröße ist überschritten. Maximale Dateigröße beträgt: 2MB';
    const EN_UPLOAD_ERR_2 = 'Zulässige Dateigröße ist überschritten. Maximale Dateigröße beträgt: 2MB';
    const EN_UPLOAD_ERR_3 = 'Datei konnte nicht vollständig hochgeladen werden';
    const EN_UPLOAD_ERR_4 = 'Es wurde keine Datei hochgeladen';
    const EN_UPLOAD_ERR_6 = 'Es konnte kein Temporärverzeichnis gefunden werden';
    const EN_UPLOAD_ERR_7 = 'Datei konnte nicht gespeichert werden';
    const EN_UPLOAD_ERR_8 = 'Upload wurde durch eine Erweiterung gestoppt';
    const EN_UPLOAD_ERR_9 = 'Dieser Dateityp wird nicht unterstützt.';

    /**
     * returns translated string
     * @param $lang
     * @param $key
     *
     * @return string
     */
    public static function getString($lang, $key)
    {
        return defined('self::' . $lang . '_' . strtoupper($key))
            ? constant('self::' . $lang . '_' . strtoupper($key))
            : '';
    }
}
