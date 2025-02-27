<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Analytics;
use App\Models\Admin\ShortUrl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Stevebauman\Location\Facades\Location;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ShortUrlController extends Controller
{
    public function store(Request $request)
    {
        // Validate URL format
        $request->validate([
            'long_url' => 'required|url'
        ]);

        $longUrl = trim($request->long_url);
        $user = Auth::user();
        
        // Create User-Specific Cache Key
        $cacheKey = 'short_url_' . $user->id . '_' . md5($longUrl);
        if (Cache::has($cacheKey)) {
            return redirect()->back()->with('short_url', url(Cache::get($cacheKey)));
        }

        // Return existing database URL
        if ($existing = ShortUrl::where('user_id', $user->id)->where('long_url', $longUrl)->first()) {
            if ($existing->isExpired()) {
                $existing->renewExpiration();
            }
            Cache::put($cacheKey, $existing->short_code, now()->addDays(7));
            return redirect()->back()->with('short_url', url($existing->short_code));
        }

        // Check if the user has reached the daily limit
        $dailyShortenedCount = ShortUrl::where('user_id', $user->id)
            ->whereDate('created_at', now()->toDateString())->count();
        if ($dailyShortenedCount >= 5) {
            return back()->with('message', 'You can only create up to 5 short URLs per day.');
        }

        // Check if URL starts with 'http' or 'https'
        if (!Str::startsWith($longUrl, ['http://', 'https://'])) {
            return back()->with('message', 'Invalid URL: Must start with http or https.');
        }
   
        // Prevent IP-based URLs (Only allow domain-based URLs)
        if (filter_var(parse_url($longUrl, PHP_URL_HOST), FILTER_VALIDATE_IP)) {
            return back()->with('message', 'Invalid URL: IP-based URLs are not allowed.');
        }

        // Prevent suspicious redirects 
        if (Str::contains($longUrl, ['?redirect=', '&redirect='])) {
            return back()->with('message', 'Invalid URL: Redirect parameters are not allowed.');
        }

        // Check if the URL is reachable or not
        try {
            $response = Http::get($longUrl);
            if ($response->failed()) {
                return back()->with('message', 'The provided URL is not reachable.');
            }
        } catch (\Exception $e) {
            return back()->with('message', 'The provided URL is invalid or unreachable.');
        }

        // Generate Unique Short Code & Store in Transaction
        $shortUrl = DB::transaction(function () use ($longUrl, $user, $cacheKey) {
            // Ensure the short code is unique inside the transaction
            do {
                $shortCode = ShortUrl::generateShortCode();
            } while (ShortUrl::where('short_code', $shortCode)->exists());

            // create a new short url
            $shortUrl = ShortUrl::create([
                'user_id' => $user->id,
                'long_url' => $longUrl,
                'short_code' => $shortCode,
                'expires_at' => now()->addDays(30)
            ]);

            Cache::put($cacheKey, $shortUrl->short_code, now()->addDays(7));
            return $shortUrl;
        });

        return redirect()->back()->with('short_url', url($shortUrl->short_code));
    }


    public function redirect($code)
    {
        // locking query for update to avoid concurrency problem
        $shortUrl = ShortUrl::where('short_code', $code)->lockForUpdate()->firstOrFail();

        // Check if URL has expired
        if ($shortUrl->isExpired()) {
            return 'This short URL has expired.';
        }

        // Use a transaction to ensure safe click count update
        DB::transaction(function () use ($shortUrl) {
            $shortUrl->increment('clicks');
        });

  
        // Get user IP and location
        $ip = request()->ip();
        if ($ip == '127.0.0.1') {
            $ip = json_decode(Http::get('https://api64.ipify.org?format=json')->body(), true)['ip'];
        }

        $location = Location::get($ip);
        try {
           // Store analytics data
            Analytics::create([
                'short_url_id' => $shortUrl->id,
                'user_ip' => $ip,
                'location' => $location ? $location->countryName : 'Unknown',
                'clicked_at' => now(),
            ]);
        } catch (\Exception $e) {
            Log::error("Analytics tracking failed: " . $e->getMessage());
        }

        // Redirect user to original URL & use away() for Open Redirect Vulnerability prevent
        return redirect()->away($shortUrl->long_url);
    }
   
}
