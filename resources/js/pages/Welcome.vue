<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { LogOut } from 'lucide-vue-next';
</script>

<template>
    <Head title="Welcome">
        <link rel="preconnect" href="https://rsms.me/" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
    </Head>
    <div class="flex flex-col min-h-screen items-center text-[#1b1b18] bg-image">
        <div class="fixed inset-0 bg-[#14141D]/20 backdrop-blur-xl"></div>
        <div class="relative z-10 flex flex-col items-center w-full h-full justify-center">
            <header class="p-4 not-has-[nav]:hidden mb-6 w-full text-sm">
                <nav class="flex items-center justify-between gap-2">
                    <div class="flex items-center gap-2">
                    <h1 class="text-[#C5C7C6] text-2xl font-bold mr-6">PPT 2</h1>


                    <Link class="nav-link" :href="route('home')">
                        <Home class="h-4 w-4"/>
                        <span>Início</span>
                    </Link>

                    <Link class="nav-link" :href="route('decks.all')">
                        <Home class="h-4 w-4"/>
                        <span>Deck</span>
                    </Link>

                    <Link class="nav-link" :href="route('home')">
                        <Home class="h-4 w-4"/>
                        <span>Rank</span>
                    </Link>

                    <Link class="nav-link" :href="route('cards.all')">
                        <Home class="h-4 w-4"/>
                        <span>Cartas</span>
                    </Link>
                </div>

                <!-- sintase talvez errada -->
                <div class="flex items-center gap-2">
                    <div class="flex items-center gap-2" v-if="$page.props.auth.user">
                        <h1 class="text-black h-9 py-2 px-4 bg-[#81E1FF]" >{{ $page.props.auth.user.username }}</h1>
                        <div class="flex items-center gap-2">
                            <Link class="py-2 px-4 h-9 border flex items-center border-[#C5C7C6] text-[#C5C7C6] hover:border-[#81E1FF] hover:bg-[#81E1FF]/90 hover:text-black cursor-pointer" :href="route('matchmaking')" as="button">
                                <p>Jogar</p>
                            </Link>
                            <Link class="py-2 px-4 h-9 border border-[#C5C7C6] text-[#C5C7C6] hover:border-[#81E1FF] hover:bg-[#81E1FF]/90 hover:text-black cursor-pointer" method="post" :href="route('logout')" as="button">
                                <LogOut class="h-4 w-4"/>
                            </Link>
                        </div>
                    </div>
                                
                    <template v-else>
                        <Link
                            :href="route('login')"
                            class="nav-link-button"
                        >
                            Entrar
                        </Link>
                        <Link
                            :href="route('register')"
                            class="nav-link-button"
                        >
                            Criar conta
                        </Link>
                    </template>
                </div>
            </nav>
        </header>
            <div class="duration-750 starting:opacity-0 flex w-full h-full justify-center opacity-100 transition-opacity lg:grow">
                <main class="flex h-full w-full justify-center overflow-hidden lg:max-w-6xl lg:flex-row">
                    <slot/>
                </main>
            </div>
        </div>
    </div>
</template>
