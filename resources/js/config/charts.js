import ApexCharts from 'apexcharts';

// Almacenar instancias de gráficos para evitar duplicados
let chartInstances = {
  signups: null,
  traffic: null
};

// --- Configuración del gráfico de Signups ---
const getSignupsChartOptions = () => {
  let signupsChartColors = {}

  if (document.documentElement.classList.contains('dark')) {
    signupsChartColors = {
      backgroundBarColors: ['#374151', '#374151', '#374151', '#374151', '#374151', '#374151', '#374151']
    };
  } else {
    signupsChartColors = {
      backgroundBarColors: ['#E5E7EB', '#E5E7EB', '#E5E7EB', '#E5E7EB', '#E5E7EB', '#E5E7EB', '#E5E7EB']
    };
  }

  return {
    series: [{
      name: 'Users',
      data: [1334, 2435, 1753, 1328, 1155, 1632, 1336]
    }],
    labels: ['01 Feb', '02 Feb', '03 Feb', '04 Feb', '05 Feb', '06 Feb', '07 Feb'],
    chart: {
      type: 'bar',
      height: '140px',
      foreColor: '#4B5563',
      fontFamily: 'Inter, sans-serif',
      toolbar: {
        show: false
      }
    },
    theme: {
      monochrome: {
        enabled: true,
        color: '#1A56DB'
      }
    },
    plotOptions: {
      bar: {
        columnWidth: '25%',
        borderRadius: 3,
        colors: {
          backgroundBarColors: signupsChartColors.backgroundBarColors,
          backgroundBarRadius: 3
        },
      },
      dataLabels: {
        hideOverflowingLabels: false
      }
    },
    xaxis: {
      floating: false,
      labels: {
        show: false
      },
      axisBorder: {
        show: false
      },
      axisTicks: {
        show: false
      },
    },
    tooltip: {
      shared: true,
      intersect: false,
      style: {
        fontSize: '14px',
        fontFamily: 'Inter, sans-serif'
      }
    },
    states: {
      hover: {
        filter: {
          type: 'darken',
          value: 0.8
        }
      }
    },
    fill: {
      opacity: 1
    },
    yaxis: {
      show: false
    },
    grid: {
      show: false
    },
    dataLabels: {
      enabled: false
    },
    legend: {
      show: false
    },
  };
}

// --- Configuración del gráfico de Traffic by Device ---
const getTrafficChannelsChartOptions = () => {
  let trafficChannelsChartColors = {}

  if (document.documentElement.classList.contains('dark')) {
    trafficChannelsChartColors = {
      strokeColor: '#1f2937'
    };
  } else {
    trafficChannelsChartColors = {
      strokeColor: '#ffffff'
    }
  }

  return {
    series: [70, 5, 25],
    labels: ['Desktop', 'Tablet', 'Phone'],
    colors: ['#16BDCA', '#FDBA8C', '#1A56DB'],
    chart: {
      type: 'donut',
      height: 400,
      fontFamily: 'Inter, sans-serif',
      toolbar: {
        show: false
      },
    },
    responsive: [{
      breakpoint: 430,
      options: {
        chart: {
          height: 300
        }
      }
    }],
    stroke: {
      colors: [trafficChannelsChartColors.strokeColor]
    },
    states: {
      hover: {
        filter: {
          type: 'darken',
          value: 0.9
        }
      }
    },
    tooltip: {
      shared: true,
      followCursor: false,
      fillSeriesColor: false,
      inverseOrder: true,
      style: {
        fontSize: '14px',
        fontFamily: 'Inter, sans-serif'
      },
      x: {
        show: true,
        formatter: function (_, { seriesIndex, w }) {
          const label = w.config.labels[seriesIndex];
          return label
        }
      },
      y: {
        formatter: function (value) {
          return value + '%';
        }
      }
    },
    grid: {
      show: false
    },
    dataLabels: {
      enabled: false
    },
    legend: {
      show: false
    },
  };
}

// --- Función para destruir gráficos existentes ---
function destroyCharts() {
  if (chartInstances.signups) {
    chartInstances.signups.destroy();
    chartInstances.signups = null;
  }
  if (chartInstances.traffic) {
    chartInstances.traffic.destroy();
    chartInstances.traffic = null;
  }
}

// --- Función Principal de Inicialización ---
function initializeAllCharts() {
  // Destruir gráficos existentes para evitar duplicados
  destroyCharts();

  // 1. Inicialización de week-signups-chart
  const signupsElement = document.getElementById('week-signups-chart');
  if (signupsElement) {
    chartInstances.signups = new ApexCharts(signupsElement, getSignupsChartOptions());
    chartInstances.signups.render();
  }

  // 2. Inicialización de traffic-by-device
  const trafficElement = document.getElementById('traffic-by-device');
  if (trafficElement) {
    chartInstances.traffic = new ApexCharts(trafficElement, getTrafficChannelsChartOptions());
    chartInstances.traffic.render();
  }
}

// --- Manejador de dark mode ---
function handleDarkModeToggle() {
  if (chartInstances.signups) {
    chartInstances.signups.updateOptions(getSignupsChartOptions());
  }
  if (chartInstances.traffic) {
    chartInstances.traffic.updateOptions(getTrafficChannelsChartOptions());
  }
}

// Evento de dark mode (solo una vez)
document.addEventListener('dark-mode', handleDarkModeToggle);

// --- Ejecución ---
// Ejecutar cuando el DOM esté listo
if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', initializeAllCharts);
} else {
  // DOM ya está listo, ejecutar inmediatamente
  initializeAllCharts();
}

// Ejecutar después de navegación Livewire
document.addEventListener('livewire:navigated', initializeAllCharts);

export { initializeAllCharts, getSignupsChartOptions, getTrafficChannelsChartOptions };