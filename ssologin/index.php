<?php

/**
 *  SAML Handler
 */

//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

session_start();
define('ONELOGIN_CUSTOMPATH', dirname(__DIR__) . DIRECTORY_SEPARATOR . 'application' . DIRECTORY_SEPARATOR .  'config' . DIRECTORY_SEPARATOR .  'sso'. DIRECTORY_SEPARATOR  );
//ONELOGIN_CUSTOMPATH
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'application' . DIRECTORY_SEPARATOR . 'libraries' . DIRECTORY_SEPARATOR . 'onelogin' . DIRECTORY_SEPARATOR . 'php-saml' . DIRECTORY_SEPARATOR . '_toolkit_loader.php';
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'application' . DIRECTORY_SEPARATOR . 'libraries' . DIRECTORY_SEPARATOR . 'robrichards' . DIRECTORY_SEPARATOR . 'xmlseclibs' . DIRECTORY_SEPARATOR . 'xmlseclibs.php';

use OneLogin\Saml2\Auth;
use OneLogin\Saml2\Utils;

$compnay_url = $_SERVER['HTTP_HOST'];
if ($compnay_url == 'localhost') {
    $spBaseUrl =  $_SERVER['USER_PORTAL_BASE_URL'];
} else {
    $spBaseUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['USER_PORTAL_BASE_URL'];
}

require_once ONELOGIN_CUSTOMPATH . "db_settings.php";
$setting = null;
//$setting=get_sso_config();

$auth = new Auth($setting);

if (isset($_REQUEST['sso'])) {
  //  $auth->login($returnTo = null, array $parameters = array(), $forceAuthn = false, $isPassive = false, $stay = false, $setNameIdPolicy = true, $nameIdValueReq = null);
   // $auth->login(null,[], false,  false, false, true, null);
   $auth->login(null,[], false,  false, false, false, null); 
   // $auth->login();
    # If AuthNRequest ID need to be saved in order to later validate it, do instead
    # $ssoBuiltUrl = $auth->login(null, array(), false, false, true);
    # $_SESSION['AuthNRequestID'] = $auth->getLastRequestID();
    # header('Pragma: no-cache');
    # header('Cache-Control: no-cache, must-revalidate');
    # header('Location: ' . $ssoBuiltUrl);
    # exit();

} else if (isset($_REQUEST['sso2'])) {
    // $returnTo = $spBaseUrl. 'ssologin/attrs.php';
    $auth->login();
} else if (isset($_REQUEST['slo'])) {
    $returnTo              = $spBaseUrl . 'logout';
    $paramters             = array();
    $nameId                = null;
    $sessionIndex          = null;
    $nameIdFormat          = null;
    $nameIdNameQualifier   = null;
    $nameIdSPNameQualifier = null;

    if (isset($_SESSION['samlNameId'])) {
        $nameId = $_SESSION['samlNameId'];
    }
    if (isset($_SESSION['samlNameIdFormat'])) {
        $nameIdFormat = $_SESSION['samlNameIdFormat'];
    }
    if (isset($_SESSION['samlNameIdNameQualifier'])) {
        $nameIdNameQualifier = $_SESSION['samlNameIdNameQualifier'];
    }
    if (isset($_SESSION['samlNameIdSPNameQualifier'])) {
        $nameIdSPNameQualifier = $_SESSION['samlNameIdSPNameQualifier'];
    }
    if (isset($_SESSION['samlSessionIndex'])) {
        $sessionIndex = $_SESSION['samlSessionIndex'];
    }

    $auth->logout($returnTo, $paramters, $nameId, $sessionIndex, false, $nameIdFormat, $nameIdNameQualifier, $nameIdSPNameQualifier);

    # If LogoutRequest ID need to be saved in order to later validate it, do instead
    # $sloBuiltUrl = $auth->logout(null, $paramters, $nameId, $sessionIndex, true);
    # $_SESSION['LogoutRequestID'] = $auth->getLastRequestID();
    # header('Pragma: no-cache');
    # header('Cache-Control: no-cache, must-revalidate');
    # header('Location: ' . $sloBuiltUrl);
    # exit();

} else if (isset($_REQUEST['acs'])) {
 //   print "<pre>";
    $paramters = array();
    if (isset($_SESSION) && isset($_SESSION['AuthNRequestID'])) {
        $requestID = $_SESSION['AuthNRequestID'];
    } else {
        $requestID = null;
    }
    $auth->processResponse($requestID);
    $errors = $auth->getErrors();
    if (!empty($errors)) {
        $paramters['errors'] = $errors;
        $paramters['getLastErrorReason'] = $auth->getLastErrorReason();
    }

    if (!$auth->isAuthenticated()) {
        $uname = $paramters['authenticated'] = 'Not authenticated';
    } else {
        $_SESSION['samlUserdata']                          = $auth->getAttributes();
        $_SESSION['samlNameId']                         = $auth->getNameId();
        $_SESSION['samlNameIdFormat']                = $auth->getNameIdFormat();
        $_SESSION['samlNameIdNameQualifier']    = $auth->getNameIdNameQualifier();
        $_SESSION['samlNameIdSPNameQualifier']  = $auth->getNameIdSPNameQualifier();
        $_SESSION['samlSessionIndex']               = $auth->getSessionIndex();
        unset($_SESSION['AuthNRequestID']);

        $attributes = $auth->getAttributes();
    
        @$mapping_attributes = $auth->getSettings()->getIdPData()['mapping_attributes'];

        foreach ($mapping_attributes as $k => $v) {
            if (isset($attributes[$v])) {
                $paramters['mappingData'][$k] = implode(",", $attributes[$v]);
            }
        }

        //get email
        if (isset($attributes['email'])) {
            $uname = $attributes['email'][0];
        } elseif (isset($attributes['User.email'])) {
            $uname = $attributes['User.email'][0];
        } elseif (isset($attributes['http://schemas.xmlsoap.org/ws/2005/05/identity/claims/emailaddress'])) {
            $uname = $attributes['http://schemas.xmlsoap.org/ws/2005/05/identity/claims/emailaddress'][0];
        } elseif (isset($attributes[$mapping_attributes['email']])) {
            $uname = $attributes[$mapping_attributes['email']][0];
        } else {
            $uname = 'na';
        }
    }

    $paramters['debug_session'] = $_SESSION;
    $paramters['email'] = strtolower($uname);
    $uname     = base64_encode($uname);
    $timestamp = base64_encode(time());
    $paramters = $auth->getSettings()->isDebugActive() ? $paramters : [];
    $paramters['debug'] = $auth->getSettings()->isDebugActive();
    @$reverseLogout = $auth->getSettings()->getIdPData()['reverseLogout'];
    $paramters['reverseLogout'] = $reverseLogout;
  //  print_r($paramters);
    $paramters = base64_encode(json_encode($paramters));

  //  session_destroy();
    $spUrl = $spBaseUrl . "sso-process-login/{$uname}/{$timestamp}/{$paramters}";
    header('Pragma: no-cache');
    header('Cache-Control: no-cache, must-revalidate');
    header('Location: ' . $spUrl);
    exit();

    if (isset($_POST['RelayState']) && Utils::getSelfURL() != $_POST['RelayState']) {
        $auth->redirectTo($_POST['RelayState']);
    }
} else if (isset($_REQUEST['sls'])) {
    
    if (isset($_SESSION) && isset($_SESSION['LogoutRequestID'])) {
        $requestID = $_SESSION['LogoutRequestID'];
    } else {
        $requestID = null;
    }

    $auth->processSLO(false, $requestID);
    $errors = $auth->getErrors();
    if (empty($errors)) {
        $spUrl = $spBaseUrl . "logout";
        header('Pragma: no-cache');
        header('Cache-Control: no-cache, must-revalidate');
        header('Location: ' . $spUrl);
        exit();
        // echo '<p>Sucessfully logged out</p>';
    } else {
        echo '<p>' . implode(', ', $errors) . '</p>';
    }
}
/*
if (isset($_SESSION['samlUserdata'])) {
    if (!empty($_SESSION['samlUserdata'])) {
        $attributes = $_SESSION['samlUserdata'];
        echo 'You have the following attributes:<br>';
        echo '<table><thead><th>Name</th><th>Values</th></thead><tbody>';
        foreach ($attributes as $attributeName => $attributeValues) {
            echo '<tr><td>' . htmlentities($attributeName) . '</td><td><ul>';
            foreach ($attributeValues as $attributeValue) {
                echo '<li>' . htmlentities($attributeValue) . '</li>';
            }
            echo '</ul></td></tr>';
        }
        echo '</tbody></table>';
    } else {
        echo "<p>You don't have any attribute</p>";
    }
    var_dump( $_SESSION);

    echo '<p><a href="?slo" >Logout</a></p>';
} else {
    echo '<p><a href="?sso" >Login</a></p>';
    echo '<p><a href="?sso2" >Login and access to attrs.php page</a></p>';
}
*/



