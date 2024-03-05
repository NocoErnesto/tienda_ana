<template >
 <div id="app"  >
     <dashboard ></dashboard>
 </div>
</template>
 
<script>
import { BCard, BCardText, BLink } from 'bootstrap-vue'
import Dashboard from './Dashboard.vue'
import RegisterV1 from './authentication/Register-v1.vue'
export default {
  components: {
    BCard,
    BCardText,
    BLink,
    Dashboard,
    RegisterV1
  },
}
</script>

<style>

</style>


