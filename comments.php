<?php
/**
 * The template for displaying comments
 */

if (post_password_required()) {
    return;
}
?>

<div id="comments" class="comments-area mt-16 pt-12 border-t border-gray-100 dark:border-gray-800">

    <?php if (have_comments()): ?>
        <div class="flex items-center gap-3 mb-10">
            <i class="ri-chat-3-line text-3xl text-primary"></i>
            <h2 class="text-2xl font-black">
                <?php
                $modernnews_comment_count = get_comments_number();
                if ('1' === $modernnews_comment_count) {
                    printf(
                        /* translators: 1: title. */
                        esc_html__('Satu Komentar di &ldquo;%1$s&rdquo;', 'modernnews'),
                        '<span>' . get_the_title() . '</span>'
                    );
                } else {
                    printf(
                        /* translators: 1: comment count number, 2: title. */
                        esc_html(_nx('%1$s Komentar', '%1$s Komentar', $modernnews_comment_count, 'comments title', 'modernnews')),
                        number_format_i18n($modernnews_comment_count),
                        '<span>' . get_the_title() . '</span>'
                    );
                }
                ?>
            </h2>
        </div>

        <ol class="space-y-10 mb-12">
            <?php
            wp_list_comments(
                array(
                    'style' => 'ol',
                    'short_ping' => true,
                    'avatar_size' => 48,
                    'callback' => null // Using default but with Tailwind targeting in main.css
                )
            );
            ?>
        </ol>

        <?php
        the_comments_navigation(array(
            'prev_text' => '<span class="flex items-center gap-2"><i class="ri-arrow-left-s-line"></i> ' . esc_html__('Komentar Lama', 'modernnews') . '</span>',
            'next_text' => '<span class="flex items-center gap-2">' . esc_html__('Komentar Baru', 'modernnews') . ' <i class="ri-arrow-right-s-line"></i></span>',
        ));

        if (!comments_open()):
            ?>
            <div
                class="bg-gray-50 dark:bg-gray-900 p-6 rounded-2xl text-gray-500 text-center font-medium border border-gray-100 dark:border-gray-800">
                <i class="ri-chat-off-line mr-2"></i>
                <?php esc_html_e('Kolom komentar telah ditutup.', 'modernnews'); ?>
            </div>
            <?php
        endif;

    endif; // Check for have_comments().
    ?>

    <?php
    $commenter = wp_get_current_commenter();
    $req = get_option('require_name_email');
    $aria_req = ($req ? " aria-required='true'" : '');

    $comment_args = array(
        'title_reply_before' => '<div class="flex items-center gap-3 mb-8"><i class="ri-pencil-line text-2xl text-primary"></i><h3 id="reply-title" class="comment-reply-title text-xl font-black">',
        'title_reply_after' => '</h3></div>',
        'fields' => array(
            'author' => '<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">' .
                '<div>' .
                '<label for="author" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Nama Lengkap ' . ($req ? '<span class="text-primary">*</span>' : '') . '</label>' .
                '<input id="author" name="author" type="text" value="' . esc_attr($commenter['comment_author']) . '" size="30" class="w-full rounded-xl border-gray-200 bg-gray-50 dark:bg-gray-800 dark:border-gray-700 focus:border-primary focus:ring-primary h-12 px-4 transition-all" ' . $aria_req . ' placeholder="Nama Anda" />' .
                '</div>',
            'email' => '<div>' .
                '<label for="email" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Alamat Email ' . ($req ? '<span class="text-primary">*</span>' : '') . '</label>' .
                '<input id="email" name="email" type="email" value="' . esc_attr($commenter['comment_author_email']) . '" size="30" class="w-full rounded-xl border-gray-200 bg-gray-50 dark:bg-gray-800 dark:border-gray-700 focus:border-primary focus:ring-primary h-12 px-4 transition-all" ' . $aria_req . ' placeholder="email@contoh.com" />' .
                '</div></div>',
            'url' => '<div class="mb-6">' .
                '<label for="url" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Situs Web</label>' .
                '<input id="url" name="url" type="url" value="' . esc_attr($commenter['comment_author_url']) . '" size="30" class="w-full rounded-xl border-gray-200 bg-gray-50 dark:bg-gray-800 dark:border-gray-700 focus:border-primary focus:ring-primary h-12 px-4 transition-all" placeholder="https://..." />' .
                '</div>',
        ),
        'comment_field' => '<div class="mb-8">' .
            '<label for="comment" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Komentar Anda</label>' .
            '<textarea id="comment" name="comment" cols="45" rows="6" class="w-full rounded-2xl border-gray-200 bg-gray-50 dark:bg-gray-800 dark:border-gray-700 focus:border-primary focus:ring-primary p-4 transition-all" required placeholder="Tuliskan pendapat Anda di sini..."></textarea>' .
            '</div>',
        'submit_button' => '<button name="%1$s" type="submit" id="%2$s" class="%3$s group inline-flex items-center gap-2 bg-primary text-white font-bold py-4 px-10 rounded-xl hover:bg-opacity-90 transition-all shadow-lg shadow-primary/20"><span>%4$s</span><i class="ri-send-plane-fill group-hover:translate-x-1 transition-transform"></i></button>',
        'class_submit' => 'submit',
        'label_submit' => 'Kirim Komentar',
    );

    comment_form($comment_args);
    ?>

</div>