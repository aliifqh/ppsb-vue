<script setup lang="ts">
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';

import DeleteUser from '@/components/DeleteUser.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import SettingsLayout from '@/layouts/settings/Layout.vue';
import { type BreadcrumbItem, type User } from '@/types';
import { User as UserIcon, Mail, Shield, CheckCircle, AlertCircle } from 'lucide-vue-next';
import { ref } from 'vue';

interface Props {
    mustVerifyEmail: boolean;
    status?: string;
}

defineProps<Props>();

const breadcrumbItems: BreadcrumbItem[] = [
    {
        title: 'Profile settings',
        href: '/settings/profile',
    },
];

const page = usePage();
const user = page.props.auth.user as User;

const form = useForm({
    name: user.name,
    email: user.email,
});

const isLoading = ref(false);

const submit = () => {
    isLoading.value = true;
    form.patch(route('profile.update'), {
        preserveScroll: true,
        onFinish: () => {
            isLoading.value = false;
        },
    });
};
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbItems">
        <Head title="Profile settings" />

        <SettingsLayout>
            <div class="container-fluid py-4">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header pb-0">
                                <div class="row">
                                    <div class="col-6">
                                        <h6 class="mb-0">Profile Information</h6>
                                        <p class="text-secondary text-sm mb-0">Update your name and email address</p>
                                    </div>
                                    <div class="col-6 text-end">
                                        <ArgonBadge v-if="user.email_verified_at" color="success" variant="gradient" size="sm">
                                            <CheckCircle class="me-1" />
                                            Verified
                                        </ArgonBadge>
                                        <ArgonBadge v-else color="warning" variant="gradient" size="sm">
                                            <AlertCircle class="me-1" />
                                            Unverified
                                        </ArgonBadge>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <form @submit.prevent="submit" class="space-y-4">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <ArgonInput
                                                v-model="form.name"
                                                type="text"
                                                label="Full Name"
                                                placeholder="Enter your full name"
                                                icon="fas fa-user"
                                                required
                                                :error="form.errors.name"
                                            />
                                        </div>
                                        <div class="col-md-6">
                                            <ArgonInput
                                                v-model="form.email"
                                                type="email"
                                                label="Email Address"
                                                placeholder="email@example.com"
                                                icon="fas fa-envelope"
                                                required
                                                :error="form.errors.email"
                                            />
                                        </div>
                                    </div>

                                    <div v-if="mustVerifyEmail && !user.email_verified_at" class="mt-4">
                                        <ArgonAlert color="warning" dismissible>
                                            <div class="d-flex align-items-center">
                                                <Mail class="me-2" />
                                                <div>
                                                    <strong>Email Verification Required</strong>
                                                    <p class="mb-0 text-sm">Your email address is unverified.</p>
                                                </div>
                                            </div>
                                        </ArgonAlert>
                                        
                                        <div class="mt-3">
                                            <Link
                                                :href="route('verification.send')"
                                                method="post"
                                                as="button"
                                                class="btn btn-warning btn-sm"
                                            >
                                                <Mail class="me-2" />
                                                Resend Verification Email
                                            </Link>
                                        </div>

                                        <div v-if="status === 'verification-link-sent'" class="mt-3">
                                            <ArgonAlert color="success" dismissible>
                                                A new verification link has been sent to your email address.
                                            </ArgonAlert>
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-center gap-3 mt-4">
                                        <ArgonButton
                                            type="submit"
                                            color="info"
                                            variant="gradient"
                                            :disabled="form.processing || isLoading"
                                        >
                                            <UserIcon v-if="!form.processing && !isLoading" class="me-2" />
                                            <div v-else class="spinner-border spinner-border-sm me-2" role="status">
                                                <span class="visually-hidden">Loading...</span>
                                            </div>
                                            Save Changes
                                        </ArgonButton>

                                        <Transition
                                            enter-active-class="transition ease-in-out"
                                            enter-from-class="opacity-0"
                                            leave-active-class="transition ease-in-out"
                                            leave-to-class="opacity-0"
                                        >
                                            <span v-show="form.recentlySuccessful" class="text-success">
                                                <CheckCircle class="me-1" />
                                                Saved successfully!
                                            </span>
                                        </Transition>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Security Section -->
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header pb-0">
                                <h6 class="mb-0">Account Security</h6>
                                <p class="text-secondary text-sm mb-0">Manage your account security settings</p>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="d-flex align-items-center p-3 border rounded">
                                            <div class="icon icon-shape icon-sm bg-gradient-warning shadow text-center border-radius-md me-3">
                                                <Shield class="text-white opacity-10" />
                                            </div>
                                            <div class="flex-1">
                                                <h6 class="mb-0">Change Password</h6>
                                                <p class="text-secondary text-sm mb-0">Update your password regularly</p>
                                            </div>
                                            <ArgonButton color="warning" variant="outline" size="sm">
                                                Change
                                            </ArgonButton>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="d-flex align-items-center p-3 border rounded">
                                            <div class="icon icon-shape icon-sm bg-gradient-info shadow text-center border-radius-md me-3">
                                                <Mail class="text-white opacity-10" />
                                            </div>
                                            <div class="flex-1">
                                                <h6 class="mb-0">Email Settings</h6>
                                                <p class="text-secondary text-sm mb-0">Manage email notifications</p>
                                            </div>
                                            <ArgonButton color="info" variant="outline" size="sm">
                                                Configure
                                            </ArgonButton>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Delete Account Section -->
                <div class="row mt-4">
                    <div class="col-12">
                        <DeleteUser />
                    </div>
                </div>
            </div>
        </SettingsLayout>
    </AppLayout>
</template>
