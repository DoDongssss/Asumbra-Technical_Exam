<template>
  <div class="min-h-screen h-screen flex flex-col bg-gray-100 relative">
    <div class="bg-green-600 h-[5px]"></div>
    <div class="p-12 flex flex-col">
      <div class="flex h-[70px] items-center justify-between">
        <div class="relative flex items-center">
          <input
            v-model="search"
            type="text"
            class="w-[270px] rounded-md border border-gray-300 px-4 py-2 shadow-sm focus:outline-none focus:border-green-600"
            placeholder="Search"
          />
          <svg
            xmlns="http://www.w3.org/2000/svg"
            class="absolute right-4 h-5 w-5 fill-gray-500"
            viewBox="0 0 512 512"
          >
            <path
              d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z"
            />
          </svg>
        </div>
        <div>
          <button
            class="flex items-center justify-center rounded bg-green-600 px-4 py-2 font-semibold text-white transition-all hover:bg-green-700"
            @click="personsStore.modalToggle()"
          >
            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="mr-1 h-4 w-4 fill-white"
              viewBox="0 0 448 512"
            >
              <path
                d="M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32V224H48c-17.7 0-32 14.3-32 32s14.3 32 32 32H192V432c0 17.7 14.3 32 32 32s32-14.3 32-32V288H400c17.7 0 32-14.3 32-32s-14.3-32-32-32H256V80z"
              />
            </svg>
            Add
          </button>
        </div>
      </div>
      <div
        class="max-full w-full overflow-hidden overflow-y-auto overflow-x-hidden rounded-md border border-green-600 bg-white p-3 shadow-sm"
      >
        <el-table
          :data="filteredData"
          stripe
          style="width: 100%"
          max-height="450"
          v-loading="personsStore.personsLoading"
        >
          <el-table-column fixed sortable prop="Fullname" label="Fullname" />
          <el-table-column
            sortable
            prop="Birthday"
            label="Birthday"
            width="250"
          />
          <el-table-column sortable prop="Age" label="Age" width="150" />
          <el-table-column
            sortable
            prop="Gender"
            label="Gender"
            width="150px"
          />
          <el-table-column
            sortable
            prop="Date_registered"
            label="Registered At"
            width="150"
          />
          <el-table-column fixed="right" label="Operations" width="150">
            <template #default="scope">
              <el-button
                size="small"
                @click="personsStore.modalToggle(scope.row)"
                >Edit</el-button
              >
              <el-button
                size="small"
                type="danger"
                @click="deleteConfirmation(scope.row)"
                >Delete</el-button
              >
            </template>
          </el-table-column>
        </el-table>
      </div>
    </div>

    <!-- FOOTER -->
    <customFooter />
  </div>

  <!-- MODAL -->
  <el-dialog
    v-model="personsStore.personsModalStatus"
    title="Create Person"
    center
  >
    <div class="w-full h-full flex flex-col">
      <div class="flex gap-3">
        <div class="flex w-1/2 flex-col">
          <label for="">* Firstname</label>
          <input
            v-model="personsStore.personsFormModal.Firstname"
            type="text"
            class="mt-1 w-full rounded-md border border-gray-400 px-4 py-2 transition-[border] focus:border-[#3C2A21] focus:outline-none"
            required
          />
          <div
            v-if="personsStore.errors.Firstname"
            class="text-red-500 text-[12px]"
          >
            {{ personsStore.errors.Firstname[0] }}
          </div>
        </div>
        <div class="flex w-1/2 flex-col">
          <label for="">* Lastname</label>
          <input
            v-model="personsStore.personsFormModal.Lastname"
            type="text"
            class="mt-1 w-full rounded-md border border-gray-400 px-4 py-2 transition-[border] focus:border-[#3C2A21] focus:outline-none"
            required
          />
          <div
            v-if="personsStore.errors.Lastname"
            class="text-red-500 text-[12px]"
          >
            {{ personsStore.errors.Lastname[0] }}
          </div>
        </div>
        <div class="flex w-1/2 flex-col">
          <label for="">* Middle Initial</label>
          <input
            v-model="personsStore.personsFormModal.Middle_Initial"
            type="text"
            class="mt-1 w-full rounded-md border border-gray-400 px-4 py-2 transition-[border] focus:border-[#3C2A21] focus:outline-none"
            required
          />
          <div
            v-if="personsStore.errors.Middle_Initial"
            class="text-red-500 text-[12px]"
          >
            {{ personsStore.errors.Middle_Initial[0] }}
          </div>
        </div>
      </div>
      <div class="flex gap-3 mt-5">
        <div class="flex w-1/2 flex-col">
          <label for="">* Birthday</label>
          <input
            v-model="personsStore.personsFormModal.Birthday"
            type="date"
            class="mt-1 w-full rounded-md border border-gray-400 px-4 py-2 transition-[border] focus:border-[#3C2A21] focus:outline-none"
            required
          />
          <div
            v-if="personsStore.errors.Birthday"
            class="text-red-500 text-[12px]"
          >
            {{ personsStore.errors.Birthday[0] }}
          </div>
        </div>
        <div class="flex w-1/2 flex-col">
          <label for="">* Gender</label>
          <select
            v-model="personsStore.personsFormModal.Gender"
            class="mt-1 w-full rounded-md border border-gray-400 px-4 py-2 transition-[border] focus:border-[#3C2A21] focus:outline-none"
          >
            <option value="1">Male</option>
            <option value="2">Female</option>
            <option value="3">Others</option>
          </select>
          <div
            v-if="personsStore.errors.Gender"
            class="text-red-500 text-[12px]"
          >
            {{ personsStore.errors.Gender[0] }}
          </div>
        </div>
        <div class="flex w-1/2 flex-col">
          <label for="">* Date Registered</label>
          <input
            v-model="personsStore.personsFormModal.Date_registered"
            type="date"
            class="mt-1 w-full rounded-md border border-gray-400 px-4 py-2 transition-[border] focus:border-[#3C2A21] focus:outline-none"
            disabled
          />
          <div
            v-if="personsStore.errors.Date_registered"
            class="text-red-500 text-[12px]"
          >
            {{ personsStore.errors.Date_registered[0] }}
          </div>
        </div>
      </div>
      <div class="w-full flex items-end justify-end mt-5">
        <button
          type="button"
          @click="personsStore.createPerson(personsStore.personsFormModal)"
          class="rounded-md bg-green-600 px-4 py-2 font-semibold text-white transition-all hover:bg-green-700"
        >
          Create
        </button>
      </div>
    </div>
  </el-dialog>
</template>

<script>
import { ref } from "vue";
import { usePersonsStore } from "../stores/person";
import customFooter from "../components/footer.vue";
export default {
  components: {
    customFooter,
  },
  setup() {
    const personsStore = usePersonsStore();
    const search = ref("");
    const deleteConfirmation = (data) => {
      ElMessageBox.confirm(
        "Person data will permanently delete the file. Continue?",
        "Warning",
        {
          confirmButtonText: "OK",
          cancelButtonText: "Cancel",
          type: "warning",
          draggable: true,
        }
      )
        .then(() => {
          personsStore.destoryPerson(data);
        })
        .catch(() => {
          ElMessage({
            type: "info",
            message: "Delete canceled",
          });
        });
    };
    return {
      search,
      personsStore,
      deleteConfirmation,
    };
  },
  computed: {
    filteredData() {
      if (this.search != "") {
        return this.personsStore.personsData.filter((data) => {
          return (
            data.Fullname.toLowerCase().includes(this.search.toLowerCase()) ||
            data.Birthday.toLowerCase().includes(this.search) ||
            data.Gender.includes(this.search) ||
            data.Age.toString().includes(this.search) ||
            data.Date_registered.toLowerCase().includes(this.search)
          );
        });
      } else {
        return this.personsStore.personsData;
      }
    },
  },
  mounted() {
    // this.personsStore.getTokenSession();
    this.personsStore.getPersons();
  },
};
</script>

<style lang="scss" scoped></style>
