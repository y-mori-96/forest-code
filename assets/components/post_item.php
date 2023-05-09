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
        <?php echo get_template_part( '/assets/components/post_time_date' ); ?>
        <div class="post-tag-terms">
            <?php echo custom_taxonomies_terms_links(); ?>
        </div>
    </header>
</article>