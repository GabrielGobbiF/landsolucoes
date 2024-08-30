<?php

namespace App\Supports\Enums\Frota;

use App\Supports\Enums\Concerns\GetsAttributes;

enum VisitorsStatus: string
{
    use GetsAttributes;

    case CREATED = 'created';

    case RELEASED = 'released';

    case CLOSED = 'closed';

    public function getLabelText(): string
    {
        return match ($this) {
            self::CREATED => 'Created',
            self::RELEASED => 'Released',
            self::CLOSED => 'Closed',
        };
    }

    public static function labelText($value): string
    {
        return match ($value) {
            self::CREATED => 'Created',
            self::RELEASED => 'Released',
            self::CLOSED => 'Closed',
        };
    }

    public function getLabelColor(): string
    {
        return match ($this) {
            self::CREATED => 'dark',
            self::RELEASED => 'info',
            self::CLOSED => 'danger',
        };
    }

    public function getLabelHTML()
    {
        return sprintf(
            '<span class="badge rounded-pill bg-%s">%s</span>',
            $this->getLabelColor(),
            __trans($this->getLabelText())
        );
    }
}
