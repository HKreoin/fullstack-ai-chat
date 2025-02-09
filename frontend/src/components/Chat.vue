<script
    setup
>
import { ref, unref, watch} from 'vue'
import axios from 'axios'

const baseUrl = import.meta.env.VITE_API_URL
const placeholder = ref('Введите запрос')
const isListening = ref(false)
const answer = ref('')
const loading = ref(false)

const form = ref({
  message: '',
})

const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition

const recognition = new SpeechRecognition()

recognition.continuous = true
recognition.interimResults = true
recognition.lang = unref('ru-RU')

recognition.onresult = (event) => {
  form.value.message = Array.from(event.results)
      .map((result) => result[0])
      .map((result) => result.transcript)
      .join("");
};
recognition.onerror = (event) => {
  error.value = 'Speech recognition error detected: ' + event.error
}

watch(isListening, () => {
  if (isListening.value) {
    placeholder.value = 'Микрофон записывает'
    recognition.start()
  } else {
    placeholder.value = 'Введите запрос'
    recognition.stop()
  }
})

const submit = async () => {
  loading.value = true
  await axios.get(`${baseUrl}/chat`, {
    params: {
      message: form.value.message
    }
  })
      .then(function (res) {
        answer.value = res.data.message
        loading.value = false
      })
      .catch(function (error) {
        console.log(error);
      })
}
</script>

<template>
  <div class="bg-gray-200">
    <header class="bg-gray-800 mb-5">
      <a
          class="logo"
          href="/"
      >Smart Chat</a>
    </header>
    <main>
      <div class="flex justify-center items-center h-screen">
        <div class="flex-column">
          <form
              action=""
              @submit.prevent="submit"
          >
            <label
                class="title"
            >Введите запрос:</label>
            <textarea
                v-model="form.message"
                type="text"
                rows="5"
                class="w-3xl resize-none mb-2"
                :placeholder="placeholder"
            ></textarea>
            <div class="flex justify-end gap-2">
              <button
                  type="button"
                  class="btn w-10 "
                  :class="{speech: isListening}"
                  @click="isListening = !isListening"
              >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="#ffffff"
                    version="1.1"
                    id="Capa_1"
                    viewBox="0 0 58 58"
                    xml:space="preserve"
                >
                <g>
	                <path d="M44,28c-0.552,0-1,0.447-1,1v6c0,7.72-6.28,14-14,14s-14-6.28-14-14v-6c0-0.553-0.448-1-1-1s-1,0.447-1,1v6   c0,8.485,6.644,15.429,15,15.949V56h-5c-0.552,0-1,0.447-1,1s0.448,1,1,1h12c0.552,0,1-0.447,1-1s-0.448-1-1-1h-5v-5.051   c8.356-0.52,15-7.465,15-15.949v-6C45,28.447,44.552,28,44,28z"/>
                  <path d="M29,46c6.065,0,11-4.935,11-11V11c0-6.065-4.935-11-11-11S18,4.935,18,11v24C18,41.065,22.935,46,29,46z"/>
                </g>
              </svg>
              </button>
              <button
                  :disabled="form.processing"
                  class="btn"
              >Отправить запрос
              </button>
            </div>
          </form>
          <div
              v-if="loading"

          ><h2 class="title animate-pulse">Ожидание ответа...</h2>
          </div>
          <div
              v-if="answer"
              class="mt-4 p-4 bg-gray-50 rounded max-w-3xl"
          >
            <h2 class="title">Ответ:</h2>
            <p>{{ answer }}</p>
          </div>
        </div>
      </div>
    </main>
  </div>
</template>