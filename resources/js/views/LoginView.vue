<template>
    <div class="login_form">
        <div class="container">
            <div class="row">
                <form @submit.prevent="login" style="width: 300px; margin: 3em;">
                    <h2 class="mb-3">Đăng nhập</h2>
                    <div class="input">
                        <label for="email">Địa chỉ Email</label>
                        <input class="form-control" type="text" name="email" placeholder="email@adress.com" />
                    </div>
                    <div class="input">
                        <label for="password">Mật khẩu</label>
                        <input class="form-control" type="password" name="password" placeholder="password123" />
                    </div>
                    <div class="alternative-option mt-4">
                        Không có tài khoản? <span @click="moveToRegister">Đăng kí</span>
                    </div>
                    <a-button type="primary" html-type="submit" class="mt-4 btn-pers" id="login_button" :loading="loading">
                        Đăng nhập
                    </a-button>
                    <div class="alert alert-warning alert-dismissible fade show mt-5 d-none" role="alert" id="alert_1">
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
  
<script>
import axios from "axios";
export default {
    data() {
        return {
            email: "",
            password: "",
            loading: false,
        };
    },
    methods: {
        login(submitEvent) {
            this.email = submitEvent.target.elements.email.value;
            this.password = submitEvent.target.elements.password.value;
            this.loading = true;
            axios.post('/login', { email: this.email, password: this.password })
                .then((response) => {
                    console.log(response.data.user)
                    window.sessionStorage.setItem('user', response.data.user)
                    this.$store.commit('setUser', response.data.user)
                    this.$router.push("/");
                })

                .catch((error) => {
                    this.loading = false;
                    let alert_1 = document.querySelector("#alert_1");
                    alert_1.classList.remove("d-none");
                    if (error.response.data.error) {
                        alert_1.innerHTML = error.response.data.error;
                    }
                    else alert_1.innerHTML = "Có lỗi xảy ra!"
                });
        },
        moveToRegister() {
            this.$router.push("/register");
        },
    },
};
</script>
<style scoped>
html,
body {
    height: 100%;
    width: 100%;
    /* Đảm bảo chiều rộng 100% cho cả html và body */
    margin: 0;
    padding: 0;
}

.container {
    height: 100vh;
    width: 100%;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
}

.row {
    /* border: 1px solid white; */
    background-color: white;
    border-radius: 1em;
}

.login_form {
    background: url(https://images.pexels.com/photos/32237/pexels-photo.jpg?auto=compress&cs=tinysrgb&dpr=2&h=750&w=1260) no-repeat center center;
    background-size: cover;
}
</style>