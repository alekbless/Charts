<script type="text/javascript">
    $(function () {
        var {{ $model->id }} = new Highcharts.Chart({
            chart: {
                renderTo: "{{ $model->id }}",
                @include('charts::_partials.dimension.js2')
                zoomType: 'x'
            },
            title: {
                text:''
            },
            tooltip: {
                formatter: function() {
                    var tooltip = Highcharts.dateFormat('%d.%m.%Y - %H:%M:%S', this.x) + ' : ' + Highcharts.numberFormat((this.y),2,'.') + ' ℃';
                    return tooltip;
                }
            },
            @if(!$model->credits)
                credits: {
                    enabled: false
                },
            @endif
            xAxis: {
                type: 'datetime'
            },
            yAxis: {
                tickInterval: 1,
                title: {
                    text: "{!! $model->y_axis_title === null ? $model->element_label : $model->y_axis_title !!}"
                },
                plotLines: [{
                    value: 0,
                    height: 0.5,
                    width: 1,
                    color: '#808080'
                }]
            },
            @if($model->colors)
                plotOptions: {
                    series: {
                        color: "{{ $model->colors[0] }}"
                    },
                },
            @endif
            legend: {
                @if(!$model->legend)
                    enabled: false,
                @endif
            },
            series: [{
                name: "{!! $model->element_label !!}",
                data: [
                    @foreach($model->values as $dta)
                        {{ $dta }},
                    @endforeach
                ]
            }]
        });
    });
</script>

@if(!$model->customId)
    @include('charts::_partials.container.div')
@endif
