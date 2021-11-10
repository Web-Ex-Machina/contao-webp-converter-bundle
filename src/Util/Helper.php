<?php

declare(strict_types=1);

/**
 * WebP Converter for Contao Open Source CMS
 * Copyright (c) 2021 Web ex Machina
 *
 * @category ContaoBundle
 * @package  Web-Ex-Machina/contao-webp-converter-bundle
 * @author   Web ex Machina <contact@webexmachina.fr>
 * @link     https://github.com/Web-Ex-Machina/contao-webp-converter-bundle/
 */

namespace WEM\WebpConverterBundle\Util;

use Contao\Environment;

class Helper
{
    public static function hasWebPSupport()
    {
        $ua = Environment::get('agent');

        return ('firefox' === $ua->browser && $ua->version >= 65)
            || ('chrome' === $ua->browser && $ua->version >= 32 && 'ios' !== $ua->os)
            || ('edge' === $ua->browser && $ua->version >= 18)
            || ('opera' === $ua->browser && $ua->version >= 18)
            || (false !== strpos($_SERVER['HTTP_ACCEPT'], 'image/webp'));
    }
}
