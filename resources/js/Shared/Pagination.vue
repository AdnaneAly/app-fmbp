<template>
    <ul class="pagination pagination-sm m-0 float-right">
        <li class="page-item">
            <Link class="page-link" :class="{'disabled' : props.prev == null}" :href="props.prev == null ? '' : props.prev">«</Link>
        </li>
        <li class="page-item" :class="{'active' : link.active}" v-for="link in computedLinks">
            <Link class="page-link" :href="link.url">{{ link.label }}</Link>
        </li>
        <li class="page-item">
            <Link class="page-link" :class="{'disabled' : props.next == null}" :href="props.next == null ? '' : props.next">»</Link>
        </li>
    </ul>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
    links: {
        type: Array,
        required: true,
    },
    prev: {
        type: String,
        default: null
    },
    next: {
        type: String,
        default: null
    }
});

const computedLinks = computed(() => {
    props.links.shift()
    props.links.pop()
    return props.links
})
</script>
