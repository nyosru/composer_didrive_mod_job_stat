<?php

function paintGraph($ar, $start = true) {

    global $vv;

    if (!isset($vv['dihead']))
        $vv['dihead'] = '';

    if ($start === true)
        $vv['dihead'] .= ' <script type = "text/javascript" src = "https://www.gstatic.com/charts/loader.js"></script> ';

    $vals = $polya = $heads = [];

    foreach ($ar as $k => $v) {
        $vals[$v['pole']][$v['head']] = $v['val'];
        $polya[$v['pole']] = 1;
        $heads[$v['head']] = 1;
    }


    $vv['dihead'] .= ' <script type="text/javascript">
      google.charts.load("current", {"packages":["line"]});
      google.charts.setOnLoadCallback(drawChart); ';

    $vv['dihead'] .= ' function drawChart() {

        var data = new google . visualization . DataTable();
        ';

    $vv['dihead'] .= ' data . addColumn("string", "-"); ';
//$vv['dihead'] .= ' data . addColumn("number", "Оборот"); ';
//$vv['dihead'] .= ' data . addColumn("number", "Оборот"); ';
//$vv['dihead'] .= ' data . addColumn("number", "Оборот"); ';
//$vv['dihead'] .= ' data . addColumn("number", "Оборот"); ';
//$vv['dihead'] .= ' data . addColumn("number", "Оборот"); ';

    foreach ($polya as $sp_head => $s) {
        $vv['dihead'] .= ' data . addColumn("number", "' . $sp_head . '"); ';
        $vv['dihead'] .= PHP_EOL;
    }

//$vv['dihead'] .= '
//      data.addColumn("number", "Day");
//      data.addColumn("number", "Guardians of the Galaxy");
//      data.addColumn("number", "The Avengers");
//      data.addColumn("number", "Transformers: Age of Extinction");
//';

    $vv['dihead'] .= ' data.addRows([ ';

//$n = 0;
    $ee = 1;
//$vv['dihead'] .= ( $ee == 1 ? '' : ',' ) . ' [ '.$n.',  37.8, 80.8, 41.8] ';
//
//$ee = 2;
//$n++;
//



    foreach ($heads as $k => $v) {

        $vv['dihead'] .= ( $ee == 1 ? '' : ',' ) . ' [ "' . $k . '" '; // ,  37.8, 80.8, 41.8] ';

        foreach ($polya as $k1 => $d) {

            $vv['dihead'] .= ' ,' . ( $vals[$k1][$k] ?? 0 );
        }

        $vv['dihead'] .= ' ] ';
        $vv['dihead'] .= PHP_EOL;

        $ee = 2;
    }

//    $ee = 2;
//    $n++;
//}
//$vv['dihead'] .= ' [ "01-01-2020", 22, 13, 37.8, 80.8, 41.8] ';
//$vv['dihead'] .= ' ,[ "10-01-2020", 84, 93, 137.8, 280.8, 411.8] ';
//$vv['dihead'] .= ' ,[ "20-01-2020", 54, 63, 137.8, 280.8, 411.8] ';
//$vv['dihead'] .= ' ,[ "30-01-2020", 44, 53, 137.8, 280.8, 411.8] ';
//$vv['dihead'] .= ' ,[ "01-02-2020", 14, 23, 137.8, 280.8, 411.8] ';
//$vv['dihead'] .= ' ,[ "10-02-2020", 334, 33, 137.8, 280.8, 411.8] ';
//$vv['dihead'] .= ' ,[ "20-01-2020", 54, 63, 137.8, 280.8, 411.8] ';
//$vv['dihead'] .= ' ,[ "30-01-2020", 44, 53, 137.8, 280.8, 411.8] ';
//$vv['dihead'] .= ' ,[ "01-02-2020", 14, 23, 137.8, 280.8, 411.8] ';
//$vv['dihead'] .= ' ,[ "10-02-2020", 334, 33, 137.8, 280.8, 411.8] ';
//$vv['dihead'] .= ' ,[ "20-01-2020", 54, 63, 137.8, 280.8, 411.8] ';
//$vv['dihead'] .= ' ,[ "30-01-2020", 44, 53, 137.8, 280.8, 411.8] ';
//$vv['dihead'] .= ' ,[ "01-02-2020", 14, 23, 137.8, 280.8, 411.8] ';
//$vv['dihead'] .= ' ,[ "10-02-2020", 334, 33, 137.8, 280.8, 411.8] ';
//        [1,  37.8, 80.8, 41.8],
//        [2,  30.9, 69.5, 32.4],
//        [3,  25.4,   57, 25.7],
//        [4,  11.7, 18.8, 10.5],
//        [5,  11.9, 17.6, 10.4],
//        [6,   8.8, 13.6,  7.7],
//        [7,   7.6, 12.3,  9.6],
//        [8,  12.3, 29.2, 10.6],
//        [9,  16.9, 42.9, 14.8],
//        [10, 12.8, 30.9, 11.6],
//        [11,  5.3,  7.9,  4.7],
//        [12,  6.6,  8.4,  5.2],
//        [13,  4.8,  6.3,  3.6],
//        [14,  4.2,  6.2,  3.4]

    $vv['dihead'] .= '                
      ]);

      var options = {
      
        curveType: "function",

        chart: {
          title: "' . ( $vv['graph_head'] ?? 'График' ) . '",
          subtitle: "' . ( $vv['graph_comment'] ?? '-' ) . '"
        },
        legend: { position: "bottom" },
        width: ' . ( $vv['graph_w'] ?? '900' ) . ',
        height: ' . ( $vv['graph_h'] ?? '700' ) . ',
        axes: {
          x: {
            0: {side: "top"}
          }
        }
      };

      var chart = new google.charts.Line(document.getElementById("' . ( $vv['graph_block_id'] ?? 'line_top_x' ) . '"));
      chart.draw(data, google.charts.Line.convertOptions(options));

    }
  </script>
';

//echo '<pre>';
//print_r(htmlspecialchars($vv['dihead']));
//echo '</pre>';
}

if (1 == 2) {

//        $s = $db->prepare('SELECT sql FROM `sqlite_master` WHERE `name` = :table LIMIT 1 ');
//        $s->execute( array( ':table' => $table ) );
//        $r = $s->fetchAll();
//        \f\pa($r);
// echo '<br/>'.__FILE__.' ('.__LINE__.')';

    /**
     * добавление записи
     */
    if (isset($_POST['addnew']{1})) {

        try {

            Nyos\mod\items::addNew($db, $vv['folder'], $vv['now_level'], $_POST, $_FILES);
            $vv['warn'] .= ( isset($vv['warn']{3}) ? '<br/>' : '' ) . 'Запись добавлена';
        } catch (Exception $e) {

            $vv['warn'] .= ( isset($vv['warn']{3}) ? '<br/>' : '' ) . 'Произошла неописуемая ситуация #' . $e->getCode() . '.' . $e->getLine() . ' (ошибка: ' . $e->getMessage() . ' )';
        }
    }
//
    elseif (1 == 2 && isset($_REQUEST['addnew']{1})) {

// $_SESSION['status1'] = true;
// $status = '';
// echo '<br/>'.__FILE__.'['.__LINE__.']';
        $r = Nyos\mod\items::addNew($db, $vv['folder'], $vv['now_mod'], array('head' => $_REQUEST['head']));
//echo '<br/>'.__FILE__.'['.__LINE__.']';
// f\pa($r);

        if (isset($r['status']) && $r['status'] == 'ok') {
            $vv['warn'] .= ( isset($vv['warn']{3}) ? '<br/>' : '' ) . $r['html'];
        }

// echo $status;
    }
//
    elseif (isset($_REQUEST['delete_item_head']{1})) {

// $_SESSION['status1'] = true;
// $status = '';
// echo '<br/>'.__FILE__.'['.__LINE__.']';
// $r = Nyos\mod\items::saveEdit($db, $id_item, $folder, $cfg_mod, $data);
// addNew( $db, $vv['folder'], $vv['now_mod'], array( 'head' => $_REQUEST['head'] ) );
//echo '<br/>'.__FILE__.'['.__LINE__.']';
// f\pa($r);

        $db->sql_Query('UPDATE mitems SET `status` = \'delete\' 
WHERE 
`head` = \'' . addslashes($_REQUEST['head']) . '\' 
AND `module` = \'' . addslashes($vv['level']) . '\' 
AND `folder` = \'' . addslashes($vv['folder']) . '\' 
;');

// echo $status;

        Nyos\mod\items::clearCash($vv['folder']);

        if (isset($r['status']) && $r['status'] == 'ok') {
            $vv['warn'] .= ( isset($vv['warn']{3}) ? '<br/>' : '' ) . $r['html'];
        }

// echo $status;
    }
//
    elseif (isset($_POST['delete_item_id']{1})) {

// $_SESSION['status1'] = true;
// $status = '';
// echo '<br/>'.__FILE__.'['.__LINE__.']';
// $r = Nyos\mod\items::saveEdit($db, $id_item, $folder, $cfg_mod, $data);
// addNew( $db, $vv['folder'], $vv['now_mod'], array( 'head' => $_REQUEST['head'] ) );
//echo '<br/>'.__FILE__.'['.__LINE__.']';
// f\pa($r);

        $db->sql_Query('UPDATE mitems SET `status` = \'delete2\' 
WHERE 
`id` = \'' . addslashes($_POST['id']) . '\' 
AND `module` = \'' . addslashes($vv['level']) . '\' 
AND `folder` = \'' . addslashes($vv['folder']) . '\' 
;');

// echo $status;

        Nyos\mod\items::clearCash($vv['folder']);

        if (isset($r['status']) && $r['status'] == 'ok') {
            $vv['warn'] .= ( isset($vv['warn']{3}) ? '<br/>' : '' ) . $r['html'];
        }

// echo $status;
    }
    /**
     * сохранение редактирования
     */ elseif (isset($_REQUEST['save_id']) && is_numeric($_REQUEST['save_id']) && isset($_REQUEST['save_edit'])) {

        $d = $_POST;
        unset($d['addnew']);
        $d['files'] = $_FILES;

        $r = Nyos\mod\items::saveEdit($db, $_REQUEST['save_id'], $vv['folder'], $vv['now_mod'], $d);
        if (isset($r['status']) && $r['status'] == 'ok') {
            $vv['warn'] .= ( isset($vv['warn']{3}) ? '<br/>' : '' ) . $r['html'];
        }
    } elseif (isset($_GET['refresh_cash']) && $_GET['refresh_cash'] == 'da') {
        \Nyos\mod\items::clearCash($vv['folder']);
    }
}


$vv['menu2'] = [
    'index' => ['name' => 'Общий обзор'],
// 'stat' => ['name' => 'Общий обзор'],
// 'oborots_raschet' => ['name' => 'подробный расчёт оборотов ТП'],
// 'job_tp' => ['name' => 'работа ТП']
];


$vv['krohi'] = [];
$vv['krohi'][1] = array(
    'text' => $vv['now_level']['name'],
    'uri' => '/i.didrive.php?level=' . $vv['now_level']['cfg.level']
);
// $vv['list'] = \Nyos\mod\items::getItems( $db, $vv['folder'], $vv['now_level']['cfg.level'], null);
//\f\pa($vv['list']);
// $vv['tpl_body'] = \f\like_tpl('body', dir_mods_mod_vers_didrive_tpl,  dir_site_module_nowlev_tpldidr, DR );
$vv['tpl_body'] = \f\like_tpl('body', dir_site_module_nowlev_tpldidr, dir_mods_mod_vers_didrive_tpl, DR);



































// месячные графики
if (isset($_REQUEST['option']) && $_REQUEST['option'] == 'index') {

    $sql = '( SELECT '
            . ' \'oborot\' `dataset` , '
            //
            . ' SUM( CASE '
            . ' WHEN ob.oborot_server_hand IS NOT NULL THEN ob.oborot_server_hand '
            . ' WHEN ob.oborot_hand IS NOT NULL THEN ob.oborot_hand '
            . ' WHEN ob.oborot_server IS NOT NULL THEN ob.oborot_server '
            . ' ELSE 0 '
            . ' END ) as oborot , '
            . ' COUNT( ob.id ) kolvo , '
            //
            . ' ROUND( SUM( CASE '
            . ' WHEN ob.oborot_server_hand IS NOT NULL THEN ob.oborot_server_hand '
            . ' WHEN ob.oborot_hand IS NOT NULL THEN ob.oborot_hand '
            . ' WHEN ob.oborot_server IS NOT NULL THEN ob.oborot_server '
            . ' ELSE 0 '
            . ' END ) / COUNT( ob.id ) , 0 ) as srednee_oborot  , '
            //
            . ' CONCAT( year(ob.date), month(ob.date) ) date_ym , '
            . ' year(ob.date) year, '
            . ' month(ob.date) month , '
            . ' ob.sale_point sp , '
            . ' sp.head sp_head, '
            . ' sp.sort sp_sort '
            . ' FROM mod_' . \f\translit(\Nyos\mod\JobDesc::$mod_oborots, 'uri2') . ' ob
                
                LEFT JOIN mod_' . \f\translit(\Nyos\mod\JobDesc::$mod_sale_point, 'uri2') . ' sp 
                ON sp.id = ob.sale_point 
                
                WHERE
                    ob.status = \'show\' 
                    AND
                    ob.date BETWEEN :d1 AND :d2
                    
                GROUP BY ob.sale_point, date_ym '
                
                // .' ORDER BY year ASC, month ASC, sp_head ASC '
                .' )
                ';

    $sql .= ' UNION ALL ';

    $sql .= ' ( SELECT '
            . ' \'timeo\' `dataset` , '
            //
            . ' SUM( CASE '
            . ' WHEN 
                    ob.cold IS NOT NULL AND
                    ob.delivery IS NOT NULL 
                THEN 
                    ob.cold + ob.delivery '
            . ' WHEN 
                    ob.cold IS NOT NULL AND
                    ob.delivery_a IS NOT NULL AND
                    ob.delivery_b IS NOT NULL 
                THEN 
                    ob.cold + ob.delivery_a + ob.delivery_b '
            . ' ELSE 0 '
            . ' END ) as oborot , '
            //
            . ' COUNT( ob.id ) kolvo , '
            //
            . ' ROUND( SUM( CASE '
            
            . ' WHEN 
                    ob.cold IS NOT NULL AND
                    ob.delivery IS NOT NULL 
                THEN 
                    ob.cold + ob.delivery '
            
            . ' WHEN 
                    ob.cold IS NOT NULL AND
                    ob.delivery_a IS NOT NULL AND
                    ob.delivery_b IS NOT NULL 
                THEN 
                    ob.cold + ob.delivery_a + ob.delivery_b '
            
            . ' ELSE 0 '
            . ' END ) / COUNT( ob.id ) , 0 ) as srednee_oborot  , '
            //
            . ' CONCAT( year(ob.date), month(ob.date) ) date_ym , '
            . ' year(ob.date) year, '
            . ' month(ob.date) month , '
            . ' ob.sale_point sp , '
            . ' sp.head sp_head, '
            . ' sp.sort sp_sort '
            //
            . ' FROM mod_' . \f\translit(\Nyos\mod\JobDesc::$mod_timeo , 'uri2') . ' ob
                
                LEFT JOIN mod_' . \f\translit(\Nyos\mod\JobDesc::$mod_sale_point, 'uri2') . ' sp 
                ON sp.id = ob.sale_point 
                
                WHERE
                    ob.status = \'show\' 
                    AND
                    ob.date BETWEEN :d1 AND :d2
                GROUP BY ob.sale_point, date_ym
                ORDER BY ob.date ASC, sp_head ASC
                )
                ';

    $ff = $db->prepare($sql);

    $in = [
        ':d1' => date('Y-m-01', strtotime('-5 month')),
        ':d2' => date('Y-m-d')
    ];
    $ff->execute($in);

    // $data = $ff->fetchAll();
    // \f\pa( $data , 2 );

    $data = [];
    $data_timeo = [];
    while ($d = $ff->fetch()) {
        if (isset($d['dataset']) && $d['dataset'] == 'oborot') {
            $data[] = [
                'pole' => $d['sp_head'],
                'sort' => date('Ymd', strtotime($d['year'] . '-' . $d['month'] . '-01')).$d['sp_sort'],
                'head' => date('m.Y', strtotime($d['year'] . '-' . $d['month'] . '-1')),
                'val' => $d['srednee_oborot'],
            ];
        }
        elseif (isset($d['dataset']) && $d['dataset'] == 'timeo') {
            $data_timeo[] = [
                'pole' => $d['sp_head'],
                'sort' => date('Ymd', strtotime($d['year'] . '-' . $d['month'] . '-01')).$d['sp_sort'],
                'head' => date('m.Y', strtotime($d['year'] . '-' . $d['month'] . '-1')),
                'val' => $d['srednee_oborot'],
            ];
        }
    }


    // \f\pa($data, 2, '', 'data');

    $vv['graph_head'] = 'Ежедневные обороты';
    $vv['graph_comment'] = 'Ежедневные обороты за сутки по месяцам';
    $vv['graph_w'] = 900;
    $vv['graph_h'] = 800;
    $vv['graph_block_id'] = 'line_top_x';
    
    usort($data, "\\f\\sort_ar_sort");
    
    paintGraph($data);
    
    $vv['graph_head'] = 'Время ожидания';
    $vv['graph_comment'] = 'Средние ежедневные показатели ( холодный цех + доставка )';
    $vv['graph_w'] = 900;
    $vv['graph_h'] = 800;
    $vv['graph_block_id'] = 'line_top_x2';
    
    usort($data_timeo, "\\f\\sort_ar_sort");
    
    paintGraph($data_timeo , false );
    
}
// недельные графики
elseif (isset($_REQUEST['option']) && $_REQUEST['option'] == 'index_n') {

    $ff = $db->prepare('SELECT 

s.sale_point sp ,
sp.head,
s.date ,
s.date_finish,
s.srednee_oborot oborot ,
s.srednee_timeo 

FROM    
mod_' . \f\translit(\Nyos\mod\JobDesc::$mod_stat_fix_month, 'uri2') . ' s
LEFT JOIN mod_' . \f\translit(\Nyos\mod\JobDesc::$mod_sale_point, 'uri2') . ' sp 
ON sp.id = s.sale_point 
ORDER BY s.date ASC
');

    $in = [];
    $ff->execute($in);

    $sps = [];

    while ($r = $ff->fetch()) {
        $sps[$r['sp']] = $r['head'];
        $ob[$r['sp']][$r['date'] . '/' . $r['date_finish']] = $r['oborot'];

//    \f\pa($r);
    }

    $weeks = \f\f_date__get_weeks(date('Y-m-d', strtotime('-2 month')), date('Y-m-d'));
    \f\pa($weeks);


    $vv['dihead'] = '<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    google.charts.load("current", {"packages":["line"]});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {

    var data = new google.visualization.DataTable();
    ';

    $vv['dihead'] .= ' data.addColumn("string", "Недели"); ';
//$vv['dihead'] .= ' data.addColumn("number", "Оборот"); ';
//$vv['dihead'] .= ' data.addColumn("number", "Оборот"); ';
//$vv['dihead'] .= ' data.addColumn("number", "Оборот"); ';
//$vv['dihead'] .= ' data.addColumn("number", "Оборот"); ';
//$vv['dihead'] .= ' data.addColumn("number", "Оборот"); ';

    foreach ($sps as $sp => $sp_head) {
        $vv['dihead'] .= ' data.addColumn("number", "' . $sp_head . '"); ';
        $vv['dihead'] .= PHP_EOL;
    }

//$vv['dihead'] .= '
//      data.addColumn("number", "Day");
//      data.addColumn("number", "Guardians of the Galaxy");
//      data.addColumn("number", "The Avengers");
//      data.addColumn("number", "Transformers: Age of Extinction");
//';

    $vv['dihead'] .= '
            data.addRows([ ';

//$n = 0;
    $ee = 1;
//$vv['dihead'] .= ( $ee == 1 ? '' : ',' ) . ' [ '.$n.',  37.8, 80.8, 41.8] ';
//
//$ee = 2;
//$n++;
//

    foreach ($weeks as $k => $v) {

        $vv['dihead'] .= ($ee == 1 ? '' : ',') . ' [ "' . date('m.d', strtotime($v[0])) . '-' . date('m.d', strtotime($v[1])) . '" '; // ,  37.8, 80.8, 41.8] ';

        foreach ($sps as $sp => $sp_head) {

            foreach ($weeks as $k1 => $v1) {
                if ($v1[0] == $v[0] && $v[1] == $v1[1])
                    $vv['dihead'] .= ' ,' . ($ob[$sp][$v[0] . '/' . $v[1]] ?? 0);
            }
        }

        $vv['dihead'] .= ' ] ';
        $vv['dihead'] .= PHP_EOL;
        $ee = 2;
    }

//    $ee = 2;
//    $n++;
//}
//$vv['dihead'] .= ' [ "01-01-2020", 22, 13, 37.8, 80.8, 41.8] ';
//$vv['dihead'] .= ' ,[ "10-01-2020", 84, 93, 137.8, 280.8, 411.8] ';
//$vv['dihead'] .= ' ,[ "20-01-2020", 54, 63, 137.8, 280.8, 411.8] ';
//$vv['dihead'] .= ' ,[ "30-01-2020", 44, 53, 137.8, 280.8, 411.8] ';
//$vv['dihead'] .= ' ,[ "01-02-2020", 14, 23, 137.8, 280.8, 411.8] ';
//$vv['dihead'] .= ' ,[ "10-02-2020", 334, 33, 137.8, 280.8, 411.8] ';
//$vv['dihead'] .= ' ,[ "20-01-2020", 54, 63, 137.8, 280.8, 411.8] ';
//$vv['dihead'] .= ' ,[ "30-01-2020", 44, 53, 137.8, 280.8, 411.8] ';
//$vv['dihead'] .= ' ,[ "01-02-2020", 14, 23, 137.8, 280.8, 411.8] ';
//$vv['dihead'] .= ' ,[ "10-02-2020", 334, 33, 137.8, 280.8, 411.8] ';
//$vv['dihead'] .= ' ,[ "20-01-2020", 54, 63, 137.8, 280.8, 411.8] ';
//$vv['dihead'] .= ' ,[ "30-01-2020", 44, 53, 137.8, 280.8, 411.8] ';
//$vv['dihead'] .= ' ,[ "01-02-2020", 14, 23, 137.8, 280.8, 411.8] ';
//$vv['dihead'] .= ' ,[ "10-02-2020", 334, 33, 137.8, 280.8, 411.8] ';
//        [1,  37.8, 80.8, 41.8],
//        [2,  30.9, 69.5, 32.4],
//        [3,  25.4,   57, 25.7],
//        [4,  11.7, 18.8, 10.5],
//        [5,  11.9, 17.6, 10.4],
//        [6,   8.8, 13.6,  7.7],
//        [7,   7.6, 12.3,  9.6],
//        [8,  12.3, 29.2, 10.6],
//        [9,  16.9, 42.9, 14.8],
//        [10, 12.8, 30.9, 11.6],
//        [11,  5.3,  7.9,  4.7],
//        [12,  6.6,  8.4,  5.2],
//        [13,  4.8,  6.3,  3.6],
//        [14,  4.2,  6.2,  3.4]

    $vv['dihead'] .= '                
            ]);
    var options = {
    chart: {
    title: "Статистика средних оборотов за неделю по точкам продаж",
            subtitle: "обороты"
    },
            width: 900,
            height: 500,
            axes: {
            x: {
            0: {side: "top"}
            }
            }
    };
    var chart = new google.charts.Line(document.getElementById("line_top_x"));
    chart.draw(data, google.charts.Line.convertOptions(options));
    }
</script>
';

//echo '<pre>';
//print_r(htmlspecialchars($vv['dihead']));
//echo '</pre>';
}    