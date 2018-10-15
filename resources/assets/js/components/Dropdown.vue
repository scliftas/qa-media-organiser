<template>
    <div>
        <li @click="toggle()" :class="'sidebar-nav-item p-4 d-flex hvr-grow'">
            <span class="my-auto ml-3">{{ this.title }}</span>
            <fa :icon="this.toggled ? 'caret-up' : 'caret-down'" size="lg" class="dropdown-toggle"/>
        </li>
        <transition name="slide-fade">
            <ul v-if="toggled" class="list-unstyled components">
                <li v-for="(item, index) in this.items" :key="index" @click="$emit('itemChosen', item)" :class="'sidebar-nav-item p-4 pl-5 d-flex hvr-grow'">{{ item.name }}</li>
            </ul>
        </transition>
    </div>
</template>

<script>
export default {
    data: () => ({
        toggled: false
    }),

    props: {
        title: {
            type: String,
            default: ''
        },
        items: {
            type: Array,
            default: []
        }
    },

    methods: {
        toggle () {
            this.toggled = !this.toggled
        }
    }
}
</script>