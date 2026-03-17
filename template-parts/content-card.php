<?php
/**
 * Template part for displaying posts in a standard card layout
 */
$layout = isset($args['layout']) ? $args['layout'] : 'list';
$card_classes = 'news-card ' . ($layout === 'grid' ? 'news-card-grid' : 'news-card-list');
?>
<article id="post-<?php the_ID(); ?>" <?php post_class($card_classes); ?>>
    <div class="news-card-image">
        <a href="<?php the_permalink(); ?>">
            <?php if (has_post_thumbnail()): ?>
                <?php the_post_thumbnail('medium_large'); ?>
            <?php else: ?>
                <div style="background-color: #eee; width: 100%; height: 100%;"></div>
            <?php endif; ?>
        </a>
    </div>
    <div class="news-card-content">
        <div class="news-card-meta">
            <?php
            $categories = get_the_category();
            if (!empty($categories)) {
                echo '<span class="text-primary">' . esc_html($categories[0]->name) . '</span>';
            }
            ?>
            <span class="sep"> &bull; </span>
            <span class="date"><?php echo get_the_date(); ?></span>
        </div>
        <h3 class="news-card-title">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h3>
        <?php if (modernnews_get_option('archive_show_excerpt', true)): ?>
        <div class="news-card-excerpt">
            <?php the_excerpt(); ?>
        </div>
        <a href="<?php the_permalink(); ?>" class="btn-read-more">Baca Selengkapnya</a>
        <?php endif; ?>
    </div>
</article>