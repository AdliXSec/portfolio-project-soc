<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $fillable = ['key', 'value', 'type', 'group'];

    public static function get(string $key, $default = null)
    {
        $setting = Cache::remember("setting_{$key}", 3600, function () use ($key) {
            return self::where('key', $key)->first();
        });

        if (!$setting) {
            return $default;
        }

        return self::castValue($setting->value, $setting->type);
    }

    public static function set(string $key, $value): bool
    {
        $processedValue = is_bool($value) ? ($value ? '1' : '0') : (string) $value;

        // Gunakan updateOrCreate: cari berdasarkan 'key', lalu update 'value' atau buat baris baru.
        $setting = self::updateOrCreate(
            ['key' => $key],
            ['value' => $processedValue]
        );

        // Jika baris baru dibuat, isi nilai default untuk 'group' dan 'type' agar konsisten.
        if ($setting->wasRecentlyCreated) {
            $setting->group = 'security'; // Asumsi semua pengaturan baru dari SOC adalah grup 'security'
            $setting->type = 'boolean';   // Asumsi semua toggle adalah 'boolean'
            $setting->save();
        }

        // Hapus cache individual dan cache grup agar data baru segera terbaca.
        Cache::forget("setting_{$key}");
        Cache::forget("soc_settings"); 

        return true;
    }

    public static function getByGroup(string $group)
    {
        return self::where('group', $group)->get()->mapWithKeys(function ($setting) {
            return [$setting->key => self::castValue($setting->value, $setting->type)];
        });
    }

    protected static function castValue($value, $type)
    {
        return match ($type) {
            'boolean' => (bool) $value,
            'integer' => (int) $value,
            'json' => json_decode($value, true),
            default => $value,
        };
    }
}
