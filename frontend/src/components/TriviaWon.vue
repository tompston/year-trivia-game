<script setup lang="ts">

defineEmits(["restart_the_game"]);
</script>

<template>
    <div class="flex-center fw-700 flex-col">
        <h4>Congrats, You won the game!</h4>
        <div class="mt-3">
            <button class="border fw-600 fs-10 py-2 px-3 transition-colors hover:bg-black hover:text-white"
                @click="$emit('restart_the_game')">RESTART THE GAME</button>
        </div>
    </div>
</template>

