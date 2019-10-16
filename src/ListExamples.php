<?php

require_once '../vendor/autoload.php';

use Office365\PHP\Client\Runtime\Auth\AuthenticationContext;
use Office365\PHP\Client\Runtime\Auth\NetworkCredentialContext;
use Office365\PHP\Client\Runtime\Utilities\RequestOptions;
use Office365\PHP\Client\SharePoint\ClientContext;
use Office365\PHP\Client\Runtime\ClientRuntimeContext;
use Office365\PHP\Client\SharePoint\File;
use Office365\PHP\Client\SharePoint\SPList;
// require_once '../bootstrap.php';

$settings = [
    'Url' => "https://mktgsite.eptarefrigeration.com/app/costan",
    'Password' => 'EL7xBzqq',
    'UserName' => 'm-cold\c-brustim',
];


function connectWithHttpAuth($url,$username,$password){
    $authCtx = new NetworkCredentialContext($username, $password);
    $authCtx->AuthType = CURLOPT_HTTPAUTH;
    $ctx = new ClientContext($url,$authCtx);
    return $ctx;
}

try {
    $listTitle = 'COSTAN_PRODUCT_METADATA';

    $ctx = connectWithHttpAuth($settings['Url'], $settings['UserName'], $settings['Password']);

    $web = $ctx->getWeb();
    $list = $web->getLists()->getByTitle($listTitle); //init List resource
    $items = $list->getItems();  //prepare a query to retrieve from the
    $ctx->load($items);  //save a query to retrieve list items from the server
    $ctx->executeQuery(); //submit query to SharePoint Online REST service
    foreach( $items->getData() as $item ) {
        var_dump($item->PRODUCT_NAME_COSTAN);
    }

}
catch (Exception $e) {
    echo 'Authentication failed: ',  $e->getMessage(), "\n";
}
