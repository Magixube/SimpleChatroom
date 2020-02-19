<template>
    <div class="container">
        <form @submit.prevent="onSubmit">
            <div class="form-group">
                <label for="InputEmail">信箱</label>
                <input
                    type="email"
                    class="form-control"
                    id="InputEmail"
                    v-model="email"
                    :class="{'is-invalid': $v.email.$error}"
                    @blur="$v.email.$touch()">
                    <p v-if="!$v.email.email">請輸入正確的電子信箱格式。</p>
                    <p v-if="!$v.email.required">這個欄位不能是空的。</p>
            </div>
            <div class="form-group">
                <label for="InputPasaword">密碼</label>
                <input
                    type="password"
                    class="form-control"
                    id="InputPasaword"
                    v-model="password"
                    :class="{'is-invalid': $v.password.$error}"
                    @blur="$v.password.$touch()">
                    <p v-if="!$v.password.minLen">你必須輸入至少 {{$v.password.$params.minLen.min}} 個字。</p>
                    <p v-if="!$v.password.required">這個欄位不能是空的。</p>
            </div>
            <button type="submit" class="btn btn-primary" :disabled="$v.$invalid">送出</button>
        </form>
    </div>
</template>

<script>
import { required, email, minLength } from 'vuelidate/lib/validators'
export default {
    data() {
        return {
            email: '',
            password: ''
        }
    },
    validations: {
        email: {
            required,
            email
        },
        password: {
            required,
            minLen: minLength(6)
        }
    },
    methods: {
        onSubmit() {
            const formData = {
                email: this.email,
                password: this.password
            }
            this.$store.dispatch('UserStore/login', formData)
        }
    }
}
</script>