<template>
  <div v-if="!isLoading" class="px-4 py-4">
    <div v-if="isEmpty">
      <div class="flex card-button">
        <button
          class="
            card-button
            py-4
            px-8
            mb-4
            capitalize
            text-center
            bg-gold
            lg:hover:bg-red lg:hover:text-white
            text-black
            focus:outline-none
            right-0
            relative
            ml-auto
          "
          @click="verifyUser()"
        >
          Validate Yourself
        </button>
      </div>
      <div>
        <h2 class="text-white">
          Please use the button below to begin validation
        </h2>
      </div>
    </div>
    <div v-else class="grid grid-cols-1 gap-4 max-w-3xl mx-auto">
      <div
        v-if="getUserDocument"
        class="game-card flex flex-col relative items-center p-8"
      >
        <h1 class="text-white text-2xl mb-4 text-center mt-4">KYC</h1>
        <p class="mb-4">You have uploaded the document below.</p>
        <div
          class="
            game-card-body
            p-4
            border-red border-t-4
            w-full
            rounded
            justify-center
            sm:w-auto
          "
        >
          <span class="flex flex-row items-center mt-2">
            <div class="block mr-2 w-full">
              <div class="flex mb-2 flex-col lg:flex-row">
                <span class="text-gold font-semibold mr-2">File Name:</span>
                <span class="text-white">{{ getUserDocument.filename }}</span>
              </div>
              <div class="flex mb-2 flex-col lg:flex-row">
                <span class="text-gold font-semibold mr-2">Type:</span>
                <span class="text-white">{{ getUserDocument.type.name }}</span>
              </div>
              <div>
                <a :href="getUserDocument.link" target="_blank">
                  <button class="btn p-3 w-full">Click to download</button>
                </a>
              </div>
              <div class="flex items-center flex-row mt-4 justify-center gap-4">
                <button
                  class="
                    btn
                    p-3
                    text-center
                    bg-gold
                    focus:outline-none
                    h-a
                    w-full
                  "
                  @click="editKYC()"
                >
                  Edit
                </button>
                <button
                  class="
                    btn
                    p-3
                    text-center
                    bg-gold
                    focus:outline-none
                    h-a
                    w-full
                  "
                  @click="deleteKYV()"
                >
                  Delete
                </button>
              </div>
            </div>
          </span>
        </div>
        <!-- <div
          v-if="balance < 1"
          class="nocredit-overlay flex justify-center items-center"
        >
          <span>You have no credits to play</span>
        </div> -->
      </div>
    </div>
    <base-modal :showing="modalVisible" @close="modalVisible = false">
      <template slot="title">
        <h1 class="text-white text-2xl mb-4">{{ modalTitle }}</h1>
      </template>
      <template slot="content">
        <div class="max-w-xl flex flex-col w-full" @keyup.enter="onFileChange">
          <div class="group">
            <label
              class="
                text-white text-xs
                group-focus:text-red-600
                transition-colors
                duration-300
              "
            >
              Document
            </label>
            <input
              ref="file"
              type="file"
              name="file"
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
              @change="documentSelected()"
            />
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
              Type ( pdf, png, jpg, jpeg )
            </label>
            <select
              v-model="documentType"
              name="documentType"
              class="w-full bg-white text-gray-900 border-r-2 p-1"
            >
              <option value="">Select Type</option>
              <option :key="1" value="drivinglicense">Driving License</option>
              <option :key="2" value="passport">Passport</option>
              <option :key="3" value="utilitybill">Utility Bill</option>
            </select>
          </div>
          <button
            :class="['btn mt-5 w-full', { disabled: loading }]"
            type="button"
            :disabled="loading"
            @click="onFileChange()"
          >
            <span v-if="loading">
              Uploading document
              <!--  <HollowDotsSpinner :animation-duration="1000" :dot-size="10" :dots-num="3" color="#d70000" style="display: inline-block" /> -->
            </span>
            <span v-else>
              {{ modalTitle }}
            </span>
          </button>
        </div>
      </template>
    </base-modal>
  </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'
import swal from 'sweetalert2'
import BaseModal from '~/components/Shared/BaseModal.vue'
// import { HollowDotsSpinner } from 'epic-spinners'

export default {
  name: 'KYCValidation',
  layout: 'User',
  scrollToTop: false,
  components: { BaseModal },
  data: () => ({
    modalVisible: false,
    isLoading: true,
    document: '',
    docuementName: '',
    imageData: '',
    documentType: '',
    isEdit: false,
    modalTitle: '',
    isEmpty: true,
    documentId: null,
    kycId: null,
    validTypes: ['application/pdf', 'image/png', 'image/jpeg', 'image/jpeg'],
    loading: false,
  }),
  mounted() {
    window.addEventListener('keyup', this.escEvent)
  },
  computed: {
    ...mapGetters('UserKYCValidationStore', [
      'userKYCValidation',
      'getUserKYCValidation',
      'uploadUserKYCDocument',
      'getUserDocument',
      'errorMessage',
      'editUserKYCDocument',
    ]),
  },
  async created() {
    await this.getKycValidationDocs()
    this.isLoading = false
  },
  methods: {
    ...mapActions('UserKYCValidationStore', [
      'createKYCValidation',
      'getKYCValidation',
      'createKYCDocuemnt',
      'getUserKYCDocuemnt',
      'editUserKYCDocuemnt',
      'deleteUserKYCDocuemnt',
    ]),
    async getKycValidationDocs() {
      await this.getKYCValidation()
      if (this.getUserKYCValidation.length) {
        const validations = this.getUserKYCValidation[0]
        this.kycId = validations.id
        this.documentId =
          validations.document && validations.document.id
            ? validations.document.id
            : null
        if (!this.kycId) {
          await this.createKYCValidation()
          this.kycId = this.getUserKYCValidation[0].id
        } else if (this.kycId && this.documentId) {
          const payload = { kycId: this.kycId, docId: this.documentId }
          await this.getUserKYCDocuemnt(payload)
          this.isEmpty = false
        }
      } else {
        await this.createKYCValidation()
        await this.getKYCValidation()
        this.kycId = this.getUserKYCValidation[0].id
      }
    },
    verifyUser() {
      if (!this.isEdit) {
        this.modalTitle = 'Add Document'
        this.modalVisible = true
      }
    },
    verification() {},
    documentSelected(e) {
      this.document = this.$refs.file.files[0]
      this.isValidFile(this.document)
      this.documentName = this.document.name
      const reader = new FileReader()
      reader.onload = (e) => {
        this.imageData = reader.result
      }
      reader.readAsDataURL(this.document)
    },
    isValidFile(file) {
      const isValidType = this.validTypes.includes(file.type)
      const isValidSize = file.size / (1024 * 1024) <= 1
      if (!isValidType || !isValidSize) {
        swal.fire({
          text: 'File must be of type pdf, png, jpg, jpeg and size must be less than or equal to 1 MB',
          type: 'error',
          title: 'Error',
          confirmButtonText: 'Ok',
          cancelButtonText: 'Cancel',
        })
        return false
      }
      return true
    },
    async onFileChange(e) {
      if (!this.document) {
        swal.fire({
          text: 'Please select a file to upload',
          type: 'warning',
          title: 'Select file',
          confirmButtonText: 'Ok',
          cancelButtonText: 'Cancel',
        })
        return
      }
      if (!this.documentType) {
        swal.fire({
          text: 'Please select document type',
          type: 'warning',
          title: 'Select document type',
          confirmButtonText: 'Ok',
          cancelButtonText: 'Cancel',
        })
        return
      }
      await this.getKycValidationDocs()

      if (this.document && this.isValidFile(this.document)) {
        this.loading = true
        if (!this.isEdit) {
          try {
            const image = {
              name: this.document.name,
              type: this.documentType,
              file: this.imageData,
            }
            let payload = {
              kycId: this.kycId,
              document: image,
            }
            await this.createKYCDocuemnt(payload)
            this.documentId =
              this.uploadUserKYCDocument && this.uploadUserKYCDocument.id
                ? this.uploadUserKYCDocument.id
                : null
            const text = this.$t('Successfully Uploaded')
            swal.fire({
              text,
              type: 'success',
              title: 'Uploaded Successfully',
              confirmButtonText: 'Ok',
              cancelButtonText: 'Cancel',
            })
            this.modalVisible = false
            if (this.documentId) {
              payload = { kycId: this.kycId, docId: this.documentId }
              await this.getUserKYCDocuemnt(payload)
              this.isEmpty = false
            }
          } catch (e) {
            if (this.errorMessage) {
              const text = this.errorMessage
              swal.fire({
                text,
                type: 'error',
                title: 'Error',
                confirmButtonText: 'Ok',
                cancelButtonText: 'Cancel',
              })
              return false
            }
          }
        } else {
          try {
            const image = {
              name: this.document.name,
              type: this.documentType,
              file: this.imageData,
            }
            let payload = {
              data: image,
              kycId: this.kycId,
              docId: this.documentId,
            }
            await this.editUserKYCDocuemnt(payload)
            const text = this.$t('Successfully Updated')
            swal.fire({
              text,
              type: 'success',
              title: 'Updated Successfully',
              confirmButtonText: 'Ok',
              cancelButtonText: 'Cancel',
            })
            this.modalVisible = false
            payload = { kycId: this.kycId, docId: this.documentId }
            await this.getUserKYCDocuemnt(payload)
            this.isEmpty = false
          } catch (e) {
            if (this.errorMessage) {
              const text = this.errorMessage
              swal.fire({
                text,
                type: 'error',
                title: 'Error',
                confirmButtonText: 'Ok',
                cancelButtonText: 'Cancel',
              })
              return false
            }
          }
        }
        this.loading = false
      }
    },
    editKYC() {
      this.isEdit = true
      if (this.isEdit) {
        this.modalTitle = 'Update Document'
        this.modalVisible = true
      }
    },
    async deleteKYV() {
      const payload = { kycId: this.kycId, docId: this.documentId }
      await this.deleteUserKYCDocuemnt(payload)
      const text = this.$t('Successfully Deleted')
      swal.fire({
        text,
        type: 'success',
        title: 'Deleted Successfully',
        confirmButtonText: 'Ok',
        cancelButtonText: 'Cancel',
      })
      this.resetState()
    },
    resetState() {
      this.isEmpty = true
      this.document = ''
      this.documentId = null
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

<style scoped>
.disabled {
  background-color: lightgrey;
  cursor: default;
}
</style>

<style>
.my-kyc-table td {
  border: 2px solid white;
  padding: 20px;
}
</style>
