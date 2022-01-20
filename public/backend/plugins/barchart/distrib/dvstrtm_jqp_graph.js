/**
 * Devstratum JQP Graph
 *
 * @version         1.5
 * @author          Sergey Osipov <info@devstratum.ru>
 * @link            https://devstratum.ru
 * @copyright       Copyright © 2021 Sergey Osipov. All Rights Reserved
 * @license         MIT/X11 License
 * Report bugs      https://github.com/devstratum/Devstratum-JQP-Graph/issues
 */

;(function(factory) {
    if (typeof define === 'function' && define.amd) {
        define(['jquery'], factory);
    } else if (typeof exports !== 'undefined') {
        module.exports = factory(require('jquery'));
    } else {
        factory(jQuery);
    }
}(function($) {

    // default options
    let defGraph = {
        title: '',
        description: '',
        unit: '',
        better: '',
        type: 'number',
        separate: false,
        labels: true,
        grid_wmax: 0,
        grid_part: 5,
        points: [],
        graphs: []
    };

    // calcWidthPercent
    function calcWidthPercent(grid_wmax, val) {
        let percent = (val / grid_wmax) * 100;
        return percent.toFixed(4);
    }

    // calcValueSeconds
    function calcValueSeconds(val) {
        let seconds = 0;
        let time_array = val.split(':');
        time_array.reverse();

        // hours
        if (time_array[2]) {
            seconds = seconds + (Number(time_array[2]) * 3600);
        }
        // minutes
        if (time_array[1]) {
            seconds = seconds + (Number(time_array[1]) * 60);
        }
        // seconds
        if (time_array[0]) {
            seconds = seconds + Number(time_array[0]);
        }

        return seconds;
    }

    // calcValueTime
    function getValueTime(sec) {
        let time_string = '';
        let hours = Math.floor(sec / 60 / 60);
        let minutes = Math.floor(sec / 60) - (hours * 60);
        let seconds = sec % 60;

        function setDigit(num) {
            let output = num;
            if (num < 10) {
                output = '0' + num;
            }
            return output;
        }

        if (hours > 0) time_string += setDigit(hours) + ':';
        time_string += setDigit(minutes) + ':' + setDigit(seconds);

        return time_string;
    }

    // calcGridMax
    function calcGridMax(options) {
        let output = 0;

        if (options.grid_wmax && options.type === 'time') {
            options.grid_wmax = calcValueSeconds(options.grid_wmax);
        }

        if (options.grid_wmax && typeof options.grid_wmax === 'number') {
            output = options.grid_wmax;
        } else {
            let bufer_max = 0;
            if (typeof options.graphs === 'object') {
                options.graphs.forEach(function(item) {
                    item.value.forEach(function(val) {
                        // check type
                        if (options.type === 'time') {
                            val = calcValueSeconds(val);
                        }
                        if (val > bufer_max) {
                            bufer_max = val;
                        }
                    });
                });
            }

            if (bufer_max > 100) {
                output = Math.ceil(bufer_max / 100) * 100;
            } else {
                output = Math.ceil(bufer_max);
            }
        }

        return output;
    }

    // calcGridStep
    function calcGridStep(options, grid_wmax, grid_part) {
        let i = 0;
        let output = '';
        let offset = 100 / grid_part;
        let grid_step = Math.round(grid_wmax / grid_part);
        while (grid_part > i) {
            let percent = Math.floor(i * offset);
            let val = i * grid_step;

            if (options.type === 'time') {
                val = getValueTime(val);
                if (i === 0) val = 0;
            }

            output += '<div class="grid-line line-' + (i + 1) + '" style="left:' + percent + '%;"><span>' + val + '</span></div>';
            i++;
        }

        return output;
    }

    // getGrid
    function getGrid(options, grid_wmax, grid_part) {
        let output = '';
        output += '<div class="grid-line-crs"></div>';
        output += calcGridStep(options, grid_wmax, grid_part);

        if (options.type === 'time') {
            grid_wmax = getValueTime(grid_wmax);
        }

        output += '<div class="grid-line-end"><span>' + grid_wmax + '</span></div>';
        return output;
    }

    // getHeader
    function getHeader(options) {
        let output = '';

        output += '<div class="dvstrtm-graph__header">';
        output += '<div class="graph-header">';

        if (options.title) {
            output += '<div class="graph-header__title">' + options.title + '</div>';
        }

        output += '<div class="graph-header__info">';

        if (options.unit) {
            output += '<div class="info-unit">' + options.unit + '</div>';
        }

        let graph_points = getGraphPoints(options);

        if (graph_points) {
            output += '<div class="info-points">';
            output += graph_points;
            output += '</div>';
        }

        if (options.better) {
            output += '<div class="info-better">' + options.better + '</div>';
        }

        output += '</div>';

        if (options.description) {
            output += '<div class="graph-header__descr">' + options.description + '</div>';
        }

        output += '</div>';
        output += '</div>';

        return output;
    }

    // getGraphPoints
    function getGraphPoints(options) {
        let output = '';

        if (typeof options.points === 'object') {
            options.points.forEach(function(item) {
                let point_color = '';
                if (item.color) {
                    point_color = 'background:' + item.color + ';';
                }

                if (item.title) {
                    output += '<div class="info-point">';
                    output += '<div class="info-point__color"><span style="' + point_color + '"></span></div>';
                    output += '<div class="info-point__title">' + item.title + '</div>';
                    output += '</div>';
                }
            });
        }

        return output;
    }

    // getGraphItems
    function getGraphItem(options, grid_wmax) {
        let output = '';

        if (typeof options.graphs === 'object') {
            options.graphs.forEach(function(item) {
                output += '<div class="chart-block">';
                output += '<div class="chart-block__label"><span>' + item.label + '</span></div>';
                output += '<div class="chart-block__lines">';

                if (item.value) {
                    let index = 999;

                    item.value.forEach(function (val, i) {
                        let val_time;

                        // check type
                        if (options.type === 'time') {
                            val_time = val;
                            val = calcValueSeconds(val);
                        }

                        if (typeof val === 'number') {
                            let line_index = 'z-index:' + (index--) + ';';

                            let line_width = 'width:' + calcWidthPercent(grid_wmax, val) + '%;';

                            let line_color = '';
                            if (item.color) {
                                line_color = 'background:' + item.color[i] + ';';
                            }

                            let line_separate = 'position:absolute;';
                            if (options.separate) {
                                line_separate = 'position:relative;';
                            }

                            output += '<div class="chart-line" style="' + line_width + line_color + line_separate + line_index +'">';
                            // check type
                            if (options.type === 'time') {
                                output += '<span>' + val_time + '</span>';
                            } else {
                                output += '<span>' + val + '</span>';
                            }
                            output += '</div>';
                        }
                    });
                }

                output += '</div>';
                output += '</div>';
            });
        }

        return output;
    }

    // createGraph
    function createGraph(object, options) {
        let grid_wmax = calcGridMax(options);
        let grid_part = options.grid_part;
        if (grid_part > 6 && (grid_part % 2) !== 0) grid_part++;

        let graph_grid = getGrid(options, grid_wmax, grid_part);
        let graph_header = getHeader(options);
        let graph_item = getGraphItem(options, grid_wmax);

        let labels = '';
        if (!options.labels) labels = ' nolabels';
        let parts = '';
        if (grid_part > 6) parts = ' oddparts';
        let output = '';
        output += '<div class="dvstrtm-graph">';
        output += graph_header;

        if (grid_wmax) {
            output += '<div class="dvstrtm-graph__body">';
            output += '<div class="graph-body' + labels + '">';
            output += '<div class="graph-body__grid' + parts + '">' + graph_grid + '</div>';
            output += '<div class="graph-body__chart">' + graph_item + '</div>';
            output += '</div>';
            output += '</div>';
        }

        output += '</div>';
        object.append(output);
    }

    // methods dvstrtm_graph
    let methods = {
        init: function(options) {
            let _ = this;
            let newOptions = $.extend({}, defGraph, options);
            createGraph(_, newOptions);
        }
    };

    // dvstrtm_graph
    $.fn.dvstrtm_graph = function(method) {
        let _ = this;
        if (methods[method]) {
            return methods[method].apply(_, Array.prototype.slice.call(arguments, 1));
        } else if (typeof method === 'object' || !method) {
            return methods.init.apply(_, arguments);
        } else {
            $.error('dvstrtm_graph method: ' +  method + 'not found');
        }

        return true;
    };
}));