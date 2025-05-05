<script setup lang="ts">
import Welcome from '@/pages/Welcome.vue';
import { ref, computed } from 'vue'
import Card from '@/components/Card.vue';

defineOptions({
    layout: Welcome,
})

const props = defineProps<{
    cards: {
        id: number;
        name: string;
        description: string;
        type: string;
        effect: string;
        rarity: string;
        cost: number;
        link_img: string;
        percentage_drop: number;
    }[];
}>();

const selectedType = ref<string | null>(null)
const selectedEffect = ref<string | null>(null)
const selectedRarity = ref<string | null>(null)

const filteredCards = computed(() => {
    return props.cards.filter(card => {
        const typeMatch = !selectedType.value || card.type === selectedType.value;
        const effectMatch = !selectedEffect.value || card.effect === selectedEffect.value;
        const rarityMatch = !selectedRarity.value || card.rarity === selectedRarity.value;
        return typeMatch && effectMatch && rarityMatch;
    });
});

const clearFilters = () => {
    selectedType.value = null
    selectedEffect.value = null
    selectedRarity.value = null
}
</script>

<template>
    <div class="flex flex-col gap-4 py-[10vh]">
        <h1 class="text-white text-2xl font-bold">Toda as cartas</h1>
        <div class="text-white flex flex-row gap-2">
            <div class="p-4 bg-[#111111] flex flex-col gap-2 h-fit">
                <!-- Filtro: Tipo -->
                <div class="w-[120px]">
                    <p class="text-white font-bold mb-2 text-sm">Tipo</p>
                    <div class="flex flex-col gap-1">
                        <button 
                            v-for="type in ['Papel', 'Pedra', 'Tesoura']" 
                            :key="type"
                            @click="selectedType = selectedType === type ? null : type"
                            class="hover-effect-filter"
                            :class="{ 'bg-[#81E1FF] text-black': selectedType === type }"
                        >
                            {{ type }}
                        </button>
                    </div>
                </div>

                <!-- Filtro: Efeito -->
                <div class="w-full">
                    <p class="text-white font-bold mb-2 text-sm">Efeito</p>
                    <div class="flex flex-col gap-1">
                        <button 
                            v-for="effect in ['Ataque', 'Defesa', 'Cura']" 
                            :key="effect"
                            @click="selectedEffect = selectedEffect === effect ? null : effect"
                            class="hover-effect-filter"
                            :class="{ 'bg-[#81E1FF] text-black': selectedEffect === effect }"
                        >
                            {{ effect }}
                        </button>
                    </div>
                </div>

                <!-- Filtro: Raridade -->
                <div class="w-full">
                    <p class="text-white font-bold mb-2 text-sm">Raridade</p>
                    <div class="flex flex-col gap-1">
                        <button 
                            v-for="rarity in ['Comum', 'Raro', 'Lendário', 'Mítico']" 
                            :key="rarity"
                            @click="selectedRarity = selectedRarity === rarity ? null : rarity"
                            class="hover-effect-filter"
                            :class="{ 'bg-[#81E1FF] text-black': selectedRarity === rarity }"
                        >
                            {{ rarity }}
                        </button>
            </div>
                </div>
            </div>
            <div class="grid grid-cols-4 gap-4 mb-6 px-2">
                <Card v-for="card in filteredCards" :key="card.id" :card="card" class="aspect-[2/3]" />
            </div>

        </div>
    </div>
</template>