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

class CssInlinerPluginTest extends \PHPUnit_Framework_TestCase
{
    protected $mockedConverter;

    /**
     * CssInlinerPluginTest setUp
     */
    public function setUp()
    {
        $this->mockedConverter = $this->getMock('Trt\SwiftCssInlinerBundle\Converter\ConverterInterface');

    }

    public function test_beforeSend()
    {
        $mockedMessage = $this->createMockedMessageWithCss();
        $eventMessageWithCss = $this->getMockBuilder('\Swift_Events_SendEvent')
            ->disableOriginalConstructor()
            ->getMock();

        $eventMessageWithCss->expects($this->any())
            ->method('getMessage')
            ->will($this->returnValue($mockedMessage));
        $this->mockedConverter->expects($this->once())
            ->method('convert')
            ->will($this->returnValue('convertedBody'))
        ;

        $mockedMessage->expects($this->once())
            ->method('setBody')
            ->with($this->equalTo('convertedBody'));

        $plugin = new CssInlinerPlugin($this->mockedConverter);
        $plugin->beforeSendPerformed($eventMessageWithCss);
    }

    protected function createMockedHeaderSetWithCss()
    {
        $textHeader = $this->getMockBuilder('\Swift_Mime_Headers_UnstructuredHeader')
            ->disableOriginalConstructor()
            ->getMock();
        $textHeader->expects($this->once())
            ->method('getFieldName')
            ->will($this->returnValue(CssInlinerPlugin::CSS_HEADER_KEY));
        $textHeader->expects($this->once())
            ->method('getFieldType')
            ->will($this->returnValue(\Swift_Mime_Header::TYPE_TEXT));
        $textHeader->expects($this->once())
            ->method('getFieldBody')
            ->will($this->returnValue('.css_class{color:black;}'));
        $headers = array(
            $textHeader
        );

        $headerSet = $this->getMockBuilder('\Swift_Mime_HeaderSet')
            ->disableOriginalConstructor()
            ->getMock();
        $headerSet->expects($this->any())
            ->method('getAll')
            ->will($this->returnValue($headers));
        $headerSet->expects($this->once())
            ->method('remove')
            ->with($this->equalTo(CssInlinerPlugin::CSS_HEADER_KEY));

        return $headerSet;
    }

    protected function createMockedMessageWithCss()
    {
        $message = $this->getMockBuilder('Swift_Mime_Message')
            ->disableOriginalConstructor()
            ->getMock();
        $message->expects($this->any())
            ->method('getHeaders')
            ->will($this->returnValue($this->createMockedHeaderSetWithCss()));

        return $message;
    }
}
 