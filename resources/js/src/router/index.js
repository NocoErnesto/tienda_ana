import Vue from 'vue'
import VueRouter from 'vue-router'


Vue.use(VueRouter)

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  scrollBehavior() {
    return { x: 0, y: 0 }
  },
  routes: [
    // {
    //   path: '/',
    //   name: 'home',
    //   component: () => import('@/views/Home.vue'),
    //   meta: {
    //     pageTitle: 'Home',
    //     breadcrumb: [
    //       {
    //         text: 'Home',
    //         active: false,
    //         redirectIfLoggedIn: false,
    //       },
    //     ],
    //   },
    // },


    // Menu Punto de venta

    {

      path: '/',
      name: 'bienvenido',
      component: () => import('@/views/Bienvenida/Bienvenida.vue'),
      meta: {
        pageTitle: 'Inicio',

      },
    },


    //dashboart
    {
      path: '/Ganancia',
      name: 'ganancia',
      component: () => import('@/views/Grafico/Grafico.vue'),
      meta: {
        pageTitle: 'Dashboard',
        breadcrumb: [
          {
            text: 'Dashboard',
            active: true,
          },
        ],
        // lista_ventas
        resource: 'Auth',
        redirectIfLoggedIn: false,
      },
    },

    {
      path: '/dashboard_categoria',
      name: 'dashboard_categoria',
      component: () => import('@/views/Grafico/ProductoCategoria/ProductoCategoria.vue'),
      meta: {
        pageTitle: 'Dashboard',
        breadcrumb: [
          {
            text: 'Dashboard',
            active: true,
          },
        ],
        // lista_ventas
        resource: 'Auth',
        redirectIfLoggedIn: false,
      },
    },




    {
      path: '/Ventas',
      name: 'lista_ventas',
      component: () => import('@/views/FormularioRegistros/abm-Ventas/ListaVenta.vue'),
      meta: {
        pageTitle: 'Ventas',
        breadcrumb: [
          {
            text: 'Ventas',
            active: true,
          },
        ],
        redirectIfLoggedIn: false,
      },
    },


    {
      path: '/compras',
      name: 'lista_compra',
      component: () => import('@/views/FormularioRegistros/abm-Compras/ListaCompra.vue'),
      meta: {
        pageTitle: 'Compras',
        breadcrumb: [
          {
            text: 'Compras',
            active: true,
          },
        ],
        redirectIfLoggedIn: false,
      },
    },
    {
      path: '/proveeedores',
      name: 'listado_proveedores',
      component: () => import('@/views/FormularioRegistros/abm-Proveedor/ListaProveedor.vue'),
      meta: {
        pageTitle: 'Proveedores',
        breadcrumb: [
          {
            text: 'Proveedores',
            active: true,
          },
        ],
        redirectIfLoggedIn: false,
      },
    },


    {
      path: '/Caja',
      name: 'listado_transacciones',
      component: () => import('@/views/FormularioRegistros/abm-Caja/Caja.vue'),
      meta: {
        pageTitle: 'Transacciones',
        breadcrumb: [
          {
            text: 'Caja',
            active: false,
          },
        ],
        redirectIfLoggedIn: false,
      },
    },



    //no funciona el embevido
    {
      path: '/listado_unidad', 
      name: 'listado_unidad',
      component: () => import('@/views/FormularioRegistros/abm-Unidad/ListaUnidad.vue'),
      meta: {
        pageTitle: 'LiStado Unidades',
        breadcrumb: [
          {
            text: 'Unidades',
            active: false,
          },
        ],
        redirectIfLoggedIn: false,
      },
    },

    {
      path: '/listado_marca', 
      name: 'listado_marca',
      component: () => import('@/views/FormularioRegistros/abm-Marca/ListaMarca.vue'),
      meta: {
        pageTitle: 'LiStado Unidades',
        breadcrumb: [
          {
            text: 'Unidades',
            active: false,
          },
        ],
        redirectIfLoggedIn: false,
      },
    },
    {
      path: '/listado_categoria', 
      name: 'listado_categoria',
      component: () => import('@/views/FormularioRegistros/abm-Categoria/ListaCategoria.vue'),
      meta: {
        pageTitle: 'Litado Categoria',
        breadcrumb: [
          {
            text: 'Categorias',
            active: false,
          },
        ],
        redirectIfLoggedIn: false,
      },
    },

    {
      path: '/listado_cliente', 
      name: 'listado_cliente',
      component: () => import('@/views/FormularioRegistros/abm-Cliente/ListaCliente.vue'),
      meta: {
        pageTitle: 'Litado Cliente',
        breadcrumb: [
          {
            text: 'Cliente',
            active: false,
          },
        ],
        redirectIfLoggedIn: false,
      },
    },
    {
      path: '/listado_proveedor', 
      name: 'listado_proveedor',
      component: () => import('@/views/FormularioRegistros/abm-Proveedor/ListaProveedor.vue'),
      meta: {
        pageTitle: 'Litado Proveedor',
        breadcrumb: [
          {
            text: 'Proveedor',
            active: false,
          },
        ],
        redirectIfLoggedIn: false,
      },
    },


    
    {
      path: '/catalogo_productos', 
      name: 'catalogo_productos',
      component: () => import('@/views/FormularioRegistros/abm-Productos/frm_catalogo/frmCatalogoProducto.vue'),
      meta: {
        pageTitle: 'Catalogo',
        breadcrumb: [
          {
            text: 'Catalogo de Productos', 
            active: false,
          },
        ],
        redirectIfLoggedIn: false,
      },
    },




    {
      path: '/login',
      name: 'auth-login',
      component: () => import('@/views/Login.vue'),
      meta: {
        layout: 'full',
        redirectIfLoggedIn: false,
      },
    },
    {
      path: '/control-usuario',
      name: 'permisos',
      component: () => import('@/views/Users/PermisoUsuario.vue'),
      meta: {
        pageTitle: 'Permisos de Usuario',
        breadcrumb: [
          {
            text: 'Per',
            active: true,
          },
        ],
      },
    },
    {
      path: '/lista-Productos',
      name: 'lista-productos',
      component: () => import('@/views/FormularioRegistros/abm-Productos/ListaProducto.vue'),
      meta: {
        pageTitle: 'Listado de Productos',
        breadcrumb: [
          {
            text: 'Per',
            active: true,
          },
        ],
      },
    },


    {
      path: '/Bienvenido',
      name: 'bienvenido',
      component: () => import('@/views/Bienvenida/Bienvenida.vue'),
      meta: {

        redirectIfLoggedIn: true,
      },
    },
    {
      path: '/lista-usuarios',
      name: 'lista-usuarios',
      component: () => import('@/views/Users/ListaUsuarios.vue'),
      meta: {

        redirectIfLoggedIn: true,
      },
    },

  ],
})


function token() {
  try {
    if (localStorage.getItem("token")) {
      return 1

    } else {
      return 0
    }
  } catch (error) {
    return 0
  }
}

router.beforeEach((to, from, next) => {
  if (to.name !== 'auth-login' && !token()) {
    next({ name: 'auth-login' })

  }
  else {
    next()
  }
})

router.afterEach(() => {

  const appLoading = document.getElementById('loading-bg')
  if (appLoading) {
    appLoading.style.display = 'none'
  }
})

export default router
