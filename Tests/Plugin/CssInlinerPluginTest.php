<?php
/*
 * This file is part of the swiftmailer-inlinercss-plugin package.
 *
 * (c) toretto460 <toretto460@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Trt\SwiftCssInlinerBundle\Tests\Plugin;

use Trt\SwiftCssInlinerBundle\Plugin\CssInlinerPlugin;

class CssInlinerPluginTest extends MailMessageHeadersMock
{
    protected $mockedConverter;
    protected $mockedHeaderDecoder;

    /**
     * CssInlinerPluginTest setUp
     */
    public function setUp()
    {
        $this->mockedConverter      = $this->getMock('Trt\SwiftCssInlinerBundle\Converter\ConverterInterface');
        $this->mockedHeaderDecoder  = $this->getMock('Trt\SwiftCssInlinerBundle\Plugin\HeaderDecoder');
    }

    public function test_beforeSendWithExplicitCss()
    {

        /**
         * Assumes that the php IMAP extension is installed.
         */
        $this->mockedHeaderDecoder->expects($this->any())
            ->method('decodeHeader')
            ->will($this->returnCallback(function(\Swift_Mime_Header $header){
                return $header->getFieldBody();
            }));

        $mockedMessage = $this->createMockedMessageWithCss(
            CssInlinerPlugin::CSS_HEADER_KEY,
            '<html><p>test</p></html>',
            '.css_class{color:black;}'
        );
        $eventMessageWithCss = $this->getMockBuilder('\Swift_Events_SendEvent')
            ->disableOriginalConstructor()
            ->getMock();

        $eventMessageWithCss->expects($this->any())
            ->method('getMessage')
            ->will($this->returnValue($mockedMessage));
        $this->mockedConverter->expects($this->once())
            ->method('convert')
            ->with(
                $this->equalTo('<html><p>test</p></html>'),
                $this->equalTo('.css_class{color:black;}'),
                $this->equalTo(false)
            )
            ->will($this->returnValue('convertedBody'))
        ;

        $mockedMessage->expects($this->once())
            ->method('setBody')
            ->with($this->equalTo('convertedBody'));

        $plugin = new CssInlinerPlugin($this->mockedConverter, $this->mockedHeaderDecoder);
        $plugin->beforeSendPerformed($eventMessageWithCss);
    }

    public function test_beforeSendWithAutoDetectCss()
    {
        /**
         * Assumes that the php IMAP extension was not installed.
         */
        $this->mockedHeaderDecoder->expects($this->any())
            ->method('decodeHeader')
            ->will($this->returnValue(''));

        $mockedMessage = $this->createMockedMessageWithCss(
            CssInlinerPlugin::CSS_HEADER_KEY_AUTODETECT,
            '<html><p>test</p></html>',
            ''
        );
        $eventMessageWithCss = $this->getMockBuilder('\Swift_Events_SendEvent')
            ->disableOriginalConstructor()
            ->getMock();

        $eventMessageWithCss->expects($this->any())
            ->method('getMessage')
            ->will($this->returnValue($mockedMessage));

        $this->mockedConverter->expects($this->once())
            ->method('convert')
            ->with(
                $this->equalTo('<html><p>test</p></html>'),
                $this->equalTo(''),
                $this->equalTo(true)
            )
            ->will($this->returnValue('convertedBody'))
        ;

        $mockedMessage->expects($this->once())
            ->method('setBody')
            ->with($this->equalTo('convertedBody'));

        $plugin = new CssInlinerPlugin($this->mockedConverter, $this->mockedHeaderDecoder);
        $plugin->beforeSendPerformed($eventMessageWithCss);
    }


}
 