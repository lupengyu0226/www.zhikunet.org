    <div id="main" style="width:100%;height:250px;"></div>
    <script type="text/javascript">
        // 基于准备好的dom，初始化echarts实例
        var myChart = echarts.init(document.getElementById('main'));
            option = {
                title: {
                    text: '<?php echo $pie_title ?>',
                    subtext: '仅供参考,准确数值请清理缓存后查看'
                },
                color: ['#3B4658'],
                tooltip : {
                    trigger: 'axis',
                    axisPointer : {            // 坐标轴指示器，坐标轴触发有效
                        type : 'shadow'        // 默认为直线，可选为：'line' | 'shadow'
                    },
                    formatter: function (params) {
                    var tar = params[0];
                    return tar.name + '<br/>' + tar.seriesName + ' : ' + tar.value;
                    }
                },
                grid: {
                    left: '3%',
                    right: '4%',
                    bottom: '3%',
                    containLabel: true
                },
                xAxis: {
                    type : 'category',
                    splitLine: {show:false},
                    data : ['<?php echo $name ?>']
                },
                yAxis: {
                    type : 'value'
                },
                series: [

                    {
                        name: '数据总量',
                        type: 'bar',
                        label: {
                            normal: {
                                show: true,
                                position: 'top'
                            }
                        },
                        data:[<?php echo $items ?>]
                    }
                ]
            };
        // 使用刚指定的配置项和数据显示图表。
        myChart.setOption(option);
    </script>