<?php

/**
  класс модуля
 * */
//

namespace Nyos\mod;

//
//if (!defined('IN_NYOS_PROJECT'))
//    throw new \Exception('Сработала защита от розовых хакеров, обратитесь к администрратору');
//
class JOB_STAT {

    public static $var = 123;

    public static function getStatInDb($db, $date, $date_finish = null) {

        $ff = $db->prepare('SELECT 
                f.sale_point,
                f.srednee_oborot,
                f.srednee_timeo,
                sp.head sp
            FROM mod_' . \f\translit(\Nyos\mod\JobDesc::$mod_stat_fix_month, 'uri2') . ' f 
                LEFT JOIN mod_' . \f\translit(\Nyos\mod\JobDesc::$mod_sale_point, 'uri2') . ' sp ON f.sale_point = sp.id '
                . ' WHERE f.date = :d1 AND f.date_finish = :d2 ');
        $in2 = [
            ':d1' => date('Y-m-d', strtotime($date)),
            ':d2' => date('Y-m-d', strtotime($date_finish)),
        ];
        $ff->execute($in2);

        if ($ff->rowCount() == 0) {
            return false;
        }


        $return = [
            'sp_oborot_srednee' => [],
            'sps' => [],
            'sp_t_srednee' => []
        ];


        while ($r = $ff->fetch()) {
            $return['sp_oborot_srednee'][$r['sale_point']] = $r['srednee_oborot'];
            $return['sps'][$r['sale_point']] = $r['sp'];
            $return['sp_t_srednee'][$r['sale_point']] = $r['srednee_timeo'];
        }

        return $return;
    }

    public static function getStat($db, $date, $date_finish = null) {

        $in = [
            ':date1' => date('Y-m-01', strtotime($date))
        ];

        if (!empty($date_finish)) {
            $in[':date2'] = date('Y-m-d', strtotime($date_finish));
        } else {
            $in[':date2'] = date('Y-m-d', strtotime($in[':date1'] . ' +1 month -1 day'));
        }

        
        $ee = self::getStatInDb($db, $in[':date1'], $in[':date2']);
        if ( !empty($ee) ) {
            $ee['saved'] = 'da';
            return $ee;
        }



        $sql = 'SELECT '

                // .' d.* , '
                . ' d.sale_point , '
                . ' d.date , '
                . ' d.hours_all , '
                . ' p.kolvo_hour_in1smena , '
                // .' o.* , '
                /* выводим оборот */
                . ' CASE
                            WHEN o.oborot_hand > 0 THEN o.oborot_hand
                            WHEN o.oborot_server_hand > 0 THEN o.oborot_server_hand
                            WHEN o.oborot_server > 0 THEN o.oborot_server
                        END `day_oborot`
                        ,

                        CASE
                            WHEN o.oborot_hand > 0 AND p.kolvo_hour_in1smena > 0 
                            THEN ROUND( o.oborot_hand/( d.hours_all / p.kolvo_hour_in1smena ) , 1 )
                            WHEN o.oborot_server_hand > 0 AND p.kolvo_hour_in1smena > 0 
                            THEN ROUND( o.oborot_server_hand/( d.hours_all / p.kolvo_hour_in1smena ) , 1 )
                            WHEN o.oborot_server > 0 AND p.kolvo_hour_in1smena > 0 
                            THEN ROUND( o.oborot_server/( d.hours_all / p.kolvo_hour_in1smena ) , 1 )
                        END `day_oborot_in_all_hands`
                        , '
                // .' t.cold , '
                // .' t.delivery, '
                . ' CASE
                            WHEN t.cold > 0 AND t.delivery > 0 
                                THEN t.delivery + t.cold 
                            WHEN t.cold > 0 AND t.delivery_a > 0 AND t.delivery_b > 0 
                                THEN t.delivery_a + t.delivery_b + t.cold
                            END timeo ,

                        sp.head sale_point_name

                    FROM 
                        mod_sp_ocenki_job_day d

                    LEFT JOIN mod_sale_point_parametr p ON p.sale_point = d.sale_point AND p.date = d.date AND p.status = \'show\'
                    LEFT JOIN mod_sale_point_oborot o ON o.sale_point = d.sale_point AND o.date = d.date AND o.status = \'show\'
                    LEFT JOIN mod_sale_point sp ON sp.id = d.sale_point AND sp.status = \'show\'
                    LEFT JOIN mod_074_time_expectations_list t ON t.sale_point = d.sale_point AND t.date = d.date AND t.status = \'show\'

                    WHERE 
                        d.date >= :date1 
                        AND d.date <= :date2

                    ;';
        $ff = $db->prepare($sql);
        $ff->execute($in);

        $res_sp_date = [];
        $res_sp_t = [];

        $res = [
            'sp_oborot_srednee' => [],
            'sp_oborot' => [],
            'sp_status' => [],
            'sps' => [],
            'all' => [],
            'sp_oborot_srednee0' => [],
        ];

        while ($r = $ff->fetch()) {

            if (empty($r['sale_point']))
                continue;

            $res['all'][] = $r;
            $res['sps'][$r['sale_point']] = $r['sale_point_name'];
            $res['sp_status'][$r['sale_point']] = true;
            $res_sp_date[$r['sale_point']][$r['date']] = $r['day_oborot_in_all_hands'];
            $res_sp_t[$r['sale_point']][$r['date']] = $r['timeo'];
        }

        $res1 = [
            'sp_oborot_srednee' => [],
            'sps' => $res['sps']
        ];



        foreach ($res['sps'] as $sp => $sp_name) {

            // echo '<br/><br/>' . $sp . '<br/>';

            for ($i = 0; $i <= 32; $i++) {

                $date = date('Y-m-d', strtotime($in[':date1'] . ' +' . $i . ' day'));

                if ($date > $in[':date2'])
                    continue;

                // echo 'd ' . $date;

                if (!empty($res_sp_date[$sp][$date])) {
                    $res['sp_oborot_srednee0'][$sp][] = $res_sp_date[$sp][$date];
                    $res['sp_timeo_srednee0'][$sp][] = $res_sp_t[$sp][$date];
                    // echo ' ++ ';
                }
                //
//                else {
//                    $res['sp_status'][$sp] = false;
//                    // echo ' -- ';
//                }
            }

            if (1 == 1 || $res['sp_status'][$sp] === true) {
                $res1['sp_oborot_srednee'][$sp] = round(array_sum($res['sp_oborot_srednee0'][$sp]) / count($res['sp_oborot_srednee0'][$sp]), 1);
                $res1['sp_t_srednee'][$sp] = round(array_sum($res['sp_timeo_srednee0'][$sp]) / count($res['sp_timeo_srednee0'][$sp]), 1);

                \Nyos\mod\items::add($db, \Nyos\mod\JobDesc::$mod_stat_fix_month, [
                    'sale_point' => $sp,
                    'date' => $in[':date1'],
                    'date_finish' => $in[':date2'],
                    'srednee_timeo' => $res1['sp_t_srednee'][$sp],
                    'srednee_oborot' => $res1['sp_oborot_srednee'][$sp]
                        // 'srednee_money_in_hand_all' => $res1['sp_t_srednee'][$sp],
                ]);
            }
        }

        $res1['all'] = $res['all'];

        return $res1;
    }

}
