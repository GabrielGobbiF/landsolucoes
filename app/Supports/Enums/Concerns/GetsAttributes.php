<?php

namespace App\Supports\Enums\Concerns;

use Illuminate\Support\Str;
use ReflectionClassConstant;
use App\Supports\Enums\Attributes\Description;
use Illuminate\Support\Collection;

trait GetsAttributes
{
    /**
     * @param self $enum
     */
    private static function getDescription(self $enum): string
    {
        $ref = new ReflectionClassConstant(self::class, $enum->name);

        $classAttributes = $ref->getAttributes(Description::class);

        if (count($classAttributes) === 0) {
            return Str::headline($enum->value);
        }

        return $classAttributes[0]->newInstance()->description;
    }

    /**
     * @return array<string,string>
     */
    public static function asSelectArray(): Collection
    {
        /** @var array<string,string> $values */
        $values = collect(self::cases())
            ->map(function ($enum) {
                return [
                    'name' => self::getDescription($enum),
                    'value' => $enum->value,
                    'translate' => ucfirst(__trans($enum->value)),
                ];
            });

        return collect($values);
    }

    /**
     * @return Collection
     */
    public static function options(): Collection
    {
        $cases   = static::cases();
        $options = [];
        foreach ($cases as $case) {
            $label = $case->name;
            if (Str::contains($label, '_')) {
                $label = Str::replace('_', ' ', $label);
            }
            $options[] = [
                #'case' => $case->name,
                'value' => $case->value,
                'label' => Str::title($label),
                'label_translate' => ucfirst(__trans(__minusculo($label)))
            ];
        }

        return collect($options);
    }
}
