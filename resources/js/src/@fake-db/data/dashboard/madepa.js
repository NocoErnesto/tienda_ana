import mock from '@/@fake-db/mock'
/* eslint-disable global-require */
const data = {
  congratulations: {
    name: 'Ernesto Noco',
    saleToday: '57.6',
  },
  statisticsItems: [
    {
      icon: 'TrendingUpIcon',
      color: 'light-primary',
      title: '230k',
      subtitle: 'Sales',
      customClass: 'mb-2 mb-xl-0',
    },
    {
      icon: 'UserIcon',
      color: 'light-info',
      title: '8.549k',
      subtitle: 'Customers',
      customClass: 'mb-2 mb-xl-0',
    },
    {
      icon: 'BoxIcon',
      color: 'light-danger',
      title: '1.423k',
      subtitle: 'Products',
      customClass: 'mb-2 mb-sm-0',
    },
    {
      icon: 'DollarSignIcon',
      color: 'light-success',
      title: '$9745',
      subtitle: 'Revenue',
      customClass: '',
    },
  ],
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
  supportTracker: {
    title: 'Support Tracker',
    lastDays: ['Last 28 Days', 'Last Month', 'Last Year'],
    totalTicket: 163,
    newTicket: 29,
    openTicket: 63,
    responseTime: 1,
    supportTrackerRadialBar: {
      series: [83],
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
  },
  statisticsOrder: {
    series: [
      {
        name: '2020',
        data: [45, 85, 65, 45, 65],
      },
    ],
  },
  statisticsProfit: {
    series: [
      {
        data: [0, 20, 5, 30, 15, 45],
      },
    ],
  },
  earningsChart: {
    series: [53, 16, 31],
  },
  revenue: {
    years: ['2020', '2019', '2018'],
    price: '25,852',
    budget: '56,800',
    revenueReport: {
      series: [
        {
          name: 'Earning',
          data: [95, 177, 284, 256, 105, 63, 168, 218, 72],
        },
        {
          name: 'Expense',
          data: [-145, -80, -60, -180, -100, -60, -85, -75, -100],
        },
      ],
    },
    budgetChart: {
      series: [
        {
          data: [61, 48, 69, 52, 60, 40, 79, 60, 59, 43, 62],
        },
        {
          data: [20, 10, 30, 15, 23, 0, 25, 15, 20, 5, 27],
        },
      ],
    },
  },
  companyTable: [
    {
      avatarImg: require('@/assets/images/icons/toolbox.svg'),
      title: 'Dixons',
      subtitle: 'meguc@ruj.io',
      avatarIcon: 'MonitorIcon',
      avatarColor: 'light-primary',
      avatarTitle: 'Technology',
      viewTitle: '23.4k',
      viewsub: 'in 24 hours',
      revenue: '891.2',
      sales: '68',
      loss: true,
    },
    {
      avatarImg: require('@/assets/images/icons/parachute.svg'),
      title: 'Motels',
      subtitle: 'vecav@hodzi.co.uk',
      avatarIcon: 'CoffeeIcon',
      avatarColor: 'light-success',
      avatarTitle: 'Grocery',
      viewTitle: '78k',
      viewsub: 'in 2 days',
      revenue: '668.51',
      sales: '97',
      loss: false,
    },
    {
      avatarImg: require('@/assets/images/icons/brush.svg'),
      title: 'Zipcar',
      subtitle: 'davcilse@is.gov',
      avatarIcon: 'WatchIcon',
      avatarColor: 'light-warning',
      avatarTitle: 'Fashion',
      viewTitle: '162',
      viewsub: 'in 5 days',
      revenue: '522.29',
      sales: '62',
      loss: false,
    },
    {
      avatarImg: require('@/assets/images/icons/star.svg'),
      title: 'Owning',
      subtitle: 'us@cuhil.gov',
      avatarIcon: 'MonitorIcon',
      avatarColor: 'light-primary',
      avatarTitle: 'Technology',
      viewTitle: '214',
      viewsub: 'in 24 hours',
      revenue: '291.01',
      sales: '88',
      loss: false,
    },
    {
      avatarImg: require('@/assets/images/icons/book.svg'),
      title: 'Cafés',
      subtitle: 'pudais@jife.com',
      avatarIcon: 'CoffeeIcon',
      avatarColor: 'light-success',
      avatarTitle: 'Grocery',
      viewTitle: '208',
      viewsub: 'in 1 week',
      revenue: '783.93',
      sales: '16',
      loss: true,
    },
    {
      avatarImg: require('@/assets/images/icons/rocket.svg'),
      title: 'Kmart',
      subtitle: 'bipri@cawiw.com',
      avatarIcon: 'WatchIcon',
      avatarColor: 'light-warning',
      avatarTitle: 'Fashion',
      viewTitle: '990',
      viewsub: 'in 1 month',
      revenue: '780.05',
      sales: '78',
      loss: false,
    },
    {
      avatarImg: require('@/assets/images/icons/speaker.svg'),
      title: 'Payers',
      subtitle: 'luk@izug.io',
      avatarIcon: 'WatchIcon',
      avatarColor: 'light-warning',
      avatarTitle: 'Fashion',
      viewTitle: '12.9k',
      viewsub: 'in 12 hours',
      revenue: '531.49',
      sales: '42',
      loss: false,
    },
  ],
  meetup: {
    mediaData: [
      { avatar: 'CalendarIcon', title: 'Sat, May 25, 2020', subtitle: '10:AM to 6:PM' },
      { avatar: 'MapPinIcon', title: 'Central Park', subtitle: 'Manhattan, New york City' },
    ],
    avatars: [
      { avatar: require('@/assets/images/portrait/small/avatar-s-9.jpg'), fullName: 'Billy Hopkins' },
      { avatar: require('@/assets/images/portrait/small/avatar-s-6.jpg'), fullName: 'Amy Carson' },
      { avatar: require('@/assets/images/portrait/small/avatar-s-8.jpg'), fullName: 'Brandon Miles' },
      { avatar: require('@/assets/images/portrait/small/avatar-s-7.jpg'), fullName: 'Daisy Weber' },
      { avatar: require('@/assets/images/portrait/small/avatar-s-20.jpg'), fullName: 'Jenny Looper' },
    ],
  },
  goalOverview: {
    completed: '786,617',
    inProgress: '13,561',
    series: [83],
  },
  transactionData: [
    {
      mode: 'Wallet',
      types: 'Starbucks',
      avatar: 'PocketIcon',
      avatarVariant: 'light-primary',
      payment: '-$74',
      deduction: true,
    },
    {
      mode: 'Bank Transfer',
      types: 'Add Money',
      avatar: 'CheckIcon',
      avatarVariant: 'light-success',
      payment: '+$480',
      deduction: false,
    },
    {
      mode: 'Paypal',
      types: 'Add Money',
      avatar: 'DollarSignIcon',
      avatarVariant: 'light-danger',
      payment: '+$480',
      deduction: false,
    },
    {
      mode: 'Mastercard',
      types: 'Ordered Food',
      avatar: 'CreditCardIcon',
      avatarVariant: 'light-warning',
      payment: '-$23',
      deduction: true,
    },
    {
      mode: 'Transfer',
      types: 'Refund',
      avatar: 'TrendingUpIcon',
      avatarVariant: 'light-info',
      payment: '+$98',
      deduction: false,
    },
  ],
}
/* eslint-disable global-require */
mock.onGet('/madepa/data').reply(() => [200, data])
