@extends('layouts.app')

@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="page-title">
			<h3 class="text-black-50 float-left"><i class="nav-icon fa fa-database"></i> Reports</h3>
			<ol class="breadcrumb float-right">
				<li class="breadcrumb-item"><a href="/home"><i class="fa fa-home"></i></a></li>
				<li class="breadcrumb-item">Dashboard</li>
			</ol>
		</div>
	</div>
</div>
<div class="row text-black-50">
	<div class="col-md-12 col-lg-12">
		<div class="card">
			<div class="card-body">
                <div class="graph__block" id="example"></div>
			</div>			
		</div>
	</div>
</div>
<script>
  $(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('.selectpicker').selectpicker();
    
    // Reports code //
    // $("#staff-table").DataTable({
    //     "processing": true,
    //     "serverSide": true,
    //     responsive: true,
    //     "order": [],
    //     ajax: {
    //         url: '/data/staff/dataTable',
    //         type: 'POST'
    //     },
    //     "columnDefs": [
    //         {
    //             "targets": [4],
    //             "orderable": false,
    //         },
    //     ],
    //     language: {
    //         searchPlaceholder: "Search",
    //         sEmptyTable: "No staff found"
    //     },
    // });
    
var myData = [
    {
        label: 'January',
        color: [
            'blue',
            'green',
            'orange'
        ],
        value: [
            3069,
            5999,
            8252,
        ]
    },
    {
        label: 'February',
        color: [
            'blue',
            'green',
            'orange'
        ],
        value: [
            2863,
            5120,
            7927,
        ]
    },
    {
        label: 'March',
        color: [
            'blue',
            'green',
            'orange'
        ],
        value: [
            4047,
            6489,
            9143,
        ]
    },
    {
        label: 'April',
        color: [
            'blue',
            'green',
            'orange'
        ],
        value: [
            4047,
            6489,
            9143,
        ]
    },
    {
        label: 'May',
        color: [
            'blue',
            'green',
            'orange'
        ],
        value: [
            4047,
            6489,
            9143,
        ]
    },
    {
        label: 'June',
        color: [
            'blue',
            'green',
            'orange'
        ],
        value: [
            4047,
            6489,
            9143,
        ]
    },
    {
        label: 'July',
        color: [
            'blue',
            'green',
            'orange'
        ],
        value: [
            4047,
            6489,
            9143,
        ]
    },
    {
        label: 'August',
        color: [
            'blue',
            'green',
            'orange'
        ],
        value: [
            4047,
            6489,
            9143,
        ]
    },
    {
        label: 'September',
        color: [
            'blue',
            'green',
            'orange'
        ],
        value: [
            4047,
            6489,
            9143,
        ]
    },
    {
        label: 'October',
        color: [
            'blue',
            'green',
            'orange'
        ],
        value: [
            4047,
            6489,
            9143,
        ]
    },
    {
        label: 'November',
        color: [
            'blue',
            'green',
            'orange'
        ],
        value: [
            4047,
            6489,
            9143,
        ]
    },
    {
        label: 'December',
        color: [
            'blue',
            'green',
            'orange'
        ],
        value: [
            4047,
            6489,
            9143,
        ]
    }
]

    $('#example').dvstrtm_graph({
      title: 'Monthly reports',
      graphs: myData
    });

    $.loadData();
});

(function($){
    $.loadData = function (){
        $('select').selectpicker();
        $.get("/data/reports/get_data", function(data, status){
            var data = JSON.parse(data);
        });    
    }

})(jQuery);
</script>
@endsection 
