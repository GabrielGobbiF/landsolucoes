<?php

namespace App\Supports\Enums\Rdse;

use App\Supports\Enums\Concerns\GetsAttributes;

enum RdseClosingStatus: string
{
    use GetsAttributes;

    case INEXECUTION = 'in_execution';

    case PENDING = 'pending';

    case INCLOSING = 'in_closing';

    case CLOSED = 'closed';

    case BILLING_RELEASED = 'billing_released';

    case CEMBILLED = 'cembilled';

    public function getIcon(): string
    {
        return match ($this) {
            self::INEXECUTION => '',
            self::PENDING => '',
            self::INCLOSING => '',
            self::CLOSED => '',
            self::BILLING_RELEASED => '',
            self::CEMBILLED => '',
        };
    }

    public function getLabelText(): string
    {
        return match ($this) {
            self::INEXECUTION => 'Em Execução',
            self::PENDING => 'Pendente',
            self::INCLOSING => 'Em Encerramento',
            self::CLOSED => 'Encerrado',
            self::BILLING_RELEASED => 'Liberado Faturamento',
            self::CEMBILLED => '100% Faturado',
        };
    }

    public static function labelText($value): string
    {
        return match ($value) {
            self::INEXECUTION => 'Em Execução',
            self::PENDING => 'Pendente',
            self::INCLOSING => 'Em Encerramento',
            self::CLOSED => 'Encerrado',
            self::BILLING_RELEASED => 'Liberado Faturamento',
            self::CEMBILLED => '100% Faturado',
        };
    }

    public function getLabelColor(): string
    {
        return match ($this) {
            self::INEXECUTION => 'info',
            self::PENDING => 'info',
            self::INCLOSING => 'info',
            self::CLOSED => 'dark',
            self::BILLING_RELEASED => 'success',
            self::CEMBILLED => 'danger',
        };
    }

    public function getLabelHTML()
    {
        return sprintf('<div class="badge badge-soft-%s font-size-12">%s</div>',
            $this->getLabelColor(),
            __trans($this->getLabelText())
        );
    }
}
