<?php

namespace WEM\WebpConverterBundle\EventListener;

use Contao\CoreBundle\ServiceAnnotation\Hook;
use Contao\FrontendTemplate;

class ModifyFrontendPageListener
{
    public function convertPictures(string $buffer, string $templateName): string
    {
        // Skip main buffer, everything should be treated
        if (false !== strpos($templateName, "fe_page")) {
            $paths = $this->extractPaths($buffer);
            dump($paths);
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
                $ext = pathinfo($p, PATHINFO_EXTENSION);

                if($excludeExtensions && in_array($ext, $excludeExtensions)) {
                    continue;
                }

                $paths[] = [
                    'path' => $p,
                    'extension' => $ext
                ];
            }
        }

        return $paths;
    }

    private function convertToWebP(string $path)
    {

    }
}