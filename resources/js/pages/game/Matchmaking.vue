<script setup lang="ts">
import Welcome from '@/pages/Welcome.vue'
import Button from '@/components/ui/button/Button.vue'
import { router } from '@inertiajs/vue3'
import { onMounted, onBeforeUnmount } from 'vue'

defineOptions({
  layout: Welcome,
})

const props = defineProps<{
  status: string
  token?: string
  players?: number[]
  queue?: number[]
}>()

let interval: number | undefined

const searchMatch = () => {
  router.visit(route('matchmaking.search'), {
    method: 'post',
    preserveState: true,
    preserveScroll: true,
    only: ['status', 'token', 'players', 'queue'],
    onFinish: () => {
      router.visit(route('matchmaking'), {
        preserveState: true,
        preserveScroll: true,
      })
    }
  })

  interval = setInterval(() => {
    if (props.status !== 'matched') {
      router.visit(route('matchmaking.search'), {
        method: 'post',
        preserveState: true,
        preserveScroll: true,
        only: ['status', 'token', 'players'],
      })
    } else {
      clearInterval(interval)
    }
  }, 2000)
}

onBeforeUnmount(() => {
  if (interval) clearInterval(interval)
})
</script>

<template>
  <div class="mt-[20vh] flex flex-col items-center justify-center">
    <Button @click="searchMatch">
      Buscar Fila
    </Button>

    <div v-if="status === 'searching'" class="mt-4 text-gray-600">
      Procurando partida...
    </div>

    <div v-if="status === 'matched'" class="mt-4 text-green-600">
      Partida encontrada! <br />
      <span class="font-mono">Token: {{ token }}</span>
    </div>
  </div>
</template>
