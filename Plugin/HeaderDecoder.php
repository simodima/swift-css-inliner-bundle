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


class HeaderDecoder
{

    /**
     * Try to decode an encoded mail header,
     * it only works with the php IMAP extension
     * @see http://www.php.net/manual/en/book.imap.php
     *
     * @param \Swift_Mime_Header $header
     * @return array|string
     */
    public function decodeHeader(\Swift_Mime_Header $header)
    {
        if(function_exists('imap_mime_header_decode')){
            return $this->extractDecodedImapHeaders(
                imap_mime_header_decode($header->getFieldBody())
            );
        }

        return '';
    }

    protected function extractDecodedImapHeaders(array $headers)
    {
        $body = '';
        foreach($headers as $header){
            $body.= (property_exists($header, 'text')) ? $headers->text : '';
        }

        return $body;

    }

} 