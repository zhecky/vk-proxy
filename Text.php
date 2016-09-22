<?php
/**
 * Base text functions
 *
 * User: zhecky
 * Date: 13.04.13
 * Time: 11:43
 */

function dropNewLines($text) {
    $text = str_replace("\n", '', $text);
    $text = str_replace("\r", '', $text);
    return $text;
}

function dropSpecSymb($text) {
    $text = str_replace('&', '', $text);
    $text = str_replace('$', '', $text);
    $text = str_replace('!', '', $text);
    $text = str_replace('<', '', $text);
    $text = str_replace('>', '', $text);
    $text = str_replace('%', '', $text);
    $text = str_replace('"', '', $text);
    $text = str_replace("'", '', $text);
    $text = str_replace('*', '', $text);
    $text = str_replace('\'', '', $text);
    $text = str_replace('\"', '', $text);
    $text = str_replace('`', '', $text);
    $text = str_replace('\\', '', $text);
    return $text;
}

function escHtml($text) {
    $text = str_replace('&', '&amp;', $text);

    $text = str_replace('<<', '&laquo;', $text);
    $text = str_replace('>>', '&raquo', $text);

    $text = str_replace('$', '&#36;', $text);
    $text = str_replace('!', '&#33;', $text);
    $text = str_replace('<', '&lt;', $text);
    $text = str_replace('>', '&gt;', $text);
    $text = str_replace('"', '\"', $text);
    $text = str_replace('%', '&#037;', $text);
    $text = str_replace('\'', '&#39;', $text);
    $text = str_replace('\"', "&quot;", $text);
    $text = str_replace('`', "&#96;", $text);
    $text = str_replace('\\', "&#92;", $text);
    $text = str_replace(' -- ', ' &mdash; ', $text);
    return $text;
}

function restoreHtml($text) {
    $text = str_replace('&amp;', '&', $text);
    $text = str_replace('&#36;', '$', $text);
    $text = str_replace('&#33;', '!', $text);
    $text = str_replace('&#39;', '\'', $text);
    $text = str_replace("&quot;", '"', $text);
    $text = str_replace("&#96;", '`', $text);
    $text = str_replace("&#92;", '\\', $text);
    $text = str_replace('&#037;', '%', $text);
    return $text;
}

function escNewLines($text) {
    $text = str_replace("\r", "", $text);
    $text = str_replace("\n", "<br>", $text);
    $text = preg_replace('/(<br>){3,}/is', '<br><br>', $text);
    return $text;
}


function normalizeSpaces($text) {
    return preg_replace('/ {2,}/is', ' ', $text);
}

function parseLink($text) {
    $text = preg_replace("/(http:\/\/([a-z0-9\-]+\.[a-z0-9\-]+(\.[a-z0-9\-]+)*)(:\d+)?(\/[A-Za-z0-9\(\)\?\.\/=\&\;\#\-_%\[\]]*))/", '<a target="_blank" href="/go.php?to=$1">$1</a>', $text);
    //$text = str_replace('?', '%3F', $text);
    /////////$text = str_replace('&amp;', '%26', $text);
    //$text= preg_replace("/(^|[\s])([\w]*?)((ht|f)tp(s)?:\/\/[\w]+[^ \,\"\n\r\t<]*)/is", "$1$2<a href=\"/go.php?to=$3\" >$3</a>", $text);
    //$text= preg_replace("/(^|[\s])([\w]*?)((www|ftp)\.[^ \,\"\t\n\r<]*)/is", "$1$2<a href=\"/go.php?to=http://$3\" >$3</a>", $text);
    //$text= preg_replace("/(^|[\n ])([a-z0-9&\-_\.]+?)@([\w\-]+\.([\w\-\.]+)+)/i", "$1<a href=\"mailto:$2@$3\">$2@$3</a>", $text);
    return $text;
}

function makeNewLines($text) {
    $text = str_replace('<br>', "\n", $text);
    return $text;
}

function array_to_sql_string($arr){
    $quoted_arr = array();
    foreach($arr as $value){
        $quoted_arr[] = "'".$value."'";
    }
    return implode(",",$quoted_arr);
}

function get_likely_words($str) {
    $result = array($str);

    $same = array(
        "a" => array("а"),
        "c" => array("с"),
        "e" => array("е"),
        "i" => array("і"),
        "t" => array("т"),
        "h" => array("н"),
        "o" => array("о", "0"),
        "p" => array("р"),
        "x" => array("х"),
        "y" => array("у"),
        "m" => array("м")
    );

    $same_copy = array();

    foreach ($same as $key => $value) {
        foreach($value as $value_same){
            if(!isSet($same_copy[$value_same])){
                $same_copy[$value_same] = array();
            }
            $same_copy[$value_same][] = $key;
        }
    }

    $same = array_merge($same, $same_copy);

    for ($ind = 0; $ind < strlen($str); $ind++) {
        $current_char = $str[$ind];
        if(isSet($same[$current_char])){
            foreach($same[$current_char] as $value){
                foreach($result as $variant){
                    $variant[$ind] = $value;
                    $result[] = $variant;
                }
            }
        }
    }
    return $result;
}

function normNames($text) {
    return escHtml(dropNewLines($text));
}

function normText($text) {
    return normalizeSpaces(escNewLines(escHtml(trim($text))));
}

function restoreText($text) {
    return makeNewLines(restoreHtml($text));
}

function to1251($text) {
    return iconv("utf-8", "windows-1251", $text);
}

function toUTF8($text) {
    return iconv("windows-1251", "utf-8", $text);
}

/**
 * @param $date int
 * @return string
 */
function dateDiffNow($date) {
    $now = time();
    if (!$date) {
        return 'док міняє час';
    }

    $year = date('Y', $date);
    $month = date('m', $date);
    $day_of_year = date('z', $date);
    $now_day_of_year = date('z');

    $day = date('j', $date); // date('d') без ведущего ноля
    $hour = date('G', $date);
    $minute = date('i', $date);

    $diff_sec = $now - $date;
    $diff_day = (string)floor($diff_sec / 60 / 60 / 24);
    $diff_hour = (string)floor(($diff_sec / 60 / 60) - ($diff_day * 24));
    $diff_min = floor(($diff_sec / 60));

    $at = (date('G', $date) == 11) ? ' об ' : ' о ';

    if ($diff_sec >= 0 && $diff_sec < 60) {
        $diff_str = 'менше хвилини тому';
    } else if ($diff_sec >= 60 && $diff_sec < 3600) {
        if ($diff_min % 10 == 1 && $diff_min != 11) {
            $diff_str =  ' хвилину';
        } else {
            $diff_str = ($diff_min % 10 >= 2 && $diff_min % 10 <= 4 && ($diff_min < 12 || $diff_min > 14)) ? ' хвилини' : ' хвилин';
        }
        $diff_str = $diff_min . $diff_str . ' тому';
    } else if ($diff_sec >= 3600 && $diff_sec < 3600 * 4) {
        $diff_str = (($diff_hour == 1) ? " годину" : $diff_hour . " години") . ' тому';
    } else {
        if ($day_of_year == $now_day_of_year && $year == date('Y')) {
            $diff_str = 'сьогодні ' . $at . $hour . ':' . $minute;
        } else if ($day_of_year == $now_day_of_year - 1 || ($now_day_of_year - 1 == -1 && date('d/m', $date) == '31/12' && date('Y', $date) == date('Y') - 1)) {
            $diff_str = 'вчора ' . $at . $hour . ':' . $minute;
        } else {
            $months = ['січ', 'лют', 'бер', 'кві', 'тра', 'чер', 'лип', 'сер', 'вер', 'жов', 'лис', 'гру'];
            $month = " {$months[$month-1]} ";
            $diff_str = $day . $month . (($year != date('Y')) ? $year : ' ')  . $at . $hour . ':' . $minute;
        }
    }

    return $diff_str;
}

/**
 * Wraping words, but ignore html tags
 * @author http://roberthartung.de/
 * @param  $string
 * @param int $length
 * @param string $wrapString
 * @return string
 */
function wordWrapIgnoreHTML($string, $length = 45, $wrapString = '<wbr>') {
    $wrapped = '';
    $word = '';
    $html = false;
    $string = (string)$string;
    for ($i = 0; $i < strlen($string); $i += 1) {
        $char = $string[$i];


        //TODO also check max count of html char
        /** HTML Begins */
        if ($char === '<') {
            if (!empty($word)) {
                $wrapped .= $word;
                $word = '';
            }

            $html = true;
            $wrapped .= $char;
        }

            /** HTML ends */
        elseif ($char === '>') {
            $html = false;
            $wrapped .= $char;
        }

            /** If this is inside HTML -> append to the wrapped string */
        elseif ($html) {
            $wrapped .= $char;
        }

            /** Whitespace characted / new line */
        elseif ($char === ' ' || $char === "\t" || $char === "\n") {
            $wrapped .= $word . $char;
            $word = '';
        }

            /** Check chars */
        else {
            $word .= $char;

            if (strlen($word) > $length) {
                $wrapped .= $word . $wrapString;
                $word = '';
            }
        }
    }

    if ($word !== '') {
        $wrapped .= $word;
    }

    return $wrapped;
}

function arrayToUTF8($arr) {
    foreach ($arr as $key => $value) {
        if (is_string($arr[$key])) {
            $arr[$key] = toUTF8($arr[$key]);
        }
    }
    return $arr;
}

function encodeString($string, $key){
    return base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $string, MCRYPT_MODE_CBC, md5(md5($key))));
}

function decodeString($encrypted, $key){
    return rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64_decode($encrypted), MCRYPT_MODE_CBC, md5(md5($key))), "\0");
}

?>
