# Layout Components

Dokumentasi untuk layout components yang digunakan dalam aplikasi PPSB Vue/Inertia.

## Overview

Layout components ini dibuat berdasarkan contoh dari project sebelumnya (`../ppsb/resources/views/layouts/partials`) dan diadaptasi untuk Vue/Inertia dengan menggunakan Tailwind CSS.

## Available Layouts

### 1. PublicLayout.vue
Layout untuk halaman publik seperti formulir pendaftaran dan halaman utama.

**Fitur:**
- Navbar dengan logo dan menu navigasi
- Footer lengkap dengan informasi kontak
- Responsive design
- Scroll effect pada navbar

**Penggunaan:**
```vue
<script setup>
import PublicLayout from '@/layouts/PublicLayout.vue';
</script>

<template>
  <PublicLayout>
    <!-- Konten halaman Anda di sini -->
  </PublicLayout>
</template>
```

### 2. SantriLayout.vue
Layout khusus untuk halaman santri dengan navbar yang berbeda.

**Fitur:**
- Navbar khusus santri dengan menu yang sesuai
- Footer dengan tombol logout dan navigasi
- Props untuk menerima data santri
- Conditional rendering berdasarkan status login

**Props:**
- `santri`: Object data santri
- `isLoggedIn`: Boolean status login

**Penggunaan:**
```vue
<script setup>
import SantriLayout from '@/layouts/SantriLayout.vue';

const props = defineProps({
  santri: Object,
  isLoggedIn: Boolean
});
</script>

<template>
  <SantriLayout :santri="santri" :is-logged-in="isLoggedIn">
    <!-- Konten halaman santri -->
  </SantriLayout>
</template>
```

### 3. AdminLayout.vue
Layout untuk panel administrasi dengan sidebar dan header.

**Fitur:**
- Sidebar dengan menu navigasi admin
- Header dengan breadcrumbs
- Responsive sidebar (mobile-friendly)
- Profile dropdown

**Props:**
- `breadcrumbs`: Array untuk breadcrumb navigation

**Penggunaan:**
```vue
<script setup>
import AdminLayout from '@/layouts/AdminLayout.vue';

const breadcrumbs = [
  { title: 'Dashboard', url: '/dashboard' },
  { title: 'Santri', url: '/santri' }
];
</script>

<template>
  <AdminLayout :breadcrumbs="breadcrumbs">
    <!-- Konten halaman admin -->
  </AdminLayout>
</template>
```

### 4. AppLayout.vue
Layout wrapper yang menggunakan AppSidebarLayout.

**Fitur:**
- Wrapper untuk AppSidebarLayout
- Support breadcrumbs

### 5. AuthLayout.vue
Layout untuk halaman autentikasi.

## File Structure

```
layouts/
├── PublicLayout.vue      # Layout untuk halaman publik
├── SantriLayout.vue      # Layout untuk halaman santri
├── AdminLayout.vue       # Layout untuk panel admin
├── AppLayout.vue         # Wrapper layout
├── AuthLayout.vue        # Layout untuk auth
├── index.ts             # Export semua layout
└── README.md            # Dokumentasi ini
```

## Styling

Semua layout menggunakan Tailwind CSS dengan:
- Responsive design
- Modern UI components
- Consistent color scheme (emerald/teal untuk primary)
- Hover effects dan transitions
- Mobile-first approach

## Navigation

### Public Navigation
- Formulir Pendaftaran
- Cek Status
- Login Admin

### Santri Navigation (ketika login)
- Beranda
- Pembayaran
- Ujian
- Data

### Admin Navigation
- Dashboard
- Santri
- Gelombang
- Unit
- Pembayaran
- Laporan

## Icons

Layout menggunakan SVG icons yang konsisten:
- Heroicons style
- Consistent sizing (24x24, 20x20, 16x16)
- Color-coded untuk setiap section

## Responsive Behavior

- **Mobile (< 768px)**: Menu text disembunyikan, hanya icon yang ditampilkan
- **Tablet (768px - 1024px)**: Sidebar collapsed, hamburger menu untuk admin
- **Desktop (> 1024px)**: Full layout dengan sidebar tetap

## Customization

Untuk menyesuaikan layout:

1. **Colors**: Ubah class Tailwind CSS untuk mengubah warna
2. **Navigation**: Edit array navigation di AdminLayout.vue
3. **Logo**: Ganti path logo di setiap layout
4. **Footer**: Edit informasi kontak di PublicLayout.vue

## Best Practices

1. **Gunakan layout yang sesuai** dengan jenis halaman
2. **Pass props yang diperlukan** untuk SantriLayout dan AdminLayout
3. **Gunakan breadcrumbs** untuk halaman admin yang kompleks
4. **Test responsive behavior** di berbagai ukuran layar
5. **Maintain consistency** dalam styling dan navigation

## Examples

Lihat file contoh penggunaan:
- `Pages/Formulir.vue` - Menggunakan PublicLayout
- `Pages/admin/Dashboard.vue` - Menggunakan AdminLayout
- `Pages/Santri/Dashboard.vue` - Menggunakan SantriLayout 