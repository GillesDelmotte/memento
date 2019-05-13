<template>
  <div>
    <header-component></header-component>
    <router-view></router-view>
    <navigation></navigation>
  </div>
</template>

<script>
Vue.component("navigation", require("./Navigation.vue").default);
Vue.component("header-component", require("./Header.vue").default);
import router from "../router.js";

export default {
  name: "Home",
  props: {
    route: String
  }
};
</script>
