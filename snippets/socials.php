<?php

$socials = [
    ['code' => 'facebook',      'title' => 'Facebook'],
    ['code' => 'vkontakte',     'title' => 'ВКонтакте'],
    ['code' => 'instagram',     'title' => 'Instagram'],
    ['code' => 'youtube',       'title' => 'Youtube'],
    ['code' => 'odnoklassniki', 'title' => 'Одноклассники'],
    ['code' => 'twitter',       'title' => 'Twitter'],
];

$out = [];

foreach ($socials as $social) {
    $url = $modx->getConfig('client_social_' . $social['code']);

    if (!empty($url)) {
        $out[] = array_merge($social, ['url' => $url]);
    }
}

return $out;
