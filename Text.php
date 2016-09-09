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

function dateDiffNow($date) {
    $diff_str = '';
    $now = time();
    if (!$date) {
        return 'Док міняє час';
    }

    $year = date('Y', $date);
    $month = date('m', $date);
    $day_of_year = date('z', $date);
    $day = date('d', $date);
    $hour = date('G', $date);
    $minute = date('i', $date);

    $now_hour = date('G');
    $now_day = date('z');
    $now_month = date('m');
    $now_year = date('Y');

    $diff_sec = $now - $date;
    $diff_day = (string)floor($diff_sec / 60 / 60 / 24);
    $diff_hour = (string)floor(($diff_sec / 60 / 60) - ($diff_day * 24));
    $diff_min = (string)floor(($diff_sec / 60));

    $ago = ' тому';


    $eleven = date('G', $date);

    if ($eleven == 11) {
        $at = ' об ';
    } else {
        $at = ' о ';
    }

    if ($diff_sec < 60 && $diff_sec >= 0) {
        $diff_str = 'менше хвилини' . $ago;

    } elseif ($diff_sec >= 60 && $diff_sec < 3600) {

        //Різниця в хвилинах

        if ($diff_min == "11" || $diff_min == "12" || $diff_min == "13" || $diff_min == "14") {
            $diff_str = " хвилин";
        } elseif ($diff_min[strlen($diff_min) - 1] == "2" || $diff_min[strlen($diff_min) - 1] == "3" || $diff_min[strlen($diff_min) - 1] == "4") {
            $diff_str = " хвилини";
        } elseif ($diff_min[strlen($diff_min) - 1] == "1") {
            $diff_str = " хвилину";
        } else {
            $diff_str = " хвилин";
        }
        $diff_str = $diff_min . $diff_str . $ago;
    } elseif ($diff_sec >= 3600 AND $diff_sec < 3600 * 4) {
        if ($diff_hour == 1) {
            $diff_str = " годину";
        } else {
            $diff_str = " години";
        }
        $diff_str = $diff_hour . $diff_str . $ago;
    } else {
        if ($day_of_year == $now_day) {
            $diff_str = 'сьогодні ' . $at . $hour . ':' . $minute;
        } elseif ($day_of_year == $now_day - 1 || $now_day - 1 <= 0) {

            $diff_str = 'вчора ' . $at . $hour . ':' . $minute;
        } else {
            switch ((int)$month) {
                case 1:
                    $month = ' січня ';
                    break;
                case 2:
                    $month = ' лютого ';
                    break;
                case 3:
                    $month = ' березня ';
                    break;
                case 4:
                    $month = ' квітня ';
                    break;
                case 5:
                    $month = ' травня ';
                    break;
                case 6:
                    $month = ' червня ';
                    break;
                case 7:
                    $month = ' липня ';
                    break;
                case 8:
                    $month = ' серпня ';
                    break;
                case 9:
                    $month = ' вересня ';
                    break;
                case 10:
                    $month = ' жовтня ';
                    break;
                case 11:
                    $month = ' листопада ';
                    break;
                case 12:
                    $month = ' грудня ';
                    break;
            }
            $diff_str = $day . $month . $year . $at . $hour . ':' . $minute;
        }

    }
    return $diff_str;

}

function dateDiffNowShort($date) {
    $diff_str = '';
    $now = time();
    if (!$date) return 'Doc changes time..';


    $year = date('Y', $date);
    $month = date('m', $date);
    $day_of_year = date('z', $date);
    $day = date('d', $date);
    $hour = date('G', $date);
    $minute = date('i', $date);

    $now_hour = date('G');
    $now_day = date('z');
    $now_month = date('m');
    $now_year = date('Y');

    $diff_sec = $now - $date;
    $diff_day = (string)floor($diff_sec / 60 / 60 / 24);
    $diff_hour = (string)floor(($diff_sec / 60 / 60) - ($diff_day * 24));
    $diff_min = (string)floor(($diff_sec / 60));

    $ago = '';


    $eleven = date('G', $date);

    if ($eleven == 11) { // zhecky, wat?
        $at = ' ';
    } else {
        $at = ' ';
    }

    if ($diff_sec < 60 && $diff_sec >= 0) {
        $diff_str = 'менше хвилини' . $ago;

    } elseif ($diff_sec >= 60 && $diff_sec < 3600) {

        //Різниця в хвилинах

        if ($diff_min == "11" || $diff_min == "12" || $diff_min == "13" || $diff_min == "14") {
            $diff_str = " хв";
        } elseif ($diff_min[strlen($diff_min) - 1] == "2" || $diff_min[strlen($diff_min) - 1] == "3" || $diff_min[strlen($diff_min) - 1] == "4") {
            $diff_str = " хв";
        } elseif ($diff_min[strlen($diff_min) - 1] == "1") {
            $diff_str = " хв";
        } else {
            $diff_str = " хв";
        }
        $diff_str = $diff_min . $diff_str . $ago;
    } elseif ($diff_sec >= 3600 AND $diff_sec < 3600 * 4) {
        if ($diff_hour == 1) {
            $diff_str = " год";
        } else {
            $diff_str = " год";
        }
        $diff_str = $diff_hour . $diff_str . $ago;
    } else {
        if ($day_of_year == $now_day) {
            $diff_str = ' ' . $at . $hour . ':' . $minute;
        } elseif ($day_of_year == $now_day - 1 || $now_day - 1 <= 0) {

            $diff_str = 'вчора ' . $at . $hour . ':' . $minute;
        } else {
            switch ((int)$month) {
                case 1:
                    $month = ' січня ';
                    break;
                case 2:
                    $month = ' лютого ';
                    break;
                case 3:
                    $month = ' березня ';
                    break;
                case 4:
                    $month = ' квітня ';
                    break;
                case 5:
                    $month = ' травня ';
                    break;
                case 6:
                    $month = ' червня ';
                    break;
                case 7:
                    $month = ' липня ';
                    break;
                case 8:
                    $month = ' серпня ';
                    break;
                case 9:
                    $month = ' вересня ';
                    break;
                case 10:
                    $month = ' жовтня ';
                    break;
                case 11:
                    $month = ' листопада ';
                    break;
                case 12:
                    $month = ' грудня ';
                    break;
            }
            $diff_str = $day . '/' . date('m', $date) . '/' . $year . $at . $hour . ':' . $minute;
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
