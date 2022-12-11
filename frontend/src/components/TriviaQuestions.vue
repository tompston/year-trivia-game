<script setup lang="ts">

defineProps<{
    year: string;
    suffledTriviaQuestions: string[];
    has_failed_the_trivia: boolean;
}>();


defineEmits(["validate_user_choice"]);

</script>

<template>
    <div>
        <h4 class="leading-none my-3 fw-700">
            {{ year }}
            was the year, when ...
        </h4>
    </div>

    <hr class="my-3 hr-1-3" />

    <div class="grid grid-cols-4 gap-2 sm:grid-cols-2">
        <div v-for="fact in suffledTriviaQuestions" v-bind:key="fact">
            <div class="bg-light-select-1 p-[18px] border-rad-4 min-h-[210px] fw-400 h-full">
                <div class="grid grid-rows-[1fr_auto] h-full">
                    <div class="opacity-70 fs-8">
                        {{ fact }}
                    </div>
                    <div class="mt-2">
                        <button :class="{ 'opacity-20': has_failed_the_trivia }" :disabled="has_failed_the_trivia"
                            @click="$emit('validate_user_choice', fact)" class="fs-9 fw-700 bg-gray-400 text-white px-3 py-1.5 border-rad-4 transition-colors
                            hover:bg-gray-500">
                            SUBMIT
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>
