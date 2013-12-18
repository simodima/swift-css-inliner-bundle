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
        if($style = $this->detectStylesheet($evt->getMessage()->getHeaders()->getAll())){
            $evt->getMessage()->setBody(
                $this->converter->convert($evt->getMessage()->getBody(), $style)
            );
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
     * @return String|null
     */
    protected function detectStylesheet(array $headers)
    {
        foreach($headers as $header){
            if($header->getFieldType() == \Swift_Mime_Header::TYPE_TEXT && $header->getFieldName() === self::CSS_HEADER_KEY){

                return $header->getFieldBody();
            }
        }

        return null;
    }
}