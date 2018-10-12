<template>
  <div class="card">
    <div v-if="title" class="text-center text-info h4 mt-4">
      {{ title }}
    </div>

    <div class="card-body mt-3 mb-3">
      <slot/>
    </div>
  </div>
</template>

<script>
export default {
  name: 'Card',

  props: ['title']
}
</script>
