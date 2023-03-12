<script setup>
import AppDateTimePicker from '@core/components/AppDateTimePicker.vue'

const date = ref('')
</script>

 

<template>
  <div style="margin-top: 5%">
    <div style="float: right;width: 45%;display: flex;justify-content: space-between;">
      <VRow justify="">
        <div style="width: 65%;display: flex;justify-content: space-between">
          <VSelect
            v-model="pageSize"
            :label="$t('row')"
            :items="pageSizes"
            :value="pageSize"
            variant="solo"
            style="width: 18%;"
          />
          <VSpacer />

          <VTextField
            v-model="search"
            type="text"

            style="width: 70%;"
          >
            {{ $t('Search') }}
          </VTextField>
        </div>
        <VSpacer />
        <VDialog
          v-model="dialog"

          width="1024"
        >
          <template #activator="{ props }">
            <VBtn
              v-bind="props"
            >
              Add maintenance
            </VBtn>
          </template>
          <VCard>
            <VCardTitle>
              <span class="text-h5">Add New maintenance</span>
            </VCardTitle>
            <VCardText>
              <VContainer>
                <VRow>
                  <VCol
                    cols="12"
                    sm="12"
                    md="12"
                  >
                    <VSelect
                      v-model="room_selected"
                      :items="roomeo"
                      item-title="rm_name"
                      item-value="id"
                      label="Room .No"
                    />
                  </VCol>
                  <VCol
                    cols="12"
                    sm="6"
                    md="6"
                  >
                    <VTextField

                      label="room type Name"
                      persistent-placeholder
                      type="text"
                    />
                  </VCol>
                  <VCol
                    cols="12"
                    sm="6"
                    md="6"
                  >
                    <VTextField

                      label="floor Name"
                      persistent-placeholder
                      type="text"
                    />
                  </VCol>

                  <VCol
                    cols="12"
                    sm="6"
                    md="6"
                  >
                    <VTextarea
                      cols="12"
                      sm="6"
                      md="6"
                      label="Auto Grow"
                      persistent-placeholder
                      auto-grow
                    />
                  </VCol>

                  <VCol
                    cols="12"
                    sm="6"
                    md="6"
                  >
                    <VSelect
                      v-model="status_data"
                      :items="statuses"
                      item-title="rm_type_name"
                      item-value="id"
                      label="status"
                    />

                    <br>



                    <VTextField
                      cols="6"
                      sm="3"
                      md="3"
                      label="Date & time"
                      type="datetime-local"
                    />

                  </VCol>
                </VRow>
              </VContainer>
            </VCardText>
            <VCardActions>
              <VSpacer />
              <VBtn
                color="blue-darken-1"
                variant="text"
                @click="dialog = false"
              >
                Close
              </VBtn>
              <VBtn
                color="blue-darken-1"
                variant="text"
                @click="Add"
              >
                Submit
              </VBtn>
            </VCardActions>
          </VCard>
        </VDialog>
      </VRow>
    </div>


    <div style="float: left;width: 14%;display: flex;justify-content: space-between">
      <VBtn
        class="btn"
        @click="exportExecl"
      >
        {{ $t('export') }}
      </VBtn>
      <VBtn
        class="btn"
        @click="Downpdf"
      >
        {{ $t('PDF') }}
      </VBtn>
    </div>

    <br>
    <br>
    <br>

    <VTable style="table-layout: fixed">
      <thead>
        <tr>
          <th class="text-left">
            {{ $t('Num') }}
          </th>
          <th

            class="text-left"
          >
            room_name
          </th>

          <th

            class="text-left"
          >
            room_type_name
          </th>
          <th

            class="text-left"
          >
            floor_name
          </th>

          <th class="text-left">
            maintenance_type_id
          </th>
          <th class="text-left">
            description
          </th>
          <th class="text-left">
            main_status
          </th>
          <th class="text-left">
            exp_ready_date
          </th>
          <th class="text-left">
            {{ $t('Delete') }}
          </th>
          <th class="text-left">
            {{ $t('Update') }}
          </th>
        </tr>
      </thead>


      <tbody>
        <tr
          v-for="(item , index) in Maintenance"
          :key="item.id"
          style="text-align: left"
        >
          <td> {{ ++index }}</td>


          <td>
            {{ item.room.rm_name_en }}
          </td>
          <td>
            {{ item.room.room_type.rm_type_name }}
          </td>
          <td>
            {{ item.room.floors.floor_name }}
          </td>



          <td>{{ item.maintenance_type.name }}</td>
          <td>{{ item.description }}</td>
          <td>{{ item.exp_ready_date }}</td>

          <td>
            <VChip
              v-if="item.main_status == 1"
              class="ma-2"
              style="color:mediumpurple;"
            >
              <VIcon
                start
                icon="mdi-account-circle-outline"
              />
              active
            </VChip>
            <VChip
              v-else="item.room_active == 0"
              class="ma-2"
              style="color:red;"
            >
              <VIcon
                start
                icon="mdi-account-circle-outline"
              />
              not active
            </VChip>
          </td>
          <td style="table-layout: fixed ">
            <VBtn
              color="primary"
              @click="Delete(item.room_id)"
            >
              <VIcon icon="mdi-delete" />
            </VBtn>
          </td>
          <td>
            <VBtn
              color="primary"
            >
              <VRow>
                <VDialog
                  v-model="item.dialog3"
                  width="1024"
                >
                  <template #activator="{ props }">
                    <VBtn
                      v-bind="props"
                      @click="Updates(item)"
                    >
                      <VIcon icon="mdi-file-edit-outline" />
                    </VBtn>
                  </template>
                  <VCard>
                    <VCardTitle>
                      <span class="text-h5">Update User Profile</span>
                    </VCardTitle>
                    <VCardText>
                      <VContainer>
                        <VRow>
                          <VCol
                            cols="12"
                            sm="6"
                            md="6"
                          >
                            <VTextField
                              v-model="room_name_edit"
                              label="Room Name"
                            />
                          </VCol>
                          <VCol
                            cols="12"
                            sm="6"
                            md="6"
                          >
                            <VTextField
                              v-model="room_name_loc_edit"
                              label="Room Name Loc"
                            />
                          </VCol>
                          <VCol
                            cols="12"
                            sm="6"
                            md="6"
                          >
                            <VTextField
                              v-model="room_max_pax_edit"
                              label="Room max pax"
                              type="text"
                            />
                          </VCol>
                          <VCol
                            cols="12"
                            sm="6"
                            md="6"
                          >
                            <VTextField
                              v-model="room_phone_no_edit"
                              label="Room Phone No"
                              persistent-hint
                              type="number"
                            />
                          </VCol>
                          <VCol
                            cols="12"
                            sm="6"
                            md="6"
                          >
                            <VTextField
                              v-model="room_phone_ext_edit"
                              label="Room Phone Ext"
                              type="number"
                            />
                          </VCol>
                          <VCol
                            cols="12"
                            sm="6"
                            md="6"
                          >
                            <VTextField
                              v-model="room_key_code_edit"
                              label="Room Key Code"
                              persistent-hint
                              type="number"
                            />
                          </VCol>

                          <VCol
                            cols="12"
                            sm="6"
                            md="6"
                          >
                            <VTextField
                              v-model="room_sort_edit"
                              label="sort order"
                              persistent-hint
                              type="number"
                            />
                          </VCol>


                          <VCol
                            cols="12"
                            sm="6"
                          >
                            <VSelect
                              v-model="room_type_select_edit"
                              :items="roomType"
                              item-title="rm_type_name"
                              item-value="id"
                              label="Room Type"
                            />
                          </VCol>
                          <VCol
                            cols="12"
                            sm="6"
                          >
                            <VSelect

                              label="Floor Type"
                            />
                          </VCol>
                          <VCol
                            cols="12"
                            sm="6"
                            md="6"
                          >
                            <VTextField
                              v-model="room_key_options_edit"
                              label="Room Key Options"
                              persistent-hint
                              type="number"
                            />
                          </VCol>

                          <VCol
                            cols="12"
                            sm="6"
                            md="6"
                          >
                            <VCheckbox
                              v-model="room_active_edit"
                              :label="`room active edit: ${room_active_edit.toString()}`"
                            />
                          </VCol>



                          <VCol
                            cols="12"
                            sm="6"
                            md="6"
                          >
                            <VCheckbox
                              v-model="room_connection_edit"
                              :label="`room connection edit: ${room_connection.toString()}`"
                            />
                          </VCol>
                        </VRow>
                      </VContainer>
                    </VCardText>
                    <VCardActions>
                      <VSpacer />
                      <VBtn
                        color="blue-darken-1"
                        variant="text"
                        @click="dialog3 = false"
                      >
                        Close
                      </VBtn>
                      <VBtn
                        color="blue-darken-1"
                        variant="text"
                        @click="updateUser"
                      >
                        Update
                      </VBtn>
                    </VCardActions>
                  </VCard>
                </VDialog>
              </VRow>
            </VBtn>
          </td>
        </tr>
      </tbody>
      <br> <caption>{{ $t('List Of Data') }}( {{ count }} )</caption>
    </VTable>
    <div style="float: right">
      <VPagination
        v-if="pageInfo"
        v-model="pageInfo.current_page"
        :length="Math.ceil(pageInfo.total / pageSize)"
        total-visible="7"
        :size="43"
        :next="pageInfo.next_page_url"
        :per-page="pageInfo.per_page"
        @click="nextPage(pageInfo.per_page, pageInfo.current_page)"
      />
    </div>
  </div>
</template>

<script>
import axios from "axios"

export default {
  name: "MaintenanceTable",

  // eslint-disable-next-line vue/component-api-style
  data(){
    return {
      search:'',
      dialog: false,
      dialog3: false,
      Maintenance:[],
      itemid: '',
      itemid_edit: '',
      room_id: '',

      room_id_edit: '',
      room_name_edit: '',
      room_name_loc_edit: '',
      room_max_pax_edit: '',
      room_phone_no_edit: '',
      room_phone_ext_edit: '',
      room_key_code_edit: '',
      room_connection_edit: '',
      room_status_edit: '',
      room_hk_status_edit: '',
      room_sort_edit: '',
      room_type_select_edit: '',
      room_key_options_edit: '',
      room_active_edit: '',

      room_name_en: '',
      room_name_loc  : '',
      room_max_pax  : '',
      room_phone_no  : '',
      room_phone_ext  : '',
      room_key_code : ref('')  ,
      room_key_options : ref('') ,
      room_connection  : true,
      fo_status  : 'VA',
      room_active  : true,
      hk_stauts  : 'CL',
      sort_order  : '',
      roomType_selected:'',
      room_selected:'',
      roomfloor_selected:'',


      maintenancetype :[],

      roomeo :[],

      roomType :[],
      status_data:'',
      statuses :['pending','finished','closed'],

      floorsType: [],


      count:0,
      perPage:10,
      pagi:[],
      page:2,
      pageInfo:null,
      totalPages: 4,
      pageSize: 5,
      pageSizes: [5, 10, 15,20,25,30],

    }
  },

  // eslint-disable-next-line vue/component-api-style
  computed:{
    filterData(){
      return  this.pagi.filter(user => user.rm_name_en.includes(this.search))
    },
  },

  // eslint-disable-next-line vue/component-api-style
  watch: {
    pageSize() {
      this.getAllPaginate()
    },
  },

  // eslint-disable-next-line vue/component-api-style
  mounted() {
    this.getAllData()
    this.getFloors()
    this.getRooms()
    this.getRoomsTypes()
    this.getAllPaginate()
    this.getmaintenancetype()
  },

  // eslint-disable-next-line vue/component-api-style
  methods:{
    async getAllPaginate(){
      // console.log(this.pageSize)
      axios
        .get(`api/roomPagination/${this.pageSize}`)
        .then(response => {
          if (response.status == 200){
            (this.pagi = response.data.data,
            this.pageInfo = response.data.pagination
            )

            // console.log(this.pagi)
            // console.log(this.pageInfo)
          }
        })

    },

    nextPage(page, query) {
      console.log('nextPage', page, query)
      axios
        .get(`api/roomPagination/${page}?page=${query}`)
        .then(response => {
          if (response.status == 200){
            (this.pagi = response.data.data,
            this.pageInfo = response.data.pagination
            )

            // console.log(this.pagi)
            // console.log(this.pageInfo)
          }
        })
    },
    insertAlert() {
      const Toast = this.$swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: toast => {
          toast.addEventListener('mouseenter', this.$swal.stopTimer)
          toast.addEventListener('mouseleave', this.$swal.resumeTimer)
        },
      })

      Toast.fire({
        icon: 'success',
        title: 'Data Added successfully',
        color: 'green',
        timer: 5000,
      })
    },
    DeleteAlert() {

      this.$swal.fire({
        icon: 'error',
        title: 'Do you want to Delete',
        showDenyButton: true,
        showCancelButton: true,
        showConfirmButton:false,
        denyButtonText: `Deleted`,
      }).then(result => {

        if (result.isDenied) {
          this.deleteData()

          const Toast = this.$swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: toast => {
              toast.addEventListener('mouseenter', this.$swal.stopTimer)
              toast.addEventListener('mouseleave', this.$swal.resumeTimer)
            },
          })

          Toast.fire({
            icon: 'success',
            title: `Data ${this.room_name_en} Deleted successfully`,
            color: 'red',
            timer: 10000,
          })
        }
      })
    },
    UpdateAlert() {
      const Toast = this.$swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: toast => {
          toast.addEventListener('mouseenter', this.$swal.stopTimer)
          toast.addEventListener('mouseleave', this.$swal.resumeTimer)
        },
      })

      Toast.fire({
        icon: 'info',
        title: 'updateed is successfully',
        color: 'mediumpurple',
        timer: 5000,
      })
    },

    getAllData(){
      axios
        .get('api/maintenance')

        .then(response =>(this.Maintenance = response.data.data))
    },

    exportExecl(){
      const XLSX = xlsx
      const workbook = XLSX.utils.book_new()
      const worksheet = XLSX.utils.aoa_to_sheet(this.framework1)

      XLSX.utils.book_append_sheet(workbook, worksheet, "framework")
      XLSX.writeFile(workbook,"users.xlsx")
    },

    Downpdf(){
      let docDefinition = {
        content: [
          {
            layout: 'lightHorizontalLines',
            table: {
              headerRows: 1,
              widths: [ '*', "auto",100,"*"],

              body:  this.framework1,

            },
          },
        ],
      }

      // pdfMake.createPdf(docDefinition).open()
      pdfMake.createPdf(docDefinition).download()

      // pdfMake.createPdf(docDefinition).print()

    },

    async  Add(){

      try {
        const user = await axios.post(
          "api/rooms",
          {
            room_id: this.room_selected,
            room_type_id: this.roomType_selected,
            room_name_en: this.room_name_en,
            room_name_loc: this.room_name_loc,
            room_max_pax: this.room_max_pax,
            room_phone_no: this.room_phone_no,
            room_phone_ext: this.room_phone_ext,
            room_connection: this.room_connection,
            fo_status: this.fo_status,
            room_active: this.room_active,
            room_key_options: this.room_key_options,
            room_key_code: this.room_key_options,
            hk_stauts: this.hk_stauts,
            sort_order: this.sort_order,
            floor_id:1,
          },
        )

        this.room_name_en= ''
        this.room_name_loc  = ''
        this.room_max_pax  = ''
        this.room_phone_no  =''
        this.room_phone_ext  = ''
        this.room_key_code = ref('')
        this.room_key_options = ref('')
        this.room_connection  = true
        this.room_active  = true
        this.sort_order  = ''
        this.roomType_selected=''
        this.room_selected=''

        this.roomfloor_selected=''

        this.getAllData()
        this.dialog = false
        this.insertAlert()
      } catch(e) {
        console.log(e)
      }
    },

    async  Delete(GetId){
      this.itemid = GetId
      this.DeleteAlert()
    },

    deleteData(){
      axios
        .delete(`api/maintenance/${this.itemid}`)
        .then(response => (this.Maintenance = response.data))
      this.getAllData()
    },

    async  Updates(Getdata){


      this.itemid = Getdata

      this.room_id_edit= Getdata.room_id,
      this.room_name_edit= Getdata.room_name_en,
      this.room_name_loc_edit= Getdata.room_name_loc,
      this.room_max_pax_edit= Getdata.room_max_pax,
      this.room_phone_no_edit= Getdata.room_phone_no,
      this.room_phone_ext_edit= Getdata.room_phone_ext,
      this.room_key_code_edit= Getdata.room_key_code,
      this.room_connection_edit= Getdata.room_connection==0?false:true,
      this.room_status_edit= Getdata.fo_status,
      this.room_hk_status_edit= Getdata.hk_stauts,
      this.room_sort_edit= Getdata.sort_order,
      this.room_key_options_edit= Getdata.room_key_options,
      this.room_active_edit= Getdata.room_active==0?false:true,
      this.room_type_select_edit= Getdata.roomType.id

      // console.log(this.itemid.room_connection_edit)
    },

    async updateUser() {



      // console.log(this.room_connection_edit)

      try {
        const user = await axios.put(
          `api/rooms/${this.itemid.room_id}`,
          {
            room_name_en: this.room_name_edit,
            room_name_loc: this.room_name_loc_edit,
            room_max_pax: this.room_max_pax_edit,
            room_phone_no: this.room_phone_no_edit,
            room_phone_ext: this.room_phone_ext_edit,
            room_type_id: this.room_type_select_edit,
            fo_status: this.room_status_edit,
            room_active: this.room_active_edit,
            room_key_options: this.room_key_options_edit,
            room_key_code: this.room_key_code_edit,
            hk_stauts: this.room_hk_status_edit,
            sort_order: this.room_sort_edit,
            room_connection: this.room_connection_edit,

          },
        )

        console.log(user)
        this.getAllPaginate()
        this.dialog3 = false
        this.UpdateAlert()
      } catch(e) {
        console.log(e)
      }

    },

    async getmaintenancetype(){
      axios
        .get('api/maintenance-type')
        .then(response => (this.maintenancetype = response.data.data))
    },

    async getRooms(){
      axios
        .get('api/rooms')
        .then(response => (this.roomeo = response.data.data))
    },

    async getRoomsTypes(){
      axios
        .get('api/room_types')
        .then(response => (this.roomType = response.data.data))
    },

    async getFloors(){
      axios
        .get('api/floor')
        .then(response => (this.floorsType = response.data))
    },


  },

}
</script>

<style>
/* width */
::-webkit-scrollbar {
  width: 10px;
  height: 10px;
}

/* Track */
::-webkit-scrollbar-track {
  box-shadow: inset 0 0 5px grey;
  border-radius: 10px;
}

/* Handle */
::-webkit-scrollbar-thumb {
  background: mediumpurple;
  border-radius: 10px;
}

/* Handle on hover */
::-webkit-scrollbar-thumb:hover {
  background: rgba(147, 112, 219, .6);  ;
}
</style>
