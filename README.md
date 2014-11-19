swift-css-inliner-bundle
========================
[![Latest Stable Version](https://poser.pugx.org/trt/swift-css-inliner-bundle/v/stable.png)](https://packagist.org/packages/trt/swift-css-inliner-bundle)
[![Build Status](https://travis-ci.org/toretto460/swift-css-inliner-bundle.png)](https://travis-ci.org/toretto460/swift-css-inliner-bundle)
[![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/toretto460/swift-css-inliner-bundle/badges/quality-score.png?s=7e5a05fb9346c1443c8235eca5376bbf31553b3d)](https://scrutinizer-ci.com/g/toretto460/swift-css-inliner-bundle/)

When HTML emails are viewed in browser-based email apps (like YahooMail!, Gmail, Hotmail, etc), those applications strip out the HEAD and BODY tags by default, so the only way to style the content is to place inline the CSS within the style attribute.
This is a dirty work for frontenders.
This plugin provides exactly the CSS processing to fille the style attributes.


Ex. using the [Zurb ink](http://zurb.com/ink/) mail template
[![Before After Plugin](https://dl.dropboxusercontent.com/u/49536335/before-after.png)](https://dl.dropboxusercontent.com/u/49536335/before-after.png)

#1. Installation

####Add the dependency within the ```composer.json```

```json
    "require": {
        "trt/swift-css-inliner-bundle": "~0.3"
    }
```

run `php composer.phar install`

####Enable the bundle (add the following line within the AppKernel.php)

```php
$bundles = array(
    [...]
    new \Trt\SwiftCssInlinerBundle\TrtSwiftCssInlinerBundle(),
);
```

#2. Usage - Full Example

```php
/**
 * @Route("/hello/{name}", name="_demo_hello")
 */
public function helloAction($name)
{
    $message = \Swift_Message::newInstance()
        ->setSubject('Hello Email')
        ->setFrom('send@example.com')
        ->setTo('recipient@example.com')
        ->setContentType('text/html')
        ->setBody("<style>.text{ color: red; }</style><p class='text'> $name </p>")
    ;
    $message->getHeaders()->addTextHeader(
        CssInlinerPlugin::CSS_HEADER_KEY_AUTODETECT
    );

    $this->get('mailer')->send($message);
}
```

#3. Usage - Step-by-step example

####1. Create the swiftmailer message.

```php
$message = \Swift_Message::newInstance()
    ->setSubject('Hello Email')
    ->setFrom('send@example.com')
    ->setTo('recipient@example.com')
    ->setContentType('text/html')
    ->setBody('<style>.text{color:red;}</style>  <p class="text"> Hello </p>')
;
```

####2. AutoDetect the "style" Html tag

The auto detect mode will find css within the style tag 

```php
$message->getHeaders()->addTextHeader(
    CssInlinerPlugin::CSS_HEADER_KEY_AUTODETECT
);
```

#### Add your style explicit

**ATTENTION**

The explicit mode work only with the php IMAP extension installed
@see [http://www.php.net/manual/en/book.imap.php](http://www.php.net/manual/en/book.imap.php)

```php
$message->getHeaders()->addTextHeader(
    CssInlinerPlugin::CSS_HEADER_KEY, //The key that say to the plugin "Apply this CSS"
    ".text{ color: red; }"
);
```

#### Send the message.

``` php
$this->get('mailer')->send($message);
```
