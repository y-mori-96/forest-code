<?php
    if (!defined('ABSPATH')) exit;
    get_header();
?>

    <main class="main-contents wrapper">
        <div class="post-list page-post-list margin-auto">
            <article class="post-item">
                <header class="post-header">
                    <h1 class="post-title">
                        <?php the_title(); ?>
                    </h1>
                </header>
                <div class="post-content wrapper">
                    <?php the_content(); ?>
                </div>
            </article>
        </div>
    </main>

<?php get_footer(); ?>