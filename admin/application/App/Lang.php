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
    const DE_MSG_SAVE_OK = 'Daten wurden erfolgreich gespeichert';
    const DE_MSG_META_SAVE_OK = 'Meta-Daten wurden erfolgreich gespeichert';
    const DE_MSG_SAVED_NOTHING = 'Keine Datensätze betroffen.';
    const DE_UPLOAD_OK = 'Datei(en) wurden erfolgreich hochgeladen.';

    const  DE_UNLINK_OK = 'Datei erfolgreich gelöscht: %s';
    const  DE_DELETE_OK = 'Datensatz erfolgreich gelöscht: %s';
    const  DE_UNLINK_ERROR = '<span class="errorLabel">Datei konnte nicht gelöscht werden:</span> %s';
    const  DE_DELETE_ERROR = '<span class="errorLabel">Datensatz konnte nicht gelöscht werden:</span> Table: %s, ID: %s';
    const  DE_FILE_NOT_FOUND = '<span class="errorLabel">Datei nicht gefunden:</span> %s';

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
}
