<?php

function formatDateAndTime($value, $format = 'd/m/Y')
{
    // Utiliza a classe de Carbon para converter ao formato de data ou hora desejado
    return Carbon\Carbon::parse($value)->format($format);
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
