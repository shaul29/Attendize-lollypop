@extends('Shared.Layouts.Master')

@section('title')
    @parent
    @lang("basic.dashboard")
@stop


@section('top_nav')
    @include('ManageEvent.Partials.TopNav')
@stop

@section('page_title')
<i class="ico-home2"></i>
@lang("basic.event_dashboard")
@endsection

@section('menu')
    @include('ManageEvent.Partials.Sidebar')
@stop

@section('head')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css" integrity="sha256-szHusaozbQctTn4FX+3l5E0A5zoxz7+ne4fr8NgWJlw=" crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.4/raphael-min.js" integrity="sha256-Gk+dzc4kV2rqAZMkyy3gcfW6Xd66BhGYjVWa/FjPu+s=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js" integrity="sha256-0rg2VtfJo3VUij/UY9X0HJP7NET6tgAY98aMOfwP0P8=" crossorigin="anonymous"></script>
    <script>
        $(function () {
            $.getJSON('https://graph.facebook.com/?id=' + '{{route('showEventPage',['event_id' => $event->id, 'event_slug' => Str::slug($event->title)])}}', function (fbdata) {
                $('#facebook-count').html(fbdata.shares);
            });
        });
    </script>

    <style>
        svg {
            width: 100% !important;
        }
    </style>
@stop

@section('content')
    <div class="row">
        <div class="col-sm-3">
            <div class="stat-box">
                <h3>{{ $event->getEventRevenueAmount()->display() }}</h3>
                <span>@lang("Event.revenue")</span>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="stat-box">
                <h3>{{ $event->orders->count() }}</h3>
                <span>@lang("Dashboard.orders")</span>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="stat-box">
                <h3>{{ $event->tickets->sum('quantity_sold') }}</h3>
                <span>@lang("Dashboard.tickets_sold")</span>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="stat-box">
                <h3>{{ $event->stats->sum('views') }}</h3>
                <span>@lang("Dashboard.event_views")</span>
            </div>
        </div>

        <!-- TODO: add event views -->

        <!-- May be implemented soon.
        <div class="col-sm-3 hide">
            <div class="stat-box">
                <h3 id="facebook-count">0</h3>
                <span>Facebook Shares</span>
            </div>
        </div>
        -->
    </div>

    <div class="row">
        <div class="col-md-9 col-sm-6">
            <div class="row">
                <div class="col-md-6">
                    <div class="panel">
                        <div class="panel-heading panel-default">
                            <h3 class="panel-title">
                                @lang("Dashboard.tickets_sold")
                        <span style="color: green; float: right;">
                            {{$event->tickets->sum('quantity_sold')}} @lang("basic.total")
                        </span>
                            </h3>
                        </div>
                        <div class="panel-body">
                            <div class="chart-wrap">
                                <div style="height:200px;" class="statChart" id="theChart"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="panel">
                        <div class="panel-heading panel-default">
                            <h3 class="panel-title">
                                @lang("Dashboard.ticket_sales_volume")
                                <span style="color: green; float: right;">
                                    {{ $event->getEventRevenueAmount()->display() }}
                                    @lang("basic.total")
                                </span>
                            </h3>
                        </div>
                        <div class="panel-body">
                            <div class="chart-wrap">
                                <div style="height: 200px;" class="statChart" id="theChart3"></div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="panel">
                        <div class="panel-heading panel-default">
                            <h3 class="panel-title">
                                @lang("Dashboard.event_page_visits")
                                <span style="color: green; float: right;">
                                    {{$event->stats->sum('views')}} @lang("basic.total")
                                </span>
                            </h3>
                        </div>
                        <div class="panel-body">
                            <div class="chart-wrap">
                                <div style="height: 200px;" class="statChart" id="theChart2"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="panel">
                        <div class="panel-heading panel-default">
                            <h3 class="panel-title">
                                @lang("Dashboard.registrations_by_ticket")
                            </h3>
                        </div>
                        <div class="panel-body">
                            <div class="chart-wrap">
                                <div style="height:200px;" class="statChart" id="pieChart"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-md-3 col-sm-6">
            <div class="panel panel-success ticket">
                <div class="panel-body">
                    <i class="ico ico-clock"></i>
                    @if($event->happening_now)
                        @lang("Dashboard.this_event_is_on_now")
                    @else
                        <span id="countdown"></span>
                    @endif
                </div>
            </div>
            <div class="panel panel-success hide">

                <div class="panel-heading">
                    <h3 class="panel-title">
                        <i class="ico-link mr5 ellipsis"></i>
                        @lang("Dashboard.quick_links")
                    </h3>
                </div>

                <div class="panel-body">

                    <a href="" class="btn-link btn">
                        @lang("Dashboard.edit_event_page_design") <i class="ico ico-arrow-right3"></i>
                    </a>
                    <a href="" class="btn-link btn">
                        @lang("Dashboard.create_tickets") <i class="ico ico-arrow-right3"></i>
                    </a>
                    <a href="" class="btn-link btn">
                        @lang("Dashboard.website_embed_code") <i class="ico ico-arrow-right3"></i>
                    </a>
                    <a href="" class="btn-link btn">
                        @lang("Dashboard.generate_affiliate_link") <i class="ico ico-arrow-right3"></i>
                    </a>
                    <a href="" class="btn-link btn">
                        @lang("Dashboard.edit_organiser_fees") <i class="ico ico-arrow-right3"></i>
                    </a>
                </div>

            </div>
        </div>
    </div>

    <script>

        var chartData = {!! $chartData  !!};
        var ticketData = {!! $ticketData  !!};



        new Morris.Donut({
            element: 'pieChart',
            data: ticketData,
        });

        new Morris.Line({
            element: 'theChart3',
            data: chartData,
            xkey: 'date',
            ykeys: ['sales_volume'],
            labels: ["@lang("Dashboard.sales_volume")"],
            xLabels: 'day',
            xLabelAngle: 30,
            yLabelFormat: function (x) {
                return '{!! $event->currency_symbol !!} ' + x;
            },
            xLabelFormat: function (x) {
                return formatDate(x);
            }
        });
        new Morris.Line({
            element: 'theChart2',
            data: chartData,
            xkey: 'date',
            //ykeys: ['views', 'unique_views'],
            //labels: ['Event Page Views', 'Unique views'],
            ykeys: ['views'],
            labels: ["@lang("Dashboard.event_views")"],
            xLabels: 'day',
            xLabelAngle: 30,
            xLabelFormat: function (x) {
                return formatDate(x);
            }
        });
        new Morris.Line({
            element: 'theChart',
            data: chartData,
            xkey: 'date',
            ykeys: ['tickets_sold'],
            labels: ["@lang("Dashboard.tickets_sold")"],
            xLabels: 'day',
            xLabelAngle: 30,
            lineColors: ['#0390b5', '#0066ff'],
            xLabelFormat: function (x) {
                return formatDate(x);
            }
        });
        function formatDate(x) {
            var m_names = <?=json_encode(array_filter(explode("|", trans("basic.months_short")))); ?>;
            var sup = "";
            var curr_date = x.getDate();

            <?php if(Lang::locale()=="en") { ?>
            if (curr_date == 1 || curr_date == 21 || curr_date == 31) {
                sup = "st";
            }
            else if (curr_date == 2 || curr_date == 22) {
                sup = "nd";
            }
            else if (curr_date == 3 || curr_date == 23) {
                sup = "rd";
            }
            else {
                sup = "th";
            }
            <?php } ?>

            return curr_date + sup + ' ' + m_names[x.getMonth() + 1];
        }

        var target_date = new Date("{{$event->start_date->format('M d, Y H:i')}} ").getTime();
        var now = new Date();
        var countdown = document.getElementById("countdown");
        if (target_date > now) {
            var days, hours, minutes, seconds;
            setCountdown();
            setInterval(function () {
                setCountdown();
            }, 30000);
            function setCountdown() {
                var current_date = new Date().getTime();
                var seconds_left = (target_date - current_date) / 1000;
                // do some time calculations
                days = parseInt(seconds_left / 86400);
                seconds_left = seconds_left % 86400;
                hours = parseInt(seconds_left / 3600);
                seconds_left = seconds_left % 3600;
                minutes = parseInt(seconds_left / 60);
                // format countdown string + set tag value
                countdown.innerHTML = (days > 0 ? '<b>' + days + "</b> @lang("basic.days")<b> " : '') + (hours > 0 ? hours + " </b>@lang("basic.hours")<b> " : '') + (minutes > 0 ? minutes + "</b> @lang("basic.minutes")" : '');
            }
        }

    </script>
@stop
