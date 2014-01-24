<?php
/**
 * This file is part of swiftMailerInlineCss package.
 *
 * Simone Di Maulo <toretto460@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Trt\SwiftCssInlinerBundle\Plugin;

use Swift_Events_SendEvent;
use Trt\SwiftCssInlinerBundle\Converter\ConverterInterface;

class CssInlinerPlugin implements \Swift_Events_SendListener
{
    const CSS_HEADER_KEY = 'css';
    const CSS_HEADER_KEY_AUTODETECT = 'css-autodetect';

    protected $converter;

    public function __construct(ConverterInterface $converter)
    {
        $this->converter = $converter;
    }

    /**
     * Invoked immediately before the Message is sent.
     *
     * @param Swift_Events_SendEvent $evt
     */
    public function beforeSendPerformed(Swift_Events_SendEvent $evt)
    {
        $styleSheetHeader = $this->detectStylesheetHeader($evt->getMessage()->getHeaders()->getAll());
        if($styleSheetHeader !== null ){

            $autoDetectCss = ($styleSheetHeader->getFieldName() == self::CSS_HEADER_KEY_AUTODETECT);
            $evt->getMessage()->setBody(
                $this->converter->convert($evt->getMessage()->getBody(), $styleSheetHeader->getFieldBody(), $autoDetectCss)
            );
            $evt->getMessage()->getHeaders()->remove(self::CSS_HEADER_KEY);
        }
    }

    /**
     * Invoked immediately after the Message is sent.
     *
     * @param Swift_Events_SendEvent $evt
     */
    public function sendPerformed(Swift_Events_SendEvent $evt)
    {
    }

    /**
     * @param \Swift_Mime_Header[] $headers
     * @return \Swift_Mime_Header|null
     */
    protected function detectStylesheetHeader(array $headers)
    {
        foreach($headers as $header){
            if(
                ($header->getFieldType() == \Swift_Mime_Header::TYPE_TEXT && $header->getFieldName() === self::CSS_HEADER_KEY) ||
                ($header->getFieldType() == \Swift_Mime_Header::TYPE_TEXT && $header->getFieldName() === self::CSS_HEADER_KEY_AUTODETECT)
            )
            {
                return $header;
            }
        }

        return null;
    }
}