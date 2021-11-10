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

namespace WEM\WebpConverterBundle\ContaoManager;

use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use WEM\WebpConverterBundle\WEMWebpConverterBundle;

/**
 * Plugin for the Contao Manager.
 *
 * @author Web ex Machina <https://www.webexmachina.fr>
 */
class Plugin implements BundlePluginInterface
{
    /**
     * {@inheritdoc}
     */
    public function getBundles(ParserInterface $parser)
    {
        return [
            BundleConfig::create(WEMWebpConverterBundle::class)
                ->setLoadAfter([ContaoCoreBundle::class])
                ->setReplace(['wem-webp-converter']),
        ];
    }
}
