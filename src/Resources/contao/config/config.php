<?php

use WEM\WebpConverterBundle\EventListener\ParseFrontendTemplateListener;

$GLOBALS['TL_HOOKS']['parseFrontendTemplate'][] = [ParseFrontendTemplateListener::class, 'convertPictures'];