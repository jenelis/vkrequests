<?php

    require (__DIR__ . '/autoload.php');

    $token = '???';
    $vk_version_api = '5.110';

    $vk = new requests($token, $vk_version_api);

    $request = $vk->request('users.get', ['user_ids' => '1']);
    var_dump($request);
