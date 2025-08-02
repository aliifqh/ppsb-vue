# Composable Tema

## useFixedTheme()

Composable untuk mengatur tema tetap di halaman tertentu.

### Penggunaan

```vue
<script setup lang="ts">
import { useFixedTheme } from '@/composables/useAppearance';

// Untuk tema light tetap
useFixedTheme('light');

// Untuk tema dark tetap
useFixedTheme('dark');
</script>
```

### Contoh Implementasi

#### Halaman dengan Tema Light Tetap
```vue
<script setup lang="ts">
import { useFixedTheme } from '@/composables/useAppearance';

// Halaman ini akan selalu light
useFixedTheme('light');
</script>

<template>
  <div class="bg-white text-gray-900">
    <!-- Konten halaman -->
  </div>
</template>
```

#### Halaman dengan Tema Dark Tetap
```vue
<script setup lang="ts">
import { useFixedTheme } from '@/composables/useAppearance';

// Halaman ini akan selalu dark
useFixedTheme('dark');
</script>

<template>
  <div class="bg-gray-900 text-white">
    <!-- Konten halaman -->
  </div>
</template>
```

### Fitur

- ✅ Otomatis menyimpan tema asli user
- ✅ Memaksa tema yang diinginkan saat halaman dimuat
- ✅ Mengembalikan tema asli saat user meninggalkan halaman
- ✅ Tidak mempengaruhi preferensi tema user di halaman lain
- ✅ Penggunaan yang sangat simpel - hanya 1 baris kode

### Catatan

- Hanya perlu dipanggil sekali di bagian atas script setup
- Tema akan otomatis dikembalikan saat komponen di-unmount
- Tidak perlu menambahkan class `dark:` di template karena tema sudah dipaksa 