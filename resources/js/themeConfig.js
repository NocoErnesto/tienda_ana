// Theme Colors
// Initially this will be blank. Later on when app is initialized we will assign bootstrap colors to this from CSS variables.
export const $themeColors = {}

// App Breakpoints
// Initially this will be blank. Later on when app is initialized we will assign bootstrap breakpoints to this object from CSS variables.
export const $themeBreakpoints = {}

// const hoy = new Date();
// export const $fechaActual=MesActual(hoy, "dd-mm-yy HH:MM:SS.000000")

// APP CONFIG
export const $themeConfig = {
  app: {
    appName: 'MENU', // Will update name in navigation menu (Branding)
    // eslint-disable-next-line global-require
    appLogoImage: require('@/assets/images/logo/menu.png'), // Will update logo in navigation menu (Branding)
  },
  layout: {
    isRTL: false,
    skin: 'dark', // light, dark, bordered, semi-dark
    routerTransition: 'zoom-out', // zoom-fade, slide-fade, fade-bottom, fade, zoom-out, none
    type: 'vertical', // vertical, horizontal
    contentWidth: 'full', // full, boxed
    menu: {
      hidden: false,
      isCollapsed: true,
    },
    navbar: {
      // ? For horizontal menu, navbar type will work for navMenu type
      type: 'sticky', // static , sticky , floating, hidden
      backgroundColor: '', // BS color options [primary, success, etc]
    },
    footer: {
      type: 'static', // static, sticky, hidden
    },
    customizer: true,
    enableScrollToTop: true,
  },
}
// function MesActual(fecha, formato) {
//   const map = {
//     dd: fecha.getDate(),
//     mm: fecha.getMonth() + 1,
//     yy: fecha.getFullYear().toString().slice(-2),
//     yyyy: fecha.getFullYear(),
//     HH: fecha.getHours(),
//     MM: fecha.getMinutes(),
//     SS: fecha.getSeconds(),
//   };
//   // HH:MM:SS
//   return formato.replace(/dd|mm|yy|yyy|HH|MM|SS/gi, (matched) => map[matched]);
// }
