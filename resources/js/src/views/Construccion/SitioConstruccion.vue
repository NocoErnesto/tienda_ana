<template>
  <!-- Error page-->
  <div class="misc-wrapper">
    <div class="misc-inner p-2 p-sm-3">
      <div class="w-100 text-center">
        <h2 class="mb-1">
          Pagina en Construicion
        </h2>
        <!-- image -->
        <b-img
          fluid
          :src="imgUrl"
          alt="Construicion"
        />
      </div>
    </div>
  </div>
<!-- / Error page-->
</template>

<script>
/* eslint-disable global-require */
import { BLink, BButton, BImg } from 'bootstrap-vue'
import VuexyLogo from '@core/layouts/components/Logo.vue'
import store from '@/store/index'

export default {
  components: {
    VuexyLogo,
    BLink,
    BButton,
    BImg,
  },
  data() {
    return {
      downImg: require('@/assets/images/pages/PaginaConstruccion.gif'),
    }
  },
  computed: {
    imgUrl() {
      if (store.state.appConfig.layout.skin === 'primary') {
        // eslint-disable-next-line vue/no-side-effects-in-computed-properties
        this.downImg = require('@/assets/images/pages/PaginaConstruccion.gif')
        return this.downImg
      }
      return this.downImg
    },
  },
}
</script>
<style lang="scss">
@import '@resources/scss/vue/pages/page-misc.scss';
</style>
