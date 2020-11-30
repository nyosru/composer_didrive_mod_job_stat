<?php

// echo __FILE__;

    ini_set('error_reporting', E_ALL);
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);


/**
 * считаем оценку за 1 день
 */
if (isset($skip_start) && $skip_start === true) {
    
} else {
    require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/didrive/base/start-for-microservice.php';
    $skip_start = false;
}

// \f\pa($_REQUEST);

try {

    //\f\pa($_REQUEST);
    
    $date = date('Y-m-d', strtotime($_REQUEST['date']));
    $date2 = date('Y-m-d', strtotime($_REQUEST['date2']));

    $e = \Nyos\mod\JOB_STAT::getStat($db, $date, $date2 );

    \f\end2('окей', true, $e);
    
}
//
catch (\Exception $ex) {

    ob_start('ob_gzhandler');

    \f\pa($ex);
    $r = ob_get_contents();
    ob_end_clean();

    \f\end2('ошибка' . $r, false);
}
