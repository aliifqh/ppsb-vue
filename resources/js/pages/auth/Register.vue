<script setup lang="ts">
import TextLink from '@/components/TextLink.vue';
import AuthBase from '@/layouts/AuthLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { LoaderCircle, Eye, EyeOff, User, Shield } from 'lucide-vue-next';
import { ref, computed } from 'vue';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const showPassword = ref(false);
const showConfirmPassword = ref(false);
const isLoading = ref(false);

const submit = () => {
    isLoading.value = true;
    form.post(route('register'), {
        onFinish: () => {
            form.reset('password', 'password_confirmation');
            isLoading.value = false;
        },
    });
};

const togglePassword = () => {
    showPassword.value = !showPassword.value;
};

const toggleConfirmPassword = () => {
    showConfirmPassword.value = !showConfirmPassword.value;
};

const passwordStrength = computed(() => {
    const password = form.password;
    if (!password) return 0;
    
    let strength = 0;
    if (password.length >= 8) strength += 25;
    if (/[a-z]/.test(password)) strength += 25;
    if (/[A-Z]/.test(password)) strength += 25;
    if (/[0-9]/.test(password)) strength += 25;
    
    return strength;
});

const passwordStrengthColor = computed(() => {
    if (passwordStrength.value <= 25) return 'danger';
    if (passwordStrength.value <= 50) return 'warning';
    if (passwordStrength.value <= 75) return 'info';
    return 'success';
});

const passwordStrengthText = computed(() => {
    if (passwordStrength.value <= 25) return 'Weak';
    if (passwordStrength.value <= 50) return 'Fair';
    if (passwordStrength.value <= 75) return 'Good';
    return 'Strong';
});
</script>

<template>
    <AuthBase title="Create an account" description="Enter your details below to create your account">
        <Head title="Register" />

        <form @submit.prevent="submit" class="space-y-4">
            <div class="space-y-4">
                <div>
                    <ArgonInput
                        v-model="form.name"
                        type="text"
                        label="Full Name"
                        placeholder="Enter your full name"
                        icon="fas fa-user"
                        required
                        autofocus
                        :error="form.errors.name"
                    />
                </div>

                <div>
                    <ArgonInput
                        v-model="form.email"
                        type="email"
                        label="Email address"
                        placeholder="email@example.com"
                        icon="fas fa-envelope"
                        required
                        :error="form.errors.email"
                    />
                </div>

                <div>
                    <ArgonInput
                        v-model="form.password"
                        :type="showPassword ? 'text' : 'password'"
                        label="Password"
                        placeholder="Create a strong password"
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
                    
                    <!-- Password Strength Indicator -->
                    <div v-if="form.password" class="mt-2">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="text-xs text-secondary">Password strength</span>
                            <span class="text-xs font-weight-bold" :class="`text-${passwordStrengthColor}`">
                                {{ passwordStrengthText }}
                            </span>
                        </div>
                        <ArgonProgress 
                            :value="passwordStrength" 
                            :color="passwordStrengthColor" 
                            size="sm"
                        />
                    </div>
                </div>

                <div>
                    <ArgonInput
                        v-model="form.password_confirmation"
                        :type="showConfirmPassword ? 'text' : 'password'"
                        label="Confirm Password"
                        placeholder="Confirm your password"
                        icon="fas fa-lock"
                        required
                        :error="form.errors.password_confirmation"
                    >
                        <template #append>
                            <ArgonButton
                                color="secondary"
                                variant="text"
                                size="sm"
                                @click="toggleConfirmPassword"
                                class="mb-0"
                            >
                                <Eye v-if="!showConfirmPassword" />
                                <EyeOff v-else />
                            </ArgonButton>
                        </template>
                    </ArgonInput>
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
                    Create account
                </ArgonButton>
            </div>

            <div class="text-center">
                <p class="text-sm text-secondary mb-0">
                    Already have an account?
                    <TextLink :href="route('login')" class="text-info">Log in</TextLink>
                </p>
            </div>
        </form>

        <!-- Social Register Section -->
        <div class="mt-4">
            <div class="text-center mb-3">
                <span class="text-sm text-secondary">Or register with</span>
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

        <!-- Terms and Security -->
        <div class="mt-4">
            <div class="d-flex align-items-center justify-content-center text-secondary mb-2">
                <Shield class="me-2" style="font-size: 0.875rem;" />
                <span class="text-xs">Your data is protected with SSL encryption</span>
            </div>
            <div class="text-center">
                <p class="text-xs text-secondary mb-0">
                    By creating an account, you agree to our 
                    <TextLink href="#" class="text-info">Terms of Service</TextLink> and 
                    <TextLink href="#" class="text-info">Privacy Policy</TextLink>
                </p>
            </div>
        </div>
    </AuthBase>
</template>
