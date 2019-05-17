<?php

namespace Roots\Branding;

// Set up plugin class
class Init
{
    public function __construct()
    {
        add_action('login_enqueue_scripts', [$this, 'login_logo']);
        add_filter('admin_footer_text', [$this, 'admin_footer'], 11);
        add_action('admin_bar_menu', [$this, 'remove_wp_logo'], 999);
        add_action('admin_bar_menu', [$this, 'create_menu'], 1);
        add_action('wp_before_admin_bar_render', [$this, 'menu_custom_logo']);
        add_filter('login_headerurl', [$this, 'login_logo_url']);
        add_filter('login_headertext', [$this, 'login_logo_headertext']);
    }


    /**
    * Remove WordPress admin bar menu
    */
    public function remove_wp_logo($wp_admin_bar)
    {
        $wp_admin_bar->remove_node('wp-logo');
    }


    /**
    * Replace login screen logo
    */
    public function login_logo()
    {
        ?>
    <style type="text/css">
      body.login div#login h1 a {
      background-image: url( <?=(ROOTS_BRANDING_PLUGIN_URL . 'assets/images/logo-icon.svg')?> );
      background-repeat: no-repeat;
      background-size: auto;
      width: 300px;
    }
    </style>
  <?php
    }



    /**
     * Replace login screen logo link
     */
    public function login_logo_url($url)
    {
        return 'https://roots.io';
    }



    // Replace login logo title
    public function login_logo_headertext()
    {
        return 'Powered by Roots';
    }


    // Create custom admin bar m enu
    public function create_menu()
    {
        global $wp_admin_bar;
        $menu_id = 'my-logo';
        $wp_admin_bar->add_node([
          'id' => $menu_id,
          'title' =>
          '<span class="ab-icon">' . file_get_contents(ROOTS_BRANDING_PLUGIN_DIR . "assets/images/logo-icon.svg") . '</span>',
          'href' => '/'
          ]);
        $wp_admin_bar->add_node([
          'parent' => $menu_id,
          'title' => __('Homepage'),
          'id' => 'my-logo-home',
          'href' => 'https://roots.io',
          'meta' => ['target' => '_blank']
          ]);
    }


    /**
    * Replace login screen logo
    */
    public function menu_custom_logo()
    {
        ?>
    <style type="text/css">
      #wpadminbar #wp-admin-bar-my-logo > .ab-item .ab-icon {
        height: 20px;
        width: 20px;
        margin-right: 0 !important;
        padding-top: 7px !important;
      }
      #wpadminbar #wp-admin-bar-my-logo > .ab-item .ab-icon svg * {
        fill: currentColor;
      }
    </style>
  <?php
    }

    /**
    * Add "designed and developed..." to admin footer.
    */
    public function admin_footer($content)
    {
        return 'Site powered by <a href="https://roots.io">Roots</a>';
    }
}
