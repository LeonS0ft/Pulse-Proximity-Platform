<div class="container">
  <div class="row m-t">
    <div class="col-sm-12">
      <nav class="navbar navbar-default card-box sub-navbar">
        <div class="container-fluid">
          <div class="navbar-header">
            <a class="navbar-brand no-link" href="javascript:void(0);">{{ trans('global.welcome_name', ['name' => \Auth::user()->name]) }}</a>
          </div>
        </div>
      </nav>
    </div>
    <?php if (\Auth::user()->getPlanId() == 0 && Gate::allows('limitation', 'account.plan_visible')) { ?>
    <div class="col-md-12">
      <div class="alert alert-success">{!! trans('global.you_are_on_plan', ['plan' => '<strong>' . \Auth::user()->getPlanName() . '</strong>']) !!} {!! trans('global.click_here_for_more_info', ['link' => '#/plan']) !!}</div>
    </div>
    <?php } ?>
  </div>
  <?php if (Gate::allows('limitation', 'mobile.visible')) { ?>

  <div class="row">
    <div class="col-sm-6 col-lg-3">
      <div class="card-box widget-icon">
        <a href="#/campaign/analytics">
          <i class="material-icons text-muted" style="font-size: 60px;">&#xE8A0;</i>
          <div class="wid-icon-info">
            <p class="text-muted m-b-5 font-13 text-uppercase">{{ trans('global.cards_viewed') }}</p>
            <h4 class="m-t-0 m-b-5 counter">{{ $card_views_today }}</h4>
            <?php if ($card_views_difference == 0) { ?>
            <small class="text-default"><b>{{ abs($card_views_difference) }}%</b> ({{ $card_views_today - $card_views_yesterday }})</small>
            <?php } elseif ($card_views_difference > 0) { ?>
            <small class="text-success"><i class="material-icons" style="font-size: 14px; position: relative; top: 3px">&#xE5D8;</i> <b>{{ abs($card_views_difference) }}%</b> ({{ $card_views_today - $card_views_yesterday }})</small>
            <?php } else { ?>
            <small class="text-danger"><i class="material-icons" style="font-size: 14px; position: relative; top: 3px">&#xE5DB;</i> <b>{{ abs($card_views_difference) }}%</b> ({{ $card_views_today - $card_views_yesterday }})</small>
            <?php } ?>
          </div>
        </a>
      </div>
    </div>

    <div class="col-sm-6 col-lg-3">
      <div class="card-box widget-icon">
        <a href="#/campaign/analytics">
          <i class="material-icons text-muted" style="font-size: 60px;">&#xE569;</i>
          <div class="wid-icon-info">
            <p class="text-muted m-b-5 font-13 text-uppercase">{{ trans('global.scenarios_triggered') }}</p>
            <h4 class="m-t-0 m-b-5 counter">{{ $interactions_today }}</h4>
            <?php if ($interaction_difference == 0) { ?>
            <small class="text-default"><b>{{ abs($interaction_difference) }}%</b> ({{ $interactions_today - $interactions_yesterday }})</small>
            <?php } elseif ($interaction_difference > 0) { ?>
            <small class="text-success"><i class="material-icons" style="font-size: 14px; position: relative; top: 3px">&#xE5D8;</i> <b>{{ abs($interaction_difference) }}%</b> ({{ $interactions_today - $interactions_yesterday }})</small>
            <?php } else { ?>
            <small class="text-danger"><i class="material-icons" style="font-size: 14px; position: relative; top: 3px">&#xE5DB;</i> <b>{{ abs($interaction_difference) }}%</b> ({{ $interactions_today - $interactions_yesterday }})</small>
            <?php } ?>
          </div>
        </a>
      </div>
    </div>

    <div class="col-sm-6 col-lg-3">
      <div class="card-box widget-icon">
        <a href="#/campaign/analytics">
          <i class="fa fa-android text-muted" aria-hidden="true" style="font-size: 60px;"></i>
          <div class="wid-icon-info">
            <p class="text-muted m-b-5 font-13 text-uppercase">Android</p>
            <h4 class="m-t-0 m-b-5 counter">{{ $android_today }}</h4>
            <?php if ($android_difference == 0) { ?>
            <small class="text-default"><b>{{ abs($android_difference) }}%</b> ({{ $android_today - $android_yesterday }})</small>
            <?php } elseif ($android_difference > 0) { ?>
            <small class="text-success"><i class="material-icons" style="font-size: 14px; position: relative; top: 3px">&#xE5D8;</i> <b>{{ abs($android_difference) }}%</b> ({{ $android_today - $android_yesterday }})</small>
            <?php } else { ?>
            <small class="text-danger"><i class="material-icons" style="font-size: 14px; position: relative; top: 3px">&#xE5DB;</i> <b>{{ abs($android_difference) }}%</b> ({{ $android_today - $android_yesterday }})</small>
            <?php } ?>
          </div>
        </a>
      </div>
    </div>

    <div class="col-sm-6 col-lg-3">
      <div class="card-box widget-icon">
        <a href="#/campaign/analytics">
          <i class="fa fa-apple text-muted" aria-hidden="true" style="font-size: 60px;"></i>
          <div class="wid-icon-info">
            <p class="text-muted m-b-5 font-13 text-uppercase">iOS</p>
            <h4 class="m-t-0 m-b-5 counter">{{ $ios_today }}</h4>
            <?php if ($ios_difference == 0) { ?>
            <small class="text-default"><b>{{ abs($ios_difference) }}%</b> ({{ $ios_today - $ios_yesterday }})</small>
            <?php } elseif ($ios_difference > 0) { ?>
            <small class="text-success"><i class="material-icons" style="font-size: 14px; position: relative; top: 3px">&#xE5D8;</i> <b>{{ abs($ios_difference) }}%</b> ({{ $ios_today - $ios_yesterday }})</small>
            <?php } else { ?>
            <small class="text-danger"><i class="material-icons" style="font-size: 14px; position: relative; top: 3px">&#xE5DB;</i> <b>{{ abs($ios_difference) }}%</b> ({{ $ios_today - $ios_yesterday }})</small>
            <?php } ?>
          </div>
        </a>
      </div>
    </div>

  </div>
<?php
$cols = 4;

if ( !Gate::allows( 'limitation', 'mobile.beacons_visible' ) )$cols--;
if ( !Gate::allows( 'limitation', 'mobile.geofences_visible' ) )$cols--;

switch ( $cols ) {
  case 4:
    $col_class = 'col-sm-6 col-lg-3';
    break;
  case 3:
    $col_class = 'col-sm-4 col-lg-4';
    break;
  case 2:
    $col_class = 'col-xs-6 col-lg-6';
    break;
}
?>
  <div class="row">
    <div class="{{ $col_class }}">
      <div class="widget-simple-chart text-right card-box">
        <div class="circliful-chart" data-percent="{{ round(($app_count / $app_count_limit) * 100) }}" data-fgcolor="#5fbeaa" data-bgcolor="#ebeff2" style="width: 100px"></div>
        <h3 class="text-success">{{ $app_count }} / {{ $app_count_limit }}</h3>
        <p><a href="#/apps" class="text-muted">{{ trans('global.apps') }}</a></p>
      </div>
    </div>
    <div class="{{ $col_class }}">
      <div class="widget-simple-chart text-right card-box">
        <div class="circliful-chart" data-percent="{{ round(($campaign_count / $campaign_count_limit) * 100) }}" data-fgcolor="#3bafda" data-bgcolor="#ebeff2" style="width: 100px"></div>
        <h3 class="text-primary">{{ $campaign_count }} / {{ $campaign_count_limit }}</h3>
        <p><a href="#/campaigns" class="text-muted">{{ trans('global.campaigns') }}</a></p>
      </div>
    </div>
    <?php if (Gate::allows('limitation', 'mobile.beacons_visible')) { ?>
    <div class="{{ $col_class }}">
      <div class="widget-simple-chart text-right card-box">
        <div class="circliful-chart" data-percent="{{ round(($beacon_count / $beacon_count_limit) * 100) }}" data-fgcolor="#3bafda" data-bgcolor="#ebeff2" style="width: 100px"></div>
        <h3 class="text-primary">{{ $beacon_count }} / {{ $beacon_count_limit }}</h3>
        <p><a href="#/beacons" class="text-muted">{{ trans('global.beacons') }}</a></p>
      </div>
    </div>
    <?php } ?>
    <?php if (Gate::allows('limitation', 'mobile.geofences_visible')) { ?>
    <div class="{{ $col_class }}">
      <div class="widget-simple-chart text-right card-box">
        <div class="circliful-chart" data-percent="{{ round(($geofence_count / $geofence_count_limit) * 100) }}" data-fgcolor="#3bafda" data-bgcolor="#ebeff2" style="width: 100px"></div>
        <h3 class="text-primary">{{ $geofence_count }} / {{ $geofence_count_limit }}</h3>
        <p><a href="#/geofences" class="text-muted">{{ trans('global.geofences') }}</a></p>
      </div>
    </div>
    <?php } ?>
  </div>
  <?php } ?>

</div>