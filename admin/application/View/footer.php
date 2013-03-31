</div><!--end of main content-->
<footer>
    <div class="ym-wrapper">
        <div class="ym-wbox">
            <p>© uslu.com 2012 &ndash; <a href="http://www.yaml.de">YAML</a></p>
        </div>
    </div>
</footer>
<!-- JavaScript at the bottom for fast page loading -->

<!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if offline -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="/<?= Bootstrap::getBasePath() ?>js/libs/jquery-1.8.2.min.js"><\/script>')</script>
<script type="text/javascript" src="/<?= Bootstrap::getBasePath() ?>js/libs/jquery-ui-1.9.0.custom.min.js"></script>
<script src="/<?= Bootstrap::getBasePath() ?>js/plugins.js"></script>
<script src="/<?= Bootstrap::getBasePath() ?>js/script.js.php?l=<?= $this->identifier ?>"></script>
<script src="/<?= Bootstrap::getBasePath() ?>js/libs/swfupload.js" type="text/javascript"></script>


<script type="text/javascript">
    $(function () {
        var messageSuccess = '<?= $this->messageSuccess ?>';
        var messageError = '<?= $this->messageError?>';

        var forward = '<?= $this->forward?>';
        var diag;
        if (messageSuccess) {
            diag = tt.message(null, messageSuccess);
        }

        if (messageError) {
            diag = tt.message(null, messageError);
        }
        if (forward && diag) {
            diag.bind("dialogclose", function (event, ui) {
                document.location.href = forward;
            })
        }
    });
</script>
<!-- end scripts -->
<!-- full skip link functionality in webkit browsers -->
<script src="/<?= Bootstrap::getBasePath() ?>css/yaml/core/js/yaml-focusfix.js"></script>
</body>
</html>
