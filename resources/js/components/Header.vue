<template>
  <div class="container header">
    <h1 class="header__title">{{currentComponent}}</h1>
    <img src="../../img/logo.svg" alt class="logo">
  </div>
</template>

<script>
import { mapState } from "vuex";
export default {
  name: "Header",
  computed: {
    ...mapState(["currentComponent"])
  }
};
</script>
