<?php

require 'lib/SampleProfile.php';

$profile = new SampleProfile();

$variables = [
    // Content Fields
    'content' => [
        'current_year' => '2013',
    ],

    // Edit Fields
    'edit' => [
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
    ],

    // Profile Fields
    'profile' => [
        'company' => $profile->data->company->name,
        'company_logo_medium' => 'https://imgplaceholder.com/560x248/d6d6d6/b3b3b3?text=COMPANY&font-size=72&font-family=stiljaFree',
        'address' => rand(10000, 90000) . ' ' . $profile->data->address->street,
        'address2' => $profile->data->address->suite,
        'city' => $profile->data->address->city,
        'state' => 'TX',
        'zip' => $profile->data->address->zipcode,
        'country' => null,
        'phone' => $profile->data->phone,
        'fax' => null,
        'email' => $profile->data->email,
        'website' => $profile->data->website,
        'twitter_username' => null,
        'facebook_username' => null,
    ],
];

foreach ($variables as $key => $value) {
    $container->get('view')->getEnvironment()->addGlobal($key, $value);
}
