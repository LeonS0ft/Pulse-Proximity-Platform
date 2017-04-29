<?php namespace Platform\Controllers\App;

use \Platform\Controllers\Core;
use Illuminate\Support\Facades\Gate;
use \Platform\Models\Analytics as ModelAnalytics;
use \Platform\Models\Location;
use \Platform\Models\Campaigns;

class DashboardController extends \App\Http\Controllers\Controller {

  /*
   |--------------------------------------------------------------------------
   | Dashboard Controller
   |--------------------------------------------------------------------------
   |
   | Dashboard related logic
   |--------------------------------------------------------------------------
   */

  /**
   * Dashboard
   */

  public function showDashboard() {
    // Default values
    $card_views_difference = 0;
    $card_views_today = 0;
    $card_views_yesterday = 0;
    $interaction_difference = 0;
    $interactions_today = 0;
    $interactions_yesterday = 0;
    $android_difference = 0;
    $android_today = 0;
    $android_yesterday = 0;
    $ios_difference = 0;
    $ios_today = 0;
    $ios_yesterday = 0;
    $app_count = 0;
    $app_count_limit = 0;
    $app_count_perc = 0;
    $campaign_count = 0;
    $campaign_count_limit = 0;
    $campaign_count_perc = 0;
    $beacon_count = 0;
    $beacon_count_limit = 0;
    $beacon_count_perc = 0;
    $geofence_count = 0;
    $geofence_count_limit = 0;
    $geofence_count_perc = 0;
    $campaign_count = 0;
    $campaign_count_limit = 0;
    $campaign_count_perc = 0;

    // Only execute queries when user has access to mobile features
    if (Gate::allows('limitation', 'mobile.visible')) {
      // Card views compared to yesterday
      $card_views_today = ModelAnalytics\CardStat::where('user_id', Core\Secure::userId())
        ->where(\DB::raw('DATE(created_at)'), date('Y-m-d'))
        ->distinct('')
        ->count();

      $card_views_yesterday = ModelAnalytics\CardStat::where('user_id', Core\Secure::userId())
        ->where(\DB::raw('DATE(created_at)'), date('Y-m-d', strtotime('-1 days')))
        ->count();

      $card_views_difference = ($card_views_today > 0) ? round((1 - $card_views_yesterday / $card_views_today) * 100, 0) : 0;
      if ($card_views_today == 0 && $card_views_yesterday > 0) $card_views_difference = -100;

      // Interactions compared to yesterday
      $interactions_today = Location\Interaction::where('user_id', Core\Secure::userId())
        ->where(\DB::raw('DATE(created_at)'), date('Y-m-d'))
        ->count();

      $interactions_yesterday = Location\Interaction::where('user_id', Core\Secure::userId())
        ->where(\DB::raw('DATE(created_at)'), date('Y-m-d', strtotime('-1 days')))
        ->count();

      $interaction_difference = ($interactions_today > 0) ? round((1 - $interactions_yesterday / $interactions_today) * 100, 0) : 0;
      if ($interactions_today == 0 && $interactions_yesterday > 0) $interaction_difference = -100;

      // Android users compared to yesterday
      $android_platform_interactions_today = Location\Interaction::where('user_id', Core\Secure::userId())
        ->where(\DB::raw('DATE(created_at)'), date('Y-m-d'))
        ->where('platform', 'Android')
        ->count();

      $android_card_views_today = ModelAnalytics\CardStat::where('user_id', Core\Secure::userId())
        ->where(\DB::raw('DATE(created_at)'), date('Y-m-d'))
        ->where('platform', 'Android')
        ->count();

      $android_platform_interactions_yesterday = Location\Interaction::where('user_id', Core\Secure::userId())
        ->where(\DB::raw('DATE(created_at)'), date('Y-m-d', strtotime('-1 days')))
        ->where('platform', 'Android')
        ->count();

      $android_card_views_yesterday = ModelAnalytics\CardStat::where('user_id', Core\Secure::userId())
        ->where(\DB::raw('DATE(created_at)'), date('Y-m-d', strtotime('-1 days')))
        ->where('platform', 'Android')
        ->count();

      $android_today = $android_platform_interactions_today + $android_card_views_today;
      $android_yesterday = $android_platform_interactions_yesterday + $android_card_views_yesterday;
      $android_difference = ($android_today > 0) ? round((1 - $android_yesterday / $android_today) * 100, 0) : 0;
      if ($android_today == 0 && $android_yesterday > 0) $android_difference = -100;

      // iOS users compared to yesterday
      $ios_platform_interactions_today = Location\Interaction::where('user_id', Core\Secure::userId())
        ->where(\DB::raw('DATE(created_at)'), date('Y-m-d'))
        ->where('platform', 'iOS')
        ->count();

      $ios_card_views_today = ModelAnalytics\CardStat::where('user_id', Core\Secure::userId())
        ->where(\DB::raw('DATE(created_at)'), date('Y-m-d'))
        ->where('platform', 'iOS')
        ->count();

      $ios_platform_interactions_yesterday = Location\Interaction::where('user_id', Core\Secure::userId())
        ->where(\DB::raw('DATE(created_at)'), date('Y-m-d', strtotime('-1 days')))
        ->where('platform', 'iOS')
        ->count();

      $ios_card_views_yesterday = ModelAnalytics\CardStat::where('user_id', Core\Secure::userId())
        ->where(\DB::raw('DATE(created_at)'), date('Y-m-d', strtotime('-1 days')))
        ->where('platform', 'iOS')
        ->count();

      $ios_today = $ios_platform_interactions_today + $ios_card_views_today;
      $ios_yesterday = $ios_platform_interactions_yesterday + $ios_card_views_yesterday;
      $ios_difference = ($ios_today > 0) ? round((1 - $ios_yesterday / $ios_today) * 100, 0) : 0;
      if ($ios_today == 0 && $ios_yesterday > 0) $ios_difference = -100;

      $app_count = Campaigns\App::where('user_id', '=', Core\Secure::userId())->count();
      $app_count_limit = \Auth::user()->plan->limitations['mobile']['apps'];
      $app_count_perc = ($app_count_limit == 0) ? 0 : round(($app_count / $app_count_limit) * 100);

      $campaign_count = Campaigns\Campaign::where('user_id', '=', Core\Secure::userId())->count();
      $campaign_count_limit = \Auth::user()->plan->limitations['mobile']['campaigns'];
      $campaign_count_perc = ($campaign_count_limit == 0) ? 0 : round(($campaign_count / $campaign_count_limit) * 100);

      if (Gate::allows('limitation', 'mobile.beacons_visible')) {
        $beacon_count = Location\Beacon::where('user_id', '=', Core\Secure::userId())->count();
        $beacon_count_limit = \Auth::user()->plan->limitations['mobile']['beacons'];
        $beacon_count_perc = ($beacon_count_limit == 0) ? 0 : round(($beacon_count / $beacon_count_limit) * 100);
      }

      if (Gate::allows('limitation', 'mobile.geofences_visible')) {
        $geofence_count = Location\Geofence::where('user_id', '=', Core\Secure::userId())->count();
        $geofence_count_limit = \Auth::user()->plan->limitations['mobile']['beacons'];
        $geofence_count_perc = ($geofence_count_limit == 0) ? 0 : round(($geofence_count / $geofence_count_limit) * 100);
      }
    }

    return view('platform.dashboard.dashboard', compact(
      'card_views_difference', 
      'card_views_today', 
      'card_views_yesterday', 
      'interaction_difference', 
      'interactions_today', 
      'interactions_yesterday', 
      'android_difference', 
      'android_today', 
      'android_yesterday', 
      'ios_difference', 
      'ios_today', 
      'ios_yesterday', 
      'app_count', 
      'app_count_limit', 
      'app_count_perc', 
      'campaign_count', 
      'campaign_count_limit', 
      'campaign_count_perc', 
      'beacon_count', 
      'beacon_count_limit', 
      'beacon_count_perc', 
      'geofence_count', 
      'geofence_count_limit', 
      'geofence_count_perc'
    ));
  }
}