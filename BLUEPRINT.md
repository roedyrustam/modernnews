# Modern News Theme - Architecture Blueprint

## System Architecture Overview

```mermaid
graph TB
    subgraph WordPress["WordPress Core"]
        WP[WordPress]
        Hooks[Action/Filter Hooks]
    end

    subgraph Theme["ModernNews Theme"]
        subgraph Core["Core Templates"]
            Header[header.php]
            Footer[footer.php]
            Functions[functions.php]
        end
        
        subgraph Templates["Page Templates"]
            FrontPage[front-page.php]
            Single[single.php]
            Archive[archive.php]
            Page[page.php]
            Search[search.php]
        end
        
        subgraph SpecialPages["Special Page Templates"]
            Regional[page-regional.php]
            Submit[page-submit-news.php]
            Author[page-author-dashboard.php]
            Live[page-live-streaming.php]
        end
        
        subgraph Includes["Includes/Optimization"]
            Widgets[widgets.php]
            ThemeOptions[theme-options.php]
            Customizer[customizer.php]
            AdsManager[ads-manager.php]
            Performance[performance.php]
            Schema[schema.php]
            AjaxArchive[ajax-archive.php]
        end
        
        subgraph Assets["Assets"]
            MainCSS[main.css]
            AdminCSS[admin.css]
            MainJS[main.js]
            AdminJS[admin.js]
        end
        
        subgraph TemplateParts["Template Parts"]
            subgraph HomeParts["Home Sections"]
                Hero[hero-grid.php]
                Editors[editors-picks.php]
                QuickRead[quick-read.php]
                Spotlight[category-spotlight.php]
            end
            ContentCard[content-card.php]
            SearchOverlay[search-overlay.php]
        end
    end
    
    subgraph External["External Services"]
        TailwindCDN[Tailwind CDN]
        GoogleFonts[Google Fonts]
        WeatherAPI[OpenWeatherMap API]
        GoogleMaps[Google Maps API]
    end

    WP --> Hooks
    Hooks --> Functions
    Functions --> Core
    Functions --> Includes
    Core --> Templates
    Core --> SpecialPages
    Templates --> TemplateParts
    Assets --> Core
    External --> Header
```

---

## Data Flow Diagram

```mermaid
flowchart LR
    subgraph User["User Interaction"]
        Browser[Browser]
        Location[Geolocation API]
    end
    
    subgraph Frontend["Frontend Layer"]
        MainJS[main.js]
        TailwindCSS[Tailwind CSS]
        DarkMode[Dark Mode Toggle]
    end
    
    subgraph PHP["PHP Layer"]
        Functions[functions.php]
        AJAX[AJAX Handlers]
        WPQuery[WP_Query]
    end
    
    subgraph Database["Database"]
        Posts[(Posts)]
        Options[(Options)]
        Terms[(Terms/Cats)]
    end
    
    subgraph APIs["External APIs"]
        Weather[WeatherAPI]
    end

    Browser --> MainJS
    Location --> MainJS
    MainJS --> AJAX
    MainJS --> DarkMode
    AJAX --> Functions
    Functions --> WPQuery
    WPQuery --> Posts
    WPQuery --> Terms
    Functions --> Options
    MainJS --> Weather
```

---

## Component Architecture

### Core Components

| Component | File | Purpose |
|-----------|------|---------|
| **Header** | `header.php` | Site header, navigation, Tailwind config, breaking news ticker |
| **Footer** | `footer.php` | Footer widgets, copyright, search overlay include |
| **Functions** | `functions.php` | Theme setup, scripts, AJAX handlers, helpers |

### Page Templates

| Template | Hierarchy | Features |
|----------|-----------|----------|
| `front-page.php` | Homepage | Modular sections (Hero, Editors, Quick Read) |
| `single.php` | Posts | E-E-A-T Date display, fetchpriority, social, schema |
| `archive.php` | Categories/Tags | Refined header, Remix Icons, AJAX load more |
| `search.php` | Search results | Premium result UI, breadcrumbs, fallback news |
| `page-submit-news.php` | Citizen News | Frontend submission form with file upload |
| `comments.php` | Comments | Redesigned thread UI with Remix Icons |

### Widget Classes

```mermaid
classDiagram
    WP_Widget <|-- ModernNews_Weather_Widget
    WP_Widget <|-- ModernNews_Trending_Widget
    WP_Widget <|-- ModernNews_Post_List_Widget
    
    class ModernNews_Weather_Widget{
        +widget()
        +form()
        +update()
    }
    
    class ModernNews_Trending_Widget{
        +widget()
        +form()
        +update()
        -count: int
    }
    
    class ModernNews_Post_List_Widget{
        +widget()
        +form()
        +update()
        -count: int
        -category: int
    }
```

---

## CSS Architecture

### Layer Structure

```
┌────────────────────────────────────┐
│          Tailwind CSS (CDN)         │  ← Utility Layer
├────────────────────────────────────┤
│            style.css                │  ← Base Reset & Variables
├────────────────────────────────────┤
│           main.css                  │  ← Component & Custom Styles
├────────────────────────────────────┤
│          admin.css                  │  ← Admin Panel Styles
├────────────────────────────────────┤
│   Inline Customizer Styles          │  ← Dynamic Theme Colors
└────────────────────────────────────┘
```

### Design Tokens

```css
/* Primary Colors */
--primary: #168098          /* Teal - Brand primary */
--accent-yellow: #FFD600    /* Yellow - CTAs, Breaking News */
--background-dark: #212121  /* Dark mode background */

/* Spacing */
--container-width: 1200px
--gap-base: 1.5rem

/* Shadows */
--shadow-sm, --shadow-md, --shadow-lg

/* Border Radius */
--border-radius: 8px
```

---

## JavaScript Architecture

### Module Structure

```mermaid
flowchart TB
    subgraph MainJS["main.js"]
        DOMReady[DOMContentLoaded]
        DOMReady --> WeatherInit[Weather Widget Init]
        DOMReady --> LocalNews[Local News AJAX]
        DOMReady --> DarkToggle[Dark Mode Toggle]
        DOMReady --> SearchInit[Search Overlay]
        DOMReady --> ScrollTop[Scroll to Top]
        DOMReady --> ProgressBar[Reading Progress]
        DOMReady --> LoadMore[Load More Handler]
    end
    
    WeatherInit --> |API Call| WeatherAPI[OpenWeatherMap]
    LocalNews --> |AJAX| WPAdmin[admin-ajax.php]
    LoadMore --> |AJAX| WPAdmin
```

### Key Functions

| Function | Trigger | Action |
|----------|---------|--------|
| Weather Widget | Page Load | Fetch weather via geolocation |
| Local News | Page Load | AJAX fetch location-based posts |
| Dark Mode | Button Click | Toggle `.dark` class on `<html>` |
| Search Overlay | Button Click | Show/hide search modal |
| Reading Progress | Scroll Event | Update progress bar width |
| Reading Progress | Scroll Event | Update progress bar width |
| Load More | Button Click | AJAX fetch next posts page |
| Citizen Submission | Form Submit | Validates and POSTs to admin-post.php |

---

## Database Schema Usage

### Options Table

| Option Key | Purpose |
|------------|---------|
| `modernnews_theme_options` | Serialized theme settings array |
| `show_on_front` | Homepage display mode (page/posts) |
| `page_on_front` | Static front page ID |

### Theme Options Structure

```php
modernnews_theme_options = [
    // API Keys
    'google_maps_api_key' => '',
    'weather_api_key' => '',
    
    // Features
    'enable_live_streaming' => false,
    'live_streaming_url' => '',
    'enable_citizen_news' => false,
    'citizen_news_url' => '',
    'subscribe_url' => '',
    
    // Social Media
    'social_facebook' => '',
    'social_twitter' => '',
    'social_instagram' => '',
    'social_youtube' => '',
    'social_tiktok' => '',
    
    // Contact
    'contact_email' => '',
    'contact_phone' => '',
    'contact_address' => '',
    
    // Footer
    'footer_about' => '',
    'footer_copyright' => '',
    'privacy_policy_url' => '',
    'terms_url' => '',
    
    // General
    'sticky_header' => false
];
```

---

## AJAX Endpoints

| Action | Handler | Purpose |
|--------|---------|---------|
| `get_local_news` | `modernnews_get_local_news()` | Fetch posts by city tag/category |
| `modernnews_load_more_posts` | `inc/ajax-archive.php` | Paginated post loading |
| `submit_citizen_news` | `admin-post.php` | Handle frontend form submission (POST) |

---

## Technical Performance Engine

| File | Feature | Purpose |
|------|---------|---------|
| `inc/performance.php` | Bloat Removal | Strips Emojis, WP version, RSD, WLW manifest |
| `inc/performance.php` | Script Deferral | Defers non-critical JS for better TBT |
| `inc/performance.php` | LCP Optimization | Disables lazy-load for first featured images |
| `inc/schema.php` | JSON-LD Automation | Automates NewsArticle, Breadcrumbs, Organization |

---

## Security Measures

- **Nonce Verification**: All AJAX calls use `wp_create_nonce()` / `check_ajax_referer()`
- **Capability Checks**: Admin pages require `manage_options`
- **Data Sanitization**: `sanitize_text_field()`, `esc_html()`, `esc_attr()` used throughout
- **Prepared Queries**: WP_Query used for database access (no raw SQL)

---

## Performance Considerations

| Feature | Implementation |
|---------|----------------|
| **Asset Loading** | CSS/JS enqueued properly with dependencies |
| **Image Handling** | WordPress thumbnail sizes (medium_large, full) |
| **AJAX Loading** | Infinite scroll reduces initial page load |
| **CDN Assets** | Tailwind, fonts loaded from CDN |

### Recommended Optimizations

1. Move Tailwind from CDN to compiled CSS
2. Implement image lazy loading
3. Add service worker for offline support
4. Cache weather API responses
5. Minify and bundle JS files

---

## Extensibility Points

### Actions
- `wp_head` - Add custom scripts/styles
- `wp_footer` - Footer scripts
- `wp_enqueue_scripts` - Enqueue assets
- `widgets_init` - Register widgets

### Filters
- `query_vars` - Add custom query parameters
- `pre_get_posts` - Modify main query
- `widget_title` - Filter widget titles
- `the_content` - Modify post content

---

## Version History

| Version | Changes |
|---------|---------|
| 1.0.0 | Initial release |
| 1.0.1 | Bug fixes, theme options improvements |
| 1.2.0 | Added Ads Manager, Citizen News, Widgets, Polished Templates |

---

*Blueprint generated: 2026-01-20*
