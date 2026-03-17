<?php
/**
 * Standard Search Form
 */
?>
<form role="search" method="get" class="relative flex items-center w-full"
    action="<?php echo esc_url(home_url('/')); ?>">
    <label for="search-field-<?php echo uniqid(); ?>"
        class="sr-only"><?php echo _x('Search for:', 'label', 'modernnews'); ?></label>
    <input type="search" id="search-field-<?php echo uniqid(); ?>"
        class="w-full bg-gray-100 dark:bg-gray-800 border-none rounded-full py-2.5 pl-5 pr-12 text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-primary placeholder:text-gray-400"
        placeholder="<?php echo esc_attr_x('Cari berita...', 'placeholder', 'modernnews'); ?>"
        value="<?php echo get_search_query(); ?>" name="s"
        aria-label="<?php echo esc_attr_x('Search terms', 'aria label', 'modernnews'); ?>" />
    <button type="submit" aria-label="<?php echo esc_attr_x('Submit Search', 'aria label', 'modernnews'); ?>"
        class="absolute right-1.5 w-8 h-8 bg-primary text-white rounded-full flex items-center justify-center hover:brightness-110 transition-all shadow-sm">
        <span class="material-symbols-outlined text-sm">search</span>
    </button>
</form>