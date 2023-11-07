import { defineStore } from "pinia";
import { ref } from "vue";
import axios from "axios";
import { toastMessage } from "./toast";
import router from "../router";

export const usePersonsStore = defineStore("persons", {
  state: () => ({
    personsData: ref(null),
    personsFormModal: ref({
      id: null,
      Firstname: "",
      Lastname: "",
      Middle_Initial: "",
      Birthday: "",
      Gender: 1,
      Date_registered: new Date().toISOString().substr(0, 10),
    }),
    personsModalStatus: ref(false),
    personsErrors: ref([]),
    personsLoading: ref(false),
  }),
  getters: {
    data: (state) => state.personsData,
    formModal: (state) => state.personsFormModal,
    modalStatus: (state) => state.personsModalStatus,
    errors: (state) => state.personsErrors,
    loading: (state) => state.personsLoading,
  },
  actions: {
    // async getTokenSession() {
    //   this.personsLoading = true;
    //   await axios
    //     .get("/sanctum/csrf-cookie")
    //     .then((res) => {
    //       this.personsData = res.data.data;
    //       this.personsLoading = false;
    //       console.log(this.personsData, "persondata");
    //     })
    //     .catch((err) => {
    //       this.personsLoading = false;
    //     });
    // },

    async getPersons() {
      if (this.personsData == null) this.personsLoading = true;

      await axios
        .get("api/v1/Persons")
        .then((res) => {
          this.personsData = res.data.data;
          this.personsLoading = false;
        })
        .catch((err) => {
          this.personsLoading = false;
        });
    },

    async createPerson(data) {
      if (data.id != undefined) {
        await axios
          .put("api/v1/Persons/" + data.id, data)
          .then((res) => {
            toastMessage().success(res.data.message);
            console.log(res);
            this.getPersons();
            this.modalToggle();
          })
          .catch((err) => {
            this.personsErrors = err.response.data.errors;
            toastMessage().error(err.response.data.message);
          });
      } else {
        console.log(data);
        await axios
          .post("api/v1/Persons", data)
          .then((res) => {
            toastMessage().success("Created Successfully");
            this.getPersons();
            this.modalToggle();
            console.log(res);
          })
          .catch((err) => {
            this.personsErrors = err.response.data.errors;
            toastMessage().error(err.response.data.message);
          });
      }
    },

    async destoryPerson(data) {
      console.log(data);
      await axios
        .delete("api/v1/Persons/" + data.id)
        .then((res) => {
          this.getPersons();
          toastMessage().success(res.data.message);
        })
        .catch((err) => {
          console.log(err);
          toastMessage().error(err.response.data.message);
        });
    },

    reformattedDate(dateFormatted) {
      const monthMap = {
        Jan: "01",
        Feb: "02",
        Mar: "03",
        Apr: "04",
        May: "05",
        Jun: "06",
        Jul: "07",
        Aug: "08",
        Sep: "09",
        Oct: "10",
        Nov: "11",
        Dec: "12",
      };

      // Split the date string and extract the month, day, and year
      let parts = dateFormatted.match(/(\w+)\s(\d+)(\w+),\s(\d{4})/);

      if (parts) {
        let month = monthMap[parts[1]];
        let day = parts[2].padStart(2, "0");
        let year = parts[4];

        // Create a formatted date string in the format "yyyy/MM/dd"
        // So that the input type date can recognized it
        return `${year}-${month}-${day}`;
      } else {
        console.error("Invalid date format");
      }
    },

    resetInput() {
      this.personsFormModal.Firstname = "";
      this.personsFormModal.Lastname = "";
      this.personsFormModal.Middle_Initial = "";
      this.personsFormModal.Birthday = "";
      this.personsFormModal.Gender = 1;
      this.personsFormModal.Date_registered = new Date()
        .toISOString()
        .substr(0, 10);
    },

    async modalToggle(data) {
      this.personsModalStatus = !this.personsModalStatus;
      this.personsErrors = [];

      this.resetInput();

      if (data != undefined) {
        console.log(data);

        const birthday = data.Birthday;
        const date_registered = data.Date_registered;
        console.log(this.reformattedDate(date_registered), "date format");
        this.personsFormModal.id = data.id;
        this.personsFormModal.Firstname = data.Firstname;
        this.personsFormModal.Lastname = data.Lastname;
        this.personsFormModal.Middle_Initial = data.Middle_Initial;
        this.personsFormModal.Birthday = this.reformattedDate(data.Birthday);
        this.personsFormModal.Gender = data.Gender_id;
        this.personsFormModal.Date_registered = this.reformattedDate(
          data.Date_registered
        );
      }
    },
  },
});
