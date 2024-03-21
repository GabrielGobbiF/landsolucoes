<?php

use App\Models\Epi;
use Carbon\Carbon;
use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

function validateDate($date, $format = 'd/m/Y')
{
    $d = \DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
}

function token($size = 10, $charsAlphabetic = true)
{
    $chars = "0123456789";
    if ($charsAlphabetic) {
        $chars .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuwxyz';
        $chars .= date("Y-m-d H:i:s");
    } else {
        $chars .= date("H:i:s");
    }
    $randomString = '';
    for ($i = 0; $i < $size; $i = $i + 1) {
        $randomString .= $chars[mt_rand(0, strlen($chars) - 5)];
    }
    return substr(uniqid(limpar($randomString)), 0, $size);
}

function formatDateAndTime($value, $format = 'd/m/Y')
{
    // Utiliza a classe de Carbon para converter ao formato de data ou hora desejado
    $value = str_replace('/', '-', $value);
    return Carbon::parse($value)->format($format);
}

function maskPrice($number = 0)
{
    $number = clearNumber($number);
    return number_format($number, 2, ',', '.');
}

function removeParseContentBar($string, $charSe = 'data-id=')
{
    $arr = str_split($string);
    $i = 0;
    foreach ($arr as $k => $char) {
        if ($char == $charSe) {
            /* abre a tag na primeira barra e
             fecha o elemento em tag quando
             achar a segunda barra */
            $arr[$k] = ($i % 2 == 0) ? '<' : '/>';
        } else {
            $arr[$k] = $char;
            $i++;
        }
        $i++;
    }
    $content = implode('', $arr);
    //remove a tag
    return $arr;
}


function titleCase($string)
{
    $string = mb_strtolower($string, 'UTF-8');
    $explode = explode(" ", $string);
    $in = '';
    foreach ($explode as $str) {
        if (strlen($str) > 2) {
            $in .= mb_convert_case($str, MB_CASE_TITLE, "UTF-8") . ' ';
        } else {
            $in .= $str . ' ';
        }
    }
    return trim(ucfirst($in));
}


function limit($string, $limit = 30)
{
    return Str::limit($string, $limit, '...');
}

function getIconByExtDoc($extensao)
{
    switch ($extensao) {
        case 'png':
            $icon = 'fas fa-image';
            $color = '#d49430';
            break;
        case 'jpg':
            $icon = 'fas fa-image';
            $color = '#d49430';
            break;
        case 'jpeg':
            $icon = 'fas fa-image';
            $color = '#d49430';
            break;
        case 'gif':
            $icon = 'fas fa-image';
            $color = '#d43030';
            break;
        case 'pdf':
            $icon = 'fas fa-file-pdf';
            $color = '#d43030';
            break;
        case 'pptx':
            $icon = 'fas fa-file-powerpoint';
            $color = '#cc4f2e';
            break;
        case 'xlsx':
            $icon = 'fas fa-file-excel';
            $color = '#30d435';
            break;
        case 'doc':
            $icon = 'fas fa-file-word';
            $color = '#1757b7';
            break;
        case 'docx':
            $icon = 'fas fa-file-word';
            $color = '#1757b7';
            break;
        default:
            $icon = 'fas fa-file';
            $color = '#d43030';
            break;
    }

    return [
        'icon' => $icon,
        'color' => $color
    ];
}

function dateTournamentForHumans($date = null)
{
    if ($date) {
        $dateForForHuman = new Carbon($date, 'America/Sao_paulo');
        return $dateForForHuman->diffForHumans([
            'syntax' => CarbonInterface::DIFF_RELATIVE_TO_NOW,
            'options' => Carbon::JUST_NOW | Carbon::ONE_DAY_WORDS | Carbon::TWO_DAY_WORDS,
        ]);
    }
}

function limpar($variavel, $traco = '-')
{
    return strtolower(preg_replace("/[^a-zA-Z0-9-]/", "$traco", strtr(utf8_decode(trim($variavel)), utf8_decode("áàãâéêíóôõúüñçÁÀÃÂÉÊÍÓÔÕÚÜÑÇ"), "aaaaeeiooouuncAAAAEEIOOOUUNC-")));
}

function return_format_date($date, $type = 'pt', $gDate = '-')
{
    if ($date != '' && strlen($date) > 4) {

        $date = ltrim($date);

        $date = str_replace("/", "-", $date);
        $date = str_replace("--", "-", $date);

        $array = explode('-', $date);

        //garante que o array possue tres elementos (dia, mes e ano)

        $date = Carbon::parse($date);

        switch ($type) {
            case 'pt':
                return Carbon::parse($date)->format("d/m/Y");
                break;
            case 'en':
                return Carbon::parse($date)->format('Y-m-d');
                break;
            default:
                return Carbon::parse($date)->format('Y-m-d');
                break;
        }
    }
    return NULL;
}

function dataLimpa($date)
{
    $date = str_replace("/", "-", $date);

    return Carbon::parse($date)->format('d/m/Y');
}

function somarData($soma, $date, $type = 'days', $formatReturn = 'Y-m-d H:i:s')
{
    $date = $date != '' ? Carbon::parse($date) : Carbon::parse(date('Y-m-d H:i:s'));

    switch ($type) {
        case 'days':
            $date->addDays($soma);
            break;

        case 'hours':
            $date->addHours($soma);
            break;

        case 'minutes':
            $date->addMinutes($soma);
            break;

        default:
            # code...
            break;
    }
    return Carbon::parse($date)->format($formatReturn);
}

function clearNumber($number = 0)
{
    if ($number === 'NaN') {
        return 0;
    }
    if (empty($number)) {
        return 0;
    }

    $number = str_replace(['R$', '&nbsp', chr(194) . chr(160)], '', $number);

    $number = ltrim($number, "\xC2\xA0");

    if (!is_numeric($number)) {
        $number = str_replace(',', '.',  $number);
        if (substr_count($number, '.') > 1) {
            $e = explode('.', $number);
            $string = '';
            for ($i = 0; $i < count($e); $i++) {
                if ($i == count($e) - 1) {
                    $string .= ',' . $e[$i];
                } else {
                    $string .= $e[$i];
                }
            }
            $number = $string;
            $number = str_replace(',', '.',  $number);
        }
    }
    $number = number_format($number, 2, '.', '');
    return $number;
}

function slack($message = [], $channel = 'sistema')
{
    \Slack::to('#' . $channel)->send($message);
}

function plural($tx, $pl = true)
{
    return $pl ? Str::plural($tx) : Str::pluralStudly($tx, 2);
}

function singular($tx)
{
    return Str::singular($tx);
}

function clear($v)
{

    return str_replace(['(', ')', '-', ' '], '', $v);
}

/**
 * Makes translation fall back to specified value if definition does not exist
 *
 * @param string $key
 * @param null|string $fallback
 * @param null|string $locale
 * @param array|null $replace
 *
 * @return array|\Illuminate\Contracts\Translation\Translator|null|string
 */
function __trans($key = '', ?array $replace = [], ?string $fallback = null, ?string $locale = 'pt-BR')
{
    $keyM = ($key);
    if (\Illuminate\Support\Facades\Lang::has($keyM, $locale) && !empty($keyM)) {
        if (gettype(trans($keyM, $replace, $locale)) == 'array') {
            return trans($keyM, $replace, $locale)[0];
        }
        return trans($keyM, $replace, $locale);
    }

    return ltrim($key);
}

function minusculo($value)
{
    return mb_strtolower($value, 'utf-8');
}
function __minusculo($value)
{
    return mb_strtolower($value, 'utf-8');
}

function maiusculo($value)
{
    return mb_strtoupper($value, 'utf-8');
}

function in_array_column($text, $column, $array)
{
    if (!empty($array) && is_array($array)) {
        for ($i = 0; $i < count($array); $i++) {
            if ($array[$i][$column] == $text || strcmp($array[$i][$column], $text) == 0) return true;
        }
    }
    return false;
}

function limparTelefone($v)
{
    return str_replace(['+55', '(', ')', '-', '-', ' '], '', $v);
}

function slug($value, $caracter = '_')
{
    return Str::slug(mb_strtolower($value, 'UTF-8'), $caracter);
}

function getEpi($id)
{
    return Epi::where('id', $id)->first();
}

function array_not_null($array = [])
{
    return collect($array)->filter(function ($request) {
        return is_string($request) && !empty($request) || is_array($request) && count($request);
    })->toArray();
}

function _log($modelName, Model $model, $causer, $logDescription = '', $attributes = [])
{
    activity($modelName)
        ->performedOn($model)
        ->causedBy($causer)
        ->withProperties($attributes)
        ->log($logDescription);
}

function __date_format($date, $format = 'd/m/Y')
{
    $value = str_replace('/', '-', $date);

    return Carbon::parse($value)->format($format);
}
