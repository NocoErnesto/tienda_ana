import { $themeBreakpoints } from '@themeConfig'


export default {
  namespaced: true,
  state: {
    windowWidth: 0,
    shallShowOverlay: false,
    UsuarioId: "",
    idUtilitario: "",

    token: "",
    classButtonGuardar: "",
    classButtonModificar: "",
    perfilUsuario: 0,
    checkObjetivo: "",
    checkObMeta: false,
    verificaEmail: "",
    nombreArea: "",
    nombreUnidad: "",
    NombrePerfil: "",//es decir nombre del rol al que pertence el usaurio
    emailUsuario: "",


    // MigerenteDigital


    //DATOS EMPRESA
    NombreEmpresa: "",
    DireccionEmpresa: "",
    TelefonoEmpresa: "",
    NitEmpresa: "",
    LogoEmpresa: "",

    //OTRAS ACCIONES
    TipoAccion: "guardar", // Accion de botones 
    classButton: "",//Oculta 
    variant: 'success',
    botonIcono: 'SaveIcon',
    botonTexto: 'Guardar',
    isCrea: true,
    isEdita: true,
    isElimina: true,
    isVer: true,
    ExisteMonto: true,
    NombreUsuario: "",
    idRolSelecionado: ""

  },
  getters: {
    // obtiene el valor actual
    currentBreakPoint: state => {
      const { windowWidth } = state
      if (windowWidth >= $themeBreakpoints.xl) return 'xl'
      if (windowWidth >= $themeBreakpoints.lg) return 'lg'
      if (windowWidth >= $themeBreakpoints.md) return 'md'
      if (windowWidth >= $themeBreakpoints.sm) return 'sm'
      return 'xs'
    },
  },

  mutations: {
    // actualiza el valor

    UPDATE_WINDOW_WIDTH(state, val) {
      state.windowWidth = val
    },
    TOGGLE_OVERLAY(state, val) {
      state.shallShowOverlay = val !== undefined ? val : !state.shallShowOverlay
    },


    setidRolSelecionado(state, idrol) {
      state.idRolSelecionado = idrol
    },
    setTipoAccion(state, tipo) {
      state.TipoAccion = tipo;
    },
    // Propiedades de Stylo de Botones
    setbotonVariant(state, variant) {
      state.variant = variant;
    },
    setbotonIcono(state, icono) {
      state.botonIcono = icono;
    },
    setbotonTexto(state, texto) {
      state.botonTexto = texto;
    },
    setClassButton(state, Bclass) {
      state.classButton = Bclass;
    },
    //Porpiedades para Acceso A botones
    setbotonCrear(state, crear) {
      state.isCrea = crear;
    },
    setbotonEditar(state, editar) {
      state.isEdita = editar;
    },
    setbotonEliminar(state, eliminar) {
      state.isElimina = eliminar;
    },
    setbotonVer(state, ver) {
      state.isVer = ver;
    },

    setidUtilitario(state, id) {
      state.idUtilitario = id;
    },
    setExisteMonto(state, existe) {
      state.ExisteMonto = existe
    },

    setNombreEmpresa(state, NombreEmpresa) {
      state.NombreEmpresa = NombreEmpresa;
    },
    setDireccionEmpresa(state, DireccionEmpresa) {
      state.DireccionEmpresa = DireccionEmpresa;
    },
    setTelefonoEmpresa(state, TelefonoEmpresa) {
      state.TelefonoEmpresa = TelefonoEmpresa;
    },
    setLogoEmpresa(state, LogoEmpresa) {
      state.LogoEmpresa = LogoEmpresa;
    },
    setNitEmpresa(state, NitEmpresa) {
      state.NitEmpresa = NitEmpresa;
    },
  },
  actions: {
    // cambia el valor
    cambiarTipoAccion({ commit }, { tipo, variant, icono, texto, Bclass }) {

      commit("setTipoAccion", tipo);
      commit("setbotonVariant", variant);
      commit("setbotonIcono", icono);
      commit("setbotonTexto", texto);
      commit("setClassButton", Bclass)
    },
    permisoCrear({ commit }, crear) {
      commit("setbotonCrear", crear);
    },
    permisoEditar({ commit }, editar) {
      commit("setbotonEditar", editar);
    },
    permisoEliminar({ commit }, eliminar) {
      commit("setbotonEliminar", eliminar);
    },
    permisoVer({ commit }, { ver }) {
      commit("setbotonVer", ver);
    },
    cambiaId({ commit }, idUtilitario) {
      commit("setidUtilitario", idUtilitario);
    },
    cambiaExisteMonto({ commit }, existe) {
      commit("setExisteMonto", existe)
    },

    cambiaNombreEmpresa({ commit }, NombreEmpresa) {
      commit("setNombreEmpresa", NombreEmpresa);
    },

    cambiaDireccionEmpresa({ commit }, DireccionEmpresa) {
      commit("setDireccionEmpresa", DireccionEmpresa);
    },
    cambiaTelefonoEmpresa({ commit }, TelefonoEmpresa) {
      commit("setTelefonoEmpresa", TelefonoEmpresa);
    },
    cambiaLogoEmpresa({ commit }, LogoEmpresa) {
      commit("setLogoEmpresa", LogoEmpresa);
    },
    cambiaNitEmpresa({ commit }, NitEmpresa) {
      commit("setNitEmpresa", NitEmpresa);
    },
    cambia_idRolSelecionado({ commit }, idRolSelecionado) {
      commit("setidRolSelecionado", idRolSelecionado)
    }
  },
}
