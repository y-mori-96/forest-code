<?php
    if (!defined('ABSPATH')) exit;
    get_header();
?>

    <div class="wrapper">
        <h1 class="page-title"><?php the_archive_title(); ?></h1>
    </div>

    <div class="wrapper">
        <div class="grid">
            <main class="main-contents">
                <div class="post-list">
                    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
                        <article class="post-item">
                            <a href="<?php echo esc_url(get_permalink()); ?>">
                                <?php if(has_post_thumbnail()): ?>
                                    <?php the_post_thumbnail('medium'); ?>
                                <?php else: ?>
                                    <img src="<?php echo esc_url(get_theme_file_uri('/assets/images/ph.png')); ?>" alt="" class="wp-post-image">
                                <?php endif; ?>
                            </a>
                            <header class="post-header">
                                <h2 class="post-title">
                                    <a href="<?php echo esc_url(get_permalink()); ?>"><?php the_title(); ?></a>
                                </h2>
                                <time class="post-date" datetime="<?php echo get_the_date('Y-m-d'); ?>">公開日　　：<?php the_date(); ?><br>最終更新日：<?php the_modified_date(); ?></time>
                                <?php the_category(); ?>

                                <?php $terms = get_the_terms($post->ID, 'custom_taxonomy'); ?>
                                <?php if ($terms && !is_wp_error($terms)): ?>
                                    <ul class="post-categories">
                                        <?php foreach ($terms as $term): ?>
                                            <li class="post-category">
                                                <?php echo esc_html($term->slug); ?>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php endif; ?>
                            </header>
                        </article>
                    <?php endwhile; else : ?>
                        <p>記事はありません。</p>
                    <?php endif; ?>
                </div>

                <div class="nav-links">
                    <?php posts_nav_link(' ', '← 新しい投稿', '過去の投稿 →'); ?>
                </div>
            </main>

            <aside class="sidebar-contents">
                <?php get_sidebar(); ?>
            </aside>
        </div>
    </div>

<?php get_footer(); ?>