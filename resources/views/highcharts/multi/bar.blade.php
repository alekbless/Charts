<script type="text/javascript">
    $(function () {
        var {{ $model->id }} = new Highcharts.Chart({
            chart: {
                renderTo:  "{{ $model->id }}",
                @include('charts::_partials.dimension.js2')
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'column'
            },
            tooltip: {
                formatter: function() {
                    var tooltip = Highcharts.dateFormat('%d.%m.%Y - %H:%M:%S', this.x) + ' : ' + Highcharts.numberFormat((this.y),2,'.');
                    return tooltip;
                }
            },
            @if($model->title)
                title: {
                    text:  "{!! $model->title !!}"
                },
            @endif
            @if(!$model->credits)
                credits: {
                    enabled: false
                },
            @endif
            plotOptions: {
               column: {
                   pointPadding: 0.2,
                   borderWidth: 0
               }
           },
           /*xAxis: {
                categories: [
                    @foreach($model->labels as $label)
                         "{!! $label !!}",
                    @endforeach
                ],
            },*/
            xAxis: {
                type: 'datetime',
                title: {
                    text: "{!! $model->x_axis_title !!}"
                },
            },
            /*
            yAxis: {
                title: {
                    text: "{!! $model->y_axis_title === null ? $model->element_label : $model->y_axis_title !!}"
                },
            },*/

            yAxis: [{ // Primary yAxis
             labels: {
                 format: '{value} kWh',
             },
             title: {
                 text: 'kWh',
             }
            }, { // Secondary yAxis
             title: {
                 text: 'Temperatur',
             },
             labels: {
                 format: '{value} °C',

             },
             opposite: true
            }],
            legend: {
                @if(!$model->legend)
                    enabled: false,
                @endif
            },
            series: [
                @for ($i = 0; $i < count($model->datasets); $i++)
                    {
                        type: '{!! $model->datasets[$i]['type'] !!}',
                        name:  "{!! $model->datasets[$i]['label'] !!}",
                        @if($model->colors && count($model->colors) > $i)
                            color: "{{ $model->colors[$i] }}",
                        @endif
                        data: [
                            @foreach($model->datasets[$i]['values'] as $dta)
                                {{ $dta }},
                            @endforeach
                        ]
                    },
                @endfor
            ]
        })
    });
</script>

@if(!$model->customId)
    @include('charts::_partials.container.div')
@endif
