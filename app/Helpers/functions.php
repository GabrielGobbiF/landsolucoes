<?php

use Carbon\Carbon;
use Carbon\CarbonInterface;
use Illuminate\Support\Str;

function formatDateAndTime($value, $format = 'd/m/Y')
{
    // Utiliza a classe de Carbon para converter ao formato de data ou hora desejado
    return Carbon::parse($value)->format($format);
}

function maskPrice($number = 0)
{
    return number_format($number, 2, '.', ',');
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
    if ($date != '') {

        $date = ltrim($date);

        $date = str_replace("/", "-", $date);

        $date = new DateTime($date);

        $format = $gDate == '-' ? '-' : '/';

        switch ($type) {
            case 'pt':
                return $date->format('d' . $format . 'm' . $format . 'Y');
                break;
            case 'en':
                return $date->format('Y' . $format . 'm' . $format . 'd');
                break;
            default:
                return $date->format('d' . $format . 'm' . $format . 'Y');
                break;
        }
    }
}

function dataLimpa($date)
{
    return Carbon::parse($date)->format('d/m/Y');
}

function somarData($soma, $type = 'days', $date, $formatReturn = 'Y-m-d H:i:s')
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

    if (empty($number)) {
        return 0;
    }

    $number = str_replace(['R$', '&nbsp', chr(194) . chr(160)], '', $number);

    $number = trim($number, "\xC2\xA0");

    $number = number_format(str_replace(",", ".", str_replace(".", "", $number)), 2, '.', '');

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
function __trans(string $key, ?string $fallback = null, ?string $locale = null, ?array $replace = [])
{
    if (\Illuminate\Support\Facades\Lang::has($key, $locale)) {
        return trans($key, $replace, $locale);
    }

    return $fallback;
}
