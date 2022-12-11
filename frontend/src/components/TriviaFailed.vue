<script setup lang="ts">

defineProps<{
    correct_answer: string;
}>();

defineEmits(["restart_the_game"]);

</script>

<template>

    <div class="flex-center mt-4 text-center">
        <div class="bg-red-700 text-white p-5 border-rad-2">
            <h5 class="fw-700">Whoops, you picked the incorrect answer!</h5>
            <div class="flex-center flex-col">
                The correct answer in this case was :
                <div class="max-w-[400px] opacity-60 font-mono text-[13px]">
                    {{ correct_answer }}
                </div>
            </div>
            <div class="mt-3">
                <button
                    class="border border-white fw-600 fs-10 py-2 px-3 transition-colors hover:bg-white hover:text-black"
                    @click="$emit('restart_the_game')">RESTART THE GAME</button>
            </div>
        </div>
    </div>
</template>