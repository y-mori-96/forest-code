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

                <div class="wrapper">
                    <?php
                        // 現在の投稿タイプを取得
                        $post_type = get_post_type();
                        // カテゴリー型のタクソノミーを取得
                        $taxonomy = 'category_' . $post_type;
                        // カテゴリー型のタクソノミーあるタームを取得
                        $term_args = array(
                            'taxonomy'   => $taxonomy,
                            'hide_empty' => false,
                        );
                        $terms = get_terms( $term_args );

                        foreach ( $terms as $term ) {
                            $args = array(
                                'post_type'      => $post_type,
                                'posts_per_page' => 3,
                                'tax_query'      => array(
                                    array(
                                        'taxonomy' => $taxonomy,
                                        'field'    => 'slug',
                                        'terms'    => $term->slug,
                                    ),
                                ),
                            );
                            $the_query = new WP_Query( $args );
                    ?>
                        <div class="post-list-title-wrapper flex-row-between">
                            <h2 class="post-list-title"><?php echo $term->name; ?></h2>
                            <a href="<?php echo get_term_link($term); ?>" class="link-view-more">もっと見る</a>
                        </div>
                        <div class="post-list">
                            <?php if ( $the_query->have_posts() ) : while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
                                <article class="post-item">
                                    <?php echo get_template_part( '/assets/components/post_item' ); ?>
                                </article>
                            <?php endwhile; else : ?>
                                <p>記事はありません。</p>
                            <?php endif; wp_reset_postdata(); ?>
                        </div>
                    <?php } ?>
                </div>
            </main>

            <aside class="sidebar-contents">
                <?php get_sidebar(); ?>
            </aside>
        </div>
    </div>

<?php get_footer(); ?>