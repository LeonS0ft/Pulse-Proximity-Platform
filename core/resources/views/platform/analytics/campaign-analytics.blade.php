<div class="container">
<div class="row m-t">
  <div class="col-sm-6">
<?php
if (count($campaigns) == 0) {
?>
    <div class="card-box">
      <h1>{{ trans('global.no_data_found') }} </h1>
    </div>

<?php
} else { 
?>
    <div class="card-box" style="padding:13px">
      <select id="campaigns" class="select2-required">
<?php
echo '<option value="">' . trans('global.all_campaigns') . '</option>';

foreach($campaigns as $key => $row) {
  $sl_campaign = \Platform\Controllers\Core\Secure::array2string(array('campaign_id' => $row['id']));
  $selected = ($row['id'] == $campaign_id) ? ' selected' : '';
  echo '<option value="' . $sl_campaign . '"' . $selected . '>' . $row['name'] . '</option>';
}
?>
      </select>
<script>
$('#campaigns').on('change', function() {
  document.location = ($(this).val() == '') ? '#/campaign/analytics/<?php echo $date_start ?>/<?php echo $date_end ?>' : '#/campaign/analytics/<?php echo $date_start ?>/<?php echo $date_end ?>/' + $(this).val();
});
</script>
    </div>
  </div>
  <div class="col-sm-6 text-center m-b-20">
      <div class="form-control" id="reportrange" style="cursor:pointer;padding:20px; width:100%; display:table"> <i class="fa fa-calendar" style="margin:0 10px 0 0"></i> <span></span> </div>
  </div>
</div>

<div class="row">
  <div class="col-lg-12">

      <div class="card-box">
        <h3 class="page-title">{{ trans('global.views_and_interactions') }}</h3>
        <div id="combine-chart">
          <div id="combine-chart-container" class="flot-chart" style="height: 320px;"> </div>
        </div>
      </div>

  </div>
</div>

<script>
$('#reportrange span').html(moment('<?php echo $date_start ?>').format('MMMM D, YYYY') + ' - ' + moment('<?php echo $date_end ?>').format('MMMM D, YYYY'));

$('#reportrange').daterangepicker({
  format: 'MM-DD-YYYY',
  startDate: moment('<?php echo $date_start ?>').format('MM-D-YYYY'),
  endDate: moment('<?php echo $date_end ?>').format('MM-D-YYYY'),
  minDate: moment('<?php echo $first_date ?>').format('MM-D-YYYY'),
  maxDate: '<?php echo date('m/d/Y') ?>',
  dateLimit: {
      days: 60
  },
  showDropdowns: true,
  showWeekNumbers: true,
  timePicker: false,
  timePickerIncrement: 1,
  timePicker12Hour: true,
  ranges: {
   '<?php echo trans('global.today') ?>': [ moment(), moment() ],
   '<?php echo trans('global.yesterday') ?>': [ moment().subtract(1, 'days'), moment().subtract(1, 'days') ],
   '<?php echo trans('global.last_7_days') ?>': [ moment().subtract(6, 'days'), moment() ],
   '<?php echo trans('global.last_30_days') ?>': [ moment().subtract(29, 'days'), moment() ],
   '<?php echo trans('global.this_month') ?>': [ moment().startOf('month'), moment().endOf('month') ],
   '<?php echo trans('global.last_month') ?>': [ moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month') ]
  },

  opens: 'left',
  drops: 'down',
  buttonClasses: ['btn', 'btn-sm'],
  applyClass: 'btn-primary',
  cancelClass: 'btn-inverse',
  separator: ' {{ strtolower(trans('global.to')) }} ',
  locale: {
    applyLabel: '<?php echo trans('global.submit') ?>',
    cancelLabel: '<?php echo trans('global.reset') ?>',
    fromLabel: '<?php echo trans('global.date_from') ?>',
    toLabel: '<?php echo trans('global.date_to') ?>',
    customRangeLabel: '<?php echo trans('global.custom_range') ?>',
    daysOfWeek: ['<?php echo trans('global.su') ?>', '<?php echo trans('global.mo') ?>', '<?php echo trans('global.tu') ?>', '<?php echo trans('global.we') ?>', '<?php echo trans('global.th') ?>', '<?php echo trans('global.fr') ?>','<?php echo trans('global.sa') ?>'],
      monthNames: ['<?php echo trans('global.january') ?>', '<?php echo trans('global.february') ?>', '<?php echo trans('global.march') ?>', '<?php echo trans('global.april') ?>', '<?php echo trans('global.may') ?>', '<?php echo trans('global.june') ?>', '<?php echo trans('global.july') ?>', '<?php echo trans('global.august') ?>', '<?php echo trans('global.september') ?>', '<?php echo trans('global.october') ?>', '<?php echo trans('global.november') ?>', '<?php echo trans('global.december') ?>'],
      firstDay: 1
  }
});

$('#reportrange').on('apply.daterangepicker', function(ev, picker) {
  $('#reportrange span').html(picker.startDate.format('MMMM D, YYYY') + ' - ' + picker.endDate.format('MMMM D, YYYY'));
  var start = picker.startDate.format('YYYY-MM-DD');
  var end = picker.endDate.format('YYYY-MM-DD');

  var sl = '{{ $sl }}';
  document.location = (sl == '') ? '#/campaign/analytics/' + start + '/' + end : '#/campaign/analytics/' + start + '/' + end + '/' + sl;
});


//Combine graph data
var statCardViews = [
<?php foreach($interaction_range as $date => $row) { ?>
[(new Date(<?php echo $row['y'] ?>, <?php echo $row['m'] - 1 ?>, <?php echo $row['d'] + 1 ?>)).getTime(), <?php echo $row['views'] ?>],
<?php } ?>
];

var statInteractions = [
<?php foreach($interaction_range as $date => $row) { ?>
[(new Date(<?php echo $row['y'] ?>, <?php echo $row['m'] - 1 ?>, <?php echo $row['d']  + 1?>)).getTime(), <?php echo $row['interactions'] ?>],
<?php } ?>
];
var ticks = [
<?php foreach($interaction_range as $date => $row) { ?>
[(new Date(<?php echo $row['y'] ?>, <?php echo $row['m'] - 1 ?>, <?php echo $row['d'] + 1 ?>)).getTime(), '<?php echo $row['m'] . '/' . $row['d'] ?>'],
<?php } ?>
];
var combinelabels = ["{{ trans('global.cards_viewed') }}", "{{ trans('global.scenarios_triggered') }}"];
var combinedatas = [statCardViews, statInteractions];

// first correct the timestamps - they are recorded as the daily
// midnights in UTC+0100, but Flot always displays dates in UTC
// so we have to add one hour to hit the midnights in the plot
for (var i = 0; i < statCardViews.length; ++i) {
  statCardViews[i][0] += 60 * 60 * 1000;
}

for (var i = 0; i < statInteractions.length; ++i) {
  statInteractions[i][0] += 60 * 60 * 1000;
}

function weekendAreas(axes) {

  var markings = [],
    d = new Date(axes.xaxis.min);

  // go to the first Saturday
  d.setUTCDate(d.getUTCDate() - ((d.getUTCDay() + 1) % 7))
  d.setUTCSeconds(0);
  d.setUTCMinutes(0);
  d.setUTCHours(0);

  var i = d.getTime();

  // when we don't set yaxis, the rectangle automatically
  // extends to infinity upwards and downwards

  do {
    markings.push({ xaxis: { from: i, to: i + 2 * 24 * 60 * 60 * 1000 }, color:"#fafafa" });
    i += 7 * 24 * 60 * 60 * 1000;
  } while (i < axes.xaxis.max);

  return markings;
}

var options = {
  series : {
    shadowSize : 0,
    lines: { 
      show: true,
      fill: false,
      lineWidth: 3
    },
    points: { 
      show: true,
      fill: true,
      radius: 3
    }
  },
  grid : {
    markings: weekendAreas,
    hoverable : true,
    clickable : true,
    tickColor : "#f9f9f9",
    borderWidth : 1,
    borderColor : "hsla(0,0%,93%,.1)"
  },
  colors : ["#50b432", "#058dc7"],
  tooltip : true,
  tooltipOpts : {
    content : "%y %s",
    defaultTheme : false
  },
  legend : {
    position : "ne",
    margin : [0, -24],
    noColumns : 0,
    labelBoxBorderColor : null,
    labelFormatter : function(label, series) {
      // just add some space to labes
      return '' + label + '&nbsp;&nbsp;';
    },
    width : 30,
    height : 2
  },
  yaxis : {
    tickColor : '#efefef',
    tickDecimals: 0,
    font : {
      color : 'rgb(68, 68, 68)'
    }
  },
  xaxis : {
    mode: "time", 
    timeformat: "%Y-%m-%d",
    ticks: ticks,
    tickLength: 0,
    tickColor : '#f5f5f5',
    font : {
      color : 'rgb(68, 68, 68)'
    }
  }
};

var data = [{
  label : combinelabels[0],
  data : combinedatas[0],
  lines : {
    show : true,
    fill : false
  },
  points : {
    show : true,
    fillColor: "#50b432"
  }
}, {
  label : combinelabels[1],
  data : combinedatas[1],
  lines : {
    show : false
  },
  bars : {
    show : true,
    align: "center",
    fill: true,
    barWidth: (1000*60*60*12)
  },
  points : {
    show : false,
    fillColor: "#058dc7"
  }
}
];

$.plot($("#combine-chart #combine-chart-container"), data, options);

$(window).resize(function(event) {
  if ($("#combine-chart #combine-chart-container").length) {
    $.plot($("#combine-chart #combine-chart-container"), data, options);
  }
});

</script>
<?php } ?>