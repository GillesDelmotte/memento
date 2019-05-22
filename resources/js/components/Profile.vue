<template>
  <section class="profile" v-if="componentReady" id="profile">
    <label class="profile__img__empty" for="imageFile" v-if="currentUserImage === null">
      <div class="cross__first"></div>
      <div class="cross__second"></div>
    </label>
    <label for="imageFile" class="profile__img" v-else>
      <img :src="'./images/profile/' + currentUserImage.image_name" alt>
    </label>
    <input
      type="file"
      id="imageFile"
      accept="image/*"
      class="imageFile"
      v-on:change="onImageChange($event)"
    >
    <h2>{{currentUser.name}}</h2>
    <div class="card">
      <label for="gsm">Gsm</label>
      <input
        type="tel"
        :value="currentUser.gsm"
        name="gsm"
        id="gsm"
        @blur="updateProfile('gsm', 'text')"
      >
    </div>
    <div class="card">
      <label for="address">Adresse</label>
      <textarea name="address" id="address" rows="2" @blur="updateProfile('address', 'text')">{{currentUser.address}}</textarea>
    </div>
    <div class="card" @click="updatejobList">
      <span>Profession</span>
      <p v-if="currentUser.job !== null" class="job">{{currentUser.job.name}}</p>
      <p v-else class="job"></p>
    </div>
    <div class="job__list">
      <a class="closer" @click="updatejobList"></a>
      <div class="job__wrapper">
        <div class="filter">
          <input
            type="text"
            name="filter"
            id="filter"
            v-model="filter"
            autocomplete="off"
            placeholder="rechercher"
          >
        </div>
        <ul v-if="filteredJob.length !== 0">
          <li
            v-for="job in filteredJob"
            :key="job.id"
            v-hammer:swipe.horizontal="(event)=> onSwipe(event)"
          >
            <a href @click="updateJob($event, job, 'job_id', 'text')"></a>
            <p>{{job.name}}</p>
            <div class="pills">
              <div>
                <a href @click="openReport($event, job)"></a>
                <img src="../../img/warning.svg" alt>
              </div>
            </div>
            <i class="arrow"></i>
          </li>
        </ul>
        <div v-else>
          <p
            class="nojobs"
          >Si vous ne trouvez pas votre profession, écrivez le dans la barre de recherche et validez avec le bouton ci dessous</p>
          <button class="button" @click="createJob">Validez</button>
        </div>
      </div>
      <div class="report__wrapper close">
        <ul>
          <li v-for="report in reports" :key="report">
            <a href @click="reportJobLink($event, report)"></a>
            <p>{{report}}</p>
          </li>
          <li>
            <a href @click="back($event)"></a>
            <p>Retour</p>
          </li>
        </ul>
      </div>
    </div>
    <div class="card">
      <label for="description">Description</label>
      <textarea
        name="description"
        id="description"
        rows="5"
        @blur="updateProfile('description', 'text')"
      >{{currentUser.description}}</textarea>
    </div>
    <div class="checkboxes">
      <div class="input__label">
        <input
          type="checkbox"
          name="schedule"
          id="schedule"
          :value="currentUser.schedule"
          :checked="currentUser.schedule ? 'checked' : ''"
          v-on:change="updateProfile('schedule', 'check')"
        >
        <div class="allLabel">
          <label for="schedule" class="falseInput"></label>
          <label for="schedule" class="goodLabel">je veux pouvoir créer un agenda</label>
        </div>
      </div>
      <div class="input__label">
        <input
          type="checkbox"
          name="private"
          id="private"
          :value="currentUser.private"
          :checked="currentUser.private ? 'checked' : ''"
          v-on:change="updateProfile('private', 'check')"
        >
        <div class="allLabel">
          <label for="private" class="falseInput"></label>
          <label
            for="private"
            class="goodLabel"
          >Autoriser mon profil à être vu par les personnes que je consulte</label>
        </div>
      </div>
    </div>
  </section>
  <div v-else class="loader">plz wait...</div>
</template>
<script>
import store from "../store.js";
import { mapState } from "vuex";
import { mapMutations } from "vuex";
import router from "../router.js";

export default {
  name: "Profile",
  data() {
    return {
      componentReady: false,
      filter: "",
      reports: [
        "insulte",
        "faute d‘orthographe",
        "cette professsion n‘existe pas"
      ],
      reportJob: null,
      image: ""
    };
  },
  computed: {
    ...mapState(["currentUser", "currentUserImage", "allJob"]),
    filteredJob() {
      if (this.filter.length === 0) {
        return this.allJob;
      } else {
        return this.allJob.filter(job => {
          return job.name.toLowerCase().match(this.filter.toLowerCase());
        });
      }
    }
  },
  methods: {
    updateProfile(name, input) {
      if (input === "check") {
        var bool = document.getElementById(name).checked;
        var value = bool.toString();
      } else {
        var value = document.getElementById(name).value;
      }

      window.axios
        .post("/updateProfile", { column: name, value: value, input: input })
        .then(response => {})
        .catch(function(error) {
          console.log(error.response.data.message);
        });
    },
    updatejobList() {
      const job__list = document.querySelector(".job__list");

      if (job__list.classList.contains("open")) {
        job__list.classList.remove("open");
        document.querySelector(".job__wrapper").classList.remove("close");
        document.querySelector(".report__wrapper").classList.add("close");
        if (document.querySelector(".swiped")) {
          document.querySelector(".swiped").classList.remove("swiped");
        }
      } else {
        job__list.classList.add("open");
      }
    },
    updateJob(e, job, name, input) {
      e.preventDefault();
      e.stopPropagation();
      const job__list = document.querySelector(".job__list");
      job__list.classList.remove("open");
      document.querySelector(".job").textContent = job.name;
      window.axios
        .post("/updateProfile", {
          column: name,
          value: job.id,
          input: input
        })
        .then(response => {})
        .catch(function(error) {
          console.log(error.response.data.message);
        });
    },
    createJob() {
      const job = this.filter;
      window.axios
        .post("/addJob", {
          job: job,
          user: this.currentUser.id
        })
        .then(response => {
          this.$store.dispatch("setCurrentUser");
          const job__list = document.querySelector(".job__list");
          job__list.classList.remove("open");
        })
        .catch(function(error) {
          console.log(error.response.data.message);
        });
    },
    onSwipe(e) {
      if (e.direction === 2) {
        const item = document.querySelector(".swiped");
        if (item !== null) {
          item.classList.remove("swiped");
        }
        e.target.parentElement.classList.add("swiped");
      } else if (e.direction === 4) {
        e.target.parentElement.classList.remove("swiped");
      }
    },
    openReport(e, job) {
      e.preventDefault();
      e.stopPropagation();

      this.reportJob = job;

      document.querySelector(".job__wrapper").classList.add("close");
      document.querySelector(".report__wrapper").classList.remove("close");
    },
    reportJobLink(e, report) {
      e.preventDefault();
      e.stopPropagation();

      if (report === "insulte") {
        var message =
          "Il y a une insulte dans cet intitulé de profession / " +
          this.reportJob.name +
          " - id: " +
          this.reportJob.id;
      } else if (report === "faute d‘orthographe") {
        var message =
          "Il y a une faute dans cet intitulé de profession / " +
          this.reportJob.name +
          " - id: " +
          this.reportJob.id;
      } else if (report === "cette professsion n‘existe pas") {
        var message =
          "Cette profession n'existe pas / " +
          this.reportJob.name +
          " - id: " +
          this.reportJob.id;
      }

      const reportObject = {
        user_id: this.currentUser.id,
        type: "job",
        description: message
      };

      window.axios
        .post("/addReport", reportObject)
        .then(response => {
          document.querySelector(".job__wrapper").classList.remove("close");
          document.querySelector(".report__wrapper").classList.add("close");
          document.querySelector(".swiped").classList.remove("swiped");
        })
        .catch(function(error) {
          console.log(error.response.data.message);
        });
    },
    back(e) {
      e.preventDefault();
      e.stopPropagation();

      document.querySelector(".job__wrapper").classList.remove("close");
      document.querySelector(".report__wrapper").classList.add("close");
    },
    onImageChange(e) {
      let files = e.target.files || e.dataTransfer.files;
      if (!files.length) return;
      this.createImage(files[0]);
    },
    createImage(file) {
      let reader = new FileReader();
      let vm = this;
      reader.onload = e => {
        vm.image = e.target.result;
        this.uploadImage();
      };
      reader.readAsDataURL(file);
    },
    uploadImage() {
      window.axios
        .post("/image/store", { image: this.image })
        .then(response => {
          router.go();
        });
    }
  },
  beforeMount() {
    store.commit("setComponentDisplayed", "Profil");
  },
  mounted() {
    this.$store.dispatch("setCurrentUser").then(() => {
      this.$store.dispatch("setAllJob").then(() => {
        this.componentReady = true;
      });
    });
  }
};
</script>
