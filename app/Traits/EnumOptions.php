<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait EnumOptions
{
    /**
     * @return array<string|int, string|int>
     */
    public static function toOptions(): array
    {
        if (! \is_a(static::class, \UnitEnum::class, allow_string: true)) {
            // TODO: Proper message to notify incorrect usage of this trait.
            throw new \Exception;
        }

        $cases = \collect(static::cases());

        return \is_a(static::class, \BackedEnum::class, allow_string: true)
            ? $cases->mapWithKeys(fn (\BackedEnum $case): array => [$case->value => $case->label()])->all()
            : $cases->mapWithKeys(fn (\UnitEnum $case): array => [$case->value => $case->label()])->all();
    }

    public function label(): string
    {
        $enumName = Str::snake(class_basename(static::class));

        return __("enums.{$enumName}.{$this->value}");
    }
}
