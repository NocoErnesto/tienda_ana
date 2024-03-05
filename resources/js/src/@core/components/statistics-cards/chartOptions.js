import { $themeColors } from '@themeConfig'

export const areaChartOptions = {
  grid: {
    show: false,
    padding: {
      left: 0,
      right: 0,
    },
  },
  chart: {
    toolbar: {
      show: false,
    },
    sparkline: {
      enabled: false,
    },
  },
  dataLabels: {
    enabled: false,
  },
  
  stroke: {
    curve: 'smooth',
    width: 2.5,
  },
  fill: {
    type: 'gradient',
    gradient: {
      shadeIntensity: 0.9,
      opacityFrom: 0.5,
      opacityTo: 0.2,
      stops: [0, 80, 100],
    },
  },
  xaxis: {
    type: 'Labels',
    lines: {
      show: false,
    },
    axisBorder: {
      show: false,
    },
    labels: { show: false },
  },
  yaxis: [
    {
      y: 0.2,
      offsetX: 2,
      offsetY: 2.2,
      padding: {
        left: 1,
        right: 2,
      },
    },
  ],
  tooltip: {
    x: { show: false },
  },
  theme: {
    monochrome: {
      enabled: false,
      color: $themeColors.primary,
      shadeTo: 'dark',
      shadeIntensity: 1,
    },
  },
}

export const lineChartOptions = {
  grid: {
    show: false,
    padding: {
      left: 2,
      right: 3,
    },
  },
  chart: {
    type: 'line',
    dropShadow: {
      enabled: false,
      top: 5,
      left: 0,
      blur: 4,
      opacity: 0.1,
    },
    toolbar: {
      show: false,
    },
    sparkline: {
      enabled: true,
    },
  },
  stroke: {
    width: 5,
    curve: 'smooth',
  },
  xaxis: {
    type: 'numeric',
  },
  colors: [$themeColors.primary],
  fill: {
    type: 'gradient',
    gradient: {
      shade: 'dark',
      gradientToColors: ['#A9A2F6'],
      shadeIntensity: 1,
      type: 'horizontal',
      opacityFrom: 1,
      opacityTo: 1,
      stops: [0, 100, 100, 100],
    },
  },
  markers: {
    size: 0,
    hover: {
      size: 5,
    },
  },
  tooltip: {
    x: { show: false },
  },
}
