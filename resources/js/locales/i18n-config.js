import { createI18n } from "vue-i18n";
import en from './dictionary/en';
import ptbr from './dictionary/ptbr';

const i18n = createI18n({
    locale: 'ptbr',
    fallbackLocale: 'en',
    messages: { en, ptbr },
});

export default i18n;
