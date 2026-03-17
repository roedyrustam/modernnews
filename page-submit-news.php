<?php
/**
 * Template Name: Citizen News Submission
 */
?>
<!DOCTYPE html>
<html class="light" <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Citizen News Submission Form |
        <?php bloginfo('name'); ?>
    </title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@300;400;500;600;700;800&amp;display=swap"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght@100..700,0..1&amp;display=swap"
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
                        "primary": "#1f8093",
                        "background-light": "#fafafa",
                        "background-dark": "#171b1c",
                        "muted-coral": "#e57373"
                    },
                    fontFamily: {
                        "display": ["Manrope", "sans-serif"]
                    },
                    borderRadius: {
                        "DEFAULT": "0.5rem",
                        "lg": "1rem",
                        "xl": "1.5rem",
                        "full": "9999px"
                    },
                },
            },
        }
    </script>
    <style>
        body {
            font-family: 'Manrope', sans-serif;
        }

        .form-card-shadow {
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.08);
        }

        .glass-effect {
            backdrop-filter: blur(8px);
            background: rgba(255, 255, 255, 0.8);
        }
    </style>
    <?php wp_head(); ?>
</head>

<body class="bg-background-light dark:bg-background-dark text-[#0f181a] dark:text-gray-100 min-h-screen">
    <!-- Top Navigation Bar -->
    <header
        class="sticky top-0 z-50 border-b border-solid border-[#e9f0f2] dark:border-gray-800 bg-background-light/90 dark:bg-background-dark/90 backdrop-blur-md px-4 md:px-20 py-3">
        <div class="max-w-[1200px] mx-auto flex items-center justify-between gap-8">
            <div class="flex items-center gap-8">
                <a href="<?php echo home_url('/'); ?>" class="flex items-center gap-3 text-primary decoration-0">
                    <div class="size-8">
                        <svg class="w-full h-full" fill="none" viewbox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
                            <path d="M44 4H30.6666V17.3334H17.3334V30.6666H4V44H44V4Z" fill="currentColor"></path>
                        </svg>
                    </div>
                    <h2 class="text-[#0f181a] dark:text-white text-xl font-extrabold leading-tight tracking-tight">
                        WartaWarga</h2>
                </a>
                <nav class="hidden md:flex items-center gap-8">
                    <?php
                    $cats = get_categories(['number' => 3]);
                    foreach ($cats as $cat) {
                        echo '<a class="text-sm font-semibold hover:text-primary transition-colors" href="' . get_category_link($cat->term_id) . '">' . $cat->name . '</a>';
                    }
                    ?>
                    <a class="text-sm font-semibold text-primary" href="#">Citizen News</a>
                </nav>
            </div>
            <div class="flex flex-1 justify-end items-center gap-4">
                <form action="<?php echo home_url('/'); ?>" method="get"
                    class="hidden lg:flex items-stretch min-w-[240px] h-10 rounded-xl bg-[#e9f0f2] dark:bg-gray-800 overflow-hidden">
                    <div class="flex items-center justify-center pl-4">
                        <span class="material-symbols-outlined text-[#558791] text-xl">search</span>
                    </div>
                    <input name="s"
                        class="w-full bg-transparent border-none focus:ring-0 text-sm placeholder:text-[#558791]"
                        placeholder="Search local news..." value="<?php echo get_search_query(); ?>" />
                </form>
                <div class="flex items-center gap-3">
                    <button
                        class="flex items-center justify-center rounded-xl h-10 px-5 bg-primary text-white text-sm font-bold transition-all hover:opacity-90">
                        <span>New Report</span>
                    </button>
                    <?php if (is_user_logged_in()):
                        $current_user = wp_get_current_user();
                        ?>
                        <div class="size-10 rounded-full bg-cover bg-center border-2 border-primary/20"
                            title="<?php echo esc_attr($current_user->display_name); ?>"
                            style='background-image: url("<?php echo get_avatar_url($current_user->ID); ?>");'></div>
                    <?php else: ?>
                        <a href="<?php echo esc_url(home_url('/kontak-redaksi')); ?>" class="text-sm font-bold text-primary">Hubungi Redaksi</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </header>

    <main class="max-w-[960px] mx-auto px-4 py-12">
        <!-- Page Heading Section -->
        <div class="mb-10">
            <?php
            if (isset($_GET['submission']) && $_GET['submission'] == 'success') {
                echo '<div class="mb-6 p-4 bg-green-100 border border-green-200 text-green-700 rounded-xl flex items-center gap-3">
                    <span class="material-symbols-outlined">check_circle</span>
                    <strong>Terima kasih!</strong> Laporan Anda berhasil dikirim dan sedang ditinjau oleh redaksi.
                </div>';
            }
            ?>
            <div class="flex flex-wrap justify-between items-end gap-6 mb-6">
                <div class="max-w-2xl">
                    <h1
                        class="text-4xl md:text-5xl font-extrabold tracking-tighter text-[#0f181a] dark:text-white mb-4">
                        Citizen Journalism: <span class="text-primary">Share Your Story</span>
                    </h1>
                    <p class="text-lg text-[#558791] dark:text-gray-400 font-medium">
                        Your voice matters. Report local incidents, achievements, or community concerns directly to our
                        newsroom.
                    </p>
                </div>
                <button
                    class="h-11 px-6 bg-[#e9f0f2] dark:bg-gray-800 text-[#0f181a] dark:text-white rounded-xl font-bold text-sm flex items-center gap-2 hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">
                    <span class="material-symbols-outlined text-lg">menu_book</span>
                    Editorial Guidelines
                </button>
            </div>
            <!-- Progress Bar -->
            <div
                class="bg-white dark:bg-gray-900 rounded-xl p-5 form-card-shadow border border-gray-100 dark:border-gray-800">
                <div class="flex justify-between items-center mb-3">
                    <span class="text-sm font-bold text-primary flex items-center gap-2">
                        <span class="material-symbols-outlined text-lg">edit_note</span>
                        Submission Progress
                    </span>
                    <span class="text-sm font-bold text-[#0f181a] dark:text-white">40% Complete</span>
                </div>
                <div class="h-2 w-full bg-[#d2e1e5] dark:bg-gray-800 rounded-full overflow-hidden">
                    <div class="h-full bg-primary transition-all duration-500" style="width: 40%;"></div>
                </div>
                <p class="mt-3 text-xs font-semibold text-[#558791] uppercase tracking-wider">Step 2: Narrative &amp;
                    Details</p>
            </div>
        </div>

        <!-- Submission Form Container -->
        <form class="space-y-10" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post"
            enctype="multipart/form-data">
            <input type="hidden" name="action" value="submit_citizen_news">
            <?php wp_nonce_field('citizen_news_submission', 'citizen_news_nonce'); ?>

            <!-- Section 1: Upload Media -->
            <section
                class="bg-white dark:bg-gray-900 rounded-2xl p-8 form-card-shadow border border-gray-100 dark:border-gray-800">
                <div class="flex items-center gap-3 mb-6">
                    <div class="size-10 bg-primary/10 rounded-lg flex items-center justify-center text-primary">
                        <span class="material-symbols-outlined">add_a_photo</span>
                    </div>
                    <h3 class="text-2xl font-bold dark:text-white">1. Evidence &amp; Visuals</h3>
                </div>
                <div
                    class="flex flex-col items-center gap-6 rounded-2xl border-2 border-dashed border-[#d2e1e5] dark:border-gray-700 px-8 py-16 bg-background-light/50 dark:bg-background-dark/30 hover:border-primary transition-colors cursor-pointer relative">
                    <input type="file" name="news_image" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                        accept="image/*,video/*">
                    <div
                        class="size-16 bg-white dark:bg-gray-800 rounded-full shadow-sm flex items-center justify-center text-primary">
                        <span class="material-symbols-outlined text-4xl">cloud_upload</span>
                    </div>
                    <div class="text-center max-w-md">
                        <p class="text-lg font-bold dark:text-white mb-2">Drag and drop photos or videos</p>
                        <p class="text-sm text-[#558791] dark:text-gray-400">
                            Support MP4, MOV, JPG, or PNG up to 100MB. High-quality visuals increase the chance of your
                            story being featured.
                        </p>
                    </div>
                    <button
                        class="px-8 h-12 bg-primary/10 text-primary font-bold rounded-xl hover:bg-primary/20 transition-all"
                        type="button">
                        Browse Files
                    </button>
                </div>
            </section>

            <!-- Section 2: Story Details -->
            <section
                class="bg-white dark:bg-gray-900 rounded-2xl p-8 form-card-shadow border border-gray-100 dark:border-gray-800">
                <div class="flex items-center gap-3 mb-8">
                    <div class="size-10 bg-primary/10 rounded-lg flex items-center justify-center text-primary">
                        <span class="material-symbols-outlined">description</span>
                    </div>
                    <h3 class="text-2xl font-bold dark:text-white">2. The Narrative</h3>
                </div>
                <div class="space-y-8">
                    <!-- Headline -->
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <label
                                class="text-sm font-extrabold text-[#0f181a] dark:text-white uppercase tracking-wider">Catchy
                                Headline <span class="text-muted-coral">*</span></label>
                            <span class="text-xs text-[#558791]">0 / 100</span>
                        </div>
                        <input name="news_title" required
                            class="w-full h-14 bg-background-light dark:bg-background-dark border-2 border-transparent focus:border-primary focus:ring-0 rounded-xl px-4 text-lg font-bold dark:text-white placeholder:text-gray-400"
                            placeholder="e.g. Flash Floods in South Jakarta Cause Major Traffic Gridlock" type="text" />
                    </div>
                    <!-- Categories -->
                    <div class="space-y-4">
                        <label
                            class="text-sm font-extrabold text-[#0f181a] dark:text-white uppercase tracking-wider">News
                            Category</label>
                        <div class="flex flex-wrap gap-3">
                            <select name="news_category"
                                class="w-full h-12 bg-background-light dark:bg-background-dark border-none focus:ring-2 focus:ring-primary rounded-xl px-4 text-sm font-bold text-[#558791]">
                                <option value="Traffic">Traffic</option>
                                <option value="Weather">Weather</option>
                                <option value="Environment">Environment</option>
                                <option value="Public Service">Public Service</option>
                                <option value="Community Event">Community Event</option>
                            </select>
                        </div>
                    </div>
                    <!-- Story Content -->
                    <div class="space-y-3">
                        <label
                            class="text-sm font-extrabold text-[#0f181a] dark:text-white uppercase tracking-wider">What's
                            happening? <span class="text-muted-coral">*</span></label>
                        <textarea name="news_content" required
                            class="w-full bg-background-light dark:bg-background-dark border-2 border-transparent focus:border-primary focus:ring-0 rounded-xl px-4 py-4 text-base leading-relaxed dark:text-white placeholder:text-gray-400"
                            placeholder="Describe the event in detail (Who, What, Where, When, Why)..."
                            rows="6"></textarea>
                    </div>
                </div>
            </section>

            <!-- Section 3: Geo-Tagging -->
            <section
                class="bg-white dark:bg-gray-900 rounded-2xl p-8 form-card-shadow border border-gray-100 dark:border-gray-800">
                <div class="flex items-center gap-3 mb-8">
                    <div class="size-10 bg-primary/10 rounded-lg flex items-center justify-center text-primary">
                        <span class="material-symbols-outlined">location_on</span>
                    </div>
                    <h3 class="text-2xl font-bold dark:text-white">3. Geo-Targeting</h3>
                </div>
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <div class="space-y-6">
                        <div class="space-y-3">
                            <label
                                class="text-sm font-extrabold text-[#0f181a] dark:text-white uppercase tracking-wider">Search
                                Location</label>
                            <div class="relative">
                                <span
                                    class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-primary">search</span>
                                <input name="news_location"
                                    class="w-full h-12 pl-12 bg-background-light dark:bg-background-dark border-none focus:ring-2 focus:ring-primary rounded-xl text-sm dark:text-white"
                                    placeholder="e.g. Sudirman, Jakarta Pusat" type="text" />
                            </div>
                        </div>
                        <div class="p-5 bg-primary/5 rounded-xl border border-primary/10">
                            <div class="flex gap-4">
                                <span class="material-symbols-outlined text-primary">info</span>
                                <p class="text-sm text-primary/80 leading-relaxed font-medium">
                                    Tagging the precise location helps us notify local authorities and residents in the
                                    affected area faster.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div
                        class="relative h-64 lg:h-auto min-h-[250px] rounded-2xl overflow-hidden border border-[#e9f0f2] dark:border-gray-800">
                        <div class="absolute inset-0 bg-gray-200 dark:bg-gray-800 flex items-center justify-center">
                            <div class="absolute inset-0 bg-cover bg-center"
                                data-alt="Stylized map of Jakarta with news markers" data-location="Jakarta"
                                style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuD0jzVq61OOKRteLkjGHBvVuG9cDKwLJ_zPsmCcI0JCunRv_l_NwnKPT1zzJuLO6qRuwZmrCG7Zo_m2Z4JK2tIs8x1Ny08_z6pLuHpYQnGEEA4p8SBjMW2e6qmrVfGluP7eytSCeAgIWktfa8XyGyKTZqT72yQUveiXCcIqSE7rfQwUIoqIQQBg2H9WimNpwHSCIL5VgONNlzZjVaDehkI80LXhN9QeOpQBbFroxCpL2RMF266U-SBHmwQZpjn9tNBIul291LW0IA4'); opacity: 0.6; filter: grayscale(100%);">
                            </div>
                            <div class="relative z-10 flex flex-col items-center">
                                <span
                                    class="material-symbols-outlined text-muted-coral text-5xl drop-shadow-lg">location_on</span>
                                <div
                                    class="mt-2 px-4 py-1 bg-white dark:bg-gray-900 rounded-full shadow-lg text-xs font-bold dark:text-white">
                                    Set News Location
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Metadata & SEO -->
            <section
                class="bg-white dark:bg-gray-900 rounded-2xl p-8 form-card-shadow border border-gray-100 dark:border-gray-800">
                <div class="flex items-center gap-3 mb-6">
                    <div class="size-10 bg-primary/10 rounded-lg flex items-center justify-center text-primary">
                        <span class="material-symbols-outlined">tag</span>
                    </div>
                    <h3 class="text-2xl font-bold dark:text-white">4. Discovery Tags</h3>
                </div>
                <div class="space-y-4">
                    <label class="text-sm font-extrabold text-[#0f181a] dark:text-white uppercase tracking-wider">SEO
                        Keywords</label>
                    <input name="news_tags"
                        class="w-full h-12 bg-background-light dark:bg-background-dark border-none focus:ring-2 focus:ring-primary rounded-xl text-sm dark:text-white"
                        placeholder="Add tags like #BanjirJakarta, #LaluLintas, #HeadlineNews..." type="text" />
                    <div class="flex items-center gap-4 py-2">
                        <input name="post_anonymous" value="1"
                            class="w-5 h-5 rounded border-gray-300 text-primary focus:ring-primary" id="anon"
                            type="checkbox" />
                        <label class="text-sm font-semibold text-[#558791] dark:text-gray-400 cursor-pointer"
                            for="anon">Post this report anonymously</label>
                    </div>
                </div>
            </section>

            <!-- Final Actions -->
            <div class="flex flex-col md:flex-row items-center justify-between gap-6 py-10">
                <button
                    class="text-[#558791] dark:text-gray-400 font-bold hover:text-[#0f181a] dark:hover:text-white transition-colors"
                    type="button">
                    Discard Draft
                </button>
                <div class="flex flex-col sm:flex-row items-center gap-4 w-full md:w-auto">
                    <button
                        class="w-full sm:w-auto px-8 h-14 border-2 border-primary text-primary font-bold rounded-2xl hover:bg-primary/5 transition-all"
                        type="button">
                        Save Draft
                    </button>
                    <button
                        class="w-full sm:w-auto px-12 h-14 bg-primary text-white font-extrabold text-lg rounded-2xl shadow-lg shadow-primary/20 hover:scale-[1.02] transition-all"
                        type="submit">
                        Publish Report
                    </button>
                </div>
            </div>
        </form>
    </main>

    <footer class="bg-white dark:bg-gray-900 border-t border-[#e9f0f2] dark:border-gray-800 py-12 px-4">
        <div class="max-w-[1200px] mx-auto flex flex-col md:flex-row justify-between items-center gap-8">
            <div class="flex items-center gap-3 text-primary/50 grayscale">
                <div class="size-6">
                    <svg class="w-full h-full" fill="none" viewbox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
                        <path d="M44 4H30.6666V17.3334H17.3334V30.6666H4V44H44V4Z" fill="currentColor"></path>
                    </svg>
                </div>
                <h2 class="text-[#0f181a] dark:text-white text-base font-bold">WartaWarga</h2>
            </div>
            <p class="text-sm text-[#558791] dark:text-gray-400 font-medium">
                ©
                <?php echo date('Y'); ?> WartaWarga News Indonesia. Empowering Citizen Voice.
            </p>
            <div class="flex gap-6">
                <a class="text-[#558791] hover:text-primary" href="#"><span
                        class="material-symbols-outlined">language</span></a>
                <a class="text-[#558791] hover:text-primary" href="#"><span
                        class="material-symbols-outlined">share</span></a>
                <a class="text-[#558791] hover:text-primary" href="#"><span
                        class="material-symbols-outlined">help</span></a>
            </div>
        </div>
    </footer>
    <?php wp_footer(); ?>
</body>

</html>