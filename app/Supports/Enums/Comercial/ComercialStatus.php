<?php

namespace App\Supports\Enums\Comercial;

use App\Supports\Enums\Concerns\GetsAttributes;

enum ComercialStatus: string
{
    use GetsAttributes;

    case ELABORACAO = 'elaboração';

    case ENVIADA = 'enviada';

    case APROVADA = 'aprovada';

    case RECUSADA = 'recusada';

    case CONCLUIDA = 'concluida';


    public function getIcon(): string
    {
        return match ($this) {
            self::ELABORACAO => '',
            self::ENVIADA => '',
            self::APROVADA => '',
            self::RECUSADA => '',
            self::CONCLUIDA => '',
        };
    }

    public function getLabelText(): string
    {
        return match ($this) {
            self::ELABORACAO => 'Elaboração',
            self::ENVIADA => 'Enviada',
            self::APROVADA => 'Aprovada',
            self::RECUSADA => 'Recusada',
            self::CONCLUIDA => 'Concluida',
        };
    }

    public function getLabelColor(): string
    {
        return match ($this) {
            self::ELABORACAO => 'info',
            self::ENVIADA => 'light',
            self::APROVADA => 'success',
            self::RECUSADA => 'danger',
            self::CONCLUIDA => 'success',
        };
    }

    public function getLabelHTML()
    {
        return sprintf(
            '
            <span class="badge rounded-pill bg-%s">
            <i class="%s"></i>
            %s</span>',
            $this->getLabelColor(),
            $this->getIcon(),
            __trans($this->getLabelText())
        );
    }
}
