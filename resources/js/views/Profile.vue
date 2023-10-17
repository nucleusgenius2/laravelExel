<template>
    <MainLayout :layout = 'route.meta.layout'>
        <template #content>

            <div class="flex-column-2">
                <div class="wrap-profile">

                    <h2>Ваш профиль</h2>
                    <div class="profile-el">
                        <span class="heading-field">Ваше имя</span>
                        <input v-model="data.name" class="field-style" autocomplete="off" type="text" name="name" required/>
                    </div>

                    <div class="profile-el">
                        <span class="heading-field">Ваш email</span>
                        <input v-model="data.email" class="field-style" autocomplete="off" type="email" name="email" required/>
                    </div>

                    <div class="profile-el">
                        <span class="heading-field">Старый пароль</span>
                        <input v-model="password" class="field-style"
                               type="password"
                               name="password"
                               required autocomplete="off"/>
                    </div>

                    <div class="profile-el">
                        <span class="heading-field">Новый пароль</span>
                        <input v-model="newPassword" class="field-style"
                               type="password"
                               name="password"
                               required autocomplete="off"/>
                    </div>

                    <div class="wrap-button-submit">
                        <div class="button-style-1" @click="updateProfile">
                            Обновить данные
                        </div>
                    </div>

                    <div class="wrap-error" v-if="error !==''">
                        {{ error }}
                    </div>

                    <div class="wrap-success" v-if="success !==''">
                        {{ success }}
                    </div>

                </div>

                <div class="wrap-balance">

                    <div class="last-operation">
                        <div>Загрузка exel документа: </div>

                        <div class="profile-el">
                            <input @change="onChangeFile" type="file" autocomplete="off"  name="file" required/>
                        </div>

                        <ButtonSave ref="saveButtonRef" @click="saveExel">Сохранить</ButtonSave>
                    </div>

                    <div class="error-upload" v-if="errorFile !==''">
                        {{ errorFile }}
                    </div>



                    <div class="show-button" @click="showList">Показать загруженный лист</div>
                    <div class="showList">

                        <div v-if="exelList">
                            <div v-for="(list, key) in exelList.data" class="wrap-game-list">
                                <div>{{ key }} )</div>
                                <div>{{ list.name }}</div>
                                <div>{{ list.date_row }}</div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>


        </template>
    </MainLayout>
</template>


<script setup>
import {onMounted, ref} from "vue";
import {authRequest} from "@/api.js";
import {useRoute} from "vue-router";
import ButtonSave from "@/components/admin/ButtonSave.vue";
const route = useRoute();

let data = ref({});
let exel = ref({});
let exelList = ref(false);
let password = ref('');
let newPassword = ref('');
let error = ref('');
let errorFile = ref('');
let success = ref('');
let newPasswordValidate = ref('');
let saveButtonRef = ref(null)


onMounted(
    async () => {
        let responsive = await authRequest('/api/profile', 'get');
        data.value = responsive.data;
    }
);



async function showList() {
    let responsive = await authRequest('/api/exel?page=1', 'get');
    exelList.value = responsive.data.json;
}


function onChangeFile(event) {
    exel.value = event.target.files[0];
}

async function saveExel(){

    //save or update
    let formData = new FormData();
    formData.append('file', exel.value);
    //create post
    let response = await authRequest('/api/exel', 'post', formData);

    if ( response.data.status  === 'success') {
        saveButtonRef.value.save()
        errorFile.value = '';
    }
    else {
        saveButtonRef.value.error()
        console.log(response.data);
        errorFile.value = response.data.text
    }


}

async function updateProfile() {

    if (data.value.name !== '' && data.value.name !== '' && password.value !== '') {

        //auth
        if (newPassword.value === '') {
            newPasswordValidate.value = 'none';
        } else {
            newPasswordValidate.value = newPassword.value;
        }

        let dataReq = {
            name: data.value.name,
            email: data.value.email,
            password: password.value,
            newPassword: newPasswordValidate.value,
        }

        let response = await authRequest('/api/profile', 'patch',  dataReq);

        if (response.data.status === 'success') {
            success.value = 'Данные обновлены';
            error.value = '';
        } else {
            error.value = 'Форма заполнена с ошибками';
            success.value = '';
        }

    } else {
        error.value = 'Не все обязательные поля заполнены';
        success.value = '';
    }
}

</script>


<style scoped>
    .field-style {
        font-size: 13px;
        border-color: #c2c2bf;
        background-color: rgb(249, 249, 249);
        border-radius: 3px;
        border-width: 1px;
        height: 35px;
        padding: 1px 2px 1px 10px;
        outline: none;
        transition: 0.3s;
        width: 100%;
        vertical-align: middle;
        box-shadow: 0 0 0 rgba(0, 0, 0, 0.075) inset;
        border-style: solid;
        margin: 0px;
        box-sizing: border-box;
        max-width: 100%;
    }

    input:focus, textarea:focus {
        border-color: #4e41d9;
    }

    .wrap-button-submit {
        text-align: center;
    }

    .button-style-1 {
        font-size: 14px;
        line-height: 18px;
        font-weight: 400;
        font-style: normal;
        text-transform: none;
        letter-spacing: 0em;
        border-radius: 3px;
        padding: 1em 1.5em;
        background: #192B3B;
        border-color: transparent;
        color: #ffffff;
        display: inline-block;
        cursor: pointer;
        transition: 0.3s;
        width: 100%;
    }

    .button-style-1:hover {
        background: #4e41d9;
    }

    .wrap-profile {
        max-width: 500px;
        margin: auto;
    }

    .profile-el {
        margin-bottom: 20px;
    }

    .wrap-error {
        max-width: 500px;
        margin-left: auto;
        margin-right: auto;
        padding: 20px;
        box-shadow: 0 0 5px #00000040;
        color: #df3627;
        font-size: 18px;
        text-align: center;
        margin-top: 9px;
    }

    .wrap-success {
        max-width: 500px;
        margin-left: auto;
        margin-right: auto;
        padding: 20px;
        box-shadow: 0 0 5px #00000040;
        color: #30ac2d;
        font-size: 18px;
        text-align: center;
        margin-top: 9px;
    }

    .flex-column-2 {
        display: flex;
        flex-wrap: wrap;
    }
    .flex-column-2 > div {
        flex-basis: 50%
    }
    .balance span:last-child{
        font-weight:600;
    }
    .last-operation {
        margin-top: 20px;
    }
    .operation {
        display: flex;
        flex-wrap: wrap;
    }

    .operation > div {
        margin-right:10px;
    }

    .plus {
        color: #20b02b;
    }
    .minus {
        color: #c62929;
    }
    .error-upload {
        margin-top:30px;
        color: #df3627;
    }
    .wrap-game-list {
        display:flex;
    }
    .wrap-game-list div {
        margin-right:10px;
    }
    .showList {
        max-height:500px;
        overflow-y: scroll;
        max-width: 400px;
    }
    .show-button {
        margin-top:20px;
        font-weight:600;
        cursor:pointer;
        transition: 0.3s;
    }
    .show-button:hover {
        color:#09be92;
    }
</style>
