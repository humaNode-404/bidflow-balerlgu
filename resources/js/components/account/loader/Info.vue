<script setup>
</script>

<template>
  <VRow>
    <VCol cols="12">
      <VCard title="Account Details">
        <VCardText class="d-flex">
          <!-- 👉 Avatar -->
          <VAvatar color="secondary" rounded="lg" size="200" class="me-6" :image="null" />

          <!-- 👉 Upload Photo -->
          <form class="d-flex flex-column justify-center gap-5">

            <v-skeleton-loader type="actions" />

            <p class="text-body-2 mb-0">
              Allowed JPG, GIF, or PNG. Max size of 3MB.
            </p>
          </form>
        </VCardText>

        <VDivider />

        <VCardText class="pt-0">
          <!-- 👉 Form -->
          <VForm class="mt-6">
            <VRow>
              <VCol cols="12">
                <VListItemTitle class="text-button text-capitalize">
                  Account Details
                </VListItemTitle>
              </VCol>


              <VCol md="4" sm="6" cols="12" v-for="n in 4" :key="n">
                <v-skeleton-loader type="list-item" />
              </VCol>



              <VCol class="mt-5" cols="12">
                <VListItemTitle class="text-button text-capitalize">
                  Contact Information
                </VListItemTitle>
              </VCol>

              <VCol md="4" sm="6" cols="12" v-for="n in 2" :key="n">
                <v-skeleton-loader type="list-item" />
              </VCol>

              <VCol cols="12">
                <v-skeleton-loader type="actions" />
              </VCol>
            </VRow>
          </VForm>
        </VCardText>
      </VCard>
    </VCol>
  </VRow>
</template>
