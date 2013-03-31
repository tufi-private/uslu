/**
 * @author Tufan Özduman
 * @since 2012-07-01
 * @copyright Tufan Özduman. All rights reserved. Copy or (re-)distribute is
 * not allowed.
 */
try {
    if (typeof tt == 'undefined') {
        tt = {};
    }
} catch (exception) {
    tt = {};
}
tt.baseUrl = "/<?= Bootstrap::getBasePath() ?>/index.php";
tt.activePage = '';
tt.sendRequest = function(data, responseHandler, scope, responseCallback) {
    jQuery.ajax({
        url: tt.baseUrl,
        processData: false,
        data: data,
        type:"POST",
        success: function(response) {
            /*var responseData = jQuery.parseJSON(response);
            if (responseData.error) {
                var isHandled = tt.onGlobalRPCError.apply(scope, [responseData.error, data]);
                if (isHandled == true) {
                    return;
                }
            }*/
            // call response handler
            if (responseHandler) {
                if (!scope) {
                    scope = null;
                }
                responseHandler.apply(scope, [response,responseCallback]);
            }
        }
    });
};

tt.callRPC = function (controller, action, params, responseHandler, scope, responseCallback) {
    controller = controller || 'index';
    action = action || 'index';
    params = params || [];
    var baseParams = {}; // intented for future use only
    var rpc = {
        controller:controller,
        "do": action,
        params:params
    };

    for (var key in baseParams) { // intented for future use
        rpc[key] = baseParams[key];
    }
    var data = JSON.stringify(rpc);
    tt.sendRequest(data, responseHandler, scope, responseCallback);
};


tt.onGlobalRPCError = function(error, data) {

    var title = "Es ist ein interner Fehler aufgetreten.";
    var msg = "Es trat ein Fehler auf. Bitte probieren Sie es später noch einmal oder informieren Sie den Administrator.";
    var detailed = false;
    var tpl = '<div id="confirmDialog" title="' + title + '">';
    tpl += '<p>' + msg + '</p>';
    if (detailed) {
        tpl += '<p style="margin-top: 1em; text-align: left;">'
            + '<strong>Exception: </strong>'
            + '<span class="red">' + error + '</span>'
            + '</p>';
        tpl += '<p style="margin-top: 1em; text-align: left; font-weight: bold">'
            + 'Data: '
            + '</p>';
        tpl += '<textarea rows="10" cols="58">' + data + '</textarea>';
        tpl += '<p style="margin-top: 1em; text-align: left; font-weight: bold">'
            + 'Stack: '
            + '</p>';
        tpl += '<textarea rows="10" cols="58">' + Stack() + '</textarea>';
    }
    tpl += '</div>';

    var okLabel = "OK";
    var config = {
        resizable:true,
        width:600,
        modal:true,
        buttons:[
            {
                text:okLabel,
                click:function () {
                    jQuery(this).dialog("close");
                }
            }
        ]
    };

    console.log(error);

    if (jQuery('.masked').isMasked()) {
        jQuery('.masked').unmask();
    }
    return jQuery(tpl).dialog(config);
};

tt.log = function(){
    try {
        if (console) {
            jQuery(arguments).each(function(index, el){
                console.log(el);
            });
        }
    } catch (e) {
        console.error(e);
        // nop
    }
};

tt.HTMLResponseHandler = function(response, responseCallback) {
    try {
        var responseData = jQuery.parseJSON(response);
        if (responseData.error) {
            tt.onGlobalRPCError.apply(scope, [responseData.error, data]);
        }

        var html = responseData.result;
        if (responseData.debug) {
            var debugWin = window.open("", "debugWin",
                "menubar=0,"
                    + "width=800,"
                    + "height=480,"
                    + "toolbar=0,"
                    + "scrollbars=1,"
                    + "resizeable=1"
            );

            if (debugWin) {
                jQuery(debugWin.document.body).html(responseData.debug);
                debugWin.focus();
            }
        }

        jQuery(this).html(html);
        if (responseCallback) {
            responseCallback.call(this, arguments);
        }
    } catch (e) {
        tt.onGlobalRPCError.apply(this,[e, response]);
    }
};

tt.confirm = function(title, msg, formObject, config){
    title = title || "Löschen bestätigen";
    msg = msg || "Sollen die ausgewählten Datensätze wirklich gelöscht werden?";
    var tpl = '<div id="confirmDialog" title="'+title+'">' + msg + '</div>';

    var okLabel = "OK";
    var cancelLabel = "Abbrechen";

    config = jQuery.extend(true, {
        resizable:false,
        width:400,
        modal:true,
        buttons:[{
                text: okLabel,
                click: function () {
                    // using the native DOM element and action here:
                    formObject.submit();
                    jQuery(this).dialog("close");
                }
            },
            {
                text: cancelLabel,
                click: function () {
                   jQuery(this).dialog("close");
                }
            }
        ]
    }, config);

    return jQuery(tpl).dialog(config);
};
tt.message = function(title, msg, config){
    title = title || "Hinweis";
    msg = msg || "Ihre Aktion wurde erfolgreich ausgeführt.";
    var tpl = '<div id="confirmDialog" title="'+title+'">' + msg + '</div>';

    var okLabel = "OK";
//    var cancelLabel = "Abbrechen";

    config = jQuery.extend(true, {
        resizable:false,
        width:400,
        modal:true,
        buttons:[{
                text: okLabel,
                click: function () {
                    jQuery(this).dialog("close");
                }
            }]
    }, config);

    return jQuery(tpl).dialog(config);
};
/**
 * sanitizes form data for ajax requests
 */
tt.sanitizeForm = function (jqXHR, settings) {
    var params = $.unserialize(settings.data);

    var rpc = {
        controller: settings.show,
        params:params
    };
    settings.data = JSON.stringify(rpc);
};
tt.ajaxSettings = {
    // dataType identifies the expected content type of the server
    // response
    type:"POST",
    dataType:'json',
    processData:false,
    beforeSend:tt.sanitizeForm,
    show:'',
    // success identifies the function to invoke when the server
    // response has been received
    success:function (data) {
        console.log(data);
        if (data.success){
            if (data.result.msg) {
                tt.message(null, data.result.msg);
            }
        } else {
            tt.message("Fehler", data.error);
        }
    }
};

/**
 *
 * @param form                  Form, id or Dom-Object to be ajaxified
 * @param contentArea           Content Area of the form
 * @param params                Form parameters
 * @param responseCallback      Actions to be executed can be different for
 *                              different forms. these can be specified in a
 *                              responseCallback function
 */
tt.ajaxifyForm = function (form, contentArea, params, responseCallback) {
    var f = typeof form === "string" ?
        jQuery('form#' + form)
        : form;

    (jQuery(f).length == 1) && (function () {
        var confirmDialog;
        /**
         *  http://api.jquery.com/serializeArray/
         *  No submit button value is serialized since the form was not
         *  submitted using a button.
         *
         *  following code is the workaround for that, including a confirm
         *  dialog for submit buttons, triggering a delete action
         */
        jQuery(f).find("input[type=submit]").click(function (event) {
            jQuery(f).append('<input type="hidden" class="_action" />');
            var btn = jQuery(this);
            btn.closest('form').find('._action[type=hidden]').attr({
                value:btn.attr('value'),
                name:btn.attr('name')
            });

            if (btn.attr('name') == 'delete_button') {
                event.stopPropagation();
                event.preventDefault();
                confirmDialog = tt.confirm('','',f);
            }
        });

        // remove all previous attached event handlers for submit
        jQuery(f).off('submit');
        // attach own submit handler now:
        jQuery(f).on('submit',function (event) {
            event.preventDefault();

            if (confirmDialog) {
                confirmDialog.dialog("destroy");
            }

            if (jQuery(contentArea).length > 0) {
                jQuery(contentArea).mask("Loading...");
            } else {
                jQuery('.tabContentArea:visible').mask('Loading...');
            }

            params = jQuery.extend({
                "show":'',
                "show_params":'',
                "do":'',
                "do_params":'',
                    "lang":"js"
            }, params);

            jQuery.map(f.serializeArray(), function(n, i){
                var name = n['name'];
                // check if we have an checkbox array a la "delete[]"
                var matches = name.match(/(.*)\[\]$/);
                if (matches) {
                    if ( !(matches[1] in params)) {
                        params[matches[1]] = new Array();
                    }
                    params[matches[1]].push(n['value']);

                } else {
                    params[n['name']] = n['value'];
                }
            });
            tt.callRPC('getRemote', params, contentArea, responseCallback);
        });
    })();
};

/**
 * Load a JavaScript file from the server using a GET HTTP request, then
 * execute it. This is a custom method replacing jQuery.getScript() for making
 * cached requests.
 * @param url
 * @param callback
 * @return {*}
 */
tt.loadScript = function(url, callback) {
    return jQuery.ajax({
      url: url,
      data: undefined,
      success: callback,
      dataType: "script",
      cache: true
    });
};
// functions related to tab handling
// ----------------------------------------------------------------------------
tt.tabs = {
    tabMap : {},
    activeTab: ''
};

/**
 * appends an identifier of the current active tab as hash to the href of
 * window location.
 * @param hashVal identifier to be appended
 */
tt.tabs.appendHash = function(hashVal) {
    if (hashVal.length == 0) return;
    var hash = document.location.hash;
    var loc = document.location.href;
    if (hash.length > 0) {
        var parts = loc.split('#');
        loc = parts[0]; // url vor dem #
    }

    var newLoc = '';
    if (loc.charAt(loc.length - 1) != '#') {
        newLoc = loc + '#' + hashVal;
    } else {
        newLoc = loc + hashVal;
    }
    window.location.href = newLoc;
};

/**
 * activates a tab identified by tabIdent
 * @param tabIdent tab identifier
 */
tt.tabs.showTab = function(tabIdent, setSession) {
    if (typeof setSession == 'undefined'){
        setSession=true;
    }

    var tabId = "#headline_" + tabIdent;
    jQuery(tabId).addClass('activeTab');
    jQuery("#content_" + tabIdent).show();
    tt.tabs.appendHash('t=' + tabIdent);
    if (setSession) {
        tt.callRPC('setActiveTab', {activeTab:tabIdent});
    }

    tt.tabs.activeTab = tabIdent;
};
/**
 * determines on page load the active tab via hash tag on the location and
 * shows it. if
 * @param defaultTab
 */

/*tt.tabs.showActiveTab = function(defaultTab, setSession) {
    if (typeof setSession == 'undefined'){
        setSession=true;
    }

    var activeTab = defaultTab;
    // determining active tab by hash
    var hash = document.location.hash;
    if (hash.length > 0) {
        var loc = document.location.href;
        var parts = loc.split('#');
        var hashParts = parts[1].split('=');
        if (hashParts.length == 2 && hashParts[0] == 't') {
            activeTab = hashParts[1];
        }

        if (tt.tabs.tabMap[activeTab].type =="complex") {
            var showParams = tt.getRequestShowParams();
            this.getRemoteTabContent(activeTab, setSession, showParams);
            return;
        }

        tt.tabs.showTab(activeTab, setSession);
    } else {
        var sessionActiveTab = '';
        tt.callRPC('getActiveTab', null, function (response) {
            var responseData = jQuery.parseJSON(response);
            try {
                sessionActiveTab = responseData.result;
                if (sessionActiveTab.length > 0) {
                    if (jQuery('#headline_' + sessionActiveTab).length > 0) {
                        activeTab = sessionActiveTab;
                    }
                }

                if (tt.tabs.tabMap[activeTab].type =="complex") {
                    var showParams = tt.getRequestShowParams();
                    this.getRemoteTabContent(activeTab, setSession);
                    return;
                }

                tt.tabs.showTab(activeTab, setSession);
            } catch (e) {
                tt.onGlobalRPCError(e);
            }
        }, this, null);
    }
}*/
/**
 * normalizes tabs and their container
 * @param basicTabs
 */
tt.tabs.normalize = function(tabs) {
    if ('undefined' == typeof tabs) {
        jQuery.each(tt.tabs.tabMap, function (i, n) {
            jQuery('#headline_' + i).removeClass('activeTab');
            jQuery('#content_' + i).hide();
        });
    } else {
        // this is the case for old-style performance tabs
        jQuery.each(tabs, function (i, n) {
            jQuery('#headline_' + n).removeClass('activeTab');
            jQuery('#content_' + n).hide();
        });
    }
};

tt.init = function () {
    $("#accordion").on(
        "click",
        "[id^=header_]",
        function () {
            document.location.href = this.href;
        }
    );

    tt.postRequestHandler();
};

tt.postRequestHandler = function(){
    tinyMCE.init(tt.tinyMCE.config);
    $( "#objects-tab-container" ).tabs();
    tt[tt.activePage] && tt[tt.activePage] && tt[tt.activePage].pageHandler();
};

tt.tinyMCE = {
    config :{
        // Location of TinyMCE script
        script_url:'/<?= Bootstrap::getBasePath() ?>js/libs/tiny_mce/tiny_mce.js',
        language : "de",
        // General options
        mode:"specific_textareas",
        editor_selector:/(tinymce)/,
        theme:"advanced",
        plugins:"autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist",

        // Theme options
        theme_advanced_buttons1:"save,newdocument,|,bold,italic,underline,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
        theme_advanced_buttons2:"cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,help,code,|,insertdate",
        theme_advanced_buttons3:"forecolor,backcolor, |,tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,media,advhr,|,print",
        theme_advanced_buttons4:"insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,|,fullscreen,preview",
        theme_advanced_toolbar_location:"top",
        theme_advanced_toolbar_align:"left",
        theme_advanced_statusbar_location:"bottom",
        theme_advanced_resizing:false,

        // Example content CSS (should be your site CSS)
        content_css:"/<?= Bootstrap::getBasePath() ?>css/yaml.css",

        // Drop lists for link/image/media/template dialogs
        template_external_list_url:"lists/template_list.js",
        external_link_list_url:"lists/link_list.js",
        external_image_list_url:"lists/image_list.js",
        media_external_list_url:"lists/media_list.js",
        entity_encoding:"raw",
        width : "700",
        height : "550",
        verify_html: false,
        cleanup: false,
        cleanup_on_startup : false
    }
};


tt.swfupload = {

    /**
     *  This is an example of how to cancel all the files queued up.
     *  It's made somewhat generic.  Just pass your SWFUpload
     *  object in to this method and it loops through cancelling the uploads.
     */
    cancelQueue:function (instance) {
        document.getElementById(instance.customSettings.cancelButtonId).disabled = true;
        instance.stopUpload();
        var stats;

        do {
            stats = instance.getStats();
            instance.cancelUpload();
        } while (stats.files_queued !== 0);
    },

    /* **********************
     Event Handlers
     These are my custom event handlers to make my
     web application behave the way I went when SWFUpload
     completes different tasks.  These aren't part of the SWFUpload
     package.  They are part of my application.  Without these none
     of the actions SWFUpload makes will show up in my application.
     ********************** */
    fileDialogStart:function () {
        /* I don't need to do anything here */
    },
    fileQueued:function (file) {
        try {
            // You might include code here that prevents the form from being submitted while the upload is in
            // progress.  Then you'll want to put code in the Queue Complete handler to "unblock" the form
            var progress = new FileProgress(file, this.customSettings.progressTarget);
            progress.setStatus("Pending...");
            //progress.toggleCancel(true, this);

        } catch (ex) {
            this.debug(ex);
        }
    },

    fileQueueError:function (file, errorCode, message) {
        try {
            if (errorCode === SWFUpload.QUEUE_ERROR.QUEUE_LIMIT_EXCEEDED) {
                alert("You have attempted to queue too many files.\n" + (message === 0 ? "You have reached the upload limit." : "You may select " + (message > 1 ? "up to " + message + " files." : "one file.")));
                return;
            }

            var progress = new FileProgress(file, this.customSettings.progressTarget);
            progress.setError();
            progress.toggleCancel(false);

            switch (errorCode) {
                case SWFUpload.QUEUE_ERROR.FILE_EXCEEDS_SIZE_LIMIT:
                    progress.setStatus("File is too big.");
                    this.debug("Error Code: File too big, File name: " + file.name + ", File size: " + file.size + ", Message: " + message);
                    break;
                case SWFUpload.QUEUE_ERROR.ZERO_BYTE_FILE:
                    progress.setStatus("Cannot upload Zero Byte files.");
                    this.debug("Error Code: Zero byte file, File name: " + file.name + ", File size: " + file.size + ", Message: " + message);
                    break;
                case SWFUpload.QUEUE_ERROR.INVALID_FILETYPE:
                    progress.setStatus("Invalid File Type.");
                    this.debug("Error Code: Invalid File Type, File name: " + file.name + ", File size: " + file.size + ", Message: " + message);
                    break;
                case SWFUpload.QUEUE_ERROR.QUEUE_LIMIT_EXCEEDED:
                    alert("You have selected too many files.  " + (message > 1 ? "You may only add " + message + " more files" : "You cannot add any more files."));
                    break;
                default:
                    if (file !== null) {
                        progress.setStatus("Unhandled Error");
                    }
                    this.debug("Error Code: " + errorCode + ", File name: " + file.name + ", File size: " + file.size + ", Message: " + message);
                    break;
            }
        } catch (ex) {
            this.debug(ex);
        }
    },

    fileDialogComplete:function (numFilesSelected, numFilesQueued) {
        try {
            /*if (this.getStats().files_queued > 0) {
                document.getElementById(this.customSettings.cancelButtonId).disabled = false;
            }*/

            /* I want auto start and I can do that here */
            this.startUpload();
        } catch (ex) {
            this.debug(ex);
        }
    },

    uploadStart:function (file) {
        try {
            /* I don't want to do any file validation or anything,
             * I'll just update the UI and return true to indicate that the
             * upload should start
             */
            var progress = new FileProgress(file, this.customSettings.progressTarget);
            progress.setStatus("Uploading...");
            progress.toggleCancel(true, this);
        }
        catch (ex) {
        }

        return true;
    },

    uploadProgress:function (file, bytesLoaded, bytesTotal) {

        try {
            var percent = Math.ceil((bytesLoaded / bytesTotal) * 100);

            var progress = new FileProgress(file, this.customSettings.progressTarget);
            progress.setProgress(percent);
            progress.setStatus("Uploading...");
        } catch (ex) {
            this.debug(ex);
        }
    },
    bgImageUploadSuccess:function (file, serverData) {
        try {
            var progress = new FileProgress(file, this.customSettings.progressTarget);
            progress.setComplete();
            progress.setStatus("Complete.");
            progress.toggleCancel(false);
            var responseData = jQuery.parseJSON(serverData);

            if (responseData.success) {
                tt.message('', responseData.message);
                var assetFilename = responseData.filename;

                $('#page-bg-image').attr('src', '/<?= Bootstrap::getFrontendBasePath();?><?= Bootstrap::getConfig()->backend->assets->foldername ?>/' + assetFilename);

            } else {
                tt.onGlobalRPCError(responseData.error);
            }
        } catch (ex) {
            this.debug("exception:");
            this.debug(ex);
        }
    },
    uploadSuccess:function (file, serverData) {
        var assetTplImage = '<div style="overflow:hidden;font-size: 0.7em;border-bottom: 1px dotted #333333; clear: right; padding-bottom: 1em; margin-bottom: 1em;">' +
            '<img src="/<?= Bootstrap::getFrontendBasePath() ?>{IMG_PATH}" alt="{IMG_PATH}"  style="float: right;" class="thumbnail">' +
            '<p style="margin:0;"><strong>Original filename: :</strong> {IMG_ORIGINAL_FILENAME}</p>' +
            '<p style="margin:0;"><strong>Thumbnail filename: :</strong> {IMG_THUMBNAIL_FILENAME}</p>' +
            '<p style="margin:0;"><strong>Width:</strong> {IMG_WIDTH}</p>' +
            '<p style="margin:0;"><strong>Height:</strong> {IMG_HEIGHT}</p>' +
            '<p style="margin:0;"><strong>Thumbnail width:</strong> {IMG_THUMBNAIL_WIDTH}</p>' +
            '<p style="margin:0;"><strong>Thumbnail height:</strong> {IMG_THUMBNAIL_HEIGHT}</p>' +
            '<p style="margin:0;"><strong>Path:</strong> {IMG_PATH}</p>' +
            '<p style="margin:0;"><strong>Thumbnail path:</strong> {IMG_THUMBNAIL_PATH}</p>' +
            '<p style="margin:0;"><strong>Category:</strong> {IMG_CATEGORY}</p>' +
            '</div>';

        try {
            var progress = new FileProgress(file, this.customSettings.progressTarget);
            progress.setComplete();
            progress.setStatus("Complete.");
            progress.toggleCancel(false);
            var responseData = jQuery.parseJSON(serverData);

            if (responseData.success) {
                tt.message('', responseData.message);
                var assetObj = responseData.uploaded;
                if (assetObj.category == 'bilder') {
                    var assetHTML = assetTplImage;
                    for (var key in assetObj) {
                        var replace = new RegExp('{IMG_' + key.toUpperCase() + '}', "g");
                        assetHTML = assetHTML.replace(replace, assetObj[key]);
                    }
                    $('#asset-list-' + responseData.contentId).prepend(assetHTML);
                }
            } else {
                tt.onGlobalRPCError(responseData.error);
            }


        } catch (ex) {
            this.debug(ex);
        }
    },

    uploadComplete:function (file) {
        try {
            /*  I want the next upload to continue automatically so I'll call startUpload here */
            if (this.getStats().files_queued === 0) {
                document.getElementById(this.customSettings.cancelButtonId).disabled = true;
            } else {
                this.startUpload();
            }
        } catch (ex) {
            this.debug(ex);
        }
    },

    uploadError:function (file, errorCode, message) {
        try {
            var progress = new FileProgress(file, this.customSettings.progressTarget);
            progress.setError();
            progress.toggleCancel(false);

            switch (errorCode) {
                case SWFUpload.UPLOAD_ERROR.HTTP_ERROR:
                    progress.setStatus("Upload Error: " + message);
                    this.debug("Error Code: HTTP Error, File name: " + file.name + ", Message: " + message);
                    break;
                case SWFUpload.UPLOAD_ERROR.MISSING_UPLOAD_URL:
                    progress.setStatus("Configuration Error");
                    this.debug("Error Code: No backend file, File name: " + file.name + ", Message: " + message);
                    break;
                case SWFUpload.UPLOAD_ERROR.UPLOAD_FAILED:
                    progress.setStatus("Upload Failed.");
                    this.debug("Error Code: Upload Failed, File name: " + file.name + ", File size: " + file.size + ", Message: " + message);
                    break;
                case SWFUpload.UPLOAD_ERROR.IO_ERROR:
                    progress.setStatus("Server (IO) Error");
                    this.debug("Error Code: IO Error, File name: " + file.name + ", Message: " + message);
                    break;
                case SWFUpload.UPLOAD_ERROR.SECURITY_ERROR:
                    progress.setStatus("Security Error");
                    this.debug("Error Code: Security Error, File name: " + file.name + ", Message: " + message);
                    break;
                case SWFUpload.UPLOAD_ERROR.UPLOAD_LIMIT_EXCEEDED:
                    progress.setStatus("Upload limit exceeded.");
                    this.debug("Error Code: Upload Limit Exceeded, File name: " + file.name + ", File size: " + file.size + ", Message: " + message);
                    break;
                case SWFUpload.UPLOAD_ERROR.SPECIFIED_FILE_ID_NOT_FOUND:
                    progress.setStatus("File not found.");
                    this.debug("Error Code: The file was not found, File name: " + file.name + ", File size: " + file.size + ", Message: " + message);
                    break;
                case SWFUpload.UPLOAD_ERROR.FILE_VALIDATION_FAILED:
                    progress.setStatus("Failed Validation.  Upload skipped.");
                    this.debug("Error Code: File Validation Failed, File name: " + file.name + ", File size: " + file.size + ", Message: " + message);
                    break;
                case SWFUpload.UPLOAD_ERROR.FILE_CANCELLED:
                    if (this.getStats().files_queued === 0) {
                        document.getElementById(this.customSettings.cancelButtonId).disabled = true;
                    }
                    progress.setStatus("Cancelled");
                    progress.setCancelled();
                    break;
                case SWFUpload.UPLOAD_ERROR.UPLOAD_STOPPED:
                    progress.setStatus("Stopped");
                    break;
                default:
                    progress.setStatus("Unhandled Error: " + error_code);
                    this.debug("Error Code: " + errorCode + ", File name: " + file.name + ", File size: " + file.size + ", Message: " + message);
                    break;
            }
        } catch (ex) {
            this.debug(ex);
        }
    }
};

tt.initBgImgUploader = function(ident) {
    var bgImageUploader = new SWFUpload({
        // debug: true,
        // Backend Settings
        upload_url:'/<?= Bootstrap::getBasePath() ?>index.php?show='+ident+'&do=uploadBgImage',
        post_params:{
            "PHPSESSID" : "<?= session_id();?>",
            'timestamp':'<?= $timestamp ?>',
            token:'<?= $token ?>',
            uploadBgImage:1,
            identifier: ident
        },

        // File Upload Settings
        file_size_limit:"2048", // 100MB
        file_types:"*.*",
        file_types_description:"Bild Dateien",
        file_upload_limit:"10",
        file_queue_limit:"0",

        // Event Handler Settings (all my handlers are in the Handler.js file)
        file_dialog_start_handler:tt.swfupload.fileDialogStart,
        file_queued_handler:tt.swfupload.fileQueued,
        file_queue_error_handler:tt.swfupload.fileQueueError,
        file_dialog_complete_handler:tt.swfupload.fileDialogComplete,
        upload_start_handler:tt.swfupload.uploadStart,
        upload_progress_handler:tt.swfupload.uploadProgress,
        upload_error_handler:tt.swfupload.uploadError,
        upload_success_handler:tt.swfupload.bgImageUploadSuccess,
        upload_complete_handler:tt.swfupload.uploadComplete,

        // Button Settings
        button_image_url:"/<?= Bootstrap::getBasePath() ?>img/SmallSpyGlassWithTransperancy_17x18.png",
        button_placeholder_id:"button-placeholder-bgImage",
        button_width:220,
        button_height:22,
        button_text:'<span class="swfButton">Bilder auswählen <span class="swfButtonSmall">(2 MB Max)</span></span>',
        button_text_style:'.swfButton { font-family: Helvetica, Arial, sans-serif; font-size: 12pt; } .swfButtonSmall { font-size: 10pt; }',
        button_text_top_padding:0,
        button_text_left_padding:18,
        button_window_mode:SWFUpload.WINDOW_MODE.TRANSPARENT,
        button_cursor:SWFUpload.CURSOR.HAND,


        // Flash Settings
        flash_url:"/<?= Bootstrap::getBasePath() ?>swf/swfupload.swf",
        custom_settings:{
            progressTarget:"fsUploadProgress-bgImage"
        }
    });

};


// general functions
/**
 * displays the current call stack
 */
if ('function' != typeof window.Stack) {
    window.Stack = function(){
        try {
            throw Error()
        } catch(ex){
            return ex.stack
        }
    }
}

$(function() {
    $("#accordion").accordion({
        navigation: true,
        navigationFilter: function(){
            var ident = document.location.href.split('show=')[1].split('&')[0];
            return this.id.split('header_')[1] == ident;
        }
    });
    tt.init();
//    tt.postRequestHandler();
});
