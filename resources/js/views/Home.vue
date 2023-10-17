<template>
    <MainLayout :layout = 'route.meta.layout'>
        <template #content>

            <div class="wrap-block-1">
                <div class="max">
                    <div class="two-swap">
                        <div class="two-block doverie">
                            <h2> Почему стоит играть на RU сервере?</h2>
                            <p class="text"> Удобный сервер с русскоязычной техподдержкой и возможность перенести свой
                                рейтинг. </p>
                        </div>

                        <div class="two-block">
                            <p class="img-txt"><img src="/images/Group_5_2x-1.png" alt="img"> Не нужно покупать игру в стим
                                (покупка невозможна для РФ) </p>
                            <p class="img-txt"><img src="/images/Group_7_2x.png" alt="img"> Выбор между классикой (faf) и новым
                                балансом.</p>
                            <p class="img-txt"><img src="/images/Group_6_2x.png" alt="img"> Нет перманентных банов, лояльное
                                отношение к игрокам </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="fon-02 home-rate-block">
                <div class="max">

                    <div class="two-swap">
                        <div class="two-block">
                            <img src="/images/Group-223234.png" alt="img">
                        </div>

                        <div class="two-block">
                            <h2> Хотите сохранить свой рейтинг? </h2>
                            <p class="text"> 1. Зарегистрируйтесь на сайте</p>
                            <p class="text"> 2. Зайдите в официальный <a href="https://discord.gg/4eaPAAjr95" target="_bank"
                                                                         rel="noopener">дискорд</a> RU сервера. </p>
                            <p class="text"> 3. Напишите сообщение в ЛС nucleus_genius</p>
                            <p class="text"> 4. В сообщении укажите ваш Username (ник) на RU сервере и приложите скриншот где
                                виден ваш ник и рейтинг на оригинальном сервере. Ваш никнейм дискорда должен совпадать или
                                частично совпадать с вашим игровым ником на оригинальном сервере (или с ником из истории ваших
                                имен на оригинальном сервере). За предоставление ложных данных или попытку назваться чужим
                                именем рейтинг будет обнулен, без возможности повторной заявки.
                            </p>
                        </div>
                    </div>

                </div>
            </div>


            <div class="m-top max">
                <h2> Последние новости </h2>
            </div>


        </template>
    </MainLayout>
</template>


<script setup>
import {useRoute} from "vue-router";
const route = useRoute();
</script>


<style scoped>

</style>


