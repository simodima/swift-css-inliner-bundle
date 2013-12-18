<?php
/**
 * This file is part of swiftMailerInlineCss package.
 *
 * Simone Di Maulo <toretto460@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Trt\SwiftCssInlinerBundle\Converter;


interface ConverterInterface
{
    /**
     * @param String $cssConverterClass
     */
    public function __construct($cssConverterClass);

    /**
     * @param  String $message
     *
     * @param  String $stylesheet
     *
     * @return String
     */
    public function convert($message, $stylesheet);
}