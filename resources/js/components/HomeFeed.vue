<script setup lang="ts">

const posts = [
    {
        id: 1,
        title: 'Inicio do projeto',
        description: 'Inicio do desenvolvimento do projeto, utilizando o framework Laravel para o backend e Vue.js para o frontend, com o objetivo de criar um jogo de cartas utilizando a lógica do PEDRA, PAPEL e TESOURA.',
        image: 'https://s2-techtudo.glbimg.com/Ibfpx3blykIH52_afrDnLdwYICA=/0x0:695x360/984x0/smart/filters:strip_icc()/i.s3.glbimg.com/v1/AUTH_08fbf48bc0524877943fe86e43087e7a/internal_photos/bs/2021/O/W/DA25h4QH2OKeHFSVVyfw/2016-04-08-16.jpg',
        created_at: '03/05/2025',
    },
]


</script>

<template>
    <div>
        <div class="text-white w-full py-[10vh] gap-3 flex flex-col">
            <h1 class="text-6xl font-bold max-w-3xl leading-tight">Um jogo de cartas usando PEDRA, PAPEL e TESOURA</h1>
            <p class="text-lg max-w-2xl text-gray-400">
                "Um jogo de cartas que usa a lógica do PEDRA, PAPEL e TESOURA."
            </p>
        </div>
    
        <div class="w-full h-full text-white">
            <h1 class="text-sm text-gray-400 font-bold mb-5">Atualizações</h1>
            <div class="flex flex-col mb-5 max-w-xl" v-for="post in posts" :key="post.id">
                <div class="flex flex-col gap-3">
                    <span class="flex flex-row items-center gap-3">
                        <h1 class="text-xl font-bold">{{post.title}}</h1>
                        <p class="text-gray-400 text-sm">{{post.created_at}}</p>
                    </span>
                    <p class="text-gray-400">{{post.description}}</p>
                </div>
            </div>
        </div>

    </div>

</template>