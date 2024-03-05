
<template>
    <div>
      <b-embed type="iframe" aspect="16by9" href="https://pweb.impuestos.gob.bo/Autenticacion/index.xhtml" sandbox="allow-same-origin allow-scripts" allowfullscreen/>
    </div>
  </template>
  
  <script>
  import { BEmbed } from 'bootstrap-vue'
  
  export default {
    components: {
      BEmbed,
    },
  }
  </script>
  
    