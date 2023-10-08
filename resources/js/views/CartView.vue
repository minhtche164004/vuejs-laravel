<template>
    <div class="container-fluid">
        <a-breadcrumb separator=">">
            <a-breadcrumb-item><router-link to="/">Trang chủ</router-link></a-breadcrumb-item>
            <a-breadcrumb-item>Giỏ hàng</a-breadcrumb-item>
        </a-breadcrumb>
        <div class="checkout-box">
            <h2 class="device">
                <label for="">Giỏ hàng</label>
            </h2>
            <ul v-if="IsProductsInCart" class="checkout-list">
                <transition-group name="fade" key="">
                    <li class="checkout-product">
                        <span class="product-price">Ảnh</span>
                        <span class="product-price">Tên sản phẩm</span>
                        <span class="product-price">Giá</span>
                        <span class="product-price">Số lượng</span>
                        <span class="product-price">Giá tổng theo sản phẩm</span>
                        <a-popconfirm title="Bạn có chắc muốn xóa toàn bộ không?" ok-text="Có" cancel-text="Không"
                            @confirm="deleteAll()">
                            <a-button type="primary" danger>Xoá toàn bộ</a-button>
                        </a-popconfirm>
                    </li>
                    <li v-for="(product, index) in getCarts" :key="product.productid" class="checkout-product">
                        <img :src="product.productimage.image" alt="" class="product-image">
                        <h3 class="product-name">{{ product.name }}</h3>
                        <span class="product-price">{{ formatnumbers(product.price) }} </span>
                        <div>
                            <button v-if="product.quantity > 1"
                                @click="this.$store.commit('adjustQuantity', { count: -1, productid: product.productid })"
                                class="product-adjust">-</button>
                            <a-popconfirm title="Bạn có chắc muốn xóa sản phẩm này không?" v-if="product.quantity === 1"
                                ok-text="Có" cancel-text="Không" @confirm="remove(product.productid)">
                                <button class="product-adjust">-</button>
                            </a-popconfirm>

                            <span class="product-price">{{ product.quantity }}</span>
                            <button
                                @click="this.$store.commit('adjustQuantity', { count: 1, productid: product.productid })"
                                class="product-adjust">+</button>

                        </div>
                        <span class="product-price">{{ formatnumbers(product.quantity * product.price) }}</span>
                        <div>
                            <a-popconfirm title="Bạn có chắc muốn xóa sản phẩm này không?" ok-text="Có" cancel-text="Không"
                                @confirm="remove(product.productid)">
                                <button class="product-remove">X</button>
                            </a-popconfirm>
                        </div>
                    </li>
                </transition-group>
            </ul>
            <div class="checkout-message" v-if="!IsProductsInCart">
                <h3>Chưa có sản phẩm nào trong giỏ hàng</h3>
                <router-link to="/">Quay trở lại trang chủ</router-link>
            </div>
            <h3 class="total" v-if="IsProductsInCart">
                Tổng giá: {{ formatnumbers(getTotalPrice) }}
            </h3>
            <a-button type="primary" danger v-if="IsProductsInCart" class="checkout-button">
                <router-link to="/checkout" class="checkout">
                    Thanh toán
                </router-link>
            </a-button>
        </div>
    </div>
</template>
  
<script>
import numeral from 'numeral';
import { useToast } from 'vue-toastification';
export default {
    computed: {
        IsProductsInCart() {
            return this.$store.state.cart.length > 0
        },
        getTotalPrice() {
            let total = 0;
            this.$store.state.cart.forEach(element => {
                total += element.price * element.quantity
            });
            return total
        },
        getCarts() {
            return this.$store.state.cart
        },
    },

    methods: {
        formatnumbers(number) {
            return numeral(number).format('0,0') + 'đ'
        },
        deleteAll() {
            this.$store.commit('getCart', [])
        },
        remove(id) {
            this.$store.dispatch('delete', id)
            // this.$store.commit('getCart', this.$cookies.get('cart'))
        },
    },
};
</script>
  
<style scoped>
.checkout-box {
    width: 100%;
    /* max-width: 900px; */
    display: flex;
    flex-direction: column;
    margin: 50px auto;
    box-sizing: border-box;
    padding: 1em;
}

.checkout-list {
    padding: 0;
}

.checkout-product {
    display: grid;
    grid-template-columns: 1fr 2fr 2fr 1fr 2fr.5fr;
    background-color: #fff;
    box-shadow: 0px 0px 10px rgba(73, 74, 78, 0.1);
    border-radius: 5px;
    list-style: none;
    box-sizing: border-box;
    padding: .8em;
    margin: 1em 0;
}

.checkout-product * {
    place-self: center;
}

.product-image {
    grid-column: 1/2;
    width: 50%;
}

.product-name {
    box-sizing: border-box;
}

.product-price {
    font-size: 1.2em;
    font-weight: bold;
}

.product-remove {
    width: 25px;
    height: 25px;
    border-radius: 50%;
    border: 0;
    background-color: #E0E0E0;
    color: #fff;
    cursor: pointer;
}

.product-adjust {
    margin: 0 1em;
    width: 25px;
    height: 25px;
    font-weight: bold;
    border-radius: 50%;
    border: 0;
    background-color: black;
    color: #fff;
    cursor: pointer;
}

.total {
    font-size: 2em;
    font-weight: bold;
    align-self: flex-end;
}

.checkout-message {
    font-size: 1.5em;
    text-align: center;
}

.fade-enter-active,
.fade-leave-active {
    transition: all .5s;
}

.fade-enter,
.fade-leave-to {
    transform: translateX(-40px);
    opacity: 0;
}

.checkout-button {
    width: 10%;
    align-self: flex-end;
}

.checkout:hover {
    color: white;
    text-decoration: none;
}
</style>
  