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

class MailMessageHeadersMock extends \PHPUnit_Framework_TestCase
{

    protected function createMockedHeaderSetWithCssHeader($headerName, $css)
    {
        $textHeader = $this->getMockBuilder('\Swift_Mime_Headers_UnstructuredHeader')
            ->disableOriginalConstructor()
            ->getMock();
        $textHeader->expects($this->any())
            ->method('getFieldName')
            ->will($this->returnValue($headerName));
        $textHeader->expects($this->any())
            ->method('getFieldType')
            ->will($this->returnValue(\Swift_Mime_Header::TYPE_TEXT));
        $textHeader->expects($this->any())
            ->method('getFieldBody')
            ->will($this->returnValue($css));
        $headers = array(
            $textHeader
        );

        $headerSet = $this->getMockBuilder('\Swift_Mime_HeaderSet')
            ->disableOriginalConstructor()
            ->getMock();
        $headerSet->expects($this->any())
            ->method('getAll')
            ->will($this->returnValue($headers));

        return $headerSet;
    }

    protected function createMockedMessageWithCss($headerName, $body, $css, $contentType = 'text/html', array $parts = array())
    {
        $message = $this->getMockBuilder('Swift_Mime_Message')
            ->disableOriginalConstructor()
            ->getMock();
        $message->expects($this->any())
            ->method('getHeaders')
            ->will($this->returnValue($this->createMockedHeaderSetWithCssHeader($headerName, $css)));
        $message->expects($this->any())
            ->method('getBody')
            ->will($this->returnValue($body));
        $message->expects($this->any())
            ->method('getContentType')
            ->will($this->returnValue($contentType));
        $message->expects($this->any())
            ->method('getChildren')
            ->will($this->returnValue($parts));

        return $message;
    }
}
