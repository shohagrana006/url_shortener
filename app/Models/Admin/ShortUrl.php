<?php

namespace App\Models\Admin;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ShortUrl extends Model
{
    protected $guarded = ['id'];


    // generate shortcode base62 with id for uniqueness
    public static function generateShortCode()
    {
        $latestId = ShortUrl::max('id') + 1;
        $base62 = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        $shortCode = '';
        while ($latestId > 0) {
            $shortCode = $base62[$latestId % 62] . $shortCode;
            $latestId = intdiv($latestId, 62);
        }

        // Ensure it's always 6 characters by adding random Base62 characters
        while (strlen($shortCode) < 6) {
            $shortCode .= $base62[random_int(0, 61)];
        }

        // Shuffle for randomness
        $shortCode = str_shuffle($shortCode);

       return $shortCode;

    }

    public function isExpired()
    {
        return $this->expires_at && Carbon::now()->greaterThan($this->expires_at);
    }

    public function renewExpiration()
    {
        $this->expires_at = Carbon::now()->addDays(30);
        $this->save();
    }
        
}
