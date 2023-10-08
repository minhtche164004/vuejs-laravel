<template>
    <!-- <header> -->
    <!-- {{ getUserfromsession() }} -->

    <div style="width: 100%;text-align: end;">
        <span v-if="ifuser">
            Xin chào <span v-if="this.$store.state.user.isadmin == 1">sếp </span>{{ this.$store.state.user.fullname }}
        </span>
        &nbsp;
        <a-button v-if="ifuser" @click="logout">
            Log out
        </a-button>
        <a-button v-else>
            <router-link to="/login">Log In</router-link>
        </a-button>
    </div>

    <div class="site-branding row">
        <div class="logo">
            <img src="https://www.sieuthimaytinhlangson.com/uploads/logo_banner/logonew.png"
                alt="Sieuthimaytinhlangson.com">
        </div>
        <div class="search">
            <Form>
                <input type="text" placeholder="Tìm kiếm...">
                <button><i class="fa fa-search"></i></button>
            </Form>
        </div>
        <div class="phone">
            <i class="fa fa-phone" style="width: 26px;
                height: 26px;
                border-radius: 100%;
                border: 1px solid #ef233c;
                line-height: 26px;
                text-align: center;
                color: #dd3333;"></i>
            <label for="">Hotline:</label>
            <a href="#">0366780698</a>
        </div>
    </div>
    <nav class="navs">
        <div>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="fa fa-bars"></span>
            </button>
        </div>
        <div class="searchs">
            <Form>
                <input type="text" placeholder="Tìm kiếm...">
                <button><i class="fa fa-search"></i></button>
            </Form>
        </div>
        <div>
            <router-link class="shopping-cart" to="/cart">
                <label class="cart" for="">{{ getCartLength }}</label>
                <div class="fa fa-shopping-bag" />
            </router-link>
        </div>
    </nav>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <button class="" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            Đóng menu <span class="fa fa-times"></span>
        </button>
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="#">Trang chủ</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Giới thiệu</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Sản phẩm</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Laptop mới</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Laptop cũ</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Linh kiện máy in</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Linh kiện laptop</a>
            </li>
            <li class="nav-item">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">Linh kiện PC</a>
                <div class="dropdown-menu bg-dark" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="#">CPU</a>
                    <a class="dropdown-item" href="#">RAM</a>
                    <a class="dropdown-item" href="#">MAIN</a>
                    <a class="dropdown-item" href="#">Nguồn PC</a>
                    <a class="dropdown-item" href="#">Vỏ cây</a>
                    <a class="dropdown-item" href="#">VGA</a>
                    <a class="dropdown-item" href="#">Màn hình</a>
                    <a class="dropdown-item" href="#">Tai nghe</a>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Thiết bị mạng</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Surface</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Macbook</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Máy in</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Thiết bị ngoại vi</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">BÀN-GHẾ GAMING</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Tin tức</a>
                <div class="dropdown-menu bg-dark" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="#">Tin sản phẩm</a>
                    <a class="dropdown-item" href="#">Thủ thuật máy tính</a>
                </div>
            </li>
        </ul>
    </div>
    <div class="navbars">
        <nav>
            <div class="dropdown-list">
                <div class="list">
                    Danh mục sản phẩm
                </div>
            </div>
            <div class="menu">
                <div class="item">
                    Trang chủ
                </div>
                <div class="item">
                    Giới thiệu
                </div>
                <div class="item">
                    Sản phẩm
                </div>
                <div class="item">
                    Tin tức
                </div>
                <div class="item">
                    Video
                </div>
                <div class="item">
                    Hỗ trợ khách hàng
                </div>
                <div class="item">
                    Liên hệ
                </div>
            </div>
            <router-link class="shopping-cart" to="/cart">
                <label class="cart" for="">{{ getCartLength }}</label>
                <div class="fa fa-shopping-bag"></div>
            </router-link>
            {{ log }}
        </nav>
    </div>
    <!-- </header> -->
</template>
<script>
import { mapState, mapGetters } from 'vuex'
import axios from 'axios';
export default {
    data() {
        return {
            user: window.sessionStorage.getItem('user') || {}
        }
    },
    computed: {
        ...mapState({
            cart: 'cart'
        }),
        ...mapGetters({
            getCount: 'getCount',
            getCartLength: 'getCartLength'
        }),
        ifuser() {
            return this.user.length > 1;
        },
    },
    methods: {
        getUserfromsession() {
            axios.get('/getuser', this.user)
                .then(response => {
                    if (response.data.user) {
                        const userData = response.data.user;
                        // this.user = response.data.user;
                        window.sessionStorage.setItem('user', response.data.user)
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        },
        logout() {
            axios.get('/logout', this.user)
                .then(response => {
                    window.sessionStorage.removeItem('user')
                    this.user = []
                    this.$router.push('/')
                })
                .catch(error => {
                    console.error(error)
                })
        }
    },
    created() {

    }


}
</script>