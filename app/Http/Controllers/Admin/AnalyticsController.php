<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Analytics;
use App\Models\Admin\ShortUrl;

class AnalyticsController extends Controller
{

    public function analytics()
    {
        $analyticsDatas = ShortUrl::where('user_id', auth()->id())
            ->select('id', 'long_url', 'short_code', 'clicks')->latest()->paginate(10);
        return view('admin.pages.analytics.index', compact('analyticsDatas'));
    }


    public function details($id)
    {
        $details = Analytics::where('short_url_id', $id)
            ->select('id', 'user_ip', 'location', 'clicked_at')->orderBy('clicked_at','desc')->paginate(10);
        return view('admin.pages.analytics.details', compact('details'));
    }



  

}
