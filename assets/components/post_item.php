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
        <div class="post-tag-terms">
            <?php echo custom_taxonomies_terms_links(); ?>
        </div>
    </header>
</article>