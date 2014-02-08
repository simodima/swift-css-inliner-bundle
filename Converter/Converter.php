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


class Converter implements ConverterInterface
{
    protected $cssConverter;

    /**
     * @param  $cssConverter
     */
    public function __construct($cssConverter)
    {
        $this->cssConverter = $cssConverter;
    }

    /**
     * @param  String  $html
     *
     * @param  String  $stylesheet
     *
     * @param  Boolean $autoDetectCss
     *
     * @return String
     */
    public function convert($html, $stylesheet, $autoDetectCss = false)
    {
        $this->cssConverter->setHTML($html);
        $this->cssConverter->setCSS($stylesheet);
        $this->cssConverter->setUseInlineStylesBlock($autoDetectCss);
        try{
            $convertedHtml = $this->cssConverter->convert();
        } catch (\Exception $e){
            return $html;
        }

        return $convertedHtml;
    }
}