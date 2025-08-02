import { onMounted, onUnmounted, ref } from 'vue';

type Appearance = 'light' | 'dark';

export function updateTheme(value: Appearance) {
    if (typeof window === 'undefined') {
        return;
    }

    document.documentElement.classList.toggle('dark', value === 'dark');
}

const setCookie = (name: string, value: string, days = 365) => {
    if (typeof document === 'undefined') {
        return;
    }

    const maxAge = days * 24 * 60 * 60;
    document.cookie = `${name}=${value};path=/;max-age=${maxAge};SameSite=Lax`;
};

const getStoredAppearance = () => {
    if (typeof window === 'undefined') {
        return null;
    }

    return localStorage.getItem('appearance') as Appearance | null;
};

export function initializeTheme() {
    if (typeof window === 'undefined') {
        return;
    }

    // Initialize theme from saved preference or default to light
    const savedAppearance = getStoredAppearance();
    updateTheme(savedAppearance || 'light');
}

const appearance = ref<Appearance>('light');

export function useAppearance() {
    onMounted(() => {
        const savedAppearance = localStorage.getItem('appearance') as Appearance | null;

        if (savedAppearance) {
            appearance.value = savedAppearance;
        }
    });

    function updateAppearance(value: Appearance) {
        appearance.value = value;

        // Store in localStorage for client-side persistence
        localStorage.setItem('appearance', value);

        // Store in cookie for SSR
        setCookie('appearance', value);

        updateTheme(value);
    }

    function toggleAppearance() {
        const newValue = appearance.value === 'light' ? 'dark' : 'light';
        updateAppearance(newValue);
    }

    return {
        appearance,
        updateAppearance,
        toggleAppearance,
    };
}

// Simple composable for fixed theme pages
export function useFixedTheme(fixedTheme: Appearance) {
    let originalTheme: string | null = null;

    onMounted(() => {
        // Store original theme
        originalTheme = localStorage.getItem('appearance');
        
        // Force fixed theme
        document.documentElement.classList.remove('dark', 'light');
        document.documentElement.classList.add(fixedTheme);
    });

    onUnmounted(() => {
        // Restore original theme when leaving the page
        if (originalTheme) {
            document.documentElement.classList.remove('dark', 'light');
            document.documentElement.classList.add(originalTheme);
        }
    });

    return {
        currentTheme: fixedTheme
    };
} 