<?php
/**
 * The sidebar containing the main widget area
 */

if (!is_active_sidebar('main-sidebar')) {
    return;
}
?>

<aside id="secondary" class="widget-area lg:col-span-4 space-y-8">

    <!-- Wrapper for Sticky Functionality -->
    <div class="sticky top-24 space-y-8">
        <?php
        // Sidebar Ad Slot (300x250)
        if (function_exists('modernnews_get_ad')) {
            $sidebar_ad = modernnews_get_ad('sidebar_ad');
            if (!empty($sidebar_ad)) {
                echo '<div class="modernnews-ad-sidebar flex justify-center mb-6">';
                echo $sidebar_ad;
                echo '</div>';
            }
        }

        dynamic_sidebar('main-sidebar');
        ?>
    </div>
</aside>