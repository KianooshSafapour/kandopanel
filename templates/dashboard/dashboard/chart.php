<div class="kt-row">
    <div class="column kt-col-xs-12 kt-col-md-12">
        <div class="dashboard-posts-box dashboard-tickets-box">
            <div class="dashboard-posts-title-holder">
                <i class="elegant-icon icon_piechart"></i>
                <h5 class="dashboard-posts-title"><?php _e("Chart", SAMYAR_TEXT_DOMAIN); ?></h5>
            </div>
            <div class="dashboard-posts-list">
                <div class="kt-row dashboard-boxs">
                    <div class="kt-row dashboard-boxs chart-box">
                        <div id="chart"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    jQuery(document).ready(function ($) {
        // درخواست Ajax برای دریافت داده‌ها
        $.ajax({
            url: kando_data.ajaxurl, // آدرس endpoint PHP
            type: 'GET',
            dataType: 'json',
            data: {
                action: 'get_user_orders_chart_data', // نام action در PHP
                nonce: kando_data.nonce, // ارسال nonce
            },
            beforeSend: function () {
                $(".chart-box").append("<span class='is-loading'><div class='samyar-form-loading' style='display: block;'></div></span>");
            },
            success: function (response) {
                if (response.status) {
                    $(".chart-box .is-loading").remove();

                    // آماده‌سازی داده‌ها برای ApexCharts
                    const labels = response.data.map(month => month.name); // برچسب‌ها (نام ماه‌ها)
                    const countData = response.data.map(month => month.data[0].count); // داده‌های تعداد فروش
                    const amountData = response.data.map(month => month.data[0].amount); // داده‌های مبلغ فروش

                    // تنظیمات ApexCharts
                    const options = {
                        chart: {
                            type: 'line', // نوع چارت (خطی)
                            height: 350, // ارتفاع چارت
                            toolbar: {
                                show: false // مخفی کردن toolbar
                            },
                            fontFamily: kando_data.language === 'fa_IR' ? 'IRANSans, Arial, sans-serif' : 'Arial, sans-serif' // فونت بر اساس زبان
                        },
                        series: [
                            {
                                name: kando_data.langs.number_purchases,
                                type: 'column', // نوع نمودار ستونی
                                data: countData // داده‌های تعداد فروش
                            },
                            {
                                name: kando_data.langs.purchase_amount,
                                type: 'line', // نوع نمودار خطی
                                data: amountData // داده‌های مبلغ فروش
                            }
                        ],
                        stroke: {
                            curve: 'smooth', // منحنی خطوط
                            width: [0, 5, 5] // عرض خطوط
                        },
                        plotOptions: {
                            bar: {
                                columnWidth: '18%', // عرض ستون‌ها
                                endingShape: 'rounded' // شکل انتهای ستون‌ها
                            }
                        },
                        fill: {
                            colors: ["#D1D7E1"], // رنگ‌های پر کردن
                            gradient: {
                                inverseColors: false,
                                shade: 'light',
                                type: 'vertical',
                                shadeIntensity: 0,
                                stops: [0, 100, 100, 100]
                            }
                        },
                        labels: labels, // برچسب‌ها (نام ماه‌ها)
                        markers: {
                            size: 0, // اندازه مارکرها
                            colors: ["#8ED557", "#89B0FA"] // رنگ مارکرها
                        },
                        xaxis: {
                            type: 'text', // نوع محور X
                            labels: {
                                style: {
                                    colors: ["#8E939B"], // رنگ برچسب‌ها
                                    fontSize: '11px', // اندازه فونت
                                    fontFamily: kando_data.language === 'fa_IR' ? 'IRANSans, Arial, sans-serif' : 'Arial, sans-serif', // فونت بر اساس زبان
                                    fontWeight: 400 // وزن فونت
                                }
                            },
                            axisBorder: {
                                show: false // مخفی کردن خط محور
                            },
                            axisTicks: {
                                show: false // مخفی کردن تیک‌ها
                            }
                        },
                        yaxis: [
                            {
                                type: 'numeric', // نوع محور Y
                                forceNiceScale: true,
                                floating: false,
                                title: {
                                    text: kando_data.langs.number_purchases // عنوان محور Y
                                },
                                labels: {
                                    formatter: function (val) {
                                        return parseInt(val); // فرمت‌دهی به مقادیر محور Y
                                    }
                                }
                            },
                            {
                                opposite: true, // نمایش محور Y در سمت مخالف
                                title: {
                                    text: kando_data.language === 'fa_IR' ? 'مبلغ فروش (تومان)' : 'Sales Amount (IRR)' // عنوان محور Y بر اساس زبان
                                },
                                axisTicks: {
                                    show: true // نمایش تیک‌ها
                                },
                                axisBorder: {
                                    show: false, // مخفی کردن خط محور
                                    color: '#8E939B' // رنگ خط محور
                                },
                                labels: {
                                    style: {
                                        colors: ["#8E939B"], // رنگ برچسب‌ها
                                        fontSize: '11px', // اندازه فونت
                                        fontFamily: kando_data.language === 'fa_IR' ? 'IRANSans, Arial, sans-serif' : 'Arial, sans-serif', // فونت بر اساس زبان
                                        fontWeight: 400 // وزن فونت
                                    },
                                    formatter: function (val) {
                                        if (kando_data.language === 'fa_IR') {
                                            return new Intl.NumberFormat('fa-IR', { maximumSignificantDigits: 3 }).format(val); // فرمت‌دهی به مقادیر محور Y برای فارسی
                                        } else {
                                            return new Intl.NumberFormat('en-US', { maximumSignificantDigits: 3 }).format(val); // فرمت‌دهی به مقادیر محور Y برای انگلیسی
                                        }
                                    }
                                }
                            }
                        ],
                        tooltip: {
                            enabled: true, // فعال کردن tooltip
                            style: {
                                fontSize: '14px', // اندازه فونت tooltip
                                fontFamily: kando_data.language === 'fa_IR' ? 'IRANSans, Arial, sans-serif' : 'Arial, sans-serif' // فونت tooltip بر اساس زبان
                            },
                            marker: {
                                show: false // مخفی کردن مارکر tooltip
                            },
                            x: {
                                show: false, // مخفی کردن محور X در tooltip
                                format: 'dd MMM', // فرمت تاریخ
                                formatter: undefined // فرمت‌دهنده سفارشی
                            }
                        },
                        states: {
                            hover: {
                                filter: {
                                    type: 'darken', // نوع فیلتر هنگام hover
                                    value: 0.35 // مقدار فیلتر
                                }
                            }
                        },
                        legend: {
                            show: true, // نمایش legend
                            position: 'top' // موقعیت legend
                        },
                        colors: ["#8ED557", "#89B0FA"], // رنگ‌های چارت (ستونی و خطی)
                        grid: {
                            show: false, // مخفی کردن grid
                            padding: {
                                top: 0,
                                right: 100,
                                bottom: 0,
                                left: 40
                            },
                            column: {
                                colors: ['transparent'] // رنگ ستون‌ها
                            }
                        }
                    };

                    // ایجاد چارت
                    const chart = new ApexCharts(document.querySelector("#chart"), options);
                    chart.render();
                } else {
                    console.error('خطا در دریافت داده‌ها:', response.message);
                    $(".chart-box .is-loading").remove();
                    $(".chart-box").append("<div class='dashboard-posts-list'><div class='alert alert-warning'>" + kando_data.langs.An_error_occurred + "</div></div>");
                }
            },
            error: function (xhr, status, error) {
                $(".chart-box .is-loading").remove();
                $(".chart-box").append("<div class='dashboard-posts-list'><div class='alert alert-warning'>" + kando_data.langs.An_error_occurred + "</div></div>");
            },
        });
    });
</script>

<style id="apexcharts-css">
    @keyframes opaque {
                               0% {
                                   opacity: 0
                               }

                               to {
                                   opacity: 1
                               }
                           }

    @keyframes resizeanim {

        0%,
        to {
            opacity: 0
        }
    }
    .apexcharts-legend{display:flex;overflow:auto;padding:0 10px;}
    .apexcharts-legend.apx-legend-position-top{flex-wrap:wrap;}
    .apexcharts-legend.apx-legend-position-top.apexcharts-align-center{justify-content:center;}
    .apexcharts-legend-series{cursor:pointer;line-height:normal;}
    .apexcharts-legend.apx-legend-position-top .apexcharts-legend-series{display:flex;align-items:center;}
    .apexcharts-legend-text{position:relative;font-size:14px;}
    .apexcharts-legend-marker{position:relative;display:inline-block;cursor:pointer;margin-right:3px;border-style:solid;}
    /*! CSS Used from: Embedded */
    .apexcharts-canvas{position:relative;user-select:none;}
    .apexcharts-canvas ::-webkit-scrollbar{-webkit-appearance:none;width:6px;}
    .apexcharts-canvas ::-webkit-scrollbar-thumb{border-radius:4px;background-color:rgba(0, 0, 0, .5);box-shadow:0 0 1px rgba(255, 255, 255, .5);-webkit-box-shadow:0 0 1px rgba(255, 255, 255, .5);}
    .apexcharts-inner{position:relative;}
    .apexcharts-text tspan{font-family:inherit;}
    .legend-mouseover-inactive circle{transition:.15s ease all;opacity:.2;}
    .apexcharts-legend-text{padding-left:15px;margin-left:-15px;}
    .apexcharts-tooltip{border-radius:5px;box-shadow:2px 2px 6px -4px #999;cursor:default;font-size:14px;left:62px;opacity:0;pointer-events:none;position:absolute;top:20px;display:flex;flex-direction:column;overflow:hidden;white-space:nowrap;z-index:12;transition:.15s ease all;}
    .apexcharts-tooltip.apexcharts-theme-light{border:1px solid #e3e3e3;background:rgba(255, 255, 255, .96);}
    .apexcharts-tooltip *{font-family:inherit;}
    .apexcharts-tooltip-text-goals-value,.apexcharts-tooltip-text-y-value,.apexcharts-tooltip-text-z-value{display:inline-block;margin-left:5px;font-weight:600;}
    .apexcharts-tooltip-text-goals-label:empty,.apexcharts-tooltip-text-goals-value:empty,.apexcharts-tooltip-text-y-label:empty,.apexcharts-tooltip-text-y-value:empty,.apexcharts-tooltip-text-z-value:empty{display:none;}
    .apexcharts-tooltip-text-goals-label,.apexcharts-tooltip-text-goals-value{padding:6px 0 5px;}
    .apexcharts-tooltip-goals-group,.apexcharts-tooltip-text-goals-label,.apexcharts-tooltip-text-goals-value{display:flex;}
    .apexcharts-tooltip-text-goals-label:not(:empty),.apexcharts-tooltip-text-goals-value:not(:empty){margin-top:-6px;}
    .apexcharts-tooltip-marker{width:12px;height:12px;position:relative;top:0;margin-right:10px;border-radius:50%;}
    .apexcharts-tooltip-series-group{padding:0 10px;display:none;text-align:left;justify-content:left;align-items:center;}
    .apexcharts-tooltip-series-group.apexcharts-active .apexcharts-tooltip-marker{opacity:1;}
    .apexcharts-tooltip-series-group.apexcharts-active,.apexcharts-tooltip-series-group:last-child{padding-bottom:4px;}
    .apexcharts-tooltip-y-group{padding:6px 0 5px;}
    .apexcharts-xaxistooltip,.apexcharts-yaxistooltip{opacity:0;pointer-events:none;color:#373d3f;font-size:13px;text-align:center;border-radius:2px;position:absolute;z-index:10;background:#eceff1;border:1px solid #90a4ae;}
    .apexcharts-xaxistooltip{padding:9px 10px;transition:.15s ease all;}
    .apexcharts-xaxistooltip:after,.apexcharts-xaxistooltip:before{left:50%;border:solid transparent;content:" ";height:0;width:0;position:absolute;pointer-events:none;}
    .apexcharts-xaxistooltip:after{border-color:transparent;border-width:6px;margin-left:-6px;}
    .apexcharts-xaxistooltip:before{border-color:transparent;border-width:7px;margin-left:-7px;}
    .apexcharts-xaxistooltip-bottom:after,.apexcharts-xaxistooltip-bottom:before{bottom:100%;}
    .apexcharts-xaxistooltip-bottom:after{border-bottom-color:#eceff1;}
    .apexcharts-xaxistooltip-bottom:before{border-bottom-color:#90a4ae;}
    .apexcharts-yaxistooltip{padding:4px 10px;}
    .apexcharts-yaxistooltip:after,.apexcharts-yaxistooltip:before{top:50%;border:solid transparent;content:" ";height:0;width:0;position:absolute;pointer-events:none;}
    .apexcharts-yaxistooltip:after{border-color:transparent;border-width:6px;margin-top:-6px;}
    .apexcharts-yaxistooltip:before{border-color:transparent;border-width:7px;margin-top:-7px;}
    .apexcharts-yaxistooltip-left:after,.apexcharts-yaxistooltip-left:before{left:100%;}
    .apexcharts-yaxistooltip-right:after,.apexcharts-yaxistooltip-right:before{right:100%;}
    .apexcharts-yaxistooltip-left:after{border-left-color:#eceff1;}
    .apexcharts-yaxistooltip-left:before{border-left-color:#90a4ae;}
    .apexcharts-yaxistooltip-right:after{border-right-color:#eceff1;}
    .apexcharts-yaxistooltip-right:before{border-right-color:#90a4ae;}
    .apexcharts-xcrosshairs,.apexcharts-ycrosshairs{pointer-events:none;opacity:0;transition:.15s ease all;}
    .apexcharts-ycrosshairs-hidden{opacity:0;}
    .apexcharts-selection-rect{cursor:move;}
    .apexcharts-svg.apexcharts-zoomable.hovering-zoom{cursor:crosshair;}
    .apexcharts-datalabels{cursor:default;pointer-events:none;}
    .apexcharts-gridline,.apexcharts-zoom-rect{pointer-events:none;}
    .apexcharts-marker{transition:.15s ease all;}
    .apexcharts-bar-goals-markers{pointer-events:none;}
</style>