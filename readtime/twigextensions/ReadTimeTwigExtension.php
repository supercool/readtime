<?php

namespace Craft;

/**
 * ActivityLogger by Supercool
 *
 * @package   ActivityLogger
 * @author    Naveed Ziarab
 * @copyright Copyright (c) 2016, Supercool Ltd
 * @link      http://www.supercooldesign.co.uk
 */

use Twig_Extension;
use Twig_Filter_Method;

class ReadTimeTwigExtension extends Twig_Extension
{

    /**
    * Returns the Twig Extension's name
    * 
    * @return string
    */
    public function getName()
    {
        return 'ReadTime';
    }

    /**
    * Defines the twig filter which will be used in twig files
    * 
    * @return array
    */
    public function getFilters()
    {
        return array(
            'readtime' => new Twig_Filter_Method($this, 'readtimeFilter'),
        );
    }

    /**
    * This calculates how long it will take to read an entry
    * 
    * @return string
    */
    public function readtimeFilter($entry)
    {

        $content = "";

        $tabs = $entry->getFieldLayout()->getTabs();
        foreach ( $tabs as $tab ) 
        {
            foreach ($tab->getFields() as $field) 
            {
                $field = $field->getField();
                $handle = $field->handle;
                $type = $field->type;

                if ( $type == "RichText" || $type == "PlainText" )
                {
                    $content .= $entry->$handle . " ";
                }

                if ( $type == "Matrix" || $type == "Neo" )
                {
                    foreach ( $entry->$handle as $block ) 
                    {
                        foreach ( $block->getFieldLayout()->getFields() as $field )
                        {
                            $field = $field->getField();
                            $handle = $field->handle;
                            $type = $field->type;

                            if ( $type == "RichText" || $type == "PlainText" )
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