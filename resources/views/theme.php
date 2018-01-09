<?php

// Fluent:php配列をオブジェクトとして扱うためのヘルパクラス
$metadata = new \Illuminate\Support\Fluent([
    'keywords' => [
        'Laravel', 'Laravel4', 'Laravel4.2', 'Framework', 'WebFramework', 'Sample',
    ] ,
    'description' => '',
    'author' => 'Hori Tomoki',
    'url' => 'http://mokoti.com',
]); 

if (!function_exists('date_string')){
    /**
     * ロケールjaの日付表現を返します
     */
    function date_string($datetime) {
        $weekdayJa = ['日', '月', '火', '水', '木', '金', '土'];
        return $datetime->format('Y年n月j日').'('.$weekdayJa[$datetime->dayOfWeek].')';
    }
}
/* End of file theme.php */
