<template>
  <div class="main-layout text-center">
    <sidebar/>
    <navbar/>

    <div class="container-fluid mt-4">
      <child/>
    </div>
  </div>
</template>

<script>
import Sidebar from '~/components/Sidebar'
import Navbar from '~/components/Navbar'

export default {
  name: 'MainLayout',

  components: {
    Sidebar,
    Navbar
  }
}
</script>
