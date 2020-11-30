<?php

// echo __FILE__;

/**
 * считаем оценку за 1 день
 */
if (isset($skip_start) && $skip_start === true) {
    
} else {
    require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/didrive/base/start-for-microservice.php';
    $skip_start = false;
}

\f\pa($_REQUEST);

echo \Nyos\mod\JOB_STAT::$var;

try {

    $date = date('Y-m-01', strtotime($_REQUEST['date']));
    $date2 = date('Y-m-d', strtotime($_REQUEST['date'] . ' +1 month -1 day'));

    for ($i = 0; $i <= 7; $i++) {
        if (date('w', strtotime($date . ' -' . $i . ' day')) == 1) {
            $date0 = date('Y-m-d', strtotime($date . ' -' . $i . ' day'));
            break;
        }
    }

    $weeks = [];

    for ($i = 1; $i <= 5; $i++) {

        $week_start = date('Y-m-d', strtotime($date0 . ' +' . $i . ' week -1 week'));
        $week_end = date('Y-m-d', strtotime($date0 . ' +' . $i . ' week -1 day'));

        $weeks[] = [$week_start, $week_end];
        // $date0 = date( 'Y-m-d', strtotime($date.' -'.$i.' day') );
        // \f\pa([ $week_start, $week_end ]);

        if ($week_end >= $date2)
            break;
    }

    // \f\pa($date0);
    // \f\pa($date2);

    \f\timer_start(77);

    foreach ($weeks as $week) {


        $u = [
            // 'action' => 'bonus_record_month',
            'date' => $week[0],
            'date2' => $week[1]
        ];
        $link = 'http://' . $_SERVER['HTTP_HOST'] . '/vendor/didrive_mod/job_stat/1/micro-service/calculate.php?' . http_build_query($u);

        if ($curl = curl_init()) { //инициализация сеанса
// $curl
// curl_setopt($curl, CURLOPT_URL, 'http://webcodius.ru/'); //указываем адрес страницы
//указываем адрес страницы
            curl_setopt($curl, CURLOPT_URL, $link);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
// curl_setopt ($curl, CURLOPT_POST, true);
// curl_setopt ($curl, CURLOPT_POSTFIELDS, "i=1");
            curl_setopt($curl, CURLOPT_HEADER, 0);
            $result = curl_exec($curl); //выполнение запроса
            // \f\pa($result, '', '', 'result');
            // \f\pa( json_decode($result) , 2, '', 'result');
            // \f\pa(json_decode($result), 2, '', 'result');
            curl_close($curl); //закрытие сеанса
            // \f\Cash::setVar($temp_var, 1, ( $time_expire ?? 60 * 60 * 5 ) );

            \f\pa($result);

        }

        $timer = \f\timer_stop(77, 'ar');

        // \f\pa($timer);

        if ($timer['sec'] > 10)
            break;

    }





//    if (1 == 1 ||
//            !empty($_REQUEST['sp']) && !empty($_REQUEST['date']) && !empty($_REQUEST['s']) && \Nyos\Nyos::checkSecret($_REQUEST['s'], $_REQUEST['sp'] . $_REQUEST['date']) !== false
//    ) {
//        
//    } else {
//        \f\end2('хьюстон что то пошло не так (обновите страницу и повторите) #' . __LINE__, false);
//    }
//
//    $return = array(
//        'txt' => '',
//        // текст о времени исполнения
//        'time' => '',
//        // смен в дне
//        'smen_in_day' => 0,
//        // часов за день отработано
//        'hours' => 0,
//        // больше или меньше нормы сделано сегодня ( 1 - больше или равно // 0 - меньше // 2 не получилось достать )
//        'oborot_bolee_norm' => 2,
//        // сумма денег на руки от количества смен и процента на ФОТ
//        'summa_na_ruki' => 0,
//        // рекомендуемая оценка управляющего
//// если 0 то нет оценки
//        'ocenka' => 5,
//        'ocenka_naruki' => 0,
//        'ocenka_timeo' => 0,
//        // оценка за процент от оборота
//        'ocenka_proc_ot_oborot' => 0,
//        'checks_for_new_ocenka' => [],
//        'date' => date('Y-m-d', strtotime($_REQUEST['date'])),
//        'sale_point' => $_REQUEST['sp'],
//        'sp' => $_REQUEST['sp'],
//        'oborot' => 0,
//        'norms' => [],
//        'timeo' => [],
//            // 'oborot_in_one_hand' => 0
//    );
//
//
//
//
//    $check = \Nyos\mod\JOBDESC_DAYOCENKA::checkInfoForOcenka($db, $return['sp'], $return['date']);
//
//    if ($check === false) {
//
//        // $return['txt'] = 'нет данных для расчёта оценки';
//        // echo __FILE__.' #'.__LINE__;
//
//        \f\end2('нет данных для оценки', false);
//    } else {
//
//        ob_start('ob_gzhandler');
//
//        $jobmans = \Nyos\mod\JobDesc::getJobmansJobingToSpMonth($db, $return['sp'], $return['date']);
//// \f\pa($jobmans, 2);
//
//        $actions = \Nyos\mod\JobDesc::getActionsJobmansOnMonth($db, array_keys($jobmans['data']['jobmans']), $return['date'], true, $return['sp']);
//        // $actions = [];
//        //\f\pa($actions, 2, '', '$actions');
////    foreach ($actions['data']['actions'] as $k => $v) {
////        if ($v['type'] == 'check')
////            \f\pa($v, 2, '', 'check');
////    }
//// считаем сколько часов отработано
//        $hours = \Nyos\mod\JOBDESC_DAYOCENKA::calcHoursDaysForOcenka($db, $return['date'], $return['sp'], array_keys($jobmans['data']['jobmans']), $actions['data']['actions']);
//        // $hours = [];
//        // \f\pa($hours, 2, '', 'колво hours');
//        // \f\pa($hours['calc_checks'], 2, '', 'calc checks');
//
//        $_checks = [];
//
//        foreach ($hours['calc_checks'] as $q) {
//            $_checks[] = ['id' => $q];
//        }
//
//        if (!empty($_checks)) {
//            // \Nyos\mod\items::$show_sql = true;
//            \Nyos\mod\items::edit($db, \Nyos\mod\JobDesc::$mod_checks, $_checks, 
//                    ['sp_calc' => $return['sp'], 'date_calc' => $return['date'] ] 
//                    );
//        }
//
//
//// proc_zp_ot_oborota_if5
//// часы что в фот
//        $return['hour_day'] = $return['hours'] = $hours['hours'];
//// общее число часов
//        $return['hours_all'] = $hours['hours_all'];
//
//        $return['checks'] = $hours['calc_checks'];
//
//        // \f\pa($_SESSION);
//        // инфа для админа        
//        if (isset($_SESSION['now_user_di']['access']) && $_SESSION['now_user_di']['access'] == 'admin')
//            $return['checks_info'] = $hours['calc_checks_info'];
//
//        foreach ($actions['data']['actions'] as $k => $v) {
//
//            if (isset($v['date']) && $v['date'] == $return['date']) {
//
//                if (isset($v['type']) && $v['type'] == 'oborot') {
//                    $return['oborot'] = $v['oborot_day'];
//                } elseif (isset($v['type']) && $v['type'] == 'norms') {
//                    $return['norms'] = [
//                        'time_wait_norm_cold' => $v['time_wait_norm_cold'] ?? '',
//                        // 'time_wait_norm_hot' => $v['time_wait_norm_hot'] ?? '' ,
//                        // 'time_wait_norm_delivery' => $v['time_wait_norm_delivery'] ?? '',
//                        'time_wait_norm_delivery_a' => $v['time_wait_norm_delivery_a'] ?? '',
//                        'time_wait_norm_delivery_b' => $v['time_wait_norm_delivery_b'] ?? '',
//                        'procent_oplata_truda_on_oborota' => $v['procent_oplata_truda_on_oborota'] ?? '',
//                        'kolvo_hour_in1smena' => $v['kolvo_hour_in1smena'] ?? '',
//                        'vuruchka_on_1_hand' => $v['vuruchka_on_1_hand'] ?? ''
//                    ];
//                } elseif (isset($v['type']) && $v['type'] == 'timeo') {
//
//                    $return['timeo'] = [
//                        'cold' => $v['cold'] ?? '',
//                        'delivery' => $v['delivery'] ?? '',
//                        'delivery_a' => $v['delivery_a'] ?? '',
//                        'delivery_b' => $v['delivery_b'] ?? '',
//                    ];
//                    $return['cold'] = $v['cold'] ?? '';
//                    $return['delivery'] = $v['delivery'] ?? '';
//                    $return['delivery_a'] = $v['delivery_a'] ?? '';
//                    $return['delivery_b'] = $v['delivery_b'] ?? '';
//                }
//            }
//        }
//
//// считаем норму на 1 руки
//        $return['smen_in_day'] = round($return['hours'] / $return['norms']['kolvo_hour_in1smena'], 1);
//
//// считаем выручку в 1 руки
//        $return['vuruchka_on_1_hand'] = $return['summa_na_ruki'] = ceil($return['oborot'] / $return['smen_in_day']);
//
////$return['vuruchka'] = $return['oborot'];
//
//        $return['summa_zp_if5'] = $hours['summa_if5'] ?? '';
//
//        if ($return['summa_na_ruki'] >= $return['norms']['vuruchka_on_1_hand']) {
//            $return['ocenka_naruki_ot_oborota'] = $return['ocenka_naruki'] = 5;
//        } else {
//            $return['ocenka_naruki_ot_oborota'] = $return['ocenka'] = $return['ocenka_naruki'] = 3;
//        }
//
//        if (1 == 1) {
//
//            $return['txt'] .= '<Br/><b>сумма на зп, если оценка 5</b>'
//                    . '<Br/>посчитали сколько отработано смен <nobr>' . $return['hours'] . '/' . $return['norms']['kolvo_hour_in1smena'] . ' = ' . $return['smen_in_day'] . '</nobr>'
//                    . '<Br/>часть оборота на 1 руки ' . $return['summa_na_ruki']
//                    . ' (норматив ' . $return['norms']['vuruchka_on_1_hand'] . ') '
//                    . '<div style="background-color: rgba(' . ( $return['ocenka_naruki'] == 5 ? '0,255,0' : '255,255,0' ) . ',0.3);" >оценка: ' . $return['ocenka_naruki'] . '</div>';
//
//            // if ($return['timeo']['cold'] <= $return['norms']['time_wait_norm_cold'] && $return['timeo']['delivery'] <= $return['norms']['time_wait_norm_delivery']) {
//            if (
//                    $return['timeo']['cold'] <= $return['norms']['time_wait_norm_cold'] && $return['timeo']['delivery_a'] <= $return['norms']['time_wait_norm_delivery_a'] && $return['timeo']['delivery_b'] <= $return['norms']['time_wait_norm_delivery_b']
//            ) {
//                $return['ocenka_time'] = 5;
//            } else {
//                $return['ocenka'] = $return['ocenka_time'] = 3;
//            }
//
//            $return['cold'] = $return['timeo']['cold'];
//            $return['delivery_a'] = $return['timeo']['delivery_a'];
//            $return['delivery_b'] = $return['timeo']['delivery_b'];
//        }
//
//        //время ожидания
//        if (1 == 1) {
//
//            $return['txt'] .= '<Br/><b>сравниваем время ожидания</b>'
//                    . '<Br/>'
//                    . $return['timeo']['cold'] . '/' . $return['timeo']['delivery_a'] . '/' . $return['timeo']['delivery_b'] // . ' (доставку не учитываем) '
//                    . ' <nobr>(норматив ' . $return['norms']['time_wait_norm_cold'] . '/' . $return['norms']['time_wait_norm_delivery_a'] . '/' . $return['norms']['time_wait_norm_delivery_b'] . ')</nobr> '
//                    . '<div style="background-color: rgba(' . ( $return['ocenka_time'] == 5 ? '0,255,0' : '255,255,0' ) . ',0.3);" >оценка: ' . $return['ocenka_time'] . '</div>';
//
//            // $return['procent_oplata_truda_on_oborota'] = $return['proc_zp_ot_oborota_if5'] = $return['if5_proc_oborot'] = round($hours['summa_if5'] / ($return['oborot'] / 100), 1);
//            $return['proc_zp_ot_oborota_if5'] = round($hours['summa_if5'] / ($return['oborot'] / 100), 1);
//
//            if ($return['proc_zp_ot_oborota_if5'] < $return['norms']['procent_oplata_truda_on_oborota']) {
//                $return['ocenka_proc_ot_oborot'] = 5;
//            } else {
//                $return['ocenka'] = $return['ocenka_proc_ot_oborot'] = 3;
//            }
//        }
//
//        if (1 == 1) {
//            $return['txt'] .= '<Br/><b>сравниваем % от оборота на ЗП</b>'
//                    . '<Br/>текущее значение ' . $return['proc_zp_ot_oborota_if5']
//                    . ' <nobr>(на зп ' . $hours['summa_if5'] . ' из ТО ' . $return['oborot'] . ')</nobr> '
//                    . '<Br/><nobr>норматив ' . $return['norms']['procent_oplata_truda_on_oborota'] . '</nobr> '
//                    . '<div style="background-color: rgba(' . ( $return['ocenka_proc_ot_oborot'] == 5 ? '0,255,0' : '255,255,0' ) . ',0.3);" >оценка: ' . $return['ocenka_proc_ot_oborot'] . '</div>'
//            ;
//        }
//        $txt_ocenka = '<div style="background-color: rgba(' . ( $return['ocenka'] == 5 ? '0,255,0' : '255,255,0' ) . ',0.8); padding:2px 5px; text-align:center;"><nobr><b>Новая итоговая оценка: ' . $return['ocenka'] . '</b></nobr></div>';
//
//        $return['txt'] .= '<br/><br/><font style="color:gray;" >обновите страницу для обновиления оценки смен в графике</font>';
//
//// \f\pa($return);
//
//        $s2 = $db->prepare('DELETE FROM `mod_sp_ocenki_job_day` WHERE `sale_point` = :sp AND `date` = :date ;');
//        $s2->execute([':sp' => $return['sale_point'], ':date' => $return['date']]);
//
//        $return2 = $return;
//        unset($return2['txt']);
//
//        // \f\pa($return2, 12, '', '$return2');
//        $e = \Nyos\mod\items::add($db, 'sp_ocenki_job_day', $return2);
//// \f\pa($e);
//
//
//        $sql = 'UPDATE `mod_050_chekin_checkout` SET `ocenka_auto` = :ocenka WHERE `id` = \'' . implode('\' OR `id` = \'', $return['checks']) . '\' ;';
////\f\pa($sql);
//        $ff = $db->prepare($sql);
//        $ff->execute([':ocenka' => $return['ocenka']]);
//// echo implode( ', ' , $return['checks'] );
//    }
//
//    $r = ob_get_contents();
//    ob_end_clean();
//
//    if (isset($_REQUEST['return']) && $_REQUEST['return'] == 'html') {
//        \f\pa([$r, $return]);
//        die;
//    }
//
//    \f\end2($txt_ocenka . $r . $return['txt'], true, $return);
}
//
catch (\Exception $ex) {

    ob_start('ob_gzhandler');

    \f\pa($ex);
    $r = ob_get_contents();
    ob_end_clean();

    \f\end2('ошибка' . $r, false);
}
