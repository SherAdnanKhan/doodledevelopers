<template>
  <div>
    <base-table
      class="w-full"
      :table-title="tableTitle"
      :header-items="headerItems"
      :records="records"
      text-color="text-white"
    >
      <template slot="name" slot-scope="{ item }">
        <div>
          {{ item.user.first_name + ' ' + item.user.last_name }}
        </div>
      </template>
      <template slot="email" slot-scope="{ item }">
        <div>
          {{ item.user.email }}
        </div>
      </template>
      <template slot="dob" slot-scope="{ item }">
        <div>
          {{ item.user.dob }}
        </div>
      </template>
      <template slot="status" slot-scope="{ item }">
        <div>
          {{ item.status.name }}
        </div>
      </template>
      <template slot="actions" slot-scope="{ item }">
        <div class="flex gap-4">
          <span class="text-xl"
            ><svg
              xmlns="http://www.w3.org/2000/svg"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
              width="25px"
              height="20"
              @click="updateDocument(item)"
            >
              <path
                strokeLinecap="round"
                strokeLinejoin="round"
                strokeWidth="{2}"
                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
              /></svg
          ></span>
          <span>
            <svg
              xmlns="http://www.w3.org/2000/svg"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
              width="25px"
              height="20px"
              @click="deleteKYC(item)"
            >
              <path
                strokeLinecap="round"
                strokeLinejoin="round"
                strokeWidth="{2}"
                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
              />
            </svg>
          </span>
        </div>
      </template>
      <template slot="document" slot-scope="{ item }">
        <div>
          <a
            href="javascript:void(0)"
            @click.stop="openLinkInNewTab(item.document.link)"
            >Download</a
          >
        </div>
      </template>
      <template slot="no-items"> Nothing Found </template>
    </base-table>
    <base-modal :showing="modalVisible" @close="modalVisible = false">
      <template slot="title">
        <h1 class="text-white text-2xl mb-4">Update Document Status</h1>
      </template>
      <template slot="content">
        <div class="max-w-xl flex flex-col w-full" @keyup.enter="performAction">
          <div class="group">
            <label
              class="
                text-white text-xs
                group-focus:text-red-600
                transition-colors
                duration-300
              "
            >
              Document Status
            </label>
            <select
              v-model="documentStatus"
              name="document"
              class="w-full h-12 bg-white text-gray-900 border-r-2 p-1"
              required
            >
              <option value="">Select Status</option>
              <option value="approved">Approved</option>
              <option value="rejected">Rejected</option>
              <option value="resubmit">Resubmit</option>
            </select>
          </div>
          <div class="group">
            <label
              class="
                text-white text-xs
                group-focus:text-red-600
                transition-colors
                duration-300
              "
            >
              Reviews
            </label>
            <input
              v-model="documentReview"
              type="text"
              name="name"
              class="
                bg-brand
                text-white
                px-2
                h-8
                mt-4
                mb-4
                w-full
                border-white
                transition-colors
                duration-300
                border-b
                bg-transparent
                group-focus:border-red
                focus:outline-none focus:border-red
              "
              required
            />
          </div>
          <button
            class="btn mt-5 w-full"
            type="button"
            @click="performAction()"
          >
            {{ buttonText }}
          </button>
        </div>
      </template>
    </base-modal>
  </div>
</template>
<script>
import { mapActions } from 'vuex'
import swal from 'sweetalert2'
import BaseModal from '~/components/Shared/BaseModal.vue'
export default {
  name: 'KYCValidation',
  layout: 'Admin',
  components: { BaseModal },
  props: {
    tableTitle: {
      type: String,
      default: '',
    },
    records: {
      type: Array,
      default: () => [],
    },
    isNewUsers: {
      type: Boolean,
      default: false,
    },
    isRejectedUsers: {
      type: Boolean,
      default: false,
    },
    isApprovedUsers: {
      type: Boolean,
      default: false,
    },
  },
  data: () => ({
    buttonText: 'Submit',
    documentStatus: '',
    documentReview: '',
    isApproved: false,
    modalVisible: false,
    headerItems: [
      {
        id: 'name',
        name: 'Name',
      },
      {
        id: 'email',
        name: 'Email',
      },
      {
        id: 'dob',
        name: 'DOB',
      },
      {
        id: 'status',
        name: 'Status',
      },
      {
        id: 'document',
        name: 'Document',
      },
      {
        id: 'actions',
        name: 'Actions',
      },
    ],
    kycId: '',
  }),
  watch: {
    isApprovedUsers: {
      immediate: true,
      handler(value) {
        if (value) {
          this.isApproved = true
          this.headerItems.pop({ id: 'action', name: 'Action' })
        }
      },
    },
  },
  mounted() {
    window.addEventListener('keyup', this.escEvent)
  },
  methods: {
    ...mapActions('AdminKYCVAlidaitonStore', [
      'updateKYCValidations',
      'deleteKYCValidations',
    ]),
    updateDocument(payload) {
      if (payload) {
        this.documentStatus = payload.status.name
        this.documentReview = payload.review_notes
        this.kycId = payload.id
        this.modalVisible = true
      }
    },
    openLinkInNewTab(link) {
      window.open(link)
    },
    async performAction() {
      if (!this.documentStatus || !this.documentReview) {
        const text = 'All fields are mandatory'
        swal.fire({
          text,
          type: 'error',
          title: 'Validation error',
          confirmButtonText: 'Ok',
          cancelButtonText: 'Cancel',
        })
        return
      }
      const res = {
        status: this.documentStatus,
        review_notes: this.documentReview,
      }
      const temp = {
        doc: res,
        id: this.kycId,
      }
      await this.updateKYCValidations(temp)
      this.$emit('update')
      const text = this.$t('updated-successfully')
      swal.fire({
        text,
        type: 'success',
        title: 'Successfully Updated',
        confirmButtonText: 'Ok',
        cancelButtonText: 'Cancel',
      })
      this.modalVisible = false
    },
    async deleteKYC(payload) {
      if (payload) {
        await this.deleteKYCValidations(payload.id)
        const text = this.$t('deleted-successfully')
        swal.fire({
          text,
          type: 'success',
          title: 'Successfully Deleted',
          confirmButtonText: 'Ok',
          cancelButtonText: 'Cancel',
        })
      }
    },
    escEvent(e) {
      if (e.key === 'Escape' && this.modalVisible === true) {
        this.modalVisible = false
      }
    },
  },
  destroyed() {
    window.removeEventListener('keyup', this.escEvent)
  },
}
</script>

<style></style>
