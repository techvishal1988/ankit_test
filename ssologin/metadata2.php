<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

define('ONELOGIN_CUSTOMPATH', dirname(__DIR__) . DIRECTORY_SEPARATOR . 'application' . DIRECTORY_SEPARATOR .  'config' . DIRECTORY_SEPARATOR .  'sso'. DIRECTORY_SEPARATOR  );

/**
 *  SAML Metadata view
 */

//require_once dirname(__DIR__).'/_toolkit_loader.php';
require_once dirname(__DIR__).DIRECTORY_SEPARATOR . 'application' .DIRECTORY_SEPARATOR . 'libraries' . DIRECTORY_SEPARATOR . 'onelogin' . DIRECTORY_SEPARATOR . 'php-saml' . DIRECTORY_SEPARATOR . '_toolkit_loader.php';
require_once dirname(__DIR__).DIRECTORY_SEPARATOR . 'application' .DIRECTORY_SEPARATOR . 'libraries' . DIRECTORY_SEPARATOR . 'robrichards' . DIRECTORY_SEPARATOR . 'xmlseclibs' . DIRECTORY_SEPARATOR . 'xmlseclibs.php';

use OneLogin\Saml2\Settings;
use OneLogin\Saml2\Error;
//require_once 'settings.php' ;
require_once ONELOGIN_CUSTOMPATH . "db_settings.php";
try {
    $settingsInfo =null ;
    #$auth = new OneLogin\Saml2\Auth($settingsInfo);
    #$settings = $auth->getSettings();
    // Now we only validate SP settings
    $settingsInfo=get_sso_config();
    $settings = new Settings($settingsInfo, true);
   // print ("<pre>");
    if( $settings->isDebugActive())
    {
    $metadata = $settings->getSPMetadata();
    $errors = $settings->validateMetadata($metadata);
    if (empty($errors)) {
        header('Content-Type: text/xml');
        echo $metadata;
    } else {
        throw new Error(
            'Invalid SP metadata: '.implode(', ', $errors),
            Error::METADATA_SP_INVALID
        );
    }
  }

} catch (Exception $e) {
    echo $e->getMessage();
}
