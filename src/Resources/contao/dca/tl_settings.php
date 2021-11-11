<?php

use Contao\CoreBundle\DataContainer\PaletteManipulator;

/**
 * Palettes
 */
PaletteManipulator::create()
	->addLegend('wem_webp_legend', 'files_legend', PaletteManipulator::POSITION_BEFORE)
    ->addField('wem_useWebp', 'wem_webp_legend', PaletteManipulator::POSITION_APPEND)
    ->applyToPalette('default', 'tl_settings') 
;
$GLOBALS['TL_DCA']['tl_settings']['palettes']['__selector__'][] = 'wem_useWebp';
$GLOBALS['TL_DCA']['tl_settings']['subpalettes']['wem_useWebp'] = 'wem_webpQuality';

/**
 * Fields
 */
$GLOBALS['TL_DCA']['tl_settings']['fields']['wem_useWebp'] = [
    'label'     => $GLOBALS['TL_LANG']['tl_settings']['wem_useWebp'],
    'inputType' => 'checkbox',
    'exclude'   => true,
    'eval'      => array('tl_class' => 'clr w50', 'submitOnChange' => true),
];
$GLOBALS['TL_DCA']['tl_settings']['fields']['wem_webpQuality'] = [
    'label'     => $GLOBALS['TL_LANG']['tl_settings']['wem_webpQuality'],
    'exclude'   => true,
    'inputType' => 'text',
    'default'   => 'auto',
    'eval'      => array('tl_class' => 'w50'),
];
