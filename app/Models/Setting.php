<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = ['group', 'key', 'value', 'is_locked'];

    /**
     * Retrieve a setting value by group and key.
     * Usage: Setting::getValue('site', 'app_name');
     */
    public static function getValue($group, $key, $default = null)
    {
        $setting = self::where('group', $group)->where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }
}