<template>
    <div class="login-box">
        <div class="login-logo">
            <a href=""><b>Boulanger</b>-APP</a>
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Connexion a l'application</p>

                <form action="#" @submit.prevent="soumettre" id="formLogin">
                    <div class="input-group mb-3">
                        <input
                            type="email"
                            name="email"
                            id="inputEmail"
                            class="form-control"
                            placeholder="Email"
                            v-model="form.email"
                            :class="{
                                'is-invalid': form.errors.email,
                            }"
                        />
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                        <span
                            v-if="form.errors.email"
                            class="error invalid-feedback"
                            >{{ form.errors.email }}</span
                        >
                    </div>
                    <div class="input-group mb-3">
                        <input
                            type="password"
                            id="inputPassword"
                            name="password"
                            class="form-control"
                            placeholder="Password"
                            v-model="form.password"
                        />
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <select
                            class="form-control"
                            name="annee"
                            style="width: 100%"
                            v-model="form.annee"
                        >
                            <option selected value="2024">Année ...</option>
                            <option value="2024">2024</option>
                            <option value="2025">2025</option>
                            <option value="2026">2026</option>
                            <option value="2027">2027</option>
                        </select>
                    </div>
                    <div class="row">
                        <!-- /.col -->
                        <div class="col-12">
                            <button
                                type="submit"
                                form="formLogin"
                                class="btn btn-primary btn-block"
                            >
                                Connecter
                            </button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

                <!-- /.social-auth-links -->
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <!-- /.login-box -->
</template>
<script>
import AuthLayout from "../Layouts/AuthLayout.vue";
import { useSwalError } from "../composables/alert";

export default {
    layout: AuthLayout,
};
</script>

<script setup>
import { useForm } from "@inertiajs/vue3";

const form = useForm({
    email: "",
    password: "",
    annee: "",
});

const soumettre = () => {
    form.post(route("login"), {
        onError: (errors) => {
            useSwalError("Une erreur s'est produite");
        },
    });
};
</script>
