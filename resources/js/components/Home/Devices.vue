<template>
    <div>
        <h2 class="device">
            <label for="">Thiết bị mạng</label>
        </h2>
        <div class="list-device row">
            <div v-for="device in devices" :key="device.productid" class="items col-lg-3 col-md-6 col-sm-6 col-6">
                <a href="#">
                    <img :src="device.productimage.image" :alt="device.name">
                </a>
                <a href="#" class="name">
                    <div class="font-weight-bold">{{ device.name }}</div>
                </a>
                <div class="price">{{ formatnumbers(device.price) }}</div>
                <div class="status">{{ device.out_of_stock == 1 ? 'Sẵn hàng' : 'Hết hàng' }}</div>
                <div class="overlay" v-if="loading">
                    <a-spin></a-spin>
                </div>
                <a-button @click="addonetocart(device)" type="primary" danger style="width: 100%;">Thêm vào giỏ
                    hàng</a-button>
            </div>
        </div>
    </div>
</template>
<script>
import numeral from 'numeral';
import * as types from '../../store/mutation-types'
import { mapMutations } from 'vuex'
import { h } from 'vue'
import { LoadingOutlined } from '@ant-design/icons-vue';
import { format } from "date-fns";
import axios from 'axios';

export default {
    name: 'Devices',
    data() {
        return {
            devices: [

            ]
        }
    },
    methods: {
        formatnumbers(number) {
            return numeral(number).format('0,0') + 'đ'
        },
        addonetocart(device) {
            this.$store.dispatch('increment', device)
        },
        ...mapMutations(
            [types.ADD_TO_CART]
        ),
    },
    computed: {
        loading() {
            return this.$store.state.loading;
        },
        indicator() {
            return h(LoadingOutlined, {
                style: {
                    fontSize: '24px',
                },
                spin: true,
            });
        },
    },
    created() {
        axios.get('/api/getproduct', undefined)
            .then(respones => {
                console.log(respones)
                this.devices = respones.data.productlist
            })
    }

}
</script>