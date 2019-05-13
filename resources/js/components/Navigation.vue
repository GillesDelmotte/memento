<template>
  <div class="nav">
    <router-link :to="{name:'schedule'}" active-class="active" class="nav-link nav__schedule" exact>
      <span>Horaire</span>
    </router-link>
    <router-link
      :to="{name:'practitionersFilter'}"
      active-class="active"
      class="nav-link nav__praticiens"
    >
      <span>Praticiens</span>
    </router-link>
    <router-link :to="{name:'meet'}" active-class="active" class="nav-link nav__meet" exact>
      <span>Meet</span>
    </router-link>
    <router-link :to="{name:'notif'}" active-class="active" class="nav-link nav__notif" exact>
      <span>Notif</span>
    </router-link>
    <router-link :to="{name:'menu'}" active-class="active" class="nav-link nav__menu" exact>
      <span>Menu</span>
    </router-link>
  </div>
</template>

<script>
export default {
  name: "Navigation"
};
</script>

<style scoped>
</style>