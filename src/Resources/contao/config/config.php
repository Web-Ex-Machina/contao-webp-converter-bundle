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

use WEM\WebpConverterBundle\EventListener\ModifyFrontendPageListener;

$GLOBALS['TL_HOOKS']['modifyFrontendPage'][] = [ModifyFrontendPageListener::class, 'convertPictures'];
