<?php
/**
 * Template Part: Social Share Buttons (Horizontal Bar)
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

<div class="social-share-container my-10 py-6 border-y border-gray-100 dark:border-zinc-800 flex flex-col md:flex-row items-center justify-between gap-6">
    <div class="flex items-center gap-3">
        <div class="size-10 rounded-xl bg-primary/10 flex items-center justify-center text-primary">
            <i class="ri-share-forward-line text-xl"></i>
        </div>
        <div>
            <h4 class="font-bold text-sm dark:text-white">Bagikan Berita Ini</h4>
            <p class="text-xs text-gray-500">Bantu sebarkan informasi bermanfaat</p>
        </div>
    </div>

    <div class="flex items-center gap-3">
        <a href="<?php echo $facebook_url; ?>" target="_blank" rel="noopener noreferrer"
            class="size-11 flex items-center justify-center rounded-xl bg-[#1877F2] text-white hover:scale-110 transition-transform shadow-sm"
            title="Share on Facebook">
            <i class="ri-facebook-fill text-xl"></i>
        </a>
        <a href="<?php echo $twitter_url; ?>" target="_blank" rel="noopener noreferrer"
            class="size-11 flex items-center justify-center rounded-xl bg-black text-white hover:scale-110 transition-transform shadow-sm"
            title="Share on X">
            <i class="ri-twitter-x-fill text-xl"></i>
        </a>
        <a href="<?php echo $whatsapp_url; ?>" target="_blank" rel="noopener noreferrer"
            class="size-11 flex items-center justify-center rounded-xl bg-[#25D366] text-white hover:scale-110 transition-transform shadow-sm"
            title="Share on WhatsApp">
            <i class="ri-whatsapp-line text-xl"></i>
        </a>
        <a href="<?php echo $linkedin_url; ?>" target="_blank" rel="noopener noreferrer"
            class="size-11 flex items-center justify-center rounded-xl bg-[#0A66C2] text-white hover:scale-110 transition-transform shadow-sm"
            title="Share on LinkedIn">
            <i class="ri-linkedin-fill text-xl"></i>
        </a>
        <button onclick="navigator.clipboard.writeText('<?php echo get_permalink(); ?>').then(() => alert('Link berhasil disalin!'))"
            class="size-11 flex items-center justify-center rounded-xl bg-gray-100 dark:bg-zinc-800 text-gray-600 dark:text-gray-300 hover:bg-primary hover:text-white transition-all shadow-sm"
            title="Copy Link">
            <i class="ri-link text-xl"></i>
        </button>
    </div>
</div>