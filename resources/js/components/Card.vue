<script setup lang="ts">
import { defineProps } from 'vue';

interface CardProps {
    name: string;
    description: string;
    type: string;
    effect: string;
    rarity: string;
    cost: number;
    points: number;
    link_img: string;
    percentage_drop: number;
}

const props = defineProps<{
    card: CardProps;
}>();

const getRarityColor = (rarity: string) => {
    switch (rarity) {
        case 'Comum':
            return 'border-t-2 border-[#E8F6FD]';
        case 'Raro':
            return 'border-t-2 border-[#3AB3F3]';
        case 'Lendário':
            return 'border-t-2 border-[#F550DF]';
        case 'Mítico':
            return 'border-t-2 border-[#F2D341]';
    }
};

const getEffectColor = (effect: string) => {
    switch (effect) {
        case 'Ataque':
            return 'bg-[#DB1818]/80';
        case 'Defesa':
            return 'bg-[#111F46]/80';
        case 'Cura':
            return 'bg-[#5BC044]/80';
            
    }
}

</script>

<template>
<div 
        class="relative w-full aspect-[2/3] rounded-lg overflow-hidden transition-all duration-300 hover:scale-105">
        <img 
            :src="card.link_img" 
            :alt="card.name"
            class="w-full h-full object-cover"
        >

        <div class="absolute bottom-0 left-0 right-0 h-1/3 p-2 bg-[#191D1F]/90 text-white" :class="getRarityColor(card.rarity)">
            <p class="text-xs">{{ card.rarity }}</p>
            <h3 class="font-bold text-sm">{{ card.name }}</h3>
            <div class="flex justify-between items-center text-xs mt-1">
                <p>Custo:</p>
                <p>{{ card.cost }}</p>
            </div>
        </div>
        
        <div class="absolute top-0 left-0 right-0 p-2 flex flex-col gap-3 w-fit">
            <span class="px-2 py-1 rounded bg-[#81E1FF]/30 text-black">
                {{ card.type }}
            </span>
            <span class="px-2 py-1 w-fit rounded-tl-md rounded-br-md text-white font-bold text-xs" :class="getEffectColor(card.effect)">
                {{ card.points || 'N' }}
            </span>
        </div>
    </div>
</template>