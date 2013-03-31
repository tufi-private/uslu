<div class="ym-wrapper">
        <div class="ym-wbox">
            <?php if (\Bootstrap::verifySession() !== true): ?>
            <?php /* dirty template hack for the login-box placement:  */ ?>
            <?= $content ?>
            <?php else : ?>
            <section class="ym-grid linearize-level-1">
                <aside class="ym-g25 ym-gl">
                    <div class="ym-gbox-left ym-clearfix">
                        <!-- menu  left -->
                        <?php include_once 'menu-left.php'; ?>
                        <!-- end menu left -->
                    </div>
                </aside>

                <article class="ym-g75 ym-gr content">
                    <div class="ym-gbox-left ym-clearfix">
                        <?= $content ?>
                    </div>
                </article>
            </section>
            <?php endif; ?>
        </div>
    </div>