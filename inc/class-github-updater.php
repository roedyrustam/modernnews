<?php
/**
 * Modern News GitHub Theme Updater
 * 
 * Handles checking and performing updates from a GitHub repository.
 */

if (!defined('ABSPATH')) {
    exit;
}

class ModernNews_GitHub_Updater {
    private $file;
    private $theme;
    private $basename;
    private $active;
    private $username;
    private $repository;
    private $authorize_token;
    private $github_response;

    public function __construct($file) {
        $this->file = $file;
        add_action('admin_init', array($this, 'set_theme_properties'));
    }

    public function set_theme_properties() {
        $this->theme = wp_get_theme(get_template());
        $this->basename = get_template();
        $this->active = ($this->basename === get_template());
    }

    public function set_username($username) {
        $this->username = $username;
    }

    public function set_repository($repository) {
        $this->repository = $repository;
    }

    public function authorize($token) {
        $this->authorize_token = $token;
    }

    private function get_repository_info() {
        if (is_null($this->github_response)) {
            $args = array();
            $url = "https://api.github.com/repos/{$this->username}/{$this->repository}/releases/latest";

            if ($this->authorize_token) {
                $args['headers']['Authorization'] = "token {$this->authorize_token}";
            }

            $response = wp_remote_get($url, $args);

            if (is_wp_error($response)) {
                return false;
            }

            $this->github_response = json_decode(wp_remote_retrieve_body($response));
        }

        return $this->github_response;
    }

    public function initialize() {
        add_filter('pre_set_site_transient_update_themes', array($this, 'modify_transient'));
        add_filter('upgrader_post_install', array($this, 'after_install'), 10, 3);
        add_filter('http_request_args', array($this, 'download_package'), 10, 2);
    }

    public function modify_transient($transient) {
        if (empty($transient->checked)) {
            return $transient;
        }

        $repo_info = $this->get_repository_info();

        if ($repo_info && isset($repo_info->tag_name)) {
            $latest_version = str_replace('v', '', $repo_info->tag_name);
            $current_version = $this->theme->get('Version');

            if (version_compare($latest_version, $current_version, '>')) {
                $new_update = array(
                    'theme'       => $this->basename,
                    'new_version' => $latest_version,
                    'url'         => "https://github.com/{$this->username}/{$this->repository}",
                    'package'     => $repo_info->zipball_url,
                );

                $transient->response[$this->basename] = $new_update;
            }
        }

        return $transient;
    }

    public function after_install($response, $hook_extra, $result) {
        global $wp_filesystem;

        $install_directory = get_theme_root() . '/' . $this->basename;
        $wp_filesystem->move($result['destination'], $install_directory);
        $result['destination'] = $install_directory;

        return $result;
    }

    public function download_package($args, $url) {
        if (is_null($this->authorize_token)) {
            return $args;
        }

        // Check if the URL is for this repository's zipball
        if (strpos($url, "api.github.com/repos/{$this->username}/{$this->repository}/zipball") !== false || 
            strpos($url, "codeload.github.com/{$this->username}/{$this->repository}/legacy.zip") !== false) {
            $args['headers']['Authorization'] = "token {$this->authorize_token}";
        }

        return $args;
    }
}
