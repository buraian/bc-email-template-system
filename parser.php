<?php

/** Settings */
define('GENERICIZED', true);

/**
 * Template Functions
 */
class Templates {
    function __construct () {
        /** @var String $this->paramName URL Query Param */
        $this->paramName = 'template';

        /** @var String $this->srcFolder Template Source Folder */
        $this->srcFolder = '../Production/Static Markup';

        /** @var Object $this->profile A Random User Profile */
        $this->profile = call_user_func(function () {
            $result = $this->curl_download('http://jsonplaceholder.typicode.com/users');
            $result = json_decode($result);
            $result = $result[rand(0, 9)];
            return $result;
        });
    }

    /**
     * Template Paths
     */
    function templatePaths () {
        return [
            'Master'     => "{$this->srcFolder}/Master Template.html",
            'Template A' => "{$this->srcFolder}/Template A/Template A.html",
            'Template B' => "{$this->srcFolder}/Template B/Template B.html",
            'Template C' => "{$this->srcFolder}/Template C/Template C.html",
            'Template D' => "{$this->srcFolder}/Template D/Template D.html",
            'Template E' => "{$this->srcFolder}/Template E/Template E.html",
            'Template F' => "{$this->srcFolder}/Template F/Template F.html",
        ];
    }

    /**
     * Header Paths
     */
    function headerPaths () {
        return [
            'Header 1' => "{$this->srcFolder}/Header 1.html",
            'Header 2' => "{$this->srcFolder}/Header 2.html",
            'Header 3' => "{$this->srcFolder}/Header 3.html",
            'Header 4' => "{$this->srcFolder}/Header 4.html",
        ];
    }
    /**
     * Footer Paths
     */
    function footerPaths () {
        return [
            'Footer 1' => "{$this->srcFolder}/Footer 1.html",
        ];
    }

    /**
     * Load Template Files Contents
     */
    function loadTemplateFile ($type, $key) {
        if ($type === 'template') {
            $file = $this->templatePaths()[$key];
        }
        elseif ($type === 'header') {
            $file = $this->headerPaths()[$key];
        }
        elseif ($type === 'footer') {
            $file = $this->footerPaths()[$key];
        }

        if (file_exists($file)) return file_get_contents($file);
    }

    /**
     * Parse Template HTML
     */
    function parseTemplate ($key) {
        $template = $this->loadTemplateFile('template', $key);

        $regexForIncludes = '/\[cc\((\w+)\):([\w-]+)\]/';
        $regexForFields = '/\[(p|edit|content):([\w-]+)(:"([^[\]]+)")?\]/';

        $compiledTemplate = preg_replace_callback($regexForIncludes, array($this, 'includeReplacer'), $template);
        $parsedTemplate = preg_replace_callback($regexForFields, array($this, 'replaceFields'), $compiledTemplate);

        return $parsedTemplate;
    }

    function includeReplacer ($matches) {
        switch ($matches[2]) {
            case 'header_html':
                return $this->loadTemplateFile('header', 'Header ' . rand(1, 4));
                break;

            case 'footer':
                return $this->loadTemplateFile('footer', 'Footer 1');
                break;
        }
    }

    function replaceFields ($matches) {
        /**
         * $matches[0] ... "[p:company]"
         * $matches[1] ... "p", "edit", "content"
         * $matches[2] ... "company", "address"
         * $matches[3] ... "" &bull; ""
         * $matches[4] ... " &bull; "
         */

        switch ($matches[1]) {
            case 'content':
                return $this->content()[$matches[2]];
                break;

            case 'edit':
                return $this->edit()[$matches[2]];
                break;

            case 'p':
                $profileField = $this->profile()[$matches[2]];
                if ($profileField) {
                    return $profileField . $matches[4];
                }
                break;

            default:
                return $matches[0];
                break;
        }
    }

    /**
     * Fetch API Data
     *
     * @param String $url
     * @return Array
     */
    function curl_download(String $url){
        if (!function_exists('curl_init')){
            die('Sorry cURL is not installed!');
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($ch);
        curl_close($ch);

        return $output;
    }

    /**
     * Content Fields
     */
    function content () {
        return [
            'current_year' => '2013',
        ];
    }

    /**
     * Edit Fields
     */
    function edit () {
        return [
            'image1' => 'https://imgplaceholder.com/560x350/d6d6d6/b3b3b3/ion-ios-photos',
            'image2' => 'https://imgplaceholder.com/560x350/d6d6d6/b3b3b3/ion-ios-photos',
            'image3' => 'https://imgplaceholder.com/560x350/d6d6d6/b3b3b3/ion-ios-photos',
            'text1' => null,
            'text2' => null,
            'text3' => null,
            'text4' => null,
            'offer1title' => '25% OFF',
            'offer1description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
            'offer2title' => 'BUY 1 GET 1 FREE',
            'offer2description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
            'offer3title' => '1/2 OFF',
            'offer3description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
            'contact-statement' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam id dolor id nibh ultricies vehicula ut id elit. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit. Donec ullamcorper nulla non metus auctor fringilla. Curabitur blandit tempus porttitor.',
            'disclaimer' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam quis risus eget urna mollis ornare vel eu leo. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec sed odio dui. Donec id elit non mi porta gravida at eget metus. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Integer posuere erat a ante venenatis dapibus posuere velit aliquet. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Cras mattis consectetur purus sit amet fermentum. Curabitur blandit tempus porttitor. Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor. Nulla vitae elit libero, a pharetra augue.',
        ];
    }

    /**
     * Profile Fields
     */
    function profile () {
        return [
            'company' => $this->profile->company->name,
            'company_logo_medium' => '<img src="https://imgplaceholder.com/560x248/d6d6d6/b3b3b3?text=COMPANY&font-size=72&font-family=stiljaFree" />',
            'address' => rand(10000, 90000) . ' ' . $this->profile->address->street,
            'address2' => $this->profile->address->suite,
            'city' => $this->profile->address->city,
            'state' => 'TX',
            'zip' => $this->profile->address->zipcode,
            'country' => null,
            'phone' => $this->profile->phone,
            'fax' => null,
            'email' => $this->profile->email,
            'website' => $this->profile->website,
            'twitter_username' => null,
            'facebook_username' => null,
        ];
    }
}

$foo = new Templates;

if ($_GET[$foo->paramName]):
    $doc = $foo->parseTemplate(urldecode($_GET[$foo->paramName]));
    if (GENERICIZED) {
        $doc = preg_replace('/<\/head>/', '<link type="text/css" href="./style.css" rel="stylesheet" /></head>', $doc);
        $doc = preg_replace('/<\/body>/', '<script type="text/javascript" src="./style.js"></script></body>', $doc);
        echo $doc;
    }
    else {
        echo $doc;
    }
else:

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Template Parser/Viewer</title>
</head>
<body>
    <ul><?php
        foreach ($foo->templatePaths() as $key => $value) {
            $encodedKey = urlencode($key);
            echo "<li><a href=\"?{$foo->paramName}={$encodedKey}\">{$key}</a></li>";
        }
    ?></ul>
</body>
</html><?php

endif;
