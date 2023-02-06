<template>
  <div class="card">
    <div
      v-if="tableTitle"
      class="card-header p-3 text-2xl text-center mb-4 text-white"
      :class="headerCustomClasses"
    >
      {{ tableTitle }}
    </div>
    <div class="card-body respnosive-table">
      <table v-if="records.length" class="w-full p-2 table-fixed">
        <thead class="">
          <tr
            v-if="$route.name === 'leaderboard'"
            class="bg-opacity-25 bg-white text-white"
          >
            <th
              v-for="(headerItem, index) in headerItems"
              :key="index"
              class="text-left p-2 font-bold text-sm lg:text-base"
              :class="{
                'w-1/6': index === 0,
                'w-1/2': index === 1,
                'w-1/4': index > 1,
              }"
            >
              {{ headerItem.name }}
            </th>
          </tr>
          <tr v-else class="bg-opacity-25 bg-white text-white lg:text-base">
            <th
              v-for="(headerItem, index) in headerItems"
              :key="index"
              class="text-left p-2 font-bold text-sm lg:text-base"
              :class="{
                'w-1/3': index === 0,
                'w-1/5': index === 1,
                'w-1/4': index > 1,
              }"
            >
              {{ headerItem.name }}
            </th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="(record, index) in recordsToShow"
            :key="index"
            class="py-2 text-white"
            :class="{ 'border-b border-grey ': recordsToShow.length > 1 }"
            @click.prevent="
              $emit('on-row-click', { id: record.id, record: record })
            "
          >
            <td
              v-for="(headerItem, fieldIndex) in headerItems"
              :key="fieldIndex"
              :class="invitationClass"
              class="p-2 text-sm lg:text-base"
            >
              <div v-if="typeof $scopedSlots[headerItem.id] !== 'undefined'">
                <slot
                  :name="headerItem.id"
                  :field="headerItem.id"
                  :item="record"
                  :index="index"
                ></slot>
              </div>
              <div v-else :key="`${index}-${headerItem.id}`">
                {{ record[headerItem.id] }}
              </div>
            </td>
          </tr>
        </tbody>
      </table>
      <div v-else>
        <div class="card-footer p-10 text-xl text-center" :class="textColor">
          <slot name="no-items">Nothing Found</slot>
        </div>
      </div>
    </div>
    <div v-if="paginate">
      <vue-ads-pagination
        :total-items="records.length"
        :items-per-page="50"
        :page="page"
        @page-change="pageChange"
        @range-change="rangeChange"
      >
        <template slot-scope="props">
            <div class="vue-ads-pr-2 vue-ads-leading-loose">
                Records {{ props.start }} to {{ props.end }} of {{ props.total }}
            </div>
        </template>
        <template
            slot="buttons"
            slot-scope="props"
        >
            <vue-ads-page-button
                v-for="(button, key) in props.buttons"
                :key="key"
                v-bind="button"
                @page-change="page = button.page"
            />
        </template>
      </vue-ads-pagination>
    </div>
  </div>
</template>

<script>
import '@/node_modules/@fortawesome/fontawesome-free/css/all.css';
import '@/node_modules/vue-ads-pagination/dist/vue-ads-pagination.css';
import VueAdsPagination, { VueAdsPageButton } from 'vue-ads-pagination';

export default {
  name: 'BaseTable',
  components: {
    VueAdsPagination,
    VueAdsPageButton,
  },
  props: {
    headerItems: {
      type: Array,
      default: () => [],
      required: true,
    },
    records: {
      type: Array,
      default: () => [],
      required: true,
    },
    tableTitle: {
      type: String,
      default: '',
    },
    headerCustomClasses: {
      type: String,
      default: '',
    },
    isInvitationPage: {
      type: Boolean,
      default: false,
    },
    textColor: {
      type: String,
      default: 'text-white',
    },
    paginate: {
      type: Boolean,
      default: false
    }
  },
  data: () => ({
    isInvitation: true,
    invitationClass: '',
    loading: false,
    page: 0,
    start: 0,
    end: 50,
  }),
  watch: {
    isInvitationPage: {
      immediate: true,
      handler(value) {
        if (value) {
          this.isInvitation = false
          this.invitationClass = 'text-center px-0'
        }
      },
    },
  },
  computed: {
    recordsToShow() {
      if(!this.paginate) {
        return this.records;
      }
      return this.records.slice(this.start, this.end);
    }
  },
  methods: {
    profileImage(img) {
      return img ?? require('~/assets/images/user.png')
    },
    refresh() {
      this.$emit('refresh')
    },
    pageChange (page) {
      this.page = page;
    },
    
    rangeChange (start, end) {
      this.end = end;
      this.start = start;
    },
  },
}
</script>

<style lang="scss">
  .vue-ads-bg-gray-200.vue-ads-text-gray {
    background: #404040;
  }
  .vue-ads-bg-teal-500.vue-ads-text-white {
    background: #DBBA6B;
  }
  .hover\:vue-ads-bg-gray-100:hover{
    background: #d70000;
  }
.card-body {
  border: 1px solid #404040;
  border-top-right-radius: 12px;
  border-top-left-radius: 12px;
  border-bottom-right-radius: 12px;
  border-bottom-left-radius: 12px;
  box-shadow: 0px 0px 14px 2px rgb(255 255 255 / 16%);
}

tbody {
  border-bottom-right-radius: 12px;
  border-bottom-left-radius: 12px;
}

table {
  width: 100%;
}

.respnosive-table {
  display: block;
  width: 100%;
  overflow-x: auto;
  -webkit-overflow-scrolling: touch;
}
</style>
