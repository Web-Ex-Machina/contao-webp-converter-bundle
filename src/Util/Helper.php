<?php

namespace WEM\WebpConverterBundle\Util;

use Contao\Environment;

class Helper
{
    public static function hasWebPSupport() {
        $ua = Environment::get('agent');

        return ($ua->browser == 'firefox' && $ua->version >= 65)
            || ($ua->browser == 'chrome' && $ua->version >= 32 && $ua->os !== 'ios')
            || ($ua->browser == 'edge' && $ua->version >= 18)
            || ($ua->browser == 'opera' && $ua->version >= 18)
            || (strpos($_SERVER['HTTP_ACCEPT'], 'image/webp') !== false);
    }
}