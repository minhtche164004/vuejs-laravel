<template>
  <div>
    <!-- Kiểm tra xem bạn đang ở trang đăng nhập hay không -->
    <template v-if="!isLoginPage">
      <Header />
    </template>

    <!-- Điều hướng chính -->
    <router-view />

    <!-- Kiểm tra xem bạn đang ở trang đăng nhập hay không -->
    <template v-if="!isLoginPage">
      <Footer />
    </template>
  </div>
</template>

<script>
import Header from "@/components/Shared/Header.vue"
import Footer from "@/components/Shared/Footer.vue"
import axios from "axios";
import { useToast } from "vue-toastification";

export default {
  components: {
    Header,
    Footer
  },
  data() {
    return {
      message: 'Hehe'
    }
  },
  computed: {
    // Xác định xem bạn đang ở trang đăng nhập hay không
    isLoginPage() {
      return this.$route.name === 'Login' || this.$route.name === 'register'; // Thay 'login' bằng tên của trang đăng nhập
    }
  },
  created() {
    axios.get('/getuser', '').then(response => {
      this.$store.commit('setUser', response.data.user)
      if (this.$cookies.get('message') != null && this.$cookies.get('message') != undefined) {
        useToast().success(this.$cookies.get('message'))
        this.$cookies.remove('message')
      }
      // console.log(this.$store.state.user)
    })
  }
}
</script>

<style scoped>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
}

nav {
  padding: 30px;
}

nav a {
  font-weight: bold;
  color: #2c3e50;
}

nav a.router-link-exact-active {
  color: #42b983;
}
</style>