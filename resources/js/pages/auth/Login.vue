<script setup lang="ts">
import TextLink from '@/components/TextLink.vue';
import AuthBase from '@/layouts/AuthLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { LoaderCircle, Eye, EyeOff, User, Shield } from 'lucide-vue-next';
import { ref } from 'vue';

defineProps<{
    status?: string;
    canResetPassword: boolean;
}>();

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const showPassword = ref(false);
const isLoading = ref(false);

const submit = () => {
    isLoading.value = true;
    form.post(route('login'), {
        onFinish: () => {
            form.reset('password');
            isLoading.value = false;
        },
    });
};

const togglePassword = () => {
    showPassword.value = !showPassword.value;
};
</script>

<template>
    <AuthBase title="Log in to your account" description="Enter your email and password below to log in">
        <Head title="Log in" />

        <div v-if="status" class="mb-4">
            <ArgonAlert color="success" dismissible>
                {{ status }}
            </ArgonAlert>
        </div>

        <form @submit.prevent="submit" class="space-y-4">
            <div class="space-y-4">
                <div>
                    <ArgonInput
                        v-model="form.email"
                        type="email"
                        label="Email address"
                        placeholder="email@example.com"
                        icon="fas fa-envelope"
                        required
                        autofocus
                        :error="form.errors.email"
                    />
                </div>

                <div>
                    <ArgonInput
                        v-model="form.password"
                        :type="showPassword ? 'text' : 'password'"
                        label="Password"
                        placeholder="Password"
                        icon="fas fa-lock"
                        required
                        :error="form.errors.password"
                    >
                        <template #append>
                            <ArgonButton
                                color="secondary"
                                variant="text"
                                size="sm"
                                @click="togglePassword"
                                class="mb-0"
                            >
                                <Eye v-if="!showPassword" />
                                <EyeOff v-else />
                            </ArgonButton>
                        </template>
                    </ArgonInput>
                </div>

                <div class="d-flex justify-content-between align-items-center">
                    <ArgonCheckbox v-model="form.remember" label="Remember me" />
                    <TextLink v-if="canResetPassword" :href="route('password.request')" class="text-sm">
                        Forgot password?
                    </TextLink>
                </div>

                <ArgonButton
                    type="submit"
                    color="info"
                    variant="gradient"
                    class="w-100"
                    :disabled="form.processing || isLoading"
                    size="lg"
                >
                    <LoaderCircle v-if="form.processing || isLoading" class="me-2 animate-spin" />
                    <User v-else class="me-2" />
                    Log in
                </ArgonButton>
            </div>

            <div class="text-center">
                <p class="text-sm text-secondary mb-0">
                    Don't have an account?
                    <TextLink :href="route('register')" class="text-info">Sign up</TextLink>
                </p>
            </div>
        </form>

        <!-- Social Login Section -->
        <div class="mt-4">
            <div class="text-center mb-3">
                <span class="text-sm text-secondary">Or continue with</span>
            </div>
            <div class="d-flex gap-2">
                <ArgonSocialButton
                    color="success"
                    variant="gradient"
                    class="flex-1"
                    href="#"
                >
                    <i class="fab fa-google me-2"></i>
                    Google
                </ArgonSocialButton>
                <ArgonSocialButton
                    color="primary"
                    variant="gradient"
                    class="flex-1"
                    href="#"
                >
                    <i class="fab fa-facebook me-2"></i>
                    Facebook
                </ArgonSocialButton>
            </div>
        </div>

        <!-- Security Notice -->
        <div class="mt-4 text-center">
            <div class="d-flex align-items-center justify-content-center text-secondary">
                <Shield class="me-2" style="font-size: 0.875rem;" />
                <span class="text-xs">Your data is protected with SSL encryption</span>
            </div>
        </div>
    </AuthBase>
</template>
