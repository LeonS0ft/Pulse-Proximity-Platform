<?php namespace Platform\Controllers\Analytics;

use \Platform\Controllers\Core;
use \Platform\Controllers\Analytics;
use \Platform\Models\Analytics as ModelAnalytics;
use \Platform\Models\Location;
use \Platform\Models\Campaigns;
use Illuminate\Http\Request;

class CampaignAnalyticsController extends \App\Http\Controllers\Controller {

  /*
   |--------------------------------------------------------------------------
   | Campaign Analytics Controller
   |--------------------------------------------------------------------------
   |
   | Campaign Analytics related logic
   |--------------------------------------------------------------------------
   */

  /**
   * Campaign Analytics
   */
  public function showAnalytics()
  {
    // Security link
    $sl = request()->get('sl', '');
    $sql_campaign = '1=1';
    $campaign_id = '';

    if ($sl != '') {
      $qs = Core\Secure::string2array($sl);
      $campaign_id = $qs['campaign_id'];
      $sql_campaign = 'campaign_id = ' . $campaign_id;
      $sl = rawurlencode($sl);
    }

    // Range
    $date_start = request()->get('start', date('Y-m-d', strtotime(' - 30 day')));
    $date_end = request()->get('end', date('Y-m-d'));

    $from =  $date_start . ' 00:00:00';
    $to = $date_end . ' 23:59:59';

    /*
     |--------------------------------------------------------------------------
     | Campaigns
     |--------------------------------------------------------------------------
     */
    $campaigns = Campaigns\Campaign::where('user_id', Core\Secure::userId())
      ->where('active', 1)
      ->orderBy('created_at', 'asc')
      ->get();

    /*
     |--------------------------------------------------------------------------
     | First date
     |--------------------------------------------------------------------------
     */
    $stats_found = false;
    $first_date = date('Y-m-d');

    $interaction_stats = Location\Interaction::where('user_id', Core\Secure::userId())
      ->select(\DB::raw('DATE(created_at) as date'))
      ->whereRaw($sql_campaign)
      ->orderBy('date', 'asc')
      ->first();

    if (! empty($interaction_stats)) {
      $stats_found = true;
      $first_date = $interaction_stats->date;
    }

    /*
     |--------------------------------------------------------------------------
     | Parse views and interactions
     |--------------------------------------------------------------------------
     */

    // Card views
    // Raw query because of this issue: https://github.com/laravel/framework/issues/18523
    $stats_card_views = \DB::select("select DATE(created_at) as date, count(id) as views 
      from `card_stats` 
      where `user_id` = :user_id 
      and exists (select * from `campaigns` inner join `campaign_card` on `campaigns`.`id` = `campaign_card`.`campaign_id` where `campaign_card`.`campaign_id` in (:campaign_id)) 
      and `created_at` >= :from and `created_at` <= :to 
      group by DATE(created_at)", 
    [
      'user_id' => Core\Secure::userId(),
      'campaign_id' => $campaign_id,
      'from' => $from,
      'to' => $to
    ]);

    /*
    $stats_card_views = ModelAnalytics\CardStat::where('user_id', Core\Secure::userId())
      ->whereHas('campaigns', function($query) use ($campaign_id) { 
        $query->whereIn('campaign_card.campaign_id', [$campaign_id]);     
      })
      ->select(\DB::raw('DATE(created_at) as date'), \DB::raw('count(id) as views'))
      ->where('created_at', '>=', $from)
      ->where('created_at', '<=', $to)
      ->groupBy([\DB::raw('DATE(created_at)')])
      ->get()
      ->toArray();
    */

    //dd(\DB::getQueryLog()); 
    // Interactions
    $stats_interactions = Location\Interaction::where('user_id', Core\Secure::userId())
      ->select(\DB::raw('DATE(created_at) as date'), \DB::raw('count(id) as interactions'))
      ->where('campaign_id', $campaign_id)
      ->where('created_at', '>=', $from)
      ->where('created_at', '<=', $to)
      ->groupBy([\DB::raw('DATE(created_at)')])
      ->get()
      ->toArray();

    // Create range
    $interaction_range = Analytics\AnalyticsController::getRange($date_start, $date_end);

    // Merge stats with range
    foreach($interaction_range as $date => $arr) {

      // Views
      $views = ($date < $first_date) ? NULL : 0;
      foreach($stats_card_views as $row) {
        if ($date == $row->date) {
          $views = $row->views;
          break 1;
        }
      }

      $arr = array_merge(['views' => $views], $arr);

      // Interactions
      $interactions = 0;
      $interactions = ($date < $first_date) ? NULL : 0;
      foreach($stats_interactions as $row) {
        if ($date == $row['date']) {
          $interactions = $row['interactions'];
          break 1;
        }
      }

      $arr = array_merge(['interactions' => $interactions], $arr);
      $interaction_range[$date] = $arr;
    }

    return view('platform.analytics.campaign-analytics', compact('sl', 'first_date', 'stats_found', 'date_start', 'date_end', 'campaigns', 'campaign_id', 'interaction_range'));
  }
}