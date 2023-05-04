<?php if (!defined('ABSPATH')) exit; ?>

<ul class="site-sidebar">
  <!-- ▼ここから検索ボックス -->
  <!-- <li class="widget widget_block">
    <h3>検索</h3>
  </li>
  <li class="widget widget_block widget_search">
    <form role="search" method="get" id="searchform" class="wp-block-search__button-outside wp-block-search__text-button wp-block-search" action="<?php echo esc_url(home_url('/')); ?>">
      <div>
        <label class="wp-block-search__input-1" for="s"><?php _x('Search for:', 'label'); ?></label>
        <div class="wp-block-search__inside-wrapper">
          <input class="wp-block-search__input" type="text" value="<?php echo get_search_query(); ?>" name="s" id="s">
          <button class="wp-block-search__button" type="submit" id="searchsubmit"><?php echo esc_attr_x('Search', 'submit button'); ?></button>
        </div>
      </div>
    </form>
  </li> -->
  <!-- ▲ここまで検索ボックス -->

  <!-- ▼ここから最新投稿 -->
  <?php
  global $post_types;
  $args = array(
    // 'post_type' => 'post', // 投稿タイプのスラッグを指定
    'post_type' => $post_types, // 投稿タイプのスラッグを指定
    'post_status' => 'publish', // 公開済の投稿を指定
    'posts_per_page' => 5, // 投稿件数の指定(-1は全件表示)
  );
  $the_query = new WP_Query($args);
  if ($the_query->have_posts()) { // 記事が取得できたか
  ?>
    <li class="widget widget_block">
      <h3>最新の投稿</h3>
    </li>
    <li class="widget widget_block widget_recent_entries">
      <ul class="wp-block-latest-posts__list wp-block-latest-posts sidebar-post-lists">
        <?php
        while ($the_query->have_posts()) {  // ループ（while）開始
          $the_query->the_post();
        ?>
          <li class="sidebar-post-list">
            <a class="sidebar-post-link" href="<?php the_permalink(); // 記事リンク ?>">
              <span class="sidebar-post-thumb">
                <?php if ( has_post_thumbnail() ) : ?>
                  <img src="<?php the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>">
                <?php else : ?>
                  <img src="<?php echo esc_url(get_theme_file_uri('/assets/images/ph.png')); ?>" alt="<?php the_title(); ?>" >
                <?php endif; ?>
              </span>
              <span class="sidebar-post-body">
                <time datetime="<?php echo get_the_date('Y-m-d'); //ハイフン区切りの投稿日 ?>">
                  <?php echo get_the_date('Y.m.d'); //ドット区切りの投稿日 ?>
                </time><br>
                <?php the_title(); // 記事タイトル ?>
              </span>
            </a>
          </li>
        <?php
        } // ループ（while）終了
        ?>
      </ul>
    </li>
  <?php
  }
  wp_reset_postdata();
  ?>
  <!-- ▲ここまで最新投稿 -->

  <!-- ▼ここからカテゴリー型カスタムタクソノミー -->
  <li class="widget widget_block">
    <h3>カテゴリー</h3>
  </li>
  <li class="widget widget_block widget_categories">
    <ul class="wp-block-categories-list wp-block-categories">
      <?php
      global $post_types;
      foreach ( $post_types as $post_type ) {
        $terms = get_terms('category_' . $post_type);
        foreach ($terms as $term) {
          echo '<li class="cat-item">
                  <a href="' . get_term_link($term) . '">' . $term->name . ' (' . $term->count . ')</a>
                </li>';
        }
      }
      ?>
    </ul>
  </li>
  <!-- ▲ここまでカテゴリー型カスタムタクソノミー -->

  <!-- ▼ここからタグ型カスタムタクソノミー -->
  <li class="widget widget_block">
    <h3>タグ</h3>
  </li>
  <li class="widget widget_block widget_categories">
    <ul class="wp-block-categories-list wp-block-categories">
      <?php
      global $post_types;
      foreach ( $post_types as $post_type ) {
        $terms = get_terms('tag_' . $post_type);
        foreach ($terms as $term) {
          echo '<li class="cat-item">
                  <a href="' . get_term_link($term) . '">' . $term->name . ' (' . $term->count . ')</a>
                </li>';
        }
      }
      ?>
    </ul>
  </li>
  <!-- ▲ここまでタグ型カスタムタクソノミー -->
</ul>