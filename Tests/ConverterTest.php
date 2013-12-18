<?php
/**
 * This file is part of swiftMailerInlineCss package.
 *
 * Simone Di Maulo <toretto460@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Trt\SwiftCssInlinerBundle\Tests;

use TijsVerkoyen\CssToInlineStyles\Exception;
use Trt\SwiftCssInlinerBundle\Converter\Converter;

class ConverterTest extends \PHPUnit_Framework_TestCase
{

    protected $mockedCssConverter;

    public function setUp()
    {
        $this->mockedCssConverter = $this->getMock('TijsVerkoyen\CssToInlineStyles\CssToInlineStyles');
    }

    /**
     * @dataProvider provideHtmlCss
     *
     * @param $html
     *
     * @param $css
     */
    public function test_convert($html, $css)
    {
        $this->mockedCssConverter->expects($this->once())
            ->method('setHTML')
            ->with($this->equalTo($html))
        ;

        $this->mockedCssConverter->expects($this->once())
            ->method('setCSS')
            ->with($this->equalTo($css))
        ;

        $this->mockedCssConverter->expects($this->once())
            ->method('convert')
            ->will($this->returnValue($html . $css));

        $converter = new Converter($this->mockedCssConverter);

        $processedText = $converter->convert($html, $css);

        $this->assertEquals($html.$css, $processedText);
    }

    /**
     * @dataProvider provideHtmlCss
     *
     * @param $html
     *
     * @param $css
     */
    public function test_convert_no_html($html, $css)
    {
        $this->mockedCssConverter->expects($this->once())
            ->method('setHTML')
            ->with($this->equalTo($html))
        ;

        $this->mockedCssConverter->expects($this->once())
            ->method('setCSS')
            ->with($this->equalTo($css))
        ;

        $this->mockedCssConverter->expects($this->once())
            ->method('convert')
            ->will($this->throwException(new Exception()));

        $converter = new Converter($this->mockedCssConverter);
        $processedText = $converter->convert($html, $css);

        $this->assertEquals($html, $processedText);

    }

    /**
     * Html and Css provider.
     *
     * @return array
     */
    public function provideHtmlCss()
    {
        return array(
            array('<html></html>', '.html{color:red;}')
        );
    }

} 