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

    $ctx = connectWithHttpAuth($settings['Url'], $settings['UserName'], $settings['Password']);
    $site = $ctx->getSite();
    $ctx->load($site); //load site settings
    $ctx->executeQuery();
    $webUrl = $site->getProperty("Url");

    $folderUrl = '/app/Costan/COSTAN_PRODUCT_RESOURCE/Gallery';

    $url = $webUrl . "/_api/web/getFolderByServerRelativeUrl('{$folderUrl}')/Files";
    $request = new RequestOptions($url);
    $resp = $ctx->executeQueryDirect($request);
    $data = json_decode($resp);

    print_r($data);
}
catch (Exception $e) {
	echo 'Authentication failed: ',  $e->getMessage(), "\n";
}
