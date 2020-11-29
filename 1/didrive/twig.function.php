<?php



$function = new Twig_SimpleFunction('job_stat__round_number', function ( $db, $date = '' ) {
    
    $massa = [1,2,3,4];
    
    $sps = \Nyos\mod\items::get($db, \Nyos\mod\JobDesc::$mod_sale_point);
    
    // \f\pa($sps);
    
    $ds = date('Y-m-01',strtotime($date));
    $df = date('Y-m-d',strtotime($ds.' +1 month -1 day') );
    
    \Nyos\mod\items::$between_date['date'] = [$ds,$df];
    
    $timeo = \Nyos\mod\items::get($db, \Nyos\mod\JobDesc::$mod_timeo );
    
    $ar_sp_timeo = [];
    
    foreach( $timeo as $k => $v ){
        
        $kk = 'cold';
        $ar_sp_timeo[$v['sale_point']][$kk][$v['date']] = ( $v[$kk] ?? 0 );
        $kk = 'hot';
        $ar_sp_timeo[$v['sale_point']][$kk][$v['date']] = ( $v[$kk] ?? 0 );
        $kk = 'delivery';
        $ar_sp_timeo[$v['sale_point']][$kk][$v['date']] = ( $v[$kk] ?? 0 );
        
    }
    
    \Nyos\mod\items::$between_date['date'] = [$ds,$df];
    $oborot = \Nyos\mod\items::get($db, \Nyos\mod\JobDesc::$mod_oborots );
    
    foreach( $oborot as $k => $v ){
        
        $kk = 'oborot';
        $ar_sp_timeo[$v['sale_point']][$kk][$v['date']] = ( $v['oborot_hand'] ?? $v['oborot_server'] ?? 0 );
    }    
    
    $srednee_sp_point_val = [];
    
    foreach( $ar_sp_timeo as $sp => $ar ){
        
        $srednee_sp_point_val[$sp] = [
            
            'cold_summ' => array_sum(array_values($ar['cold'])),
            'cold_count' => count($ar['cold']),
            'cold' => round(array_sum(array_values($ar['cold']))/count($ar['cold']),1),
            
            'delivery_summ' => array_sum(array_values($ar['delivery'])),
            'delivery_count' => count($ar['delivery']),
            'delivery' => round(array_sum(array_values($ar['delivery']))/count($ar['delivery']),1),
            
            'hot_summ' => array_sum(array_values($ar['hot'])),
            'hot_count' => count($ar['hot']),
            'hot' => round(array_sum(array_values($ar['hot']))/count($ar['hot']),1),
            
            'oborot_summ' => array_sum(array_values($ar['oborot'])),
            'oborot_count' => count($ar['oborot']),
            'oborot' => round(array_sum(array_values($ar['oborot']))/count($ar['oborot']),1)
        ];
        
    }
    
    
    
    return [ 
        'srednee' => $srednee_sp_point_val,
        'sps' => $sps,
        'm' => $massa, 
        'to' => $ar_sp_timeo,
        //'to' => $timeo 
        ];
});
$twig->addFunction($function);
