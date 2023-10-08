import { Store } from "vuex";

const localStoragePlugin = (store: Store<any>) => {
  store.watch(
    (state) => state.cart,
    (cart) => {
      localStorage.setItem('cart', JSON.stringify(cart));
    },
    { deep: true }
  );
  const cart = localStorage.getItem('cart');
  if (cart) {
    store.commit('setCart', JSON.parse(cart));
  }
};

export default localStoragePlugin;
