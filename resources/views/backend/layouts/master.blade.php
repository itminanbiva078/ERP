<!doctype html>
<html class="no-js" lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>@yield('title', 'Master-ERP')</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        @include('backend.layouts.partials.styles')
        @yield('styles')
    </head>
    <body class="sidebar-mini skin-purple-light sidebar-mini layout-fixed  text-sm"> 
        @include('backend.layouts.partials.systemConfigure')
        @include('backend.layouts.partials.header')
        @include('backend.layouts.partials.sidebar')
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            @yield('navbar-content')
            <section class="content">
                <div class="container-fluid">
                    @if(helper::roleAccess(Route::currentRouteName()) || Route::currentRouteName() =='home')
                        @yield('admin-content')
                    @else 
                        @yield('admin-content')
                    @endif
                </div>
            </section>
        </div>
        <div id="loader"></div>
        @include('backend.layouts.partials.footer')
        @include('backend.layouts.partials.scripts')
        @include('backend.layouts.partials.messages')
        @include('backend.layouts.partials.datatable')
        @include('backend.layouts.partials.customScripts')
        @include('backend.layouts.partials.modal')
        @yield('scripts')


<script>
    var options = {
          series: [{
          name: 'Income',
          data: [31, 40, 28, 51, 42, 109, 100]
        }, {
          name: 'Expense',
          data: [11, 32, 45, 32, 34, 52, 41]
        }],
          chart: {
          height: 350,
          type: 'area'
        },
        dataLabels: {
          enabled: false
        },
        stroke: {
          curve: 'smooth'
        },
        xaxis: {
          type: 'datetime',
          categories: ["2018-09-19T00:00:00.000Z", "2018-09-19T01:30:00.000Z", "2018-09-19T02:30:00.000Z", "2018-09-19T03:30:00.000Z", "2018-09-19T04:30:00.000Z", "2018-09-19T05:30:00.000Z", "2018-09-19T06:30:00.000Z"]
        },
        tooltip: {
          x: {
            format: 'dd/MM/yy HH:mm'
          },
        },
        };

        var chart = new ApexCharts(document.querySelector("#userChart"), options);
        chart.render();


//


var options = {
          series: [{
          name: 'Cash Flow',
          data: [1.45, 5.42, 5.9, -0.42, -12.6, -18.1, -18.2, -14.16, -11.1, -6.09, 0.34, 3.88, 13.07,
            5.8, 2, 7.37, 8.1, 13.57, 15.75, 17.1, 19.8, -27.03, -54.4, -47.2, -43.3, -18.6, -
            48.6, -41.1, -39.6, -37.6, -29.4, -21.4, -2.4
          ]
        }],
          chart: {
          type: 'bar',
          height: 350
        },
        plotOptions: {
          bar: {
            colors: {
              ranges: [{
                from: -100,
                to: -46,
                color: '#F15B46'
              }, {
                from: -45,
                to: 0,
                color: '#FEB019'
              }]
            },
            columnWidth: '80%',
          }
        },
        dataLabels: {
          enabled: false,
        },
        yaxis: {
          title: {
            text: 'Growth',
          },
          labels: {
            formatter: function (y) {
              return y.toFixed(0) + "%";
            }
          }
        },
        xaxis: {
          type: 'datetime',
          categories: [
            '2011-01-01', '2011-02-01', '2011-03-01', '2011-04-01', '2011-05-01', '2011-06-01',
            '2011-07-01', '2011-08-01', '2011-09-01', '2011-10-01', '2011-11-01', '2011-12-01',
            '2012-01-01', '2012-02-01', '2012-03-01', '2012-04-01', '2012-05-01', '2012-06-01',
            '2012-07-01', '2012-08-01', '2012-09-01', '2012-10-01', '2012-11-01', '2012-12-01',
            '2013-01-01', '2013-02-01', '2013-03-01', '2013-04-01', '2013-05-01', '2013-06-01',
            '2013-07-01', '2013-08-01', '2013-09-01'
          ],
          labels: {
            rotate: -90
          }
        }
        };

        var chart = new ApexCharts(document.querySelector("#priceChart"), options);
        chart.render();
</script>


        
    </body>

</html>