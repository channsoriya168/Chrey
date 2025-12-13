// Language configuration
export const languages = [
    { code: 'km', name: 'KH', fullName: 'ខ្មែរ', flag: 'circle-flags:kh' },
    { code: 'en', name: 'EN', fullName: 'English', flag: 'circle-flags:gb' }
]

// Get current language object
export function getCurrentLanguage(locale) {
    return languages.find((lang) => lang.code === locale) || languages[1]
}
