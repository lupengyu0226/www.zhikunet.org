    <div id="main" style="width:100%;height:300px;"></div>
    <script type="text/javascript">
        // 基于准备好的dom，初始化echarts实例
        var myChart = echarts.init(document.getElementById('main'));

        option = {
            title: {
                text: '<?php echo $localupload ?>'
            },
            tooltip : {
                trigger: 'axis',
                axisPointer : {            // 坐标轴指示器，坐标轴触发有效
                    type : 'shadow'        // 默认为直线，可选为：'line' | 'shadow'

                },
            },
            legend: {
                data:['内容发布']
            },
            toolbox: {
                show: true,
                feature: {
                    magicType: {type: ['line', 'bar']},
                    restore: {},
                }
            },
            xAxis:  {
                type: 'category',
                boundaryGap: false,
                data: ["<?php echo $days ?>"]
            },
            yAxis: {
                type: 'value',
                axisLabel: {
                    formatter: '{value}'
                }
            },
            series: [
                {
                    name:'内容发布',
                    type:'line',
                    layout: 'none',
                    color: ['#3B4658'],
                    data:[<?php echo $localnum ?>],
                    coordinateSystem: 'cartesian2d',
                    smooth: true,
                    label: {
                        normal: {
                            show: true,
                            formatter: '{c}'
                        }
                    },
                    markLine: {
                        data: [
                            {type: 'average', name: '平均值'}
                        ]
                    }
                },
               
            ]
        };
        myChart.setOption(option);
    </script>