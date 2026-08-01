<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $fillable = [
        'key',
        'value',
        'type',
    ];

    public static function getValue(string $key, mixed $default = null): mixed
    {
        $setting = static::query()
            ->where('key', $key)
            ->first();

        if (! $setting) {
            return $default;
        }

        return match ($setting->type) {
            'boolean' => filter_var($setting->value, FILTER_VALIDATE_BOOL),
            'integer' => (int) $setting->value,
            default => $setting->value,
        };
    }

    public static function setValue(
        string $key,
        mixed $value,
        string $type = 'text',
    ): void {
        static::query()->updateOrCreate(
            ['key' => $key],
            [
                'value' => $type === 'boolean'
                    ? ($value ? '1' : '0')
                    : (string) ($value ?? ''),
                'type' => $type,
            ],
        );
    }
}
