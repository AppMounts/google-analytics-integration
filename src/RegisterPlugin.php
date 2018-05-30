<?php

namespace GoogleAnalyticsIntegration;


class RegisterPlugin
{
    public static function run()
    {
        // Shortcode register
        add_shortcode('google-analytics-optout', array('GoogleAnalyticsIntegration\RegisterPlugin', 'createGoogleAnalyticsOptoutLink'));

        // Shortcode in widgets
        add_filter('widget_text', 'do_shortcode');
        add_filter('script_loader_tag', array('GoogleAnalyticsIntegration\RegisterPlugin', 'addAsyncAttribute'), 10, 2);

        //
        add_action('wp_head', array('GoogleAnalyticsIntegration\RegisterPlugin', 'addTrackingCode'));
        add_action('admin_init', array('GoogleAnalyticsIntegration\RegisterPlugin', 'registerSettings'));
        add_action('admin_menu', array('GoogleAnalyticsIntegration\View\AdminOption', 'registerOptionPage'));

        wp_register_script('appmounts-google-analytics', 'https://www.google-analytics.com/analytics.js', array(), '0.1', true);
    }

    public function addTrackingCode()
    {
        $gaProperty = get_option('google_analytics_property');

        if (!empty($gaProperty)) {
            wp_enqueue_script('appmounts-google-analytics');

            echo "<script>
                var gaProperty = '" . $gaProperty . "';
                var disableStr = 'ga-disable-' + gaProperty;
                
                if (document.cookie.indexOf(disableStr + '=true') > -1) {
                    window[disableStr] = true;
                }
                
                function gaOptout() {
                    document.cookie = disableStr + '=true; expires=Thu, 31 Dec 2099 23:59:59 UTC; path=/';
                    window[disableStr] = true;
                    alert('Das Tracking durch Google Analytics wurde in Ihrem Browser für diese Website deaktiviert.');
                }
                
                window.ga=window.ga||function(){(ga.q=ga.q||[]).push(arguments)};ga.l=+new Date;
                ga('create', '" . $gaProperty . "', 'auto');
                ga('set', 'anonymizeIp', true);
                ga('send', 'pageview');
                </script>";
        }
    }

    public function registerSettings()
    {
        add_option('google_analytics_property', '');

        register_setting('appmounts_google_analytice_integration_group', 'google_analytics_property', 'myplugin_callback' );
    }

    public function createGoogleAnalyticsOptoutLink()
    {
        if (!empty($content)) {
            return '<a href="javascript:gaOptout();">'.$content.'</a>';
        }

        return "";
    }

    public function addAsyncAttribute($tag, $handle)
    {
        if ($handle !== 'appmounts-google-analytics') {
            return $tag;
        }

        return str_replace( ' src', ' async="async" src', $tag);
    }
}