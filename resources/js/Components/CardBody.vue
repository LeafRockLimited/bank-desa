<template>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" 
        :class="{
            'w-fit' : fit
        }">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <slot name="content"></slot>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props:{
        fit: Boolean
    }
}
</script>