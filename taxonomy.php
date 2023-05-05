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
                <?php if (get_official_document_url()): ?>
                    <article class="post-document">
                        <a href="<?php echo get_official_document_url(); ?>" target="_blank">
                            公式ドキュメント
                        </a>
                    </article>
                <?php endif; ?>

                <div class="wrapper">
                    <h2 class="post-list-title">まとめ投稿</h2>
                    <div class="post-list">
                        <?php
                            // 現在の投稿タイプを取得
                            $post_type = get_post_type();
                            // 現在のタクソノミーの情報を取得
                            $queried_object = get_queried_object();

                            $args = array(
                                'post_type' => $post_type,
                                'tax_query' => array(
                                    'relation' => 'AND',
                                    array(
                                        'taxonomy' => 'category_' . $post_type,
                                        'field' => 'slug',
                                        'terms' => $queried_object->slug,
                                    ),
                                    array(
                                        'taxonomy' => 'tag_backend',
                                        'field' => 'slug',
                                        'terms' => 'summary',
                                    ),
                                )
                            );
                            $the_query = new WP_Query( $args );

                            if ( $the_query->have_posts() ) {
                                while ( $the_query->have_posts() ) {
                                    $the_query->the_post();
                        ?>
                            <!-- 投稿の情報を出力するコード -->
                            <?php echo get_template_part( '/assets/components/post_item' ); ?>
                        <?php
                                }
                            } else {
                                // 投稿が存在しない場合の処理
                            }
                            wp_reset_postdata();
                        ?>
                    </div>

                    <h2 class="post-list-title">新着投稿</h2>
                    <div class="post-list">
                        <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
                            <?php echo get_template_part( '/assets/components/post_item' ); ?>
                        <?php endwhile; else : ?>
                            <p>記事はありません。</p>
                        <?php endif; ?>
                    </div>
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