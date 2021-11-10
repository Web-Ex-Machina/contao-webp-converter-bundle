<?php

use WEM\WebpConverterBundle\EventListener\ModifyFrontendPageListener;

$GLOBALS['TL_HOOKS']['modifyFrontendPage'][] = [ModifyFrontendPageListener::class, 'convertPictures'];