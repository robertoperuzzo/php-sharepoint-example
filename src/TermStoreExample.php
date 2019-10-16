<?php

require_once '../vendor/autoload.php';

use Office365\PHP\Client\Runtime\Auth\AuthenticationContext;
use Office365\PHP\Client\Runtime\Auth\NetworkCredentialContext;
use Office365\PHP\Client\Runtime\Utilities\RequestOptions;
use Office365\PHP\Client\SharePoint\ClientContext;
use Office365\PHP\Client\Runtime\ClientRuntimeContext;
use Office365\PHP\Client\SharePoint\File;
use Office365\PHP\Client\SharePoint\SPList;
use Office365\PHP\Client\Runtime\ClientObject;
use Office365\PHP\Client\Runtime\CSOM\ICSOMCallable;
use Office365\PHP\Client\Runtime\CSOM\ObjectIdentityQuery;
use Office365\PHP\Client\Runtime\ResourcePathServiceOperation;
use Office365\PHP\Client\SharePoint\Taxonomy\TaxonomySession;
// use SimpleXMLElement;
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

    $path = new ResourcePathServiceOperation($ctx, null, "GetTaxonomySession", null);
    // $path->TypeId = $this->getServerTypeId();
    // $path->IsStatic = true;
    $taxonomySession = new TaxonomySession($ctx, $path);
    $objectIdentityQuery = new ObjectIdentityQuery($taxonomySession->getResourcePath());
    $ctx->addQuery($objectIdentityQuery, $taxonomySession);
    $ctx->addQuery($objectIdentityQuery);
    var_dump($taxonomySession);


}
catch (Exception $e) {
	echo 'Authentication failed: ',  $e->getMessage(), "\n";
}
