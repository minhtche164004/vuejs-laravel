<template>
    <div class="listitem col-lg-3">
        <ul class="main-menu">
            <li v-for="(item, index) in listitem" :key="index">
                <a href="#">
                    {{ item }}
                </a>
            </li>
        </ul>
    </div>
</template>
<script>
export default {
    data() {
        return {
            listitem: ['Laptop mới', 'Laptop cũ', 'Linh kiện máy in', 'Linh kiện laptop', 'Linh kiện PC', 'Thiết bị mạng'
                , 'Surface', 'Macbook', 'Máy in', 'Camera', 'Thiết bị ngoại vi', 'BÀN - GHẾ GAMING'
            ]
        }
    },
}
</script>