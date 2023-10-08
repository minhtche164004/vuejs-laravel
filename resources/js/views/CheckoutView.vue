<template>
    <div class="container-fluid">
        <a-breadcrumb separator=">">
            <a-breadcrumb-item><router-link to="/">Trang chủ</router-link></a-breadcrumb-item>
            <a-breadcrumb-item><router-link to="/cart">Giỏ hàng</router-link></a-breadcrumb-item>
            <a-breadcrumb-item>Thanh toán</a-breadcrumb-item>
        </a-breadcrumb>
        <a-form :model="formState" layout="vertical" name="checkout_form" @finish="onFinish">
            <div class="container mb-5" style="padding: 0;">
                <h2 class="device">
                    <label for="">Thanh toán</label>
                </h2>
                <div class="row" style="border: 1px solid gray; margin: 0;">

                    <div class="col-lg-4">
                        <h3 class="bill_title text-left">Thông tin mua hàng</h3>
                        <a-space direction="vertical" style="text-align: left;">

                            <a-form-item name="name" label="Họ và tên" validateTrigger="blur"
                                :rules="[{ required: true, message: 'Không được để trống họ và tên' }]">
                                <a-input v-model:value="formState.name" placeholder="Họ và tên" />
                            </a-form-item>
                            <a-form-item name="address" label="Địa chỉ" validateTrigger="blur"
                                :rules="[{ required: true, message: 'Không được để trống địa chỉ' }]">
                                <a-input v-model:value="formState.address" placeholder="Địa chỉ" />
                            </a-form-item>
                            <a-form-item name="number" label="Số điện thoại" validateTrigger="blur"
                                :rules="[{ required: true, message: 'Không được để trống số điện thoại' }]">
                                <a-input v-model:value="formState.number" placeholder="Số điện thoại" />
                            </a-form-item>
                            <a-form-item name="email" label="Email"
                                :rules="[{ required: true, message: 'Không được để trống số email' }, { type: 'email', message: 'Vui lòng nhập đúng định dạng email' }]">
                                <a-input v-model:value="formState.email" placeholder="Email" />
                            </a-form-item>

                        </a-space>
                    </div>
                    <div class="col-lg-4">
                        <h3 class="bill_title text-left">Hình thức thanh toán</h3>
                        <a-form-item name="payment">
                            <a-radio-group v-model:value="formState.payment" @change="toggleBillBank">
                                <a-radio :style="radioStyle" :value="1"><b>Nhận hàng thanh toán tiền tại nhà Ship COD</b>
                                </a-radio>
                                <a-radio :style="radioStyle" :value="2">
                                    <b>Chuyển khoản ngân hàng</b>
                                </a-radio>
                            </a-radio-group>
                        </a-form-item>
                        <div class="bill-bank text-left" :class="{ 'bill-bank-visible': showBillBank }">
                            …………………………………………..<br>
                            Tài khoản Banking<br>
                            …………………………………………..<br>
                            Ngân hàng viễn thương Techcombank<br>
                            Chủ TK: Trịnh Công Minh<br>
                            Số TK: 1903 6397 346019<br>
                            Chi nhánh Quảng Ninh<br>
                        </div>
                        <h3 class="bill_title text-left">Thông tin thêm</h3>
                        <a-form-item name="note" label="Ghi chú đơn hàng (Tùy chọn)">
                            <a-textarea v-model:value="formState.note" placeholder="Ghi chú về đơn hàng"></a-textarea>
                        </a-form-item>
                    </div>

                    <div class="col-lg-4" style="border-left: 1px solid grey;">
                        <h3 class="bill_title text-left">Đơn hàng của bạn</h3>
                        <ul class="checkout-list">
                            <transition-group name="fade" key="">
                                <li v-for="(product) in getCarts" :key="product.id" class="checkout-product">
                                    <img :src="product.productimage.image" alt="" class="product-image">
                                    <p class="product-name">{{ product.name }}</p>
                                    <span class="product-price">{{ product.quantity }}sp</span>
                                </li>
                            </transition-group>
                        </ul>
                        <div class="text-left mb-5" style="display: flex;">
                            <span style="flex-grow: 1;"><b>Thành tiền:</b></span>
                            <span style="color: red;flex-grow: 1;"><b>{{ formatnumbers(getTotalPrice) }}</b></span>
                        </div>
                        <a-form-item>
                            <!-- <button type="submit" class="order-submit">Đặt hàng</button> -->
                            <a-button class="order-submit" :loading="iconLoading" html-type="submit">Đặt hàng</a-button>
                        </a-form-item>
                    </div>
                </div>
            </div>
        </a-form>
    </div>
</template>
<script>
import { ref } from 'vue';
import numeral from 'numeral';
import axios from 'axios';
import { useToast } from 'vue-toastification';
export default {
    name: 'CheckoutView',
    data() {
        return {
            formState: {
                name: '',
                address: '',
                number: '',
                payment: 1,
                note: ''
            },
            radioStyle: {
                display: 'flex',
                height: '30px',
                lineHeight: '30px',
            },
            showBillBank: false,
            iconLoading: false,
        }
    },
    created() {
        if (this.$store.state.user) {
            this.formState.name = this.$store.state.user.fullname;
            this.formState.address = this.$store.state.user.address;
            this.formState.number = this.$store.state.user.phonenumber;
            this.formState.email = this.$store.state.user.email;
        }
    },
    computed: {
        getCarts() {

            return this.$store.state.cart
        },
        getTotalPrice() {
            let total = 0;
            this.$store.state.cart.forEach(element => {
                total += element.price * element.quantity
            });
            return total
        }
    },
    methods: {
        formatnumbers(number) {
            return numeral(number).format('0,0') + 'đ'
        },
        onFinish() {
            // 1. Lấy dữ liệu từ formState
            this.iconLoading = true
            const data = {
                name: this.formState.name,
                address: this.formState.address,
                number: this.formState.number,
                email: this.formState.email,
                payment: this.formState.payment,
                note: this.formState.note,
                products: this.getCarts.map(product => ({
                    image: product.productimage.image,
                    productid: product.productid,
                    name: product.name,
                    quantity: product.quantity,
                    price: product.price,
                })),
                totalPrice: this.getTotalPrice,
            };

            axios.post('/save-data', data,)
                .then(response => {
                    window.location.href = response.data.redirectUrl
                    this.$store.commit('getCart', [])
                    this.$cookies.set('message', response.data.message)
                    // this.iconLoading = false;
                })
                .catch(error => {
                    this.iconLoading = false;
                    useToast().error("Thanh toán thất bại");
                    console.log(error)
                });

        }
        ,
        toggleBillBank() {
            if (this.formState.payment === 2) {
                this.showBillBank = true;
            } else {
                this.showBillBank = false;
            }
        }
    },
}
</script>
<style scoped>
.order-submit {
    border-radius: 0;
    width: 100%;
    height: fit-content;
    background-color: #ff4f00;
    color: white;
    border: none;
    outline: none;
    padding: 10px 0;
    font-size: 20px;
}

.order-submit:hover {
    color: white;
}

.bill_title {
    font-size: 14px;
    color: #222;
    border-left: 5px solid #ccc;
    background-color: #f5f5f5;
    line-height: 32px;
    width: 100%;
    padding-left: 9px;
    margin-top: 15px;
    margin-bottom: 10px;
    text-transform: uppercase;
}

.bill-bank {
    display: none;
    animation-name: slideOut;
    animation-duration: 0.5s;
}

.bill-bank-visible {
    display: block;
    animation-name: slideIn;
    animation-duration: 0.5s;
}

@keyframes slideIn {
    from {
        transform: translateY(100%);
    }

    to {
        transform: translateY(0);
    }
}

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
    max-height: 200px;
    overflow-y: scroll;
}

.checkout-product {
    display: grid;
    grid-template-columns: 2fr 3fr 2fr;
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