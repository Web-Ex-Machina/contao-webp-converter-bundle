<?php

namespace WEM\WebpConverterBundle\EventListener;

use Contao\CoreBundle\ServiceAnnotation\Hook;
use Contao\FrontendTemplate;
use Symfony\Component\Filesystem\Filesystem;
use WebPConvert\WebPConvert;
use WEM\WebpConverterBundle\Util\Helper;

class ModifyFrontendPageListener
{
    public function convertPictures(string $buffer, string $templateName): string
    {   
        // Skip the browser cannot handle webp
        if(!Helper::hasWebPSupport()) {
            return $buffer;
        }

        // Skip main buffer, everything should be treated
        if (false !== strpos($templateName, "fe_page")) {
            $paths = $this->extractPaths($buffer);
            
            if(!empty($paths)) {
                foreach($paths as $p) {
                    $webp = $this->convertToWebP(
                        $p['path'],
                        sprintf('assets/webpconverter/%s/%s', substr($p['name'], 0, 1), $p['name'] . '.webp')
                    );

                    $buffer = str_replace($p['path'], $webp, $buffer);
                }
            }
        }

        return $buffer;
    }

    /**
     * Extract images paths
     * 
     * @param  string $buffer            [HTML Buffer]
     * @param  array  $excludeExtensions [Extensions to exclude (optional)]
     * 
     * @return array                    [Pictures paths & extension]
     */
    protected function extractPaths(string $buffer, array $excludeExtensions = []) {
        preg_match_all('/src="([^"]*)"/', $buffer, $result);
        $paths = [];

        if(!empty($result[1])) {
            foreach ($result[1] as $p) {
                $data = pathinfo($p);

                if($excludeExtensions && in_array($data['extension'], $excludeExtensions)) {
                    continue;
                }

                $paths[] = [
                    'path' => $p,
                    'name' => $data['basename'],
                    'dir' => $data['dirname'],
                    'extension' => $data['extension']
                ];
            }
        }

        return $paths;
    }

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

        if ($filesystem->exists($destination)) {
            return $destination;
        }

        try {
            WebPConvert::convert($src, $destination, $options);
            return $destination;

        } catch (ConversionFailedException $e) {
            return $src;

        } catch (TargetNotFoundException $e) {
            return $src;
        }
    }
}