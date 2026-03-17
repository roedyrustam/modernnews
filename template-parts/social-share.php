<?php
/**
 * Template Part: Social Share Buttons
 */

// Get current URL and Title
$post_url = urlencode(get_permalink());
$post_title = urlencode(get_the_title());

// Share Links
$facebook_url = "https://www.facebook.com/sharer/sharer.php?u={$post_url}";
$twitter_url = "https://twitter.com/intent/tweet?text={$post_title}&url={$post_url}";
$whatsapp_url = "https://api.whatsapp.com/send?text={$post_title}%20{$post_url}";
$linkedin_url = "https://www.linkedin.com/shareArticle?mini=true&url={$post_url}&title={$post_title}";

?>

<!-- Desktop: Floating Left -->
<div class="social-share-desktop hidden xl:flex fixed left-8 top-1/2 -translate-y-1/2 flex-col gap-3 z-40">
    <a href="<?php echo $facebook_url; ?>" target="_blank" rel="noopener noreferrer"
        class="w-10 h-10 flex items-center justify-center rounded-full bg-blue-600 text-white hover:scale-110 transition-transform shadow-md"
        title="Share on Facebook">
        <i class="ri-facebook-fill text-lg"></i>
    </a>
    <a href="<?php echo $twitter_url; ?>" target="_blank" rel="noopener noreferrer"
        class="w-10 h-10 flex items-center justify-center rounded-full bg-black text-white hover:scale-110 transition-transform shadow-md"
        title="Share on X">
        <i class="ri-twitter-x-fill text-lg"></i>
    </a>
    <a href="<?php echo $whatsapp_url; ?>" target="_blank" rel="noopener noreferrer"
        class="w-10 h-10 flex items-center justify-center rounded-full bg-green-500 text-white hover:scale-110 transition-transform shadow-md"
        title="Share on WhatsApp">
        <i class="ri-whatsapp-line text-lg"></i>
    </a>
    <a href="<?php echo $linkedin_url; ?>" target="_blank" rel="noopener noreferrer"
        class="w-10 h-10 flex items-center justify-center rounded-full bg-blue-700 text-white hover:scale-110 transition-transform shadow-md"
        title="Share on LinkedIn">
        <i class="ri-linkedin-fill text-lg"></i>
    </a>
</div>

<!-- Mobile: Fixed Bottom (Above current bottom nav if exists, or just minimal) -->
<div
    class="social-share-mobile xl:hidden w-full py-3 flex justify-center gap-4 bg-white dark:bg-zinc-900 border-t border-gray-100 dark:border-zinc-800">
    <span class="text-xs font-bold uppercase tracking-wider text-gray-400 self-center mr-2">Bagikan</span>
    <a href="<?php echo $facebook_url; ?>" target="_blank" rel="noopener noreferrer"
        class="w-8 h-8 flex items-center justify-center rounded-full bg-blue-100 text-blue-600 hover:bg-blue-600 hover:text-white transition-colors">
        <i class="ri-facebook-fill"></i>
    </a>
    <a href="<?php echo $twitter_url; ?>" target="_blank" rel="noopener noreferrer"
        class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-100 text-black hover:bg-black hover:text-white transition-colors">
        <i class="ri-twitter-x-fill"></i>
    </a>
    <a href="<?php echo $whatsapp_url; ?>" target="_blank" rel="noopener noreferrer"
        class="w-8 h-8 flex items-center justify-center rounded-full bg-green-100 text-green-600 hover:bg-green-600 hover:text-white transition-colors">
        <i class="ri-whatsapp-line"></i>
    </a>
</div>