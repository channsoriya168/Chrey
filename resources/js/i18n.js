import { createI18n } from 'vue-i18n'
import en from './locales/en.json'
import km from './locales/km.json'

const messages = {
    en,
    km
}

// Get language from URL query parameter, fallback to localStorage, then default to 'en'
const getInitialLocale = () => {
    const urlParams = new URLSearchParams(window.location.search)
    const urlLang = urlParams.get('lang')

    if (urlLang && (urlLang === 'en' || urlLang === 'km')) {
        // Save URL language to localStorage for persistence
        localStorage.setItem('locale', urlLang)
        return urlLang
    }

    return localStorage.getItem('locale') || 'en'
}

const i18n = createI18n({
    legacy: false,
    locale: getInitialLocale(),
    fallbackLocale: 'en',
    messages,
    globalInjection: true
})

export default i18n