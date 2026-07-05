<?php
/**
 * هلپرهای سراسری — هنرستان هزاره صنعت
 */

if (!function_exists('verta')) {
    function verta($datetime = null) {
        return \Hekmatinasser\Verta\Verta::instance($datetime);
    }
}

if (!function_exists('toFarsiNum')) {
    function toFarsiNum(string $str): string {
        $fa = ['۰','۱','۲','۳','۴','۵','۶','۷','۸','۹'];
        return str_replace(range(0,9), $fa, $str);
    }
}
