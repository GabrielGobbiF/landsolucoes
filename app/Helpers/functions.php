<?php

use App\Models\Encarregado;
use App\Models\Epi;
use App\Models\Equipe;
use App\Models\Supervisor;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Money\Money;
use Illuminate\Support\Number;

if (!function_exists('only_numbers')) {
    /**
     * Extrai apenas os números de uma string.
     *
     * @param string $string
     * @return string
     */
    function only_numbers($string)
    {
        return preg_replace('/\D/', '', $string);
    }
}

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
    $soma = intVal($soma);

    $date = str_replace('/', '-', $date);

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
            return trans($keyM, $replace, $locale)[0] ?? $key;
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

function _mix($path)
{
    return config('app.env') == 'production' ? url(asset(mix($path))) : asset($path);
}

function users()
{
    return User::all();
}

function formatNameRDSE($input)
{
    // Remover todos os caracteres não alfanuméricos do input
    $cleaned = preg_replace('/[^a-zA-Z0-9]/', '', $input);

    // Usar expressões regulares para formatar a string conforme o padrão desejado
    $formatted = preg_replace('/^([A-Z]{3})([A-Z])([A-Z]{3})(\d{2})(\d+)$/', '$1/$2.$3.$4.$5', $cleaned);

    return $formatted;
}

function monthDate($date)
{
    if (empty($date)) return null;

    $date = empty($date) ? Carbon::now() :  Carbon::parse($date);

    return $date->translatedFormat('F/Y');
}

function year()
{
    return Carbon::now()->format('Y');
}

function monthByFormat($month)
{
    if ($month < 1 || $month > 12) {
        return 'Mês inválido';
    }

    $data = Carbon::createFromFormat('m', $month);
    return ucfirst($data->translatedFormat('F'));
}

function equipes()
{
    return Equipe::all();
}

function supervisores()
{
    return Supervisor::all();
}

function encarregados()
{
    return Encarregado::all();
}

function uuid()
{
    return Str::uuid();
}

function __singular($text)
{
    return Str::singular($text);
}

/**
 * Calcula as datas de início e fim com base no período.
 *
 * @param string $period
 * @param string|null $startDate
 * @param string|null $endDate
 * @return array
 * @throws \Exception
 */
function calculateDates(string $period, ?string $startDate = null, ?string $endDate = null): array
{
    $today = Carbon::today();
    $start_at = null;
    $end_at = null;

    switch ($period) {
        case 'today':
            $start_at = $end_at = $today;
            break;

        case 'tomorrow':
            $start_at = $end_at = $today->copy()->addDay();
            break;

        case 'yesterday':
            $start_at = $end_at = $today->copy()->subDay();
            break;

        case 'last_3_days':
            $start_at = $today->copy()->subDays(3);
            $end_at = $today;
            break;

        case 'last_7_days':
            $start_at = $today->copy()->subDays(7);
            $end_at = $today;
            break;

        case 'last_15_days':
            $start_at = $today->copy()->subDays(15);
            $end_at = $today;
            break;

        case 'last_30_days':
            $start_at = $today->copy()->subDays(30);
            $end_at = $today;
            break;

        case 'next_3_days':
            $start_at = $today;
            $end_at = $today->copy()->addDays(3);
            break;

        case 'next_5_days':
            $start_at = $today;
            $end_at = $today->copy()->addDays(5);
            break;

        case 'next_15_days':
            $start_at = $today;
            $end_at = $today->copy()->addDays(15);
            break;

        case 'next_30_days':
            $start_at = $today;
            $end_at = $today->copy()->addDays(30);
            break;

        case 'specific':
            if (!$startDate || !$endDate) {
                throw new \Exception("Para 'Período específico', as datas de início e fim são obrigatórias.");
            }

            $start_at = Carbon::parse($startDate);
            $end_at = Carbon::parse($endDate);

            if ($start_at->greaterThan($end_at)) {
                throw new \Exception("A data inicial não pode ser maior que a data final.");
            }
            break;

        default:
            throw new \Exception("Período inválido.");
    }

    return [
        'start_at' => $start_at->toDateString(),
        'end_at' => $end_at->toDateString(),
    ];
}

function clearNumberToSendWhats($number)
{
    return '55' . clear($number);
}

function currency($value, $in = "BRL", $locale = 'pt-BR')
{
    return Number::currency(($value), $in, $locale);
}
