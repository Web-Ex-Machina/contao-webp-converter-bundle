<?php

namespace WEM\WebpConverterBundle\EventListener;

use Contao\CoreBundle\ServiceAnnotation\Hook;
use Contao\FrontendTemplate;

class ParseFrontendTemplateListener
{
    public function convertPictures(string $buffer, string $templateName): string
    {
        if ('ce_text' === $templateName) {
            // Modify $buffer
        }

        dump($buffer);

        return $buffer;
    }
}