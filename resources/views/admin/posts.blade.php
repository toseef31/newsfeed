@extends('admin.layouts.master')

@section('style')
<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<style>
.daterangepicker td.in-range {
    background-color: #51cbce;
    border-color: transparent;
    color: #fbfbfb;
    border-radius: 0;
}
.modal-header .close {
    padding: 0 !important;
    margin: 0 !important;
}
</style>
<script>
        $(function() { $("#e1").daterangepicker({
			  "alwaysShowCalendars": true,
    ranges: {
        'Today': [moment(), moment()],
        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
        'This Month': [moment().startOf('month'), moment().endOf('month')],
        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
    },
	"locale": {
        "format": "YYYY-MM-DD",
        "separator": " / ",
        "applyLabel": "Apply",
        "cancelLabel": "Cancel",
        "fromLabel": "From",
        "toLabel": "To",
        "customRangeLabel": "Custom Rang",
        "weekLabel": "W",
        "daysOfWeek": [
            "Su",
            "Mo",
            "Tu",
            "We",
            "Th",
            "Fr",
            "Sa"
        ],
        "monthNames": [
            "January",
            "February",
            "March",
            "April",
            "May",
            "June",
            "July",
            "August",
            "September",
            "October",
            "November",
            "December"
        ],
        "firstDay": 1
    },

 });

 $('input[name="e1"]').on('apply.daterangepicker', function(ev, picker) {
      $(this).val(picker.startDate.format('YYYY-MM-DD') + ' / ' + picker.endDate.format('YYYY-MM-DD'));
      var date =picker.startDate.format('YYYY-MM-DD') + ' / ' + picker.endDate.format('YYYY-MM-DD');
      // alert(date);
      var team =$('#get_teams').val();
       var role =$('#get_role').val();
       var keyword =$('#keyword').val();
       $.ajax({
               headers: {
                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
               },
               type: 'post',
               data: {date:date,role:role,team:team,keyword:keyword},
               // url: "{{url('dashboard/postionsearch/')}}/"+id,
               url: "{{url('dashboard/datesearch')}}",
              success: function (response) {
               // $('#showresponce').html(response);
               var res = JSON.parse(response);
               var data =res.output;
               var total =res.total;
                 $('#showresponce2').html(data);
                 var totalcount =res.totalcount;
                  $('#show_record').html(total+' founds in '+totalcount+' publications');

             }

          });
  });
 }

 );
    </script>
@endsection
@section('content')

  <div class="wrapper">
    <div class="main-panel">
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-absolute fixed-top navbar-transparent">
        <div class="container-fluid">
          <div class="navbar-wrapper">
            <div class="navbar-toggle">
              <button type="button" class="navbar-toggler">
                <span class="navbar-toggler-bar bar1"></span>
                <span class="navbar-toggler-bar bar2"></span>
                <span class="navbar-toggler-bar bar3"></span>
              </button>
            </div>
            <a class="navbar-brand" href="#pablo" style="text-transform:uppercase;"><strong>News</strong></a>
          </div>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
          </button>
            <div class="collapse navbar-collapse justify-content-end" id="navigation">

            <ul class="navbar-nav">
              <li>
                <a href="{{url('dashboard/allcsv')}}" class="btn top-btn csv-btn">Download <br> CSV</a>
                <a href="{{url('dashboard/add-post')}}" class="btn btn-primary top-btn new-btn" style="background: #63c6bd;">New Post</a>
              </li>
              <li class="nav-item btn-rotate dropdown">
                <a class="nav-link dropdown-toggle" href="http://example.com" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                  <p>
                    <span class="d-lg-none d-md-block">Some Actions</span>
                  </p>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                  <a class="dropdown-item" href="{{ url('dashboard/logout') }}">Logout</a>
                </div>
              </li>

            </ul>
          </div>
        </div>
      </nav>
      <!-- End Navbar -->
      <!-- <div class="panel-header panel-header-sm">


</div> -->
      <div class="content">
        <div class="row">

          <div class="col-md-12">
            <div class="row">
              <div class="col-md-12 mb-20">
                <form class="form-inline pull-left search-bar" action="">
                  <div class="form-group">
                    <input type="text" class="form-control border-gray" id="keyword" placeholder="Search" onkeyup="searchByname(this.value)" onkeydown="searchByname(this.value)">
                  </div>
                  <div class="form-group">
                   <input id="e1" name="e1" class="form-control border-gray" value="Select Date">

                  </div>
                  <div class="form-group">
                    <select name="team" id="get_teams" class="form-control border-gray" onchange="teams(this);">
                            <option value="">Select Team</option>
                            @foreach(Feed::teams() as $team)
                         <option value="{{$team->id}}">{{$team->name}}</option>
                            @endforeach
                          </select>
                  </div>
                  <div class="form-group">
                      <select name="role" id="get_role" class="form-control border-gray" onchange="postion(this);">
                            <option value="">Select Role</option>
                            @foreach(Feed::roles() as $role)
                            <option value="{{$role->id}}">{{$role->name}}</option>
                            @endforeach
                          </select>
                  </div>
                  <!-- <button type="submit" class="btn btn-default">Submit</button> -->
                </form>
                <p class="pull-right mb-0" style="line-height: 36px"><span id="show_record"></span> </p>
              </div>
            </div>
            @if(Session::has('post'))
               <div class="alert alert-success">
                  {{ Session::get('post') }}
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  </button>
               </div>
               @endif
               @if(Session::has('delnum'))
               <div class="alert alert-success">
                  {{ Session::get('delnum') }}
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  </button>
               </div>
               @endif
            <div class="card" id="showresponce">
              <!-- <div class="card-header">
                <h4 class="card-title"> Jobs List</h4>
              </div> -->

              <div class="card-body">
                <div class="table-responsive" id="showresponce2">

                  <table class="table">
                    <thead>
                      <th colspan="2"></th>
                      <th colspan="2">Title</th>
                      <th colspan="">Created at</th>
                      <th colspan="3">Team</th>
                      <th colspan="3">Roles</th>
                      <th colspan="3">Targeted Audience</th>
                      <th colspan="3">Likes</th>
                      <th colspan="3">Dislike</th>
                      <th colspan="3">blank_field</th>
                      <th colspan="3">blank_field</th>

                    </thead>
                    <tbody>
                    </tbody>
                    </table>

                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('script')
<script src="https://www.jqueryscript.net/demo/Delete-Confirmation-Dialog-Plugin-with-jQuery-Bootstrap/bootstrap-confirm-delete.js"></script>
<script>
$(document).on('click', '.demo', function(e) {
  e.preventDefault();
  var url = $(this).attr('href');
  Notify.confirm({
title : 'Delete',
html : '<b>Are you sure To Delete This Entry?</b>',
ok : function(){
  // Notify.suc('OK');
  window.location.href =url;
}
});
});

function teams(data){
 var id =data.value;
 var role =$('#get_role').val();
 var date =$('#e1').val();
 var keyword =$('#keyword').val();
 // alert(date);
  $.ajax({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type: 'post',
          data: {team:id,role:role,date:date,keyword:keyword},
          // url: "{{url('dashboard/teamsearch/')}}/"+id,
          url: "{{url('dashboard/teamsearch')}}",
         success: function (response) {
          // $('#showresponce').html(response);
          // console.log(response);
          var res = JSON.parse(response);
          var data =res.output;
          var total =res.total;
            $('#showresponce2').html(data);
            var totalcount =res.totalcount;
             $('#show_record').html(total+' founds in '+totalcount+' publications');


        }

     });
}


function postion(data){
 var id =data.value;
 var team =$('#get_teams').val();
  var date =$('#e1').val();
  var keyword =$('#keyword').val();
  $.ajax({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type: 'post',
          data: {role:id,team:team,date:date,keyword:keyword},
          url: "{{url('dashboard/postionsearch')}}",
         success: function (response) {
          // $('#showresponce').html(response);
          // console.log(response);
          var res = JSON.parse(response);
          var data =res.output;
          var total =res.total;
            $('#showresponce2').html(data);
            var totalcount =res.totalcount;
             $('#show_record').html(total+' founds in '+totalcount+' publications');


        }

     });
}

function searchByname(searchkeyword){
  var searchkeyword = searchkeyword;
  var role =$('#get_role').val();
  var team =$('#get_teams').val();
   var date =$('#e1').val();
    $.ajax({
      headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type: 'post',
          url: "{{url('/dashboard/search')}}",
          data: {
            searchkeyword: searchkeyword,role:role,team:team,date:date
            },
          success: function (response) {
              // $('#showresponce').html(response);
              // console.log(response);
              var res = JSON.parse(response);
              var data =res.output;
              var total =res.total;
                $('#showresponce2').html(data);
                var totalcount =res.totalcount;
                 $('#show_record').html(total+' founds in '+totalcount+' publications');


          }
        });
  }

  $('body').on('click', '.pagination a', function(e) {
  		e.preventDefault();
  	 // alert(page);
  	 var page = $(this).attr('href').split('page=')[1];
  	 getArticles(page)

  });
   function getArticles(page) {
  		 location.hash=page;
       var role =$('#get_role').val();
       var team =$('#get_teams').val();
        var date =$('#e1').val();
  		 var token   = "{{ csrf_Token() }}";
  		 // alert(listing_id);
  		$.ajax({
  				url : '/dashboard/posts-ajax/?page='+page,
          data: {role:role,team:team,date:date,_token:token},
  		}).done(function (response) {
  			// console.log(response);
        var res = JSON.parse(response);
        var data =res.output;
        var total =res.total;
  				$('#showresponce2').html(data);
          var totalcount =res.totalcount;
  				 $('#show_record').html(total+' founds in '+totalcount+' publications');

  		}).fail(function () {
  				alert('Articles could not be loaded.');
  		});
  }

$(document).ready(function () {
  var url = window.location.href;
      var id = url.substring(url.lastIndexOf('?') + 1);
      //alert(id);
      var token   = "{{ csrf_Token() }}";
      // alert(listing_id);
     $.ajax({
       type:'get',
         url : '/dashboard/posts-ajax/?'+id,
     }).done(function (response) {

       var res = JSON.parse(response);
       // console.log(res.output);
       var data =res.output;
       var total =res.total;
       var totalcount =res.totalcount;
         $('#showresponce2').html(data);

         $('#show_record').html(total+' founds in '+totalcount+' publications');

     }).fail(function () {
         alert('Articles could not be loaded.');
     });
 });
</script>
@endsection
