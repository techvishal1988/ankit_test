<?php 
function get_sso_config_ssl()
{

    $current_sub_domain_name=$_SERVER['HTTP_HOST'];
    define('BASEPATH', 'sso_settings');
    define('CV_PLATFORM_DB_NAME', 'platform_admin_db');
    define('ENVIRONMENT', 'production');
    $db = array('default' => array());
    //require_once  '..\application' . DIRECTORY_SEPARATOR . 'config' .  DIRECTORY_SEPARATOR . 'database.php';
    require_once dirname(__DIR__).DIRECTORY_SEPARATOR . 'database.php';
/*
    print ("PDO");
    $pdo = new PDO("mysql:host={$db['default']['hostname']};dbname={$db['default']['database']}",$db['default']['username'],$db['default']['password'], array(
        PDO::MYSQL_ATTR_SSL_KEY    =>$_SERVER["MYSQL_CLIENT_KEY"],
        PDO::MYSQL_ATTR_SSL_CERT=>$_SERVER["MYSQL_CLIENT_CERT"],
        PDO::MYSQL_ATTR_SSL_CA    =>$_SERVER["MYSQL_CA_CERT"]
        )
    );
    $stmt = $pdo->query("SHOW TABLES;");
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    print_r($row);
*/
////////////////////////////////////////////////////////////////
print ("proce");
$con = mysqli_init();
if (!$con) {
  die("mysqli_init failed");
}

mysqli_ssl_set($con, $_SERVER["MYSQL_CLIENT_KEY"], $_SERVER["MYSQL_CLIENT_CERT"], $_SERVER["MYSQL_CA_CERT"], NULL, NULL);

if (!mysqli_real_connect($con, $db['default']['hostname'], $db['default']['username'], $db['default']['password'], $db['default']['database'])) {
  die("Connect Error: " . mysqli_connect_error());
}
// Perform query
if ($result = mysqli_query($con, "SELECT * FROM login_user limit 0,5")) {
    echo "Returned rows are: " . mysqli_num_rows($result);
    // Free result set
    mysqli_free_result($result);
  }
// Some queries...

mysqli_close($con);



print ("OOP");

    
   
    $mysqli = mysqli_init();
    if (!$mysqli) {
        die("mysqli_init failed");
    }
   // if($db['default']['encrypt']){
    $mysqli -> ssl_set($_SERVER["MYSQL_CLIENT_KEY"], $_SERVER["MYSQL_CLIENT_CERT"], $_SERVER["MYSQL_CA_CERT"], NULL, NULL);
   // }
    if (!$mysqli -> real_connect($db['default']['hostname'], $db['default']['username'], $db['default']['password'], $db['default']['database'],NULL,NULL,MYSQLI_CLIENT_SSL)) {
        die("Connect Error: " . mysqli_connect_error());
    }

    $sql = "SELECT `sso_config`, `domain`.`sub_domain_name`
    FROM ".CV_PLATFORM_DB_NAME.".`domain`
    JOIN ".CV_PLATFORM_DB_NAME.".`manage_company` ON `manage_company`.`id` = `domain`.`company_Id`
    WHERE `domain`.`sub_domain_name` = '".$current_sub_domain_name."'";

    $result = mysqli_query($mysqli,$sql);

    if ($result->num_rows > 0) {
       $sso_config = $result->fetch_assoc()['sso_config'];        
    } 
    $mysqli -> close();

    if (!empty($sso_config)) {
        return json_decode($sso_config,true);
    }
    return NULL;
}

function get_sso_config_old()
{

    $current_sub_domain_name=$_SERVER['HTTP_HOST'];
    define('BASEPATH', 'sso_settings');
    define('CV_PLATFORM_DB_NAME', 'platform_admin_db');
    define('ENVIRONMENT', 'production');
    $db = array('default' => array());
    //require_once  '..\application' . DIRECTORY_SEPARATOR . 'config' .  DIRECTORY_SEPARATOR . 'database.php';
    require_once dirname(__DIR__).DIRECTORY_SEPARATOR . 'database.php';
   
    $mysqli = mysqli_init();
    if (!$mysqli) {
        die("mysqli_init failed");
    }
   // if($db['default']['encrypt']){
    $mysqli -> ssl_set($_SERVER["MYSQL_CLIENT_KEY"], $_SERVER["MYSQL_CLIENT_CERT"], $_SERVER["MYSQL_CA_CERT"], NULL, NULL);
   // }
    if (!$mysqli -> real_connect($db['default']['hostname'], $db['default']['username'], $db['default']['password'], $db['default']['database'],NULL,NULL,MYSQLI_CLIENT_SSL)) {
        die("Connect Error: " . mysqli_connect_error());
    }

    $sql = "SELECT `sso_config`, `domain`.`sub_domain_name`
    FROM ".CV_PLATFORM_DB_NAME.".`domain`
    JOIN ".CV_PLATFORM_DB_NAME.".`manage_company` ON `manage_company`.`id` = `domain`.`company_Id`
    WHERE `domain`.`sub_domain_name` = '".$current_sub_domain_name."'";

    $result = mysqli_query($mysqli,$sql);

    if ($result->num_rows > 0) {
       $sso_config = $result->fetch_assoc()['sso_config'];        
    } 
    $mysqli -> close();

    if (!empty($sso_config)) {
        return json_decode($sso_config,true);
    }
    return NULL;
}


function get_sso_config()
{

    $current_sub_domain_name=$_SERVER['HTTP_HOST'];
    define('BASEPATH', 'sso_settings');
    define('CV_PLATFORM_DB_NAME', 'platform_admin_db');
    define('ENVIRONMENT', 'production');
    $db = array('default' => array());
    //require_once  '..\application' . DIRECTORY_SEPARATOR . 'config' .  DIRECTORY_SEPARATOR . 'database.php';
    require_once dirname(__DIR__).DIRECTORY_SEPARATOR . 'database.php';
    $conn = mysqli_connect($db['default']['hostname'], $db['default']['username'], $db['default']['password']);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    $sql = "SELECT `sso_config`, `domain`.`sub_domain_name`
    FROM ".CV_PLATFORM_DB_NAME.".`domain`
    JOIN ".CV_PLATFORM_DB_NAME.".`manage_company` ON `manage_company`.`id` = `domain`.`company_Id`
    WHERE `domain`.`sub_domain_name` = '".$current_sub_domain_name."'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
       $sso_config = $result->fetch_assoc()['sso_config'];
        
    } 
    $conn->close();

    if (!empty($sso_config)) {
        return json_decode($sso_config,true);
    }
    return NULL;
}