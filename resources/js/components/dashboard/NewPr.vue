<!-- eslint-disable prettier/prettier -->
<script setup>
import { newPRDialog } from '@/stores/dialogStore';
import { useForm } from '@inertiajs/vue3';
import dayjs from 'dayjs';
import relativeTime from 'dayjs/plugin/relativeTime';
import { PerfectScrollbar } from 'vue3-perfect-scrollbar';
import { useDisplay } from 'vuetify';
dayjs.extend(relativeTime);


const props = defineProps({
  item: {
    type: null,
  },
});

const { xs } = useDisplay();
const dialogStore = newPRDialog();
const step = ref(1);

const stepper = [
  {
    title: 'General Information',
    subtitle: 'Enter basic details about the Purchase Request.',
  },
  {
    title: 'Description & Purpose',
    subtitle: 'Provide details about the request and its purpose.',
  },
  {
    title: 'Event Details',
    subtitle: 'Specify the event information associated with the PR.',
  },
  {
    title: 'End User Information',
    subtitle: 'Assign the request to an office and user.',
  },
  {
    title: 'Review & Submit',
    subtitle: 'Check all entered information before submitting the PR.',
  },
];

const btn = reactive({
  prev: true,
  next: false,
  nextText: 'Next',
});

watch(step,(value)=>{
  btn.prev = value === 1;
  btn.next = value === stepper.length;
  btn.nextText = value === stepper.length? 'Finish': 'Next';
});

const initialFormState = {
  number: '000-'.concat(dayjs(dayjs()).format('MM-YYYY') ,'-0000'),
  mode: 'Competitive Bidding',
  value: '',
  desc: '',
  purpose: '',
  event_need: null,
  event_loc: "Baler, Aurora",
  user_id: null,
  step: 1,
};

const form = useForm({ ...initialFormState });

const pickerValue = ref(form.event_need ? dayjs(form.event_need).toDate() : null);
const onDateChange = (newValue) => {
  if (newValue) {
    pickerValue.value = newValue;
    form.event_need = dayjs(newValue).format("YYYY-MM-DD");
  }
};

// Filter users based on selected office
const filteredUsers = computed(() => {
  return props.item.users.filter(user => user.office_id === form.office_id);
});

// Watch for changes in office_id to clear user_id if the office changes
watch(() => form.office_id, (newOfficeId, oldOfficeId) => {
  if (newOfficeId !== oldOfficeId) {
    form.user_id = null;
  }
});

const submit =  () => {
form.post(route('prdocs.store'), {
      only: ['filters', 'offices', 'users'],
      replace: true,
      onSuccess: () => {
      step.value++;
      form.step = step.value;
      form.clearErrors();
    },
  });
};

const finish = () => {
  form.post(route('prdocs.store'), {
    only: ['prdocs', 'notifs'],
    replace: true,
    onSuccess: () => {
      closeForm();
    },
  });
};

const closeForm = () => {
      dialogStore.closeDialog();
      Object.assign(form, { ...initialFormState });
      form.clearErrors();
      step.value = 1;
};

const prev = () => {
     
      form.clearErrors();
      step.value--;
      form.step = step.value;
       console.log(form.step);
};

</script>

<template>
  <VDialog
    overflow="hidden"
    persistent
    v-model="dialogStore.isOpen"
    max-width="800"
    :fullscreen="xs"
    :transition="{ 'dialog-bottom-transition': xs }"
    class="user-select-none"
  >
    <template #activator="{ props }">
      <IconBtn v-bind="props" variant="tonal" color="primary"
        ><VIcon icon="bx-plus"></VIcon
      ></IconBtn>
    </template>

    <v-stepper alt-labels selected-class="text-primary text-h6" v-model="step">
      <template v-slot:default>
        <v-toolbar density="compact" prominent>
          <v-toolbar-title class="text-h5">Create New PR</v-toolbar-title>

          <v-spacer></v-spacer>

          <IconBtn
            rounded="lg"
            variant="elevated"
            color="error"
            @click="closeForm"
          >
            <VIcon icon="bx-x"></VIcon>
          </IconBtn>
        </v-toolbar>
        <v-stepper-header>
          <template v-for="(item, n) in stepper" :key="n">
            <v-stepper-item
              complete-icon="bx-check-circle"
              color="primary"
              :complete="step - 1 > n"
              :editable="step - 1 > n"
              :value="n + 1"
            >
              <template #title v-if="step - 1 == n"> {{ item.title }}</template>
            </v-stepper-item>
            <v-divider v-if="n !== stepper.length - 1"></v-divider>
          </template>
        </v-stepper-header>

        <v-stepper-window>
          <v-stepper-window-item> </v-stepper-window-item>

          <!-- Step 1 Content -->
          <v-stepper-window-item>
            <v-card density="compact" min-height="200">
              <VCardText class="pt-0" :class="{ 'px-0': xs }">
                <VListItemTitle class="text-button text-capitalize">
                  {{ stepper[step - 1].title }}
                </VListItemTitle>
                <VListItemSubtitle class="text-caption">
                  {{ stepper[step - 1].subtitle }}
                </VListItemSubtitle>
              </VCardText>

              <VCardText :class="{ 'px-0': xs }">
                <VForm ref="" @submit.prevent="submit" validate-on="lazy">
                  <v-row>
                    <!-- PR Number -->
                    <v-col cols="12" md="6">
                      <v-text-field
                        clearable
                        v-model.trim="form.number"
                        label="PR Number"
                        placeholder="000-00-0000-0000"
                        persistent-placeholder
                        :error-messages="form.errors.number"
                        outlined
                      />
                    </v-col>

                    <!-- PR Mode -->
                    <v-col cols="12" md="6">
                      <v-select
                        clearable
                        v-model="form.mode"
                        :items="item.prModes"
                        item-text="mode"
                        item-value="mode"
                        label="PR Mode"
                        placeholder="Competitive Bidding"
                        persistent-placeholder
                        prepend-inner-icon="mdi-gavel"
                        outlined
                      />
                    </v-col>

                    <!-- PR Value -->
                    <v-col cols="12" md="6">
                      <v-text-field
                        clearable
                        v-model="form.value"
                        label="PR Value"
                        placeholder="1234.56"
                        persistent-placeholder
                        prefix="₱"
                        :error-messages="form.errors.value"
                        outlined
                      />
                    </v-col>
                  </v-row>

                  <VRow fluid justify="space-between">
                    <VCol>
                      <VBtn block :disabled="btn.prev" @click="prev">
                        Previous
                      </VBtn>
                    </VCol>
                    <VCol>
                      <VBtn
                        block
                        type="submit"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                      >
                        {{ btn.nextText }}
                      </VBtn>
                    </VCol>
                  </VRow>
                </VForm>
              </VCardText>
            </v-card>
          </v-stepper-window-item>

          <!-- Step 2 Content -->
          <v-stepper-window-item>
            <v-card density="compact" min-height="200">
              <VCardText class="pt-0" :class="{ 'px-0': xs }">
                <VListItemTitle class="text-button text-capitalize">
                  {{ stepper[step - 1].title }}
                </VListItemTitle>
                <VListItemSubtitle class="text-caption">
                  {{ stepper[step - 1].subtitle }}
                </VListItemSubtitle>
              </VCardText>

              <VCardText :class="{ 'px-0': xs }">
                <VForm @submit.prevent="submit" validate-on="lazy">
                  <v-row>
                    <!-- PR Desc -->
                    <v-col cols="12">
                      <v-textarea
                        clearable
                        v-model.trim="form.desc"
                        label="Description"
                        placeholder="Brief description of the PR."
                        persistent-placeholder
                        counter
                        auto-grow
                        rows="1"
                        :error-messages="form.errors.desc"
                        outlined
                      />
                    </v-col>

                    <!-- PR Purpose -->
                    <v-col cols="12">
                      <v-textarea
                        clearable
                        v-model.trim="form.purpose"
                        label="Purpose"
                        placeholder="The purpose or reason for the request."
                        persistent-placeholder
                        counter
                        auto-grow
                        rows="2"
                        :error-messages="form.errors.purpose"
                        outlined
                      />
                    </v-col>
                  </v-row>

                  <VRow fluid justify="space-between">
                    <VCol>
                      <VBtn block :disabled="btn.prev" @click="prev">
                        Previous
                      </VBtn>
                    </VCol>
                    <VCol>
                      <VBtn
                        block
                        type="submit"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                      >
                        {{ btn.nextText }}
                      </VBtn>
                    </VCol>
                  </VRow>
                </VForm>
              </VCardText>
            </v-card>
          </v-stepper-window-item>

          <!-- Step 3 Content -->
          <v-stepper-window-item>
            <PerfectScrollbar
              tag="div"
              :style="xs ? 'max-block-size: 42rem' : 'max-block-size: 29rem'"
              :options="{ wheelPropagation: false, suppressScrollX: true }"
            >
              <v-card density="compact" min-height="200">
                <VCardText class="pt-0" :class="{ 'px-0': xs }">
                  <VListItemTitle class="text-button text-capitalize">
                    {{ stepper[step - 1].title }}
                  </VListItemTitle>
                  <VListItemSubtitle class="text-caption">
                    {{ stepper[step - 1].subtitle }}
                  </VListItemSubtitle>
                </VCardText>

                <VCardText :class="{ 'px-0': xs }">
                  <VForm @submit.prevent="submit" validate-on="lazy">
                    <v-row justify="space-around">
                      <!-- PR Event Need -->
                      <v-col cols="12" md="6">
                        <v-date-picker
                          class="mx-auto"
                          hide-header
                          v-model:model-value="pickerValue"
                          :min="
                            dayjs()
                              .add(1, 'week')
                              .add(1, 'day')
                              .format('YYYY-MM-DD')
                          "
                          :max="dayjs().add(6, 'month').format('YYYY-MM-DD')"
                          @update:model-value="onDateChange"
                          show-adjacent-months
                        ></v-date-picker>
                      </v-col>
                      <!-- PR Event Location -->
                      <v-col cols="12" md="6">
                        <v-text-field
                          clearable
                          readonly
                          v-model.trim="form.event_need"
                          label="Event Date"
                          hint="Use the Date picker to modify this."
                          persistent-hint
                          placeholder="Target date to have the request."
                          persistent-placeholder
                          counter
                          :error-messages="form.errors.event_need"
                          outlined
                        />
                        <br />
                        <v-text-field
                          clearable
                          v-model.trim="form.event_loc"
                          label="Event Location"
                          placeholder="Location of the event."
                          persistent-placeholder
                          counter
                          :error-messages="form.errors.event_loc"
                          outlined
                        />
                      </v-col>
                    </v-row>

                    <VRow fluid justify="space-between">
                      <VCol>
                        <VBtn block :disabled="btn.prev" @click="prev">
                          Previous
                        </VBtn>
                      </VCol>
                      <VCol>
                        <VBtn
                          block
                          type="submit"
                          :class="{ 'opacity-25': form.processing }"
                          :disabled="form.processing"
                        >
                          {{ btn.nextText }}
                        </VBtn>
                      </VCol>
                    </VRow>
                  </VForm>
                </VCardText>
              </v-card>
            </PerfectScrollbar>
          </v-stepper-window-item>

          <!-- Step 4 Content -->
          <v-stepper-window-item>
            <v-card density="compact" min-height="200">
              <VCardText class="pt-0" :class="{ 'px-0': xs }">
                <VListItemTitle class="text-button text-capitalize">
                  {{ stepper[step - 1].title }}
                </VListItemTitle>
                <VListItemSubtitle class="text-caption">
                  {{ stepper[step - 1].subtitle }}
                </VListItemSubtitle>
              </VCardText>

              <VCardText :class="{ 'px-0': xs }">
                <VForm @submit.prevent="submit" validate-on="lazy">
                  <v-row justify="space-around">
                    <v-col cols="10">
                      <!-- Office Selection -->
                      <v-select
                        clearable
                        v-model="form.office_id"
                        :items="item.offices"
                        :hint="
                          form.office_id
                            ? `${item.offices[form.office_id - 1].name}, ${item.offices[form.office_id - 1].abbr}`
                            : ''
                        "
                        item-title="name"
                        item-value="id"
                        label="Baler-LGU Offices"
                        persistent-hint
                        outlined
                      >
                        <template #hint>
                          <span v-if="form.office_id">{{
                            `${item.offices[form.office_id].name}, ${item.offices[form.office_id].abbr}`
                          }}</span>
                        </template>
                      </v-select>
                      <br />

                      <!-- End User Selection -->
                      <v-select
                        v-model="form.user_id"
                        :items="filteredUsers"
                        item-title="name"
                        item-value="id"
                        label="End User"
                        placeholder="Assign the request to a specific user."
                        persistent-placeholder
                        hint="Select office first"
                        :error-messages="form.errors.user_id"
                        clearable
                      >
                      </v-select>
                    </v-col>
                  </v-row>

                  <VRow fluid justify="space-between">
                    <VCol>
                      <VBtn block :disabled="btn.prev" @click="prev">
                        Previous
                      </VBtn>
                    </VCol>
                    <VCol>
                      <VBtn
                        block
                        type="submit"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                      >
                        {{ btn.nextText }}
                      </VBtn>
                    </VCol>
                  </VRow>
                </VForm>
              </VCardText>
            </v-card>
          </v-stepper-window-item>

          <!-- Step 5 Content -->
          <v-stepper-window-item>
            <PerfectScrollbar
              tag="div"
              :style="xs ? 'max-block-size: 42rem' : 'max-block-size: 29rem'"
              :options="{ wheelPropagation: false, suppressScrollX: true }"
            >
              <v-card density="compact" min-height="200">
                <VCardText class="pt-0" :class="{ 'px-0': xs }">
                  <VListItemTitle class="text-button text-capitalize">
                    {{ stepper[step - 1].title }}
                  </VListItemTitle>
                  <VListItemSubtitle class="text-caption">
                    {{ stepper[step - 1].subtitle }}
                  </VListItemSubtitle>
                </VCardText>

                <VCardText :class="{ 'px-0': xs }">
                  <VForm @submit.prevent="finish" validate-on="lazy">
                    <v-row>
                      <!-- PR Number -->
                      <v-col cols="12" md="6">
                        <v-text-field
                          clearable
                          v-model="form.number"
                          label="PR Number"
                          placeholder="000-00-0000-0000"
                          persistent-placeholder
                          :error-messages="form.errors.number"
                          outlined
                        />
                      </v-col>

                      <!-- PR Value -->
                      <v-col cols="12" md="6">
                        <v-text-field
                          clearable
                          v-model="form.value"
                          label="PR Value"
                          placeholder="1234.56"
                          persistent-placeholder
                          prefix="₱"
                          :error-messages="form.errors.value"
                          outlined
                        />
                      </v-col>
                    </v-row>

                    <v-row>
                      <!-- PR Mode -->
                      <v-col cols="12">
                        <v-select
                          clearable
                          v-model="form.mode"
                          :items="item.prModes"
                          item-text="mode"
                          item-value="mode"
                          label="PR Mode"
                          placeholder="Competitive Bidding"
                          persistent-placeholder
                          :error-messages="form.errors.mode"
                          outlined
                        />
                      </v-col>
                    </v-row>

                    <v-row>
                      <!-- PR Desc -->
                      <v-col cols="12">
                        <v-textarea
                          clearable
                          hide-details
                          v-model.trim="form.desc"
                          label="Description"
                          placeholder="Brief description of the PR."
                          persistent-placeholder
                          counter
                          auto-grow
                          rows="1"
                          :error-messages="form.errors.desc"
                          outlined
                        />
                      </v-col>

                      <!-- PR Purpose -->
                      <v-col cols="12">
                        <v-textarea
                          clearable
                          hide-details
                          v-model.trim="form.purpose"
                          label="Purpose"
                          placeholder="The purpose or reason for the request."
                          persistent-placeholder
                          counter
                          auto-grow
                          rows="2"
                          :error-messages="form.errors.purpose"
                          outlined
                        />
                      </v-col>
                    </v-row>

                    <v-row justify="space-around">
                      <v-col cols="12" md="6">
                        <!-- PR Event Need -->
                        <v-text-field
                          clearable
                          v-model.trim="form.event_need"
                          label="Event Date"
                          placeholder="Target date to have the request."
                          persistent-placeholder
                          counter
                          :error-messages="form.errors.event_need"
                          outlined
                        />
                      </v-col>

                      <v-col cols="12" md="6">
                        <!-- PR Event Location -->
                        <v-text-field
                          clearable
                          hide-details
                          v-model.trim="form.event_loc"
                          label="Event Location"
                          placeholder="Location of the event."
                          persistent-placeholder
                          counter
                          :error-messages="form.errors.event_loc"
                          outlined
                        />
                      </v-col>
                    </v-row>

                    <v-row>
                      <v-col cols="12" md="6">
                        <!-- Office Selection -->
                        <v-select
                          clearable
                          v-model="form.office_id"
                          :items="item.offices"
                          :hint="
                            form.office_id
                              ? `${item.offices[form.office_id - 1].name}, ${item.offices[form.office_id - 1].abbr}`
                              : ''
                          "
                          item-title="name"
                          item-value="id"
                          label="Baler-LGU Offices"
                          persistent-hint
                          outlined
                        >
                          <template #hint>
                            <span v-if="form.office_id">{{
                              `${item.offices[form.office_id].name}, ${item.offices[form.office_id].abbr}`
                            }}</span>
                          </template>
                        </v-select>
                      </v-col>

                      <v-col cols="12" md="6">
                        <!-- End User Selection -->
                        <v-select
                          v-model="form.user_id"
                          :items="filteredUsers"
                          item-title="name"
                          item-value="id"
                          label="End User"
                          placeholder="Assign the request to a specific user."
                          persistent-placeholder
                          hint="Select office first"
                          :error-messages="form.errors.user_id"
                          clearable
                        >
                        </v-select>
                      </v-col>
                    </v-row>

                    <VRow fluid justify="space-between">
                      <VCol>
                        <VBtn block :disabled="btn.prev" @click="prev">
                          Previous
                        </VBtn>
                      </VCol>
                      <VCol>
                        <VBtn block type="submit">
                          {{ btn.nextText }}
                        </VBtn>
                      </VCol>
                    </VRow>
                  </VForm>
                </VCardText>
              </v-card>
            </PerfectScrollbar>
          </v-stepper-window-item>
        </v-stepper-window>
      </template>
    </v-stepper>
  </VDialog>
</template>

<style lang="scss" scoped>
.close-btn {
  z-index: 100;
  inset-block-start: 1.5rem;
  inset-inline-start: 92.5%;
}

.v-card {
  max-block-size: 100%;
}
</style>
