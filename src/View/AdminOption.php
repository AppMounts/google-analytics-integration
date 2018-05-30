<?php

namespace GoogleAnalyticsIntegration\View;


class AdminOption
{
    function registerOptionPage()
    {
        add_options_page(
            'Google Analytics Integration by AppMounts',
            'Google Analytics',
            'manage_options',
            'google-analytics-integration',
            array(
                'GoogleAnalyticsIntegration\View\AdminOption',
                'showOptionPage'
            )
        );
    }

    function showOptionPage()
    {
        do_settings_fields('writing', 'default');

        echo "<div class=\"wrap\">" .
             "<h1>Google Analytics</h1>" .
             "<form method=\"post\" action=\"options.php\">";
        echo settings_fields('appmounts_google_analytice_integration_group');
        echo "<table class=\"form-table tools-privacy-policy-page\">" .
             "<tr>" .
             "<th scope=\"row\">Google Analytics ID</th>" .
             "<td>" .
             "<input name=\"google_analytics_property\" type=\"text\" value=\"" . get_option('google_analytics_property') . " \" class=\"regular-text ltr\" />" .
             "</td>" .
             "</table>";
        echo submit_button();
        echo "</form>" .
             "</div>";
    }
}