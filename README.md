# Modern News Theme

A dynamic, modern, and SEO-optimized WordPress news theme with Geo-targeting capabilities.

**Version:** 1.2.0  
**Requires:** WordPress 6.0+  
**Tested up to:** WordPress 6.8.1  
**Requires PHP:** 7.4+

---

## ✨ Features

### Core Functionality
- **Tailwind CSS** - Modern utility-first CSS framework (CDN-based with custom config)
- **Dark Mode** - Automatic and manual dark/light theme switching
- **Responsive Design** - Mobile-first, fully responsive layout
- **SEO Optimized** - Advanced JSON-LD automation (NewsArticle, Breadcrumbs, Organization)
- **Geo-Targeting** - AJAX-powered local news based on user location
- **Speed Sovereignty** - Aggressive bloat removal, script deferral, and LCP optimizations
- **E-E-A-T Ready** - Transparent author bios, "Last Updated" timestamps, and reading time estimates
- **Premium Iconography** - Full transition to Remix Icon system for a modern aesthetic

### Homepage
- Hero grid section with featured posts (3 posts layout)
- Local news section with geolocation detection
- Category sections with "Berita Terbaru"
- Newsletter subscription component
- Breaking News ticker with auto-scroll animation
- **Ad Integrations:** Header Leaderboard (728x90) and Sidebar Rectangle (300x250)
- **Editor's Picks:** Curated selection of top stories

### Single Post
- Reading progress bar
- Sticky social share sidebar
- Author bio with follow button
- Related news section
- Newsletter CTA box
- Comment system integration

### Archive & Category Pages
- Featured card for first post
- Tag-based filter chips with AJAX filtering
- Infinite scroll / Load More button
- Author avatars and timestamps

### Special Pages
- Regional news page (`page-regional.php`)
- Citizen journalism submission (`page-submit-news.php`)
- Author dashboard (`page-author-dashboard.php`)
- Live streaming page (`page-live-streaming.php`)

### Widgets
- **Weather Widget** - OpenWeatherMap integration
- **Trending Posts** - Comment-count based popularity
- **Post List** - Recent/category posts with thumbnails

### Navigation
- Mega menu with category dropdowns
- Mobile hamburger menu with sticky bottom share bar
- Search overlay with live suggestions
- Modernized 404, Search, and Archive templates
- **Citizen News Submission** - Public frontend form for community reporting

### 💰 Monetization
- **Ads Manager** - Integrated admin panel for managing ad codes/images
- **Ad Slots** - Pre-defined locations: Header, Sidebar, Before Content, After Content
- **Dummy Ads** - Auto-fallback to placeholders for setup/testing

---

## 📁 File Structure

```
modernnews/
├── assets/
│   ├── css/
│   │   ├── admin.css       # Admin panel styling
│   │   └── main.css        # Main frontend styles
│   └── js/
│       ├── admin.js        # Admin panel scripts
│       └── main.js         # Frontend JavaScript
├── inc/
│   ├── ads-manager.php     # Ad placement management
│   ├── performance.php     # Speed & performance engine
│   ├── schema.php          # SEO & JSON-LD automation
│   ├── ajax-archive.php    # AJAX archive handler
│   ├── customizer.php      # Theme Customizer settings
│   ├── theme-options.php   # Admin theme settings
│   └── widgets.php         # Custom widgets
├── template-parts/
│   ├── home/
│   │   └── content-dynamic.php  # Dynamic homepage layout
│   ├── content.php         # Default content template
│   ├── content-card.php    # Post card component
│   ├── content-search.php  # Search results item
│   └── search-overlay.php  # Search overlay modal
├── 404.php                 # 404 error page
├── archive.php             # Archive/category template
├── author.php              # Author page template
├── comments.php            # Comments template
├── footer.php              # Site footer
├── front-page.php          # Homepage template
├── functions.php           # Theme functions
├── header.php              # Site header
├── index.php               # Blog page fallback
├── page.php                # Default page template
├── page-*.php              # Custom page templates
├── search.php              # Search results page
├── searchform.php          # Search form
├── sidebar.php             # Sidebar template
├── single.php              # Single post template
├── style.css               # Theme header & base CSS
└── screenshot.jpg          # Theme preview image
```

---

## ⚙️ Configuration

### Theme Options (Admin Panel)

Navigate to **Modern News** in the WordPress admin menu.

| Tab | Settings |
|-----|----------|
| **General** | Sticky header toggle |
| **Features** | Live streaming, Citizen news, Subscribe URL |
| **Social Media** | Facebook, Twitter, Instagram, YouTube, TikTok URLs |
| **Contact** | Email, Phone, Office address |
| **Footer** | About text, Copyright, Privacy & Terms URLs |
| **API Settings** | Google Maps API, OpenWeatherMap API keys |

### Navigation Menus
- **Primary Menu** - Main header navigation (supports mega menu)
- **Footer Menu** - Footer navigation links

### Widget Areas
- **Main Sidebar** - Appears on single posts and archives
- **Footer Column 1** - Branding/About section
- **Footer Column 2** - Category links
- **Footer Column 2** - Category links
- **Footer Column 3** - Company/Contact info

### Citizen News Setup
1. Create a new page (e.g., "Submit News").
2. Assign the **"Citizen News Submission"** template to it.
3. The form will appear automatically on the frontend.
4. Submissions are saved as **Drafts** in the Posts menu for editorial review.

---

## 🎨 Customization

### Theme Customizer
Access via **Appearance → Customize**:
- Primary color
- Secondary color
- Header background
- Body background

### Tailwind Configuration
Edit the inline Tailwind config in `header.php`:

```javascript
tailwind.config = {
  darkMode: "class",
  theme: {
    extend: {
      colors: {
        "primary": "#168098",
        "accent-yellow": "#FFD600",
        // ... more colors
      },
      fontFamily: {
        "display": ["Epilogue", "sans-serif"],
        "body": ["Noto Sans", "sans-serif"]
      }
    }
  }
}
```

### CSS Variables
Main CSS custom properties in `assets/css/main.css`:

```css
:root {
  --container-width: 1200px;
  --gap-base: 1.5rem;
  --border-radius: 8px;
  --shadow-sm: 0 2px 4px rgba(0, 0, 0, 0.05);
  --shadow-md: 0 8px 16px rgba(0, 0, 0, 0.1);
  --shadow-lg: 0 16px 32px rgba(0, 0, 0, 0.15);
}
```

---

## 🔌 External Dependencies

| Resource | Purpose |
|----------|---------|
| Tailwind CSS (CDN) | Utility-first CSS framework |
| Google Fonts (Epilogue, Noto Sans) | Typography |
| Material Symbols | Icon system |
| OpenWeatherMap API | Weather widget data |

---

## 📝 Development Notes

### AJAX Endpoints
- `wp_ajax_get_local_news` - Fetch location-based news
- `wp_ajax_modernnews_load_more_posts` - Infinite scroll loading

### JavaScript Functions
- Dark mode toggle
- Breaking news ticker animation
- Weather widget initialization
- Search overlay functionality
- Reading progress bar
- Scroll to top button

### Post Sorting
Supported query parameters:
- `?sort=latest` (default)
- `?sort=oldest`
- `?sort=popular` (by comment count)

---

## 🚀 Getting Started

1. **Install**: Upload theme to `wp-content/themes/`
2. **Activate**: Go to Appearance → Themes → Activate
3. **Configure Menus**: Create Primary and Footer menus
4. **Add Widgets**: Set up sidebar and footer widgets
5. **Theme Options**: Configure API keys, social links, contact info
6. **Create Pages**: Use page templates for special features

---

## 📄 License

Licensed for use on bijidata.online

**Author:** Roedy  
**Author URI:** https://bijidata.online
