<template>
  <div>
    <KYCValidations
      :records="new_validations"
      :table-title="headerNew"
      :is-approved-users="false"
      @update="fetchRecords"
    />
    <KYCValidations
      :records="rejected_validations"
      :table-title="headerRejected"
      :is-approved-users="false"
      @update="fetchRecords"
    />
    <KYCValidations
      :records="approved_validations"
      :table-title="headerApproved"
      :is-approved-users="true"
      @update="fetchRecords"
    />
  </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'
import KYCValidations from '~/components/Admin/KYCValidations.vue'
// import swal from 'sweetalert2'
// import BaseModal from '~/components/Shared/BaseModal.vue'
export default {
  name: 'KYCValidation',
  layout: 'Admin',
  components: { KYCValidations },
  async asyncData({ store }) {
    await store.dispatch('AdminKYCVAlidaitonStore/getAllKYCValidations')
  },
  data: () => ({
    headerNew: 'New Users to Validate',
    headerRejected: 'Rejected Users',
    headerApproved: 'Approved Users',
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
        id: 'actions',
        name: 'Actions',
      },
      {
        id: 'document',
        name: 'Document',
      },
    ],
  }),
  computed: {
    ...mapGetters('AdminKYCVAlidaitonStore', ['getAllUserKYCValidations']),
    new_validations() {
      if (
        !this.getAllUserKYCValidations &&
        !this.getAllUserKYCValidations.length
      )
        return []

      return this.getAllUserKYCValidations.filter(
        (validations) =>
          validations.document &&
          (validations.status.id.toLowerCase() === 'resubmit' ||
            validations.status.id.toLowerCase() === 'new')
      )
    },
    rejected_validations() {
      if (
        !this.getAllUserKYCValidations &&
        !this.getAllUserKYCValidations.length
      )
        return []

      return this.getAllUserKYCValidations.filter(
        (validations) =>
          validations.document &&
          validations.status.id.toLowerCase() === 'rejected'
      )
    },
    approved_validations() {
      if (
        !this.getAllUserKYCValidations &&
        !this.getAllUserKYCValidations.length
      )
        return []

      return this.getAllUserKYCValidations.filter(
        (validations) =>
          validations.document &&
          validations.status.id.toLowerCase() === 'approved'
      )
    },
  },
  methods: {
    ...mapActions('AdminKYCVAlidaitonStore', ['getAllKYCValidations']),
    async fetchRecords() {
      await this.getAllKYCValidations()
    },
  },
}
</script>

<style></style>
