<script setup lang="ts">
import Card from '@/components/Card.vue';
import { Button } from '@/components/ui/button';
import { Head, Link } from '@inertiajs/vue3';
import { router } from '@inertiajs/vue3';
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
    player1: {
        id: number;
        name: string;
        points: number;
        percentage_drop: number;
    };
    player2: {
        id: number;
        name: string;
        points: number;
        percentage_drop: number;
    };
}>();

const giveUp = () => {
    router.visit(route('matchmaking.give-up'), {
    method: 'post',
    preserveState: true,
    preserveScroll: true,
    only: ['status', 'token', 'players'],
    onFinish: () => {
        router.visit(route('matchmaking'), {
            preserveState: true,
            preserveScroll: true,
        })
    }
  })
}
</script>

<template>
    <Head title="Game">
        <link rel="preconnect" href="https://rsms.me/" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
    </Head>
    <div class="flex flex-col items-center justify-center h-screen bg-image overflow-y-hidden">
        <div class="absolute inset-0 bg-black/88 "></div>
        
        <!-- game layout -->
        <div class="relative z-10 flex flex-col items-center w-full h-full justify-center border">
            
            <!-- seu deck -->
             <div class="flex flex-row items-center justify-center">
                 <div class="absolute px-3 w-full h-[200px] bottom-0 flex flex-row items-center justify-between">
                    <div class="w-[230px] p-4 h-full items-center flex flex-col gap-2 justify-end">
                        <div class="flex flex-row gap-2 items-center w-full">
                            <div class="w-[40px] h-[40px] border"></div>
                            <p>{{ player1 }}</p>
                        </div>
                        <div class="w-full bg-[#07EF9C]/40 h-[40px] border flex items-center justify-center">
                            <p class="font-bold">100/100</p>
                        </div>
                        <div class="w-full bg-[#EAD40C]/40 h-[40px] border flex items-center justify-center">
                            <p class="font-bold">100/100</p>
                        </div>
                    </div>
                    
                    <div class="w-[600px] h-full items-center flex justify-center">
                        <div class="flex flex-row gap-1 items-center justify-center pt-[80px] relative">
                            <Card
                                variant="compact"
                                v-for="(card, idx) in card_deck.slice(0, 5)"
                                :key="card.id"
                                :card="card"
                                :style="{
                                    overflow: 'hidden',
                                    height: '200px',
                                    transform: `rotate(${(idx - 2) * 1}deg)`,
                                    zIndex: 10 + idx
                                }"
                                class="transition-all duration-300 hover:z-50 hover:scale-130 hover:-translate-y-[100px] hover:rotate-0"
                            />
                        </div>
                    </div>

                    <div class="w-[200px] h-full flex flex-col gap-2 items-center justify-center">
                        <Button variant="game">
                            <p>Lorem</p>
                        </Button>
                        <Button variant="game">
                            <p>Lorem</p>
                        </Button>
                        <Button variant="game">
                            <p>Lorem</p>
                        </Button>
                    </div>
                </div>
             </div>

             <div class="flex flex-row items-center justify-center">
                 <div class="absolute p-2 w-full h-[200px] flex flex-row items-center justify-center">
                    
                    <div class="w-[500px] h-full border flex justify-center items-center">
                        <p>Cartas Jogadas</p>
                    </div>

                </div>
             </div>


             <!-- deck do adversario -->
             <div class="flex flex-row items-center justify-center">
                 <div class="absolute p-2 w-full h-[200px] top-0 flex flex-row items-center justify-between">
                    <div class="w-[200px] h-full flex flex-col gap-2 items-center justify-center">
                        <Button variant="game">
                            <p>Reportar</p>
                        </Button>
                        <Button variant="game">
                            <p @click="giveUp">Desistir (ff)</p>
                        </Button>
                    </div>
                    
                    <div class="w-[500px] h-full border border-blue-300 items-center flex justify-center">
                        <p>Cartas do adversario</p>
                    </div>

                    <div class="w-[200px] p-4 h-full items-center flex flex-col gap-2 justify-start">
                        <div class="flex flex-row gap-2 items-center w-full">
                            <div class="w-[40px] h-[40px] border"></div>
                            <p>{{ player2 }}</p>
                        </div>
                        <div class="w-full bg-[#07EF9C]/40 h-[40px] border flex items-center justify-center">
                            <p class="font-bold">100/100</p>
                        </div>
                    </div>
                </div>
             </div>
        </div>
    </div>
</template>