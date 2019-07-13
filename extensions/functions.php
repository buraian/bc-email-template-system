<?php


$functions = [
    // Lorem Ipsum Generator
    'lipsum' => new Twig_SimpleFunction('lipsum', function ($count = 1, $type = 'words', $wrapper = '') {
        $lipsum = new joshtronic\LoremIpsum();
        switch ($type) {
            case 'words':
                return $lipsum->words($count, $wrapper);
                break;

            case 'sentences':
                return $lipsum->sentences($count, $wrapper);
                break;

            case 'paragraphs':
                return $lipsum->paragraphs($count, $wrapper);
                break;

            default:
                throw new Exception("Lipsum type \"{$type}\" is not an option.", 1);
                break;
        }
    }),

    // Generate Sample Image
    'generate_image' => new Twig_SimpleFunction('generate_image', function ($options = []) {
        $service_url = 'https://imgplaceholder.com';
        $width       = $options['width']                  ?: 560;
        $height      = $options['height']                 ?: 315;
        $background  = ltrim($options['background'], '#') ?: 'd6d6d6';
        $fontColor   = ltrim($options['fontColor'], '#')  ?: 'b3b3b3';
        $fontSize    = $options['fontSize']               ?: null;
        $fontFamily  = $options['fontFamily']             ?: null;
        $message     = $options['message']                ?: null;
        $icon        = $options['icon']                   ?: 'fa-image';

        $hostpath = sprintf("https://imgplaceholder.com/%sx%s/%s/%s",
            $width,
            $height,
            $background,
            $fontColor
        );

        if (!$fontFamily && !$message) {
            $hostpath = "{$hostpath}/{$icon}";
        }

        $query = http_build_query([
            'font-family' => $fontFamily,
            'font-size'   => $fontSize,
            'text'        => $message,
        ]);

        $src = $query ? "{$hostpath}?{$query}" : $hostpath;

        $rawHTML = sprintf('<img src="%s" width="%s" height="%s" />',
            $src,
            $width,
            $height
        );

        return new \Twig\Markup($rawHTML, 'UTF-8');
    }),

    // Pathinfo (https://www.php.net/manual/en/function.pathinfo.php)
    'pathinfo' => new Twig_SimpleFunction('pathinfo', function ($path, $options = PATHINFO_DIRNAME | PATHINFO_BASENAME | PATHINFO_EXTENSION | PATHINFO_FILENAME) {
        return pathinfo($path, $options);
    }),
];

foreach ($functions as $function) {
    $container->get('view')->getEnvironment()->addFunction($function);
}
