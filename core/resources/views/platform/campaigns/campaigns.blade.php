<div class="container">
  <div class="row m-t">
    <div class="col-sm-12">
     
     <nav class="navbar navbar-default card-box sub-navbar">
      <div class="container-fluid">

        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-title-navbar" aria-expanded="false">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand no-link" href="javascript:void(0);">{{ trans('global.campaigns') }}</a>
        </div>

        <div class="collapse navbar-collapse" id="bs-title-navbar">

          <div class="navbar-form navbar-right">
              <a href="#/campaign/new" class="btn btn-primary"><i class="fa fa-plus" aria-hidden="true"></i> {{ trans('global.new_campaign') }}</a>
          </div>
          
          <ul class="nav navbar-nav navbar-right">
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{ trans('global.records') }} <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="javascript:void(0);" id="select-all">{{ trans('global.select_all') }}</a></li>
                <li><a href="javascript:void(0);" id="deselect-all">{{ trans('global.select_none') }}</a></li>
                <li role="separator" class="divider"></li>
                <li class="dropdown-header">{{ trans('global.with_selected') }}</li>
                <li class="must-have-selection"><a href="javascript:void(0);" id="selected-switch">{{ trans('global.toggle_active') }}</a></li>
                <li class="must-have-selection"><a href="javascript:void(0);" id="selected-delete">{{ trans('global.delete_selected') }}</a></li>
              </ul>
            </li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{ trans('global.export') }} <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="{{ url('platform/campaigns/export?type=xls') }}">Excel5 (xls)</a></li>
                <li><a href="{{ url('platform/campaigns/export?type=xlsx') }}">Excel2007 (xlsx)</a></li>
                <li><a href="{{ url('platform/campaigns/export?type=csv') }}">CSV</a></li>
              </ul>
            </li>
          </ul>
          
        </div>
      </div>
    </nav>
     
    </div>
  </div>
  <script>
var campaigns_table = $('#dt-table-campaigns').DataTable({
  ajax: "{{ url('platform/campaigns/data') }}",
  order: [
    [0, "asc"]
  ],
  dom: "<'row'<'col-sm-12 dt-header'<'pull-left'lr><'pull-right'f><'pull-right hidden-sm hidden-xs'T><'clearfix'>>>t<'row'<'col-sm-12 dt-footer'<'pull-left'i><'pull-right'p><'clearfix'>>>",
  processing: true,
  serverSide: true,
  stateSave: true,
  responsive: true,
  stripeClasses: [],
  lengthMenu: [
    [10, 25, 50, 75, 100, 1000000],
    [10, 25, 50, 75, 100, "{{ trans('global.all') }}"]
  ],
  columns: [ {
		data: "name"
	}, {
    data: "apps",
    sortable: false
  }, {
    data: "scenarios",
    sortable: false,
    width: 160
  }, {
    data: "analytics",
    sortable: false,
    width: 160
  }, {
		data: "created_at",
    width: 120
  }, {
		data: "active",
    width: 60
  }, {
    data: "sl",
    width: 74,
    sortable: false
  }],
  rowCallback: function(row, data) {
    if($.inArray(data.DT_RowId.replace('row_', ''), selected_campaigns) !== -1) {
      $(row).addClass('success');
    }
  },
  fnDrawCallback: function() {
    onDataTableLoad();
  },
  columnDefs: [
    {
      render: function (data, type, row) {
        return '<a href="#/scenarios/' + row.sl + '" class="link">{{ trans('global.edit_scenarios') }} (' + data + ')</a>';
      },
      targets: 2
    },
    {
      render: function (data, type, row) {
        return '<a href="#/campaign/analytics/' + row.sl + '" class="link">{{ trans('global.view_analytics') }}</a>';
      },
      targets: 3
    },
    {
      render: function (data, type, row) {
        return '<div data-moment="fromNowDateTime">' + data + '</div>';
      },
      targets: [4] /* Column to re-render */
    },
    {
      render: function (data, type, row) {
        if(data == 1)
        {
          return '<div class="text-center"><i class="fa fa-check" aria-hidden="true"></i></div>';
        }
        else
        {
          return '<div class="text-center"><i class="fa fa-times" aria-hidden="true"></i></div>';
        }
      },
      targets: 5
    },
    {
      render: function (data, type, row) {
        return '<div class="row-actions-wrap"><div class="text-center row-actions" data-sl="' + data + '">' + 
          '<a href="#/campaign/edit/' + data + '" class="btn btn-xs btn-success row-btn-edit" data-toggle="tooltip" title="{{ trans('global.edit') }}"><i class="fa fa-pencil"></i></a> ' + 
          '<a href="javascript:void(0);" class="btn btn-xs btn-danger row-btn-delete" data-toggle="tooltip" title="{{ trans('global.delete') }}"><i class="fa fa-trash"></i></a>' + 
          '</div></div>';
      },
      targets: 6 /* Column to re-render */
    },
  ],
  language: {
    search: "",
    emptyTable: "{{ trans('global.empty_table') }}",
    info: "{{ trans('global.dt_info') }}",
    infoEmpty: "",
    infoFiltered: "(filtered from _MAX_ total entries)",
    thousands: "{{ trans('i18n.thousands_sep') }}",
    lengthMenu: "{{ trans('global.show_records') }}",
    processing: '<i class="fa fa-circle-o-notch fa-spin"></i>',
    paginate: {
      first: '<i class="fa fa-fast-backward"></i>',
      last: '<i class="fa fa-fast-forward"></i>',
      next: '<i class="fa fa-caret-right"></i>',
      previous: '<i class="fa fa-caret-left"></i>'
    }
  }
})
.on('init.dt', function() {
	var count = $(this).dataTable().fnGetData().length;
	if(count == 0) {
		$('.must-have-selection').addClass('disabled');
	}
});

$('#select-all').on('click', function() {
	selected_campaigns = [];

	$('#dt-table-campaigns tbody tr').each(function() {
		var id = this.id.replace('row_', '');
		selected_campaigns.push(id);
	});

	checkButtonVisibility();
	campaigns_table.ajax.reload();
});

$('#deselect-all').on('click', function() {
	selected_campaigns = [];
	checkButtonVisibility();
	campaigns_table.ajax.reload();
});
    
// Click
$('#dt-table-campaigns').on('click', 'tr', function() {
	checkButtonVisibility();
});

$('#dt-table-campaigns_wrapper .dataTables_filter input').attr('placeholder', "{{ trans('global.search_') }}");

$('#dt-table-campaigns tbody').on('click dblclick', 'tr', function(e) {
    if(e.target.nodeName == 'TD')
    {
        var td_index = $(e.target).index();
    }
    else
    {
        var td_index = $(e.target).parents('td').index();
    }
    if(td_index == 2 || td_index == 3 || td_index == 6) return;

    var id = this.id.replace('row_', '');
    var index = $.inArray(id, selected_campaigns);

    if (index === -1) {
        selected_campaigns.push(id);
    } else {
        selected_campaigns.splice(index, 1);
    }

    $(this).toggleClass('success');
});


checkButtonVisibility();

function checkButtonVisibility()
{
    var disabled = (parseInt(selected_campaigns.length) > 0) ? false : true;
	if (disabled)
	{
		$('.must-have-selection').addClass('disabled');
	}
	else
	{
		$('.must-have-selection').removeClass('disabled');
	}
}
</script>
  <div class="row">
    <div class="col-sm-12">
      <div class="card-box table-responsive">
        <table class="table table-striped table-bordered table-hover table-selectable" id="dt-table-campaigns" style="width:100%">
          <thead>
            <tr>
              <th>{{ trans('global.name') }}</th>
              <th>{{ trans('global.apps') }}</th>
              <th>{{ trans('global.scenarios') }}</th>
              <th>{{ trans('global.analytics') }}</th>
              <th>{{ trans('global.created') }}</th>
              <th class="text-center">{{ trans('global.active') }}</th>
              <th class="text-center">{{ trans('global.actions') }}</th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>
<script>

$('#dt-table-campaigns').on('click', '.row-btn-delete', function() {
  var sl = $(this).parent('.row-actions').attr('data-sl');

  swal({
    title: _lang['confirm'],
    type: "warning",
    showCancelButton: true,
    cancelButtonText: _lang['cancel'],
    confirmButtonColor: "#DD6B55",
    confirmButtonText: _lang['yes_delete']
  }, 
  function(){
    blockUI();
  
    var jqxhr = $.ajax({
      url: "{{ url('platform/campaign/delete') }}",
      data: {sl: sl, _token: '<?= csrf_token() ?>'},
      method: 'POST'
    })
    .done(function(data) {
      if(data.result == 'success')
      {
        campaigns_table.ajax.reload();
      }
      else
      {
        swal(data.msg);
      }
    })
    .fail(function() {
      console.log('error');
    })
    .always(function() {
      unblockUI();
    });
  });
});

$('#selected-delete').on('click', function() {
	if (! $(this).parent('li').hasClass('disabled'))
	{
		swal({
		  title: _lang['confirm'],
		  type: "warning",
		  showCancelButton: true,
		  cancelButtonText: _lang['cancel'],
		  confirmButtonColor: "#DD6B55",
		  confirmButtonText: _lang['yes_delete']
		}, 
		function(){
			blockUI();
		
			var jqxhr = $.ajax({
				url: "{{ url('platform/campaign/delete') }}",
				data: { ids: selected_campaigns, _token: '<?= csrf_token() ?>'},
				method: 'POST'
			})
			.done(function() {
				selected_campaigns = [];
				campaigns_table.ajax.reload();
				checkButtonVisibility();
			})
			.fail(function() {
				console.log('error');
			})
			.always(function() {
				unblockUI();
			});
		});
	}
});

$('#selected-switch').on('click', function() {
	if (! $(this).parent('li').hasClass('disabled'))
	{
    blockUI();

    var jqxhr = $.ajax({
        url: "{{ url('platform/campaign/switch') }}",
        data: { ids: selected_campaigns, _token: '<?= csrf_token() ?>'},
        method: 'POST'
    })
    .done(function() {
        selected_campaigns = [];
        campaigns_table.ajax.reload();
        checkButtonVisibility();
    })
    .fail(function() {
        console.log('error');
    })
    .always(function() {
        unblockUI();
    });
  }
});
</script> 
</div>