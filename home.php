<?php
    if (!defined('ABSPATH')) exit;
    get_header();
?>

    <div class="wrapper">
        <h1 class="page-title">投稿一覧</h1>
    </div>

    <div class="wrapper">
        <div class="grid">
            <main class="main-contents margin-auto">
                <div class="wrapper">
                <?php
                    $post_types = array( 'development', 'design', 'frontend', 'backend', 'tool', 'essay' );
                    foreach ( $post_types as $post_type ) {
                        $terms = get_terms( array(
                            'taxonomy' => 'category_' . $post_type,
                            'hide_empty' => false,
                        ) );
                        if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
                            foreach ( $terms as $term ) {
                                $args = array(
                                    'post_type' => $post_type,
                                    'posts_per_page' => 3,
                                    'tax_query' => array(
                                        array(
                                            'taxonomy' => 'category_' . $post_type,
                                            'field' => 'slug',
                                            'terms' => $term->slug
                                        )
                                    )
                                );
                                $the_query = new WP_Query( $args );
                                if ( $the_query->have_posts() ) : ?>
                                    <div class="wrapper">
                                        <div class="post-list-title-wrapper flex-row-between">
                                            <h2 class="post-list-title"><?php echo $term->name; ?></h2>
                                            <a href="<?php echo get_term_link($term); ?>" class="link-view-more">もっと見る</a>
                                        </div>
                                        <div class="post-list">
                                            <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
                                                <article class="post-item">
                                                    <?php echo get_template_part( '/assets/components/post_item' ); ?>
                                                </article>
                                            <?php endwhile; ?>
                                        </div>
                                    </div>
                                    <?php wp_reset_postdata();
                                endif;
                            }
                        }
                    }
                ?>
               </div>
            </main>
            <aside class="sidebar-contents">
                <?php get_sidebar(); ?>
            </aside>
        </div>
    </div>

<?php get_footer(); ?>