<script setup lang="ts">
import { FetchTrivia, defaultClient as client, TriviaApiResponseInterface } from '../assets/ts';
import { onMounted, Ref, ref } from 'vue'

// Component Imports
import LoadingSpinner from './LoadingSpinner.vue'
import DebugGrid from './DebugGrid.vue';
import Header from './Header.vue'
import TriviaQuestions from './TriviaQuestions.vue';
import TriviaFailed from './TriviaFailed.vue';
import TriviaWon from './TriviaWon.vue'

// state variables for game flow
const has_started_a_game = ref<boolean>(false)
const api_response_failed = ref<boolean>(false)
const has_failed_the_trivia = ref<boolean>(false)
const isFetching = ref<boolean>(false)
const correctly_answered_questions = ref<number>(0)
const MAX_QUESTIONS = 4

// data variables
const triviaEndpointResponse = ref<TriviaApiResponseInterface>()
const suffledTriviaQuestions = ref<string[]>([])

/** Flow for cycling throught the questions  */
async function GetTrivia() {
    isFetching.value = true
    has_started_a_game.value = true
    const res = await FetchTrivia(client);

    if (res.status === 200) {
        const data = await res.json()

        /**
         * Create a deep copy of the original list, so that you don't 
         * manipulate the data variable value
         * Reference -> https://www.samanthaming.com/tidbits/50-how-to-deep-clone-an-array/
         */
        let trivia_copy = [...data.data]

        isFetching.value = false
        triviaEndpointResponse.value = Object.assign({}, data);
        /** Shuffle the array of the returned api response */
        suffledTriviaQuestions.value = trivia_copy.sort(() => Math.random() - 0.5)
    }
    /** If the API does not return status 200, stop the game */
    else {
        api_response_failed.value = true
    }
}

function validateUserChoice(chosen_answer: string) {
    if (chosen_answer === triviaEndpointResponse.value.data[0]) {
        correctly_answered_questions.value += 1
        GetTrivia()
    } else {
        has_failed_the_trivia.value = true
    }
}

function restartTheGame() {
    GetTrivia()
    correctly_answered_questions.value = 0
    has_failed_the_trivia.value = false
    api_response_failed.value = false
}

// Start the flow of the game, when the page is loaded
onMounted(() => {
    GetTrivia()
})

</script>

<template>

    <Header />

    <!-- Mini explanation for the game -->
    <div class="border-rad-3 fw-400 leading-6 mb-7 opacity-70 fs-7">
        To win the game, answer {{ MAX_QUESTIONS }} trivia connections correctly!
        <div>
            Currently, you have answered {{ correctly_answered_questions }} questions correctly,
            {{ MAX_QUESTIONS - correctly_answered_questions }} more to win!
        </div>
    </div>

    <!-- If is fetching, return a loading spinner -->
    <div v-if="isFetching && correctly_answered_questions != MAX_QUESTIONS && !api_response_failed">
        <LoadingSpinner />
    </div>

    <!-- If is not fetching and game has started and not 
    enought correct answers, show the grid -->
    <div
        v-if="(!isFetching && has_started_a_game && correctly_answered_questions < MAX_QUESTIONS) && triviaEndpointResponse">
        <TriviaQuestions :year="triviaEndpointResponse.year" :suffledTriviaQuestions="suffledTriviaQuestions"
            :has_failed_the_trivia="has_failed_the_trivia" @validate_user_choice="validateUserChoice($event)" />

        <DebugGrid :values="
        [
            { label: `correct_answer`, value: triviaEndpointResponse.data[0] },
        ]" />
    </div>

    <div v-if="(correctly_answered_questions == MAX_QUESTIONS)">
        <TriviaWon @restart_the_game="restartTheGame()" />
    </div>

    <div v-if="has_failed_the_trivia && triviaEndpointResponse">
        <TriviaFailed :correct_answer="triviaEndpointResponse.data[0]" @restart_the_game="restartTheGame()" />
    </div>

    <div v-if="api_response_failed">
        <div class="flex-center text-center my-4">
            <div class="bg-red-700 text-white border-rad-4 px-4 py-2 fw-600">Whoops, something went wrong!</div>
        </div>
    </div>
</template>
