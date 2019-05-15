<template>
  <section id="admin">
    <div class="toogle__menu">
      <router-link :to="{name:'adminStat'}" active-class="active" class="toogle__item" exact>
        <span>Stats</span>
      </router-link>
      <router-link :to="{name:'adminReport'}" active-class="active" class="toogle__item" exact>
        <span>Report</span>
      </router-link>
    </div>
    <router-view></router-view>
  </section>
</template>

<script>
import store from "../store.js";
import { mapMutations } from "vuex";
export default {
  name: "Admin",
  beforeMount() {
    store.commit("setComponentDisplayed", "Admin");
  }
};
</script>

<style scoped>
</style>