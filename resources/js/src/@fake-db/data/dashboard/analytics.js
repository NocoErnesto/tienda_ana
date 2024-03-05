import mock from '@/@fake-db/mock'
/* eslint-disable global-require */
const data = {
  congratulations: {
    name: 'Ernesto Noco',
    saleToday: '57.6',
  },
  subscribersGained: {
    series: [
      {
        name: 'Subscribers',
        data: [28, 40, 36, 52, 38, 60, 55],
      },
    ],
    analyticsData: {
      subscribers: 92600,
    },
  },
  //bajas acumuladas
  ordersRecevied: {
    series: [
      {
        name: 'Orders',
        data: [10, 15, 8, 15, 7, 12, 8],
      },
    ],
    analyticsData: {
      orders: 38400,
    },
  },

  //bajas acumuladas
  avgSessions: {
    sessions: 2700,
    lastDays: ['Last 28 Days', 'Last Month', 'Last Year'],
    growth: '+5.2%',
    goal: 100000,
    users: 100000,
    retention: 90,
    duration: 1,
    salesBar: {
      series: [
        {
          name: 'Sessions',
          data: [75, 125, 225, 175, 125, 75, 25],
        },
      ],
    },
  },
  // supportTracker: {
  //   title: 'HeadCount',
  //   lastDays: [
  //     'Enero',
  //     'Febrero',
  //     'Marzo',
  //     'Abril',
  //     'Mayo',
  //     'Junio',
  //     'Julio',
  //     'Agosto',
  //     'Septiembre',
  //     'Octubre',
  //     'Noviembre',
  //     'Diciembre'],
  //   totalTicket: 332,
  //   newTicket: 279,
  //   openTicket: 31,
  //   responseTime: 0,
  //   supportTrackerRadialBar: {
  //     series: [85],
  //   },
  // },
  revenue: {
    years: ['2020', '2019', '2018'],
    price: '25,852',
    budget: '56,800',
    revenueReport: {
      series: [
        {
          name: 'Altas',
          data: [95, 177, 284, 256, 105, 63, 168, 218, 72],
        },
        {
          name: 'Bajas',
          data: [-145, -80, -60, -180, -100, -60, -85, -75, -100],
        },
      ],
    },

    
    budgetChart: {
      series: [
        {
          name:'Altas',
          data: [95, 177, 284, 256, 105, 63, 168, 218, 72],
        },
        {
          name:'Baja',
          data: [-145, -80, -60, -180, -100, -60, -85, -75, -100],
        },
      ],
    },
  },
  timeline: {
    step1: {
      title: '12 Invoices have been paid',
      subtitle: 'Invoices have been paid to the company.',
      img: require('@/assets/images/icons/json.png'),
      fileName: 'data.json',
      duration: '12 min ago',
    },
    step2: {
      title: 'Client Meeting',
      subtitle: 'Project meeting with john @10:15am',
      avatar: require('@/assets/images/portrait/small/avatar-s-9.jpg'),
      avatarName: 'John Doe (Client)',
      occupation: 'CEO of Infibeam',
      duration: '45 min ago',
    },
    step3: {
      title: 'Create a new project for client',
      subtitle: 'Add files to new design folder',
      duration: '2 day ago',
      avatars: [
        { userImg: require('@/assets/images/portrait/small/avatar-s-9.jpg'), name: 'Billy Hopkins' },
        { userImg: require('@/assets/images/portrait/small/avatar-s-6.jpg'), name: 'Amy Carson' },
        { userImg: require('@/assets/images/portrait/small/avatar-s-8.jpg'), name: 'Brandon Miles' },
        { userImg: require('@/assets/images/portrait/small/avatar-s-7.jpg'), name: 'Daisy Weber' },
        { userImg: require('@/assets/images/portrait/small/avatar-s-20.jpg'), name: 'Jenny Looper' },
      ],
    },
    step4: {
      title: 'Create a new project for client',
      duration: '5 day ago',
      subtitle: 'Add files to new design folder',
    },
  },
  salesChart: {
    series: [
      {
        name: 'Sales',
        data: [90, 50, 86, 40, 100, 20],
      },
      {
        name: 'Visit',
        data: [70, 75, 70, 76, 20, 85],
      },
    ],
  },
  appDesign: {
    date: '03 Sep, 20',
    title: 'App design',
    subtitle: 'You can Find Only Post and Quotes Related to IOS like ipad app design, iphone app design',
    teams: [
      { name: 'Figma', color: 'light-warning' },
      { name: 'Wireframe', color: 'light-primary' },
    ],
    members: [
      { img: require('@/assets/images/portrait/small/avatar-s-9.jpg'), color: 'primary' },
      { text: 'PI', color: 'light-danger' },
      { img: require('@/assets/images/portrait/small/avatar-s-14.jpg'), color: 'primary' },
      { img: require('@/assets/images/portrait/small/avatar-s-7.jpg'), color: 'primary' },
      { text: 'AL', color: 'light-secondary' },
    ],
    planing: [
      { title: 'Due Date', subtitle: '12 Apr, 21' },
      { title: 'Budget', subtitle: '$49251.91' },
      { title: 'Cost', subtitle: '$840.99' },
    ],



    //Analitics
    statisticsItems: [
      {
        icon: 'TrendingUpIcon',
        color: 'light-primary',
        title: '230k',
        subtitle: 'Sales',
        customClass: 'mb-2 mb-xl-0',
      },
    ]
  },
}
/* eslint-disable global-require */
mock.onGet('/analytics/data').reply(() => [200, data])
