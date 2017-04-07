<?php
/**
 * Readtime
 *
 * @link      http://supercooldesign.co.uk
 * @copyright Copyright (c) 2017 Supercool
 */

namespace supercool\readtime\twigextensions;

use Craft;

/**
 * Twig can be extended in many ways; you can add extra tags, filters, tests, operators,
 * global variables, and functions. You can even extend the parser itself with
 * node visitors.
 *
 * http://twig.sensiolabs.org/doc/advanced.html
 *
 * @author    Supercool
 * @package   Readtime
 * @since     1.0.0
 */
class ReadtimeTwigExtension extends \Twig_Extension
{
    // Public Methods
    // =========================================================================

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'Read Time';
    }

    /**
     * Returns an array of Twig filters, used in Twig templates via:
     *
     *      {{ 'something' | someFilter }}
     *
     * @return array
     */
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('readtime', [$this, 'readtimeFilter']),
        ];
    }

    /**
     * Returns an array of Twig functions, used in Twig templates via:
     *
     *      {% set this = someFunction('something') %}
     *
    * @return array
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('readtime', [$this, 'readtimeFilter']),
        ];
    }

    /**
     * Our function called via Twig; it can do anything you want
     *
     * @param null $text
     *
     * @return string
     */
    public function readtimeFilter($entry = null)
    {
        $content = "";

        $tabs = $entry->getFieldLayout()->getTabs();

        foreach ( $tabs as $tab ) 
        {

            foreach ($tab->getFields() as $field) 
            {
                $handle = $field->handle;
                $type = get_class($field);

                if ( $type == 'craft\fields\PlainText' || $type == 'craft\fields\RichText' )
                {
                    $content .= $entry->$handle . " ";
                }

                if ( $type == 'craft\fields\Matrix' || $type == "Neo" )
                {
                    foreach ( $entry->$handle as $block ) 
                    {
                        foreach ( $block->getFieldLayout()->getFields() as $field )
                        {
                            $handle = $field->handle;
                            $type = get_class($field);

                            if ( $type == 'craft\fields\PlainText' || $type == 'craft\fields\RichText' )
                            {
                                $content .= $block->$handle . " ";
                            }
                        }
                    }
                }
            }
        }

        $content = strip_tags($content);

        $words = str_word_count( $content );
        $min = floor( $words / 150 );
        $duration = ( $min < 1 ? '1' : $min ) . ' minute';

        return $duration;
    }
}
