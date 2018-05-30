<?php

spl_autoload_register(function ($className) {
    if (strpos($className, 'GoogleAnalyticsIntegration') !== false) {
        $fileName = str_replace('\\', '/', $className);

        include_once 'src/' . str_replace('GoogleAnalyticsIntegration/', '', $fileName) . '.php';
    }
});