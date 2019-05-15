<template>
  <section id="adminReport" v-if="componentReady">
    <div class="noreport" v-if="reports.lenght === 0">
      <p>il n'y pas pas de report</p>
    </div>
    <div v-else>
      <ul class="list cards">
        <li class="list__item card" v-for="report in reports" :key="report.id">
          <div class="user__date">
            <span class="user">{{report.user.name}}</span>
            <span class="date">{{date(report.created_at)}}</span>
          </div>
          <div class="description">
            <p>{{description(report.description, 0)}}</p>
            <p>{{description(report.description, 1)}}</p>
          </div>
        </li>
      </ul>
    </div>
  </section>
  <section class="loader" v-else>plz wait...</section>
</template>

<script>
import store from "../store.js";
import { mapMutations } from "vuex";
export default {
  name: "AdminReport",
  data() {
    return {
      componentReady: false,
      reports: null
    };
  },
  methods: {
    date(date) {
      const splitDate = date.split(" ");

      return splitDate[0];
    },
    description(desc, number) {
      const splitDesc = desc.split("/");
      return splitDesc[number];
    }
  },
  mounted() {
    window.axios
      .post("/getReports")
      .then(response => {
        this.reports = response.data;
        this.componentReady = true;
      })
      .catch(error => console.error(error));
  }
};
</script>

<style scoped>
</style>