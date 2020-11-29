<?php

/**
  определение функций для TWIG
 */
//creatSecret
// $function = new Twig_SimpleFunction('creatSecret', function ( string $text ) {
//    return \Nyos\Nyos::creatSecret($text);
// });
// $twig->addFunction($function);
// $function = new Twig_SimpleFunction('site_mod__check_norms_day', function ( $db, $date ) {
//creatSecret
$function = new Twig_SimpleFunction('job_stat__getstat', function ( $db, string $date ) {
    return \Nyos\mod\JOB_STAT::getStat($db, $date);
});
$twig->addFunction($function);



$function = new Twig_SimpleFunction('job_stat__check_norms_day', function ( $db, $date ) {

// \f\pa($date);

    $date_start = date('Y-m-01', strtotime($date));
    $date_finish = date('Y-m-d', strtotime($date_start . ' +1 month -1 day'));


// \Nyos\mod\items::$show_sql = true;
    \Nyos\mod\items::$var_ar_for_1sql[':date_start'] = $date_start;
    \Nyos\mod\items::$var_ar_for_1sql[':date_finish'] = $date_finish;

    \Nyos\mod\items::$join_where = ' INNER JOIN `mitems-dops` mid22 '
            . ' ON mid22.id_item = mi.id '
            . ' AND mid22.name = \'date\' '
            . ' AND mid22.value_date BETWEEN :date_start AND :date_finish '
    ;

    $norms = \Nyos\mod\items::getItemsSimple3($db, \Nyos\mod\jobdesc::$mod_norms_day);
// $norms = \Nyos\mod\items::getItemsSimple($db, \Nyos\mod\jobdesc::$mod_norms_day);
// \f\pa($norms);


    $ar1 = [];
    foreach ($norms as $v) {
        $ar1[$v['sale_point']][$v['date']] = 1;
    }

// \f\pa($ar1);

    $sps = \Nyos\mod\items::getItemsSimple3($db, \Nyos\mod\jobdesc::$mod_sale_point);
    $df_now = date('Y-m-d', $_SERVER['REQUEST_TIME'] - 3600 * 24);
    $all_sp = [];

    foreach ($sps as $kk => $sp) {

        if (!empty($sp['head']) && $sp['head'] == 'default')
            continue;

// \f\pa($sp,'','','sp');

        if (empty($all_sp[$sp['id']]))
            $all_sp[$sp['id']] = ['id' => $sp['id'], 'head' => $sp['head'], 'status' => 'ok', 'days' => []];

        for ($d = 0; $d <= 31; $d++) {

            $df = date('Y-m-d', strtotime($date_start . ' +' . $d . ' day'));

            if ($df > $date_finish)
                break;

// если дата больше текущей
//            if ($df > $df_now) {
//                $all_sp[$sp['id']]['days'][$df] = 'skip';
//                $all_sp[$sp['id']]['status'] = null;
//            }
//            // если дата раньше текущей, статусы ставим
//            else {

            if (empty($ar1[$sp['id']][$df])) {
                $all_sp[$sp['id']]['days'][$df] = false;
                if ($all_sp[$sp['id']]['status'] != 'warn') {
                    $all_sp[$sp['id']]['status'] = 'no';
                }
            } else {
                $all_sp[$sp['id']]['days'][$df] = true;
                if ($all_sp[$sp['id']]['status'] == 'no') {
                    $all_sp[$sp['id']]['status'] = 'warn';
                }
            }
//            }
        }
    }

    return $all_sp;

//    if ($folder == '')
//        $folder = \Nyos\Nyos::$folder_now;

    /*

      $ff = $db->prepare('SELECT * FROM `gm_user` WHERE `folder` = :folder ');
      $ff->execute(array(':folder' => $folder ));

      //    echo '<Br/>'.$folder;
      //    echo '<Br/>'.__FILE__.' '.__LINE__;

      $re = [];

      while ($e = $ff->fetch()) {
      $re[$e['id']] = $e;
      }

     */

//    $file_cash = DR . '/sites/' . $folder . '/people.iiko';
//    $massa = json_decode(file_get_contents($file_cash));
//\f\pa($massa);

    return $massa;
});
$twig->addFunction($function);



$function = new Twig_SimpleFunction('job_stat__check_timeo_days', function ( $db, $date ) {

// \f\pa($date);

    $date_start = date('Y-m-01', strtotime($date));
    $date_finish = date('Y-m-d', strtotime($date_start . ' +1 month -1 day'));


// \Nyos\mod\items::$show_sql = true;

    \Nyos\mod\items::$var_ar_for_1sql[':date_start'] = $date_start;
    \Nyos\mod\items::$var_ar_for_1sql[':date_finish'] = $date_finish;
    \Nyos\mod\items::$join_where = ' INNER JOIN `mitems-dops` mid22 '
            . ' ON mid22.id_item = mi.id '
            . ' AND mid22.name = \'date\' '
            . ' AND mid22.value_date BETWEEN :date_start AND :date_finish '
            . ' INNER JOIN `mitems-dops` mid23 '
            . ' ON mid23.id_item = mi.id '
            . ' AND mid23.name = \'sale_point\' '
    ;

    $norms = \Nyos\mod\items::get($db, \Nyos\mod\jobdesc::$mod_timeo);
// $norms = \Nyos\mod\items::getItemsSimple3($db, \Nyos\mod\jobdesc::$mod_timeo);
// $norms = \Nyos\mod\items::getItemsSimple($db, \Nyos\mod\jobdesc::$mod_norms_day);
// \f\pa($norms);

    $ar1 = [];
    foreach ($norms as $v) {
// if( !empty($v['sale_point']) )
        $ar1[$v['sale_point']][$v['date']] = 1;
    }

// \f\pa($ar1);
// $sps = \Nyos\mod\items::getItemsSimple3($db, \Nyos\mod\jobdesc::$mod_sale_point);
    $sps = \Nyos\mod\items::get($db, \Nyos\mod\jobdesc::$mod_sale_point);

    $all_sp = [];

    $df_now = date('Y-m-d', $_SERVER['REQUEST_TIME'] - 3600 * 24);


    foreach ($sps as $kk => $sp) {

        if (!empty($sp['head']) && $sp['head'] == 'default')
            continue;

// \f\pa($sp,'','','sp');

        if (empty($all_sp[$sp['id']]))
            $all_sp[$sp['id']] = ['id' => $sp['id'], 'head' => $sp['head'], 'status' => 'ok', 'days' => []];


        for ($d = 0; $d <= 31; $d++) {

            $df = date('Y-m-d', strtotime($date_start . ' +' . $d . ' day'));

            if ($df > $date_finish)
                break;

// если дата больше текущей
            if ($df > $df_now) {
                continue;
                $all_sp[$sp['id']]['days'][$df] = 'skip';
// $all_sp[$sp['id']]['status'] = null;
            }
// если дата раньше текущей, статусы ставим
            else {

//                if (empty($ar1[$sp['id']][$df])) {
//                    $all_sp[$sp['id']]['days'][$df] = 'no';
//                    $all_sp[$sp['id']]['status'] = 'no';
//                } else {
//                    $all_sp[$sp['id']]['days'][$df] = 'yes';
//                }

                if (empty($ar1[$sp['id']][$df])) {
                    $all_sp[$sp['id']]['days'][$df] = false;

// if ($all_sp[$sp['id']]['status'] == 'no') {
                    $all_sp[$sp['id']]['status'] = 'warn';
// }
//                if ($all_sp[$sp['id']]['status'] != 'warn') {
//                    $all_sp[$sp['id']]['status'] = 'no';
//                }
                } else {
                    $all_sp[$sp['id']]['days'][$df] = true;
//                if ($all_sp[$sp['id']]['status'] == 'no') {
//                    $all_sp[$sp['id']]['status'] = 'warn';
//                }
                }

// $all_sp[$sp['id']]['status'] = 'warn';
            }
        }
    }

// \f\pa($all_sp,2,'','all_sp');
    return $all_sp;

//    if ($folder == '')
//        $folder = \Nyos\Nyos::$folder_now;

    /*

      $ff = $db->prepare('SELECT * FROM `gm_user` WHERE `folder` = :folder ');
      $ff->execute(array(':folder' => $folder ));

      //    echo '<Br/>'.$folder;
      //    echo '<Br/>'.__FILE__.' '.__LINE__;

      $re = [];

      while ($e = $ff->fetch()) {
      $re[$e['id']] = $e;
      }

     */

//    $file_cash = DR . '/sites/' . $folder . '/people.iiko';
//    $massa = json_decode(file_get_contents($file_cash));
//\f\pa($massa);

    return $massa;
});
$twig->addFunction($function);


$function = new Twig_SimpleFunction('job_stat__check_ocenka', function ( $db, $date ) {

// \f\pa($date);

    $date_start = date('Y-m-01', strtotime($date));
    $date_finish = date('Y-m-d', strtotime($date_start . ' +1 month -1 day'));

// \Nyos\mod\items::$show_sql = true;
    \Nyos\mod\items::$var_ar_for_1sql[':date_start'] = $date_start;
    \Nyos\mod\items::$var_ar_for_1sql[':date_finish'] = $date_finish;

    \Nyos\mod\items::$join_where = ' INNER JOIN `mitems-dops` mid22 '
            . ' ON mid22.id_item = mi.id '
            . ' AND mid22.name = \'date\' '
            . ' AND mid22.value_date BETWEEN :date_start AND :date_finish '
    ;

    $ocenki = \Nyos\mod\items::getItemsSimple3($db, \Nyos\mod\jobdesc::$mod_ocenki_days);
// $norms = \Nyos\mod\items::getItemsSimple($db, \Nyos\mod\jobdesc::$mod_norms_day);
// \f\pa($norms);


    $ar1 = [];
    foreach ($ocenki as $v) {
        $ar1[$v['sale_point']][$v['date']] = 1;
    }

// \f\pa($ar1);

    $sps = \Nyos\mod\items::getItemsSimple3($db, \Nyos\mod\jobdesc::$mod_sale_point);

    $all_sp = [];

    $df_now = date('Y-m-d', $_SERVER['REQUEST_TIME'] - 3600 * 24);


    foreach ($sps as $kk => $sp) {

        if (!empty($sp['head']) && $sp['head'] == 'default')
            continue;

// \f\pa($sp,'','','sp');

        if (empty($all_sp[$sp['id']]))
            $all_sp[$sp['id']] = ['id' => $sp['id'], 'head' => $sp['head'], 'status' => 'ok', 'days' => []];

// $all_sp[$sp['id']]['status'] = 'no';

        for ($d = 0; $d <= 31; $d++) {

            $df = date('Y-m-d', strtotime($date_start . ' +' . $d . ' day'));

            if ($df > $date_finish)
                break;

// если дата больше текущей
            if ($df > $df_now) {
                continue;
                $all_sp[$sp['id']]['days'][$df] = 'skip';
// $all_sp[$sp['id']]['status'] = null;
            }
// если дата раньше текущей, статусы ставим
            else {

                if (empty($ar1[$sp['id']][$df])) {
                    $all_sp[$sp['id']]['days'][$df] = false;

                    if ($all_sp[$sp['id']]['status'] != 'no') {
                        $all_sp[$sp['id']]['status'] = 'warn';
                    }

//                if ($all_sp[$sp['id']]['status'] != 'warn') {
//                    $all_sp[$sp['id']]['status'] = 'no';
//                }
                } else {
                    $all_sp[$sp['id']]['days'][$df] = true;
//                if ($all_sp[$sp['id']]['status'] == 'no') {
//                    $all_sp[$sp['id']]['status'] = 'warn';
//                }
                }
//                if (empty($ar1[$sp['id']][$df])) {
//                    $all_sp[$sp['id']]['days'][$df] = 'no';
//                    $all_sp[$sp['id']]['status'] = 'no';
//                } else {
//                    $all_sp[$sp['id']]['days'][$df] = 'yes';
//                }
            }
        }
    }

    return $all_sp;

//    if ($folder == '')
//        $folder = \Nyos\Nyos::$folder_now;

    /*

      $ff = $db->prepare('SELECT * FROM `gm_user` WHERE `folder` = :folder ');
      $ff->execute(array(':folder' => $folder ));

      //    echo '<Br/>'.$folder;
      //    echo '<Br/>'.__FILE__.' '.__LINE__;

      $re = [];

      while ($e = $ff->fetch()) {
      $re[$e['id']] = $e;
      }

     */

//    $file_cash = DR . '/sites/' . $folder . '/people.iiko';
//    $massa = json_decode(file_get_contents($file_cash));
//\f\pa($massa);

    return $massa;
});
$twig->addFunction($function);



if (1 == 1) {
    $function = new Twig_SimpleFunction('get_users_from_import', function ( $folder = '' ) {

        if ($folder == '')
            $folder = \Nyos\Nyos::$folder_now;

        /*

          $ff = $db->prepare('SELECT * FROM `gm_user` WHERE `folder` = :folder ');
          $ff->execute(array(':folder' => $folder ));

          //    echo '<Br/>'.$folder;
          //    echo '<Br/>'.__FILE__.' '.__LINE__;

          $re = [];

          while ($e = $ff->fetch()) {
          $re[$e['id']] = $e;
          }

         */

        $file_cash = DR . '/sites/' . $folder . '/people.iiko';
        $massa = json_decode(file_get_contents($file_cash));
//\f\pa($massa);

        return $massa;
    });
    $twig->addFunction($function);

    $function = new Twig_SimpleFunction('add_users_from_import', function ( $db, $folder = '' ) {

        if ($folder == '')
            $folder = \Nyos\Nyos::$folder_now;

//      $ff = $db->prepare('SELECT * FROM `gm_user` WHERE `folder` = :folder ');
//      $ff->execute(array(':folder' => $folder ));
//      $re = [];
//      while ($e = $ff->fetch()) {
//      $re[$e['id']] = $e;
//      }

        $file_cash = DR . '/sites/' . $folder . '/people.iiko';
        $massa = json_decode(file_get_contents($file_cash), true);
//\f\pa($massa);

        $ret = '<p>c IIKO получено записей сотрудников ' . sizeof($massa) . '</p>';

        $indb = [];


// чистим всю базу сотрудников
//    $ff = $db->prepare('DELETE FROM `mitems` WHERE `folder` = :folder and `module` = :mod ');
//    $ff->execute(array(
//        ':folder' => $folder,
//        ':mod' => '070.jobman'
//    ));
// echo '<hr>наши люди<hr>';
//    $e = 1;
// смотрим инфу что на сайтте люди

        \f\timer::start(55);

        $now_users = \Nyos\Mod\Items::getItems($db, $folder, '070.jobman');
        $user = [];

        foreach ($now_users['data'] as $k => $v) {
            if (isset($v['dop']['iiko_id'])) {
                $user[$v['dop']['iiko_id']] = 1;
            }
        }

        \f\timer::stop('str', 55);
        \f\CalcMemory::stop(55);


        $ret .= '<h2>Добавляем сотрудников из </h2>';

//    $e = 0;
// смотрим инфу с айки
        foreach ($massa as $k => $v) {

//        if ($e >= 20)
//            continue;
//
//        $e++;

            if (!isset($user[$v['id']])) {
                $indb[$v['id']] = $v;
            }

//      \f\pa($v);
        }

        $ret .= '<br/>новых записей ' . sizeof($indb);

        $nn = 0;
        foreach ($indb as $id => $v) {

            if ($nn >= 100)
                break;

            if (isset($v['lastName']{1}) && isset($v['firstName']{1}) && isset($v['middleName']{1})) {
                $new_people = array('head' => $v['lastName'] . ' ' . $v['firstName'] . ' ' . $v['middleName']);
            } elseif (isset($v['name']{1})) {
                $new_people = array('head' => $v['name']);
            } else {
                continue;
            }
// $new_people_dop = [];
// \f\pa($v);

            foreach ($v as $k1 => $v1) {

                if (is_array($v1)) {

                    foreach ($v1 as $k2 => $v2) {
                        $new_people[$k1 . '_' . $k2] = $v2;
                    }
                } else {

                    if ($k1 == 'id') {
                        $k1 = 'iiko_id';
                    } elseif ($k1 == 'name') {
                        $k1 = 'iiko_name';
                    } elseif ($k1 == 'birthday') {

                        $new_people['bdate'] = $v1 = date('Y-m-d', strtotime($v1));
                    }

                    $new_people[$k1] = $v1;
                }
            }

//\f\pa($new_people);

            \Nyos\mod\items::addNew($db, $folder, \Nyos\Nyos::$menu['070.jobman'], $new_people);

            $nn++;
        }

        $ret .= '<br/>Добавлено ' . $nn;

        return $ret;
    });
    $twig->addFunction($function);

    $function = new Twig_SimpleFunction('di_getModersAccess', function ( $db, $folder = '' ) {

        if ($folder == '')
            $folder = \Nyos\Nyos::$folder_now;

        $ff = $db->prepare('SELECT * FROM `gm_user` WHERE `folder` = :folder ');
        $ff->execute(array(':folder' => $folder));

//    echo '<Br/>'.$folder;
//    echo '<Br/>'.__FILE__.' '.__LINE__;

        $re = [];

        while ($e = $ff->fetch()) {
            $re[$e['id']] = $e;
        }

        return $re;
    });
    $twig->addFunction($function);
}