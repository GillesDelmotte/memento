<template>
  <section id="adminReport" v-if="componentReady">
    <div class="noreport" v-if="reports.length === 0">
      <p>Il n'y pas pas de report</p>
    </div>
    <div v-else>
      <ul class="list cards">
        <li class="list__item card" v-for="report in reports" :key="report.id">
          <div class="user__date">
            <span class="user">{{report.user.name}}</span>
            <span class="date">{{date(report.created_at)}}</span>
          </div>
          <div class="description">
            <p class="description__first">{{description(report.description, 0)}}</p>
            <p class="description__second">{{description(report.description, 1)}}</p>
          </div>
          <div class="pill delete">
            <a href @click="deleteReport($event, report.id)"></a>
            <div class="cross__first"></div>
            <div class="cross__second"></div>
          </div>
        </li>
      </ul>
    </div>
  </section>
  <div ref="loader" v-else class="loader"></div>
</template>

<script>
import { TimelineMax } from "gsap";
import store from "../store.js";
import { mapMutations } from "vuex";
export default {
  name: "AdminReport",
  data() {
    return {
      componentReady: false,
      reports: []
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
    },
    deleteReport(e, id) {
      e.preventDefault();
      e.stopPropagation();

      window.axios
        .post("/deleteReport", { id: id })
        .then(response => {
          window.axios
            .post("/getReports")
            .then(response => {
              this.reports = response.data;
              this.componentReady = true;
            })
            .catch(error => console.error(error));
        })
        .catch(function(error) {
          console.log(error.response.data.message);
        });
    }
  },
  mounted() {
    var { loader } = this.$refs;

    var timeline = new TimelineMax({
      repeat: -1,
      yoyo: true
    });
    timeline.to(loader, 1, { autoAlpha: 0.3 });
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