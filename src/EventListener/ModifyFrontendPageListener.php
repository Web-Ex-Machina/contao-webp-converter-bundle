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

namespace WEM\WebpConverterBundle\EventListener;

use Contao\Config;
use Symfony\Component\Filesystem\Filesystem;
use WebPConvert\WebPConvert;
use WEM\WebpConverterBundle\Util\Helper;

class ModifyFrontendPageListener
{
    /**
     * @var array
     */
    protected $arrExcludedExtensions = ['webp'];

    /**
     * Convert pictures from HTML buffer.
     */
    public function convertPictures(string $buffer, string $templateName): string
    {
        // Skip the browser cannot handle webp
        if (!Helper::hasWebPSupport() || !Config::get('wem_useWebp')) {
            return $buffer;
        }

        // Skip main buffer, everything should be treated
        if (false !== strpos($templateName, 'fe_page')) {
            $paths = $this->extractPaths($buffer);

            if (!empty($paths)) {
                // Get encoding config
                $options = ['quality' => 'auto'];

                if (Config::get('wem_webpQuality')) {
                    $options['quality'] = (int) (Config::get('wem_webpQuality'));
                }

                foreach ($paths as $p) {
                    $webp = $this->convertToWebP(
                        $p['path'],
                        sprintf('assets/webpconverter/%s/%s', substr($p['name'], 0, 1), $p['name'].'.webp'),
                        $options
                    );

                    $buffer = str_replace($p['path'], $webp, $buffer);
                }
            }
        }

        return $buffer;
    }

    /**
     * Extract images paths.
     *
     * @param string $buffer             [HTML Buffer]
     * @param array  $excludedExtensions [Extensions to exclude (optional)]
     *
     * @return array [Pictures paths & extension]
     */
    protected function extractPaths(string $buffer, array $excludedExtensions = [])
    {
        preg_match_all('/img.*src="([^"]*)"/', $buffer, $result);
        $paths = [];

        $excludedExtensions = array_merge($excludedExtensions, $this->arrExcludedExtensions);

        if (!empty($result[1])) {
            foreach ($result[1] as $p) {
                $data = pathinfo($p);

                if (\in_array($data['extension'], $excludedExtensions, true)) {
                    continue;
                }

                $paths[] = [
                    'path' => $p,
                    'name' => $data['basename'],
                    'dir' => $data['dirname'],
                    'extension' => $data['extension'],
                ];
            }
        }

        return $paths;
    }

    /**
     * Call Webp Converter library & cache system.
     *
     * @param bool|bool $skipCache
     */
    private function convertToWebP(string $src, string $destination, array $options = [], bool $skipCache = false): string
    {
        // check if encoded
        if (preg_match('~%[0-9A-F]{2}~i', $src)) {
            $src = rawurldecode($src);
        }
        if (preg_match('~%[0-9A-F]{2}~i', $destination)) {
            $destination = rawurldecode($destination);
        }

        // Check if the wanted file already exists
        $filesystem = new FileSystem();

        if ($filesystem->exists($destination) && !$skipCache) {
            return $destination;
        }

        try {
            WebPConvert::convert($src, $destination, $options);

            return $destination;
        } catch(\WebPConvert\Exceptions\InvalidInput\InvalidImageTypeException $e) {
            return $src;
        } catch (\WebPConvert\Exceptions\WebPConvertException $e) {
            return $src;
        } catch (\WebPConvert\Exceptions\InvalidInput\TargetNotFoundException $e) {
            return $src;
        }
    }
}
