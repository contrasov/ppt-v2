<script setup lang="ts">
import Paper from '@/components/type/Paper.vue';
import Rock from '@/components/type/Rock.vue';
import Scissors from '@/components/type/Scissors.vue';

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
    variant?: 'default' | 'compact' | 'hover';
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

const getCardType = (type: string) => {
    switch (type) {
        case 'Papel':
            return Paper;
        case 'Pedra':
            return Rock;
        case 'Tesoura':
            return Scissors;
    }
}

const getCardTypeColor = (type: string) => {
    switch (type) {
        case 'Papel':
            return 'bg-[#355863]';
        case 'Pedra':
            return 'bg-[#68362B]';
        case 'Tesoura':
            return 'bg-[#807548]';
    }
}
</script>

<template>
<div 
        class="relative w-full overflow-hidden"
        :class="props.variant === 'compact' ? 'aspect-[2/3] cursor-pointer' : 'w-full h-full'"
        >
        <img 
            :src="card.link_img" 
            :alt="card.name"
            class="w-full h-full object-cover"
        >

        <div class="absolute top-0 left-0 right-0 p-2 flex flex-col gap-2 w-fit">
            <span class="w-fit rounded-br-md rounded-tl-md p-1" :class="getCardTypeColor(card.type)">
                <component :is="getCardType(card.type)"
                :class="props.variant === 'compact' ? 'w-4 h-4' : 'w-6 h-6'"
                />
            </span>
            <template v-if="props.variant === 'compact'">
                <span class="text-[10px] text-gray-300 bg-[#007E7E] rounded-md p-1 flex items-center justify-center">{{ card.cost }}</span>
            </template>
            <span
                class="W-6 h-6 flex p-1 w-full justify-center rounded-tl-md rounded-br-md text-white font-bold text-xs"
                :class="getEffectColor(card.effect)"
            >
                {{ card.points || 'N' }}
            </span>
        </div>
        <div
            v-if="props.variant !== 'hover'"
            class="absolute bottom-0 left-0 right-0 h-1/3 p-3 bg-[#191D1F] text-white"
            :class="getRarityColor(card.rarity)"
        >
            <span class="flex flex-col gap-1">
                <h3
                    class="font-bold"
                    :class="props.variant === 'compact' ? 'text-xs' : 'text-sm'"
                >
                    {{ card.name }}
                </h3>
                <p class="text-xs text-gray-400"
                :class="props.variant === 'compact' ? 'text-[8px]' : 'text-xs'"
                >{{ card.description }}</p>
            </span>
            <div v-if="props.variant !== 'compact'" class="flex justify-between items-center text-xs mt-2">
                <p>Custo:</p>
                <p>{{ card.cost }}</p>
            </div>
        </div>
        <div
            v-else
            class="absolute bottom-0 left-0 right-0 h-1/3 p-3 bg-[#191D1F] text-white"
            :class="getRarityColor(card.rarity)"
        >
            <span class="flex flex-col gap-1">
                <h3 class="font-bold text-xs">{{ card.name }}</h3>
                <p class="text-xs text-gray-400">{{ card.description }}</p>
            </span>
        </div>
    </div>
</template>