<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Support\Facades\Crypt;

class BCryptCaster implements CastsAttributes
{
    /**
     * @param $model
     * @param string $key
     * @param $value
     * @param array $attributes
     * @return mixed|string
     */
    public function get($model, string $key, $value, array $attributes)
    {
        try {
            return Crypt::decryptString($value);
        } catch (\Exception) {
            return null;
        }
    }

    /**
     * @param $model
     * @param string $key
     * @param $value
     * @param array $attributes
     * @return mixed|string
     */
    public function set($model, string $key, $value, array $attributes)
    {
        if (empty($value) && $value !== 0) {
            return null;
        }
        return Crypt::encryptString($value);
    }
}
