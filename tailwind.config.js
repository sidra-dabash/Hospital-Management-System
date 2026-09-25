import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Cairo', 'Tajawal', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: {
                    50: '#eff6ff',
                    100: '#dbeafe',
                    200: '#bfdbfe',
                    300: '#93c5fd',
                    400: '#60a5fa',
                    500: '#3b82f6',
                    600: '#1d6fb5',
                    700: '#165793',
                    800: '#0f4c75',
                    900: '#0b3a5a',
                    950: '#08253d',
                },
                secondary: {
                    50: '#f0fdf4',
                    100: '#dcfce7',
                    200: '#bbf7d0',
                    300: '#86efac',
                    400: '#4ade80',
                    500: '#22c55e',
                    600: '#2e9e4c',
                    700: '#2e7d32',
                    800: '#1f5e2a',
                    900: '#14532d',
                    950: '#052e16',
                },
                accent: {
                    purple: '#7c3aed',
                    red: '#ef4444',
                    orange: '#f59e0b',
                    blue: '#3b82f6',
                    green: '#22c55e',
                },
                neutral: {
                    50: '#f8fafc',
                    100: '#f1f5f9',
                    200: '#e2e8f0',
                    300: '#cbd5e1',
                    400: '#94a3b8',
                    500: '#64748b',
                    600: '#475569',
                    700: '#334155',
                    800: '#1e293b',
                    900: '#0f172a',
                },
            },
            boxShadow: {
                'card': '0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03)',
                'card-hover': '0 10px 25px -5px rgba(0, 0, 0, 0.08), 0 8px 10px -6px rgba(0, 0, 0, 0.05)',
                'soft': '0 2px 15px -3px rgba(15, 76, 117, 0.08)',
            },
            backgroundImage: {
                'hero-gradient': 'linear-gradient(135deg, #eff6ff 0%, #f0fdf4 100%)',
                'leaf-pattern': "url(\"data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='100' height='100' viewBox='0 0 100 100'%3E%3Cpath fill='%2322c55e' fill-opacity='0.03' d='M20 80 Q30 50 60 40 Q40 60 20 80Z'/%3E%3Cpath fill='%231d6fb5' fill-opacity='0.03' d='M70 20 Q80 40 85 70 Q65 55 70 20Z'/%3E%3C/svg%3E\")",
            },
        },
    },

    plugins: [forms],
};
