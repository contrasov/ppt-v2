<script setup lang="ts">
import Welcome from '@/pages/Welcome.vue';
import { Button } from '@/components/ui/button';
import { Package2 } from 'lucide-vue-next';
import { useForm } from '@inertiajs/vue3';
import Card from '@/components/Card.vue';
import { 
    Carousel, 
    CarouselContent, 
    CarouselItem, 
    CarouselNext, 
    CarouselPrevious 
} from '@/components/ui/carousel'

defineOptions({
    layout: Welcome,
})

const form = useForm({
    name: '',
    description: '',
});

const props = defineProps<{
    decks: {
        id: number;
        name: string;
        description: string;
    }[];
    card_deck: {
        id: number;
        name: string;
        description: string;
        type: string;
        effect: string;
        rarity: string;
        cost: number;
        link_img: string;
        points: number;
        percentage_drop: number;
    }[];
}>();


const createInitialDeck = () => {
    form.post('/decks/initial');
}
</script>

<template>
    <div class="flex flex-col gap-4 py-[10vh] w-full">
        <div class="flex justify-between items-center">
            <h1 class="text-white text-2xl font-bold">Seus decks</h1>
            <Button @click="createInitialDeck"><Package2 class="w-4 h-4" />Receber Deck inicial</Button>
        </div>
        <div class="flex flex-col gap-4 w-full">
            <div class="flex flex-col gap-4 w-full">
                <div class="flex flex-col gap-4 w-full" v-for="deck in decks" :key="deck.id">
                    <span class="flex flex-row gap-2 items-center">
                        <h2 class="text-white text-lg font-bold">{{ deck.name }}</h2>
                        <span class="text-white text-sm">-</span>
                        <p class="text-gray-400 text-sm">{{ deck.description }}</p>
                    </span>
                    <div class="grid grid-cols-5 gap-2 items-center justify-center">
                        <Card v-for="card in card_deck" :key="card.id" :card="card" class="aspect-[2/3]" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>