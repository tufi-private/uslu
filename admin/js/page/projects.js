tt.projects = {
    pageHandler:function () {
        var oldEl;

        var updateTitle = function (objId, newVal, father) {
            tt.callRPC(
                'projects',
                'updateContentTitle',
                {
                    title:newVal,
                    id:objId
                }, function (response) {
                    var responseData = jQuery.parseJSON(response);
                    if (responseData.error) {
                        var diag = tt.onGlobalRPCError.apply(this, [responseData.error]);
                        diag.on('dialogclose', function () {
                            father.replaceWith(oldEl);
                        });
                        return;
                    }
                    oldEl.text(newVal);
                    father.replaceWith(oldEl);
                }
            )
        };

        var handleTitleChange = function (el) {
            var objId = el.id.split('-')[2];
            var newVal = $(el).val();
            var father = $(el).parent();
            updateTitle(objId, newVal, father);
        };

        $('h5[id^="title-object-"]').live(
            'click',
            function (event) {
                var value = $(this).text();
                oldEl = $(this);
                var objId = this.id.split('-')[2];
                var inputTpl = '<div class="titleEdit"><input type="text" name="title-' + objId + '" id="input-title-' + objId + '" value="' + value + '"  /> <button class="ym-button ym-edit" id="btn-title-' + objId + '">OK</button> </div>';
                $(this).replaceWith(inputTpl);
            }
        );

        $('[id^="input-title-"]').live("keypress", function (e) {
            if (e.which == 13) {
                handleTitleChange(this);
            }
        });
        $('[id^="btn-title-"]').live("click", function (e) {
            handleTitleChange($(this).siblings()[0]);
        });

        var tabs = $('div[id^="tabs"]');
        var uploader = new Array(tabs.length);

        tabs.each(function (index, el) {
            uploader[index] = new SWFUpload({
//                debug: true,
                // Backend Settings
                upload_url:'/<?= Bootstrap::getBasePath() ?>index.php?show=projects&do=upload',
                post_params:{
                    'timestamp':'<?= $timestamp ?>',
                    token:'<?= $token ?>',
                    "PHPSESSID" : "<?= session_id();?>",
                    contentId:(function () {
                        var id = $(el).find('input[name="contentId"]').val();
                        return id;
                    })()
                },

                // File Upload Settings
                file_size_limit:"2048", // 100MB
                file_types:"*.*",
                file_types_description:"All Files",
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
                upload_success_handler:tt.swfupload.uploadSuccess,
                upload_complete_handler:tt.swfupload.uploadComplete,

                // Button Settings
                button_image_url:"/<?= Bootstrap::getBasePath() ?>img/SmallSpyGlassWithTransperancy_17x18.png",
                button_placeholder_id:"spanButtonPlaceholder"+index,
                button_width:220,
                button_height:22,
                button_text:'<span class="swfButton">Bilder auswählen <span class="swfB    uttonSmall">(2 MB Max)</span></span>',
                button_text_style:'.swfButton { font-family: Helvetica, Arial, sans-serif; font-size: 12pt; } .swfButtonSmall { font-size: 10pt; }',
                button_text_top_padding:0,
                button_text_left_padding:18,
                button_window_mode:SWFUpload.WINDOW_MODE.TRANSPARENT,
                button_cursor:SWFUpload.CURSOR.HAND,


                // Flash Settings
                flash_url:"/<?= Bootstrap::getBasePath() ?>swf/swfupload.swf",

                custom_settings:{
                    progressTarget:"fsUploadProgress" + index
                }
            });

        });

        $('button[name="delete_asset"]').on('click', function (event) {
            event.stopPropagation();
            event.preventDefault();
            confirmDialog = tt.confirm('', '', $(this).parents('form'));
        });

        tt.initBgImgUploader("projects");
    }

};
$(document).ready(tt.projects.pageHandler);
