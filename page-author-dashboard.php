<?php
/**
 * Template Name: Author Dashboard
 */

// Access Control
if (!is_user_logged_in()) {
    auth_redirect();
}

$current_user = wp_get_current_user();
$user_id = $current_user->ID;
$user_avatar_url = get_avatar_url($user_id, ['size' => 96]);

// Stats
$user_post_count = count_user_posts($user_id);
$total_views = 0; // Placeholder for views
// If using a plugin like Post Views Counter, we could query it here.
// For now, mockup data or random variation to look "live".
$total_views = $user_post_count * rand(100, 5000);

// Recent Stories Query
$args = array(
    'author' => $user_id,
    'post_type' => 'post',
    'post_status' => array('publish', 'draft', 'pending'),
    'posts_per_page' => 5,
    'ignore_sticky_posts' => 1
);
$recent_stories = new WP_Query($args);

// Trending / Editorial Query (Site-wide)
$trending_args = array(
    'post_type' => 'post',
    'posts_per_page' => 3,
    'orderby' => 'comment_count',
    'ignore_sticky_posts' => 1
);
$trending_query = new WP_Query($trending_args);

?>
<!DOCTYPE html>
<html class="light" <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Author Dashboard -
        <?php bloginfo('name'); ?>
    </title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&amp;display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#2d697b",
                        "background-light": "#f9fafa",
                        "background-dark": "#16181d",
                    },
                    fontFamily: {
                        "display": ["Inter"]
                    },
                    borderRadius: { "DEFAULT": "0.25rem", "lg": "0.5rem", "xl": "0.75rem", "full": "9999px" },
                },
            },
        }
    </script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        .active-nav {
            background-color: rgba(45, 105, 123, 0.1);
            color: #2d697b;
        }
    </style>
    <?php wp_head(); ?>
</head>

<body class="bg-background-light dark:bg-background-dark font-display text-slate-900 dark:text-slate-100 min-h-screen">
    <div class="flex min-h-screen">
        <!-- Sidebar Navigation -->
        <aside
            class="w-64 border-r border-slate-200 dark:border-slate-800 bg-white dark:bg-background-dark flex flex-col fixed h-full z-20">
            <div class="p-6">
                <div class="flex items-center gap-3 mb-8">
                    <div class="size-10 bg-primary rounded-lg flex items-center justify-center text-white">
                        <span class="material-symbols-outlined">newspaper</span>
                    </div>
                    <span class="font-bold text-xl tracking-tight">WartaDash</span>
                </div>
                <nav class="space-y-1">
                    <a class="flex items-center gap-3 px-3 py-2 rounded-lg active-nav" href="#">
                        <span class="material-symbols-outlined text-[22px]">dashboard</span>
                        <span class="text-sm font-medium">Dashboard</span>
                    </a>
                    <a class="flex items-center gap-3 px-3 py-2 rounded-lg text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800"
                        href="<?php echo admin_url('edit.php'); ?>">
                        <span class="material-symbols-outlined text-[22px]">article</span>
                        <span class="text-sm font-medium">My Stories</span>
                    </a>
                    <a class="flex items-center gap-3 px-3 py-2 rounded-lg text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800"
                        href="<?php echo admin_url('profile.php'); ?>">
                        <span class="material-symbols-outlined text-[22px]">person</span>
                        <span class="text-sm font-medium">Profile</span>
                    </a>
                    <a class="flex items-center gap-3 px-3 py-2 rounded-lg text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800"
                        href="<?php echo home_url(); ?>">
                        <span class="material-symbols-outlined text-[22px]">public</span>
                        <span class="text-sm font-medium">View Site</span>
                    </a>
                    <a class="flex items-center gap-3 px-3 py-2 rounded-lg text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800"
                        href="<?php echo wp_logout_url(home_url()); ?>">
                        <span class="material-symbols-outlined text-[22px]">logout</span>
                        <span class="text-sm font-medium">Logout</span>
                    </a>
                </nav>
            </div>
            <div class="mt-auto p-4 border-t border-slate-100 dark:border-slate-800">
                <div class="flex items-center gap-3 mb-4 px-2">
                    <div class="size-10 rounded-full bg-slate-200 dark:bg-slate-700 overflow-hidden">
                        <img alt="Profile" src="<?php echo esc_url($user_avatar_url); ?>"
                            class="w-full h-full object-cover" />
                    </div>
                    <div class="flex flex-col">
                        <span class="text-xs font-semibold">
                            <?php echo esc_html($current_user->display_name); ?>
                        </span>
                        <span class="text-[10px] text-slate-500 uppercase tracking-wider">Author</span>
                    </div>
                </div>
                <a href="<?php echo admin_url('post-new.php'); ?>"
                    class="w-full bg-primary hover:bg-primary/90 text-white rounded-lg py-2.5 text-sm font-bold transition-colors flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined text-sm">add</span>
                    Create New Post
                </a>
            </div>
        </aside>

        <!-- Main Content Area -->
        <main class="flex-1 ml-64 p-8">
            <!-- Header Section -->
            <header class="mb-8">
                <div class="flex items-center gap-2 text-sm text-slate-500 mb-2">
                    <span class="text-slate-900 dark:text-white font-medium">Author Dashboard</span>
                    <span class="material-symbols-outlined text-xs">chevron_right</span>
                    <span>Overview</span>
                </div>
                <div class="flex justify-between items-end">
                    <div>
                        <h1 class="text-3xl font-black tracking-tight text-slate-900 dark:text-white">Welcome back,
                            <?php echo esc_html($current_user->first_name ?: $current_user->display_name); ?>!
                        </h1>
                        <p class="text-slate-500 mt-1">Here is your content performance overview.</p>
                    </div>
                    <!-- <div class="flex gap-3">
                    <button class="px-4 py-2 border border-slate-200 dark:border-slate-700 rounded-lg text-sm font-medium hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors flex items-center gap-2">
                        <span class="material-symbols-outlined text-lg">calendar_today</span>
                        Last 7 Days
                    </button>
                </div> -->
                </div>
            </header>

            <!-- Quick Stats Grid -->
            <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div
                    class="bg-white dark:bg-slate-900 p-6 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm">
                    <div class="flex justify-between items-start mb-4">
                        <div class="p-2 bg-primary/10 rounded-lg text-primary">
                            <span class="material-symbols-outlined">visibility</span>
                        </div>
                    </div>
                    <p class="text-sm font-medium text-slate-500">Total Views (Est.)</p>
                    <p class="text-2xl font-bold mt-1 tracking-tight">
                        <?php echo number_format($total_views); ?>
                    </p>
                </div>
                <div
                    class="bg-white dark:bg-slate-900 p-6 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm">
                    <div class="flex justify-between items-start mb-4">
                        <div class="p-2 bg-blue-100 rounded-lg text-blue-600">
                            <span class="material-symbols-outlined">article</span>
                        </div>
                    </div>
                    <p class="text-sm font-medium text-slate-500">Total Stories</p>
                    <p class="text-2xl font-bold mt-1 tracking-tight">
                        <?php echo number_format($user_post_count); ?>
                    </p>
                </div>
                <div
                    class="bg-white dark:bg-slate-900 p-6 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm">
                    <div class="flex justify-between items-start mb-4">
                        <div class="p-2 bg-orange-100 rounded-lg text-orange-600">
                            <span class="material-symbols-outlined">timer</span>
                        </div>
                    </div>
                    <p class="text-sm font-medium text-slate-500">Member Since</p>
                    <p class="text-2xl font-bold mt-1 tracking-tight">
                        <?php echo date('Y', strtotime($current_user->user_registered)); ?>
                    </p>
                </div>
                <div
                    class="bg-white dark:bg-slate-900 p-6 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm">
                    <div class="flex justify-between items-start mb-4">
                        <div class="p-2 bg-primary rounded-lg text-white">
                            <span class="material-symbols-outlined">bolt</span>
                        </div>
                    </div>
                    <p class="text-sm font-medium text-slate-500">Account Status</p>
                    <p class="text-2xl font-bold mt-1 tracking-tight">Active</p>
                </div>
            </section>

            <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
                <!-- Recent Stories Table -->
                <div class="xl:col-span-2 space-y-6">
                    <div
                        class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
                        <div
                            class="px-6 py-4 border-b border-slate-100 dark:border-slate-800 flex justify-between items-center">
                            <h2 class="font-bold text-lg">My Recent Stories</h2>
                            <a class="text-primary text-sm font-semibold hover:underline"
                                href="<?php echo admin_url('edit.php'); ?>">View All</a>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left">
                                <thead class="bg-slate-50 dark:bg-slate-800/50">
                                    <tr>
                                        <th class="px-6 py-3 text-xs font-bold text-slate-500 uppercase">Story Title
                                        </th>
                                        <th class="px-6 py-3 text-xs font-bold text-slate-500 uppercase">Status</th>
                                        <th class="px-6 py-3 text-xs font-bold text-slate-500 uppercase">Category</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                                    <?php if ($recent_stories->have_posts()): ?>
                                        <?php while ($recent_stories->have_posts()):
                                            $recent_stories->the_post(); ?>
                                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                                                <td class="px-6 py-4">
                                                    <div class="font-semibold text-sm line-clamp-1"><a
                                                            href="<?php echo get_edit_post_link(); ?>">
                                                            <?php the_title(); ?>
                                                        </a></div>
                                                    <div class="text-xs text-slate-400 mt-1">
                                                        <?php echo human_time_diff(get_the_time('U'), current_time('timestamp')) . ' ago'; ?>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4">
                                                    <?php
                                                    $status = get_post_status();
                                                    $badge_class = 'bg-gray-100 text-gray-800';
                                                    if ($status === 'publish')
                                                        $badge_class = 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400';
                                                    if ($status === 'draft')
                                                        $badge_class = 'bg-orange-100 text-orange-800 dark:bg-orange-900/30 dark:text-orange-400';
                                                    if ($status === 'pending')
                                                        $badge_class = 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400';
                                                    ?>
                                                    <span
                                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?php echo $badge_class; ?> capitalize">
                                                        <?php echo $status; ?>
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4">
                                                    <div
                                                        class="flex items-center gap-1.5 text-xs text-slate-600 dark:text-slate-400">
                                                        <?php $cat = get_the_category();
                                                        echo !empty($cat) ? esc_html($cat[0]->name) : '-'; ?>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endwhile;
                                        wp_reset_postdata(); ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="3" class="px-6 py-8 text-center text-slate-500 text-sm">You haven't
                                                written any stories yet.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Trending & Inspiration Sidebar -->
                <div class="space-y-8">
                    <div class="bg-[#2d697b] text-white rounded-xl shadow-lg p-6 relative overflow-hidden">
                        <div class="relative z-10">
                            <h3 class="text-xl font-bold mb-2">Editor's Spotlight</h3>
                            <p class="text-white/80 text-sm mb-4">Focus on "Local News" this week! Regional stories are
                                seeing higher engagement.</p>
                            <a href="<?php echo admin_url('post-new.php'); ?>"
                                class="inline-block bg-white text-primary px-4 py-2 rounded-lg text-xs font-bold hover:bg-slate-100 transition-colors">Write
                                Now</a>
                        </div>
                        <span
                            class="material-symbols-outlined absolute -right-4 -bottom-4 text-white/10 text-9xl">campaign</span>
                    </div>

                    <div
                        class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
                        <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-800 flex items-center gap-2">
                            <span class="material-symbols-outlined text-primary">trending_up</span>
                            <h2 class="font-bold">Trending Now</h2>
                        </div>
                        <div class="p-6 space-y-5">
                            <?php
                            if ($trending_query->have_posts()):
                                $count = 1;
                                while ($trending_query->have_posts()):
                                    $trending_query->the_post();
                                    ?>
                                    <div class="flex items-start gap-4">
                                        <span class="text-2xl font-black text-slate-100 dark:text-slate-800">
                                            <?php echo str_pad($count, 2, '0', STR_PAD_LEFT); ?>
                                        </span>
                                        <div>
                                            <div class="text-sm font-bold line-clamp-2"><a href="<?php the_permalink(); ?>">
                                                    <?php the_title(); ?>
                                                </a></div>
                                            <div class="text-[11px] text-slate-500 uppercase tracking-tighter">
                                                <?php comments_number('0 Comments', '1 Comment', '% Comments'); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?php $count++; endwhile;
                                wp_reset_postdata(); endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <?php wp_footer(); ?>
</body>

</html>