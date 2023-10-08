import { createStore } from "vuex";
import * as types from "./mutation-types";
import { useToast } from "vue-toastification";
import localStoragePlugin from './localStoragePlugin';
import createMutationsSharer from "vuex-shared-mutations";
import { format } from "date-fns";

interface State {
    loading: boolean;
    cart: CartItem[];
    user: {};
}

interface CartItem {
    productid: number;
    quantity: number;
    time: string;
}

const store = createStore<State>({
    state() {
        return {
            loading: false,
            cart: [],
            user: {},
        };
    },
    getters: {
        getCount(state) {
            return Math.floor(state.cart.length * Math.random());
        },
        getCartLength(state) {
            return state.cart.length;
        },
    },
    mutations: {
        increment(state, payload: CartItem) {
            console.log(payload.productid);
            const existingItem = state.cart.find(item => item.productid === payload.productid);

            if (existingItem) {
                state.cart = state.cart.map(item => {
                    if (item.productid === payload.productid) {
                        item.quantity++;
                    }
                    return item;
                });
            } else {
                state.cart.push({ ...payload, time: format(new Date(), "HH:mm:ss dd/MM/yyyy"), quantity: 1 });
            }
        },
        setLoading(state, isLoading: boolean) {
            state.loading = isLoading;
        },
        getCart(state, payload: CartItem[] | null) {
            if (payload === null || payload === undefined) {
                state.cart = [];
            } else {
                state.cart = payload;
            }
        },
        setCart(state, cart: CartItem[]) {
            state.cart = cart;
        },
        delete(state, payload: number) {
            state.cart = state.cart.filter(item => item.productid !== payload);
        },
        adjustQuantity(state, payload: { productid: number; count: number }) {
            state.cart = state.cart.map(item => {
                if (item.productid === payload.productid) {
                    item.quantity += payload.count;
                }
                return item;
            });
        },
        setUser(state, payload: {}) {
            state.user = payload;
        },
    },
    actions: {
        increment({ commit }, payload: CartItem) {
            commit('setLoading', true);
            setTimeout(() => {
                commit('increment', payload);
                commit('setLoading', false);
                useToast().success('Thêm vào giỏ hàng thành công!', { timeout: 1000 });
            }, 1000);
        },
        delete({ commit }, payload: number) {
            commit('delete', payload);
        },
    },
    plugins: [localStoragePlugin, createMutationsSharer({ predicate: ["increment", "adjustQuantity", "delete", "getCart"] })],
});

export default store;
