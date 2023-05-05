<?php
    if (!defined('ABSPATH')) exit;
    get_header();
?>


    <div class="wrapper">
        <div class="grid">
            <main class="main-contents">
                <div class="post-list">
                    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
                        <article class="single-post-item">
                            <header class="single-post-header">
                                <h1 class="post-title">
                                    <?php the_title(); ?>
                                </h1>
                                <!-- 公開日/更新日 -->
                                <div class="single-post-date-wrapper">
                                    <time class="single-post-date" datetime="<?php echo get_the_date('Y-m-d'); ?>">公開日：<?php the_date(); ?>　　最終更新日：<?php the_modified_date(); ?></time>
                                </div>
                                <!-- サムネイル -->
                                <div class="post-thumbnail">
                                    <?php if(has_post_thumbnail()): ?>
                                        <?php the_post_thumbnail('medium_large'); ?>
                                    <?php else : ?>
                                        <img src="<?php echo esc_url(get_theme_file_uri('/assets/images/ph.png')); ?>" alt="<?php the_title(); ?>" >
                                    <?php endif; ?>
                                </div>
                            </header>
                            <!-- 本文 -->
                            <div class="post-content wrapper">
                                <?php the_content(); ?>
                            </div>

                            <!-- タグ -->
                            <!-- <footer class="post-footer wrapper"> -->
                            <footer class="wrapper shingle-post-tag-terms">
                                <?php echo custom_taxonomies_terms_links(); ?>
                            </footer>
                        </article>
                    <?php endwhile; else : ?>
                        <p>記事はありません。</p>
                    <?php endif; ?>
                </div>
            </main>

            <aside class="sidebar-contents">
                <?php get_sidebar(); ?>
            </aside>
        </div>
    </div>

<?php get_footer(); ?>