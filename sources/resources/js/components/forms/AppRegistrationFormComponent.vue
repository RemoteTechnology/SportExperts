<script>
    import Card from "primevue/card";
    import InputText from "primevue/inputtext";
    import Button from "primevue/button";
    import InputMask from "primevue/inputmask";
    import FloatLabel from "primevue/floatlabel";
    import Password from "primevue/password";
    import Dropdown from 'primevue/dropdown';
    import { registrationRequest } from "../../api/UserRequest";
    import { UserModel } from "../../models/UserModel";
    import { createLogOptionRequest } from "../../api/CreateLogOptionRequest";
    import { createInvitedRequest } from "../../api/InvitedRequest";
    import { createOptionRequest } from "../../api/OptionRequest";
    import { eventRecordRequest } from "../../api/ParticipantRequest";
    import { MESSAGES } from "../../common/messages";
    import AppFormWrapperComponent from "../wrappers/AppFormWrapperComponent.vue";
    import {IDENTIFIER, USER_ROLE} from "../../common/fields";
    import {ENDPOINTS} from "../../common/route/api";

    export default {
        data() {
            return {
                selectedCountries: null,
                // TODO: подумать выносить это в апи или нет
                 countries: [
                     {'icon': 'fi-ad', 'name': 'Андорра', 'countryCode': '+376'},
                     {'icon': 'fi-ae', 'name': 'ОАЭ', 'countryCode': '+971'},
                     {'icon': 'fi-af', 'name': 'Афганистан', 'countryCode': '+93'},
                     {'icon': 'fi-ag', 'name': 'Антигуа и Барбуда', 'countryCode': '+1-268'},
                     {'icon': 'fi-ai', 'name': 'Ангилья', 'countryCode': '+1-264'},
                     {'icon': 'fi-al', 'name': 'Албания', 'countryCode': '+355'},
                     {'icon': 'fi-am', 'name': 'Армения', 'countryCode': '+374'},
                     {'icon': 'fi-ao', 'name': 'Ангола', 'countryCode': '+244'},
                     {'icon': 'fi-aq', 'name': 'Антарктида', 'countryCode': '+672'},
                     {'icon': 'fi-ar', 'name': 'Аргентина', 'countryCode': '+54'},
                     {'icon': 'fi-as', 'name': 'Американское Самоа', 'countryCode': '+1-684'},
                     {'icon': 'fi-at', 'name': 'Австрия', 'countryCode': '+43'},
                     {'icon': 'fi-au', 'name': 'Австралия', 'countryCode': '+61'},
                     {'icon': 'fi-aw', 'name': 'Аруба', 'countryCode': '+297'},
                     {'icon': 'fi-ax', 'name': 'Аландские острова', 'countryCode': '+358-18'},
                     {'icon': 'fi-az', 'name': 'Азербайджан', 'countryCode': '+994'},
                     {'icon': 'fi-ba', 'name': 'Босния и Герцеговина', 'countryCode': '+387'},
                     {'icon': 'fi-bb', 'name': 'Барбадос', 'countryCode': '+1-246'},
                     {'icon': 'fi-bd', 'name': 'Бангладеш', 'countryCode': '+880'},
                     {'icon': 'fi-be', 'name': 'Бельгия', 'countryCode': '+32'},
                     {'icon': 'fi-bf', 'name': 'Буркина-Фасо', 'countryCode': '+226'},
                     {'icon': 'fi-bg', 'name': 'Болгария', 'countryCode': '+359'},
                     {'icon': 'fi-bh', 'name': 'Бахрейн', 'countryCode': '+973'},
                     {'icon': 'fi-bi', 'name': 'Бурунди', 'countryCode': '+257'},
                     {'icon': 'fi-bj', 'name': 'Бенин', 'countryCode': '+229'},
                     {'icon': 'fi-bl', 'name': 'Сен-Бартелеми', 'countryCode': '+590'},
                     {'icon': 'fi-bm', 'name': 'Бермуды', 'countryCode': '+1-441'},
                     {'icon': 'fi-bn', 'name': 'Бруней', 'countryCode': '+673'},
                     {'icon': 'fi-bo', 'name': 'Боливия', 'countryCode': '+591'},
                     {'icon': 'fi-bq', 'name': 'Бонэйр, Синт-Эстатиус и Саба', 'countryCode': '+599'},
                     {'icon': 'fi-br', 'name': 'Бразилия', 'countryCode': '+55'},
                     {'icon': 'fi-bs', 'name': 'Багамы', 'countryCode': '+1-242'},
                     {'icon': 'fi-bt', 'name': 'Бутан', 'countryCode': '+975'},
                     {'icon': 'fi-bv', 'name': 'Остров Буве', 'countryCode': '+47'},
                     {'icon': 'fi-bw', 'name': 'Ботсвана', 'countryCode': '+267'},
                     {'icon': 'fi-by', 'name': 'Беларусь', 'countryCode': '+375'},
                     {'icon': 'fi-bz', 'name': 'Белиз', 'countryCode': '+501'},
                     {'icon': 'fi-ca', 'name': 'Канада', 'countryCode': '+1'},
                     {'icon': 'fi-cc', 'name': 'Кокосовые острова', 'countryCode': '+61'},
                     {'icon': 'fi-cd', 'name': 'Демократическая Республика Конго', 'countryCode': '+243'},
                     {'icon': 'fi-cf', 'name': 'Центральноафриканская Республика', 'countryCode': '+236'},
                     {'icon': 'fi-cg', 'name': 'Конго', 'countryCode': '+242'},
                     {'icon': 'fi-ch', 'name': 'Швейцария', 'countryCode': '+41'},
                     {'icon': 'fi-ci', 'name': 'Кот-д’Ивуар', 'countryCode': '+225'},
                     {'icon': 'fi-ck', 'name': 'Острова Кука', 'countryCode': '+682'},
                     {'icon': 'fi-cl', 'name': 'Чили', 'countryCode': '+56'},
                     {'icon': 'fi-cm', 'name': 'Камерун', 'countryCode': '+237'},
                     {'icon': 'fi-cn', 'name': 'Китай', 'countryCode': '+86'},
                     {'icon': 'fi-co', 'name': 'Колумбия', 'countryCode': '+57'},
                     {'icon': 'fi-cr', 'name': 'Коста-Рика', 'countryCode': '+506'},
                     {'icon': 'fi-cu', 'name': 'Куба', 'countryCode': '+53'},
                     {'icon': 'fi-cv', 'name': 'Кабо-Верде', 'countryCode': '+238'},
                     {'icon': 'fi-cw', 'name': 'Кюрасао', 'countryCode': '+599'},
                     {'icon': 'fi-cx', 'name': 'Остров Рождества', 'countryCode': '+61'},
                     {'icon': 'fi-cy', 'name': 'Кипр', 'countryCode': '+357'},
                     {'icon': 'fi-cz', 'name': 'Чехия', 'countryCode': '+420'},
                     {'icon': 'fi-de', 'name': 'Германия', 'countryCode': '+49'},
                     {'icon': 'fi-dj', 'name': 'Джибути', 'countryCode': '+253'},
                     {'icon': 'fi-dk', 'name': 'Дания', 'countryCode': '+45'},
                     {'icon': 'fi-dm', 'name': 'Доминика', 'countryCode': '+1-767'},
                     {'icon': 'fi-do', 'name': 'Доминиканская Республика', 'countryCode': '+1-809'},
                     {'icon': 'fi-dz', 'name': 'Алжир', 'countryCode': '+213'},
                     {'icon': 'fi-ec', 'name': 'Эквадор', 'countryCode': '+593'},
                     {'icon': 'fi-ee', 'name': 'Эстония', 'countryCode': '+372'},
                     {'icon': 'fi-eg', 'name': 'Египет', 'countryCode': '+20'},
                     {'icon': 'fi-eh', 'name': 'Западная Сахара', 'countryCode': '+212'},
                     {'icon': 'fi-er', 'name': 'Эритрея', 'countryCode': '+291'},
                     {'icon': 'fi-es', 'name': 'Испания', 'countryCode': '+34'},
                     {'icon': 'fi-et', 'name': 'Эфиопия', 'countryCode': '+251'},
                     {'icon': 'fi-fi', 'name': 'Финляндия', 'countryCode': '+358'},
                     {'icon': 'fi-fj', 'name': 'Фиджи', 'countryCode': '+679'},
                     {'icon': 'fi-fk', 'name': 'Фолклендские острова', 'countryCode': '+500'},
                     {'icon': 'fi-fm', 'name': 'Микронезия', 'countryCode': '+691'},
                     {'icon': 'fi-fo', 'name': 'Фарерские острова', 'countryCode': '+298'},
                     {'icon': 'fi-fr', 'name': 'Франция', 'countryCode': '+33'},
                     {'icon': 'fi-ga', 'name': 'Габон', 'countryCode': '+241'},
                     {'icon': 'fi-gb', 'name': 'Великобритания', 'countryCode': '+44'},
                     {'icon': 'fi-gd', 'name': 'Гренада', 'countryCode': '+1-473'},
                     {'icon': 'fi-ge', 'name': 'Грузия', 'countryCode': '+995'},
                     {'icon': 'fi-gf', 'name': 'Французская Гвиана', 'countryCode': '+594'},
                     {'icon': 'fi-gg', 'name': 'Гернси', 'countryCode': '+44-1481'},
                     {'icon': 'fi-gh', 'name': 'Гана', 'countryCode': '+233'},
                     {'icon': 'fi-gi', 'name': 'Гибралтар', 'countryCode': '+350'},
                     {'icon': 'fi-gl', 'name': 'Гренландия', 'countryCode': '+299'},
                     {'icon': 'fi-gm', 'name': 'Гамбия', 'countryCode': '+220'},
                     {'icon': 'fi-gn', 'name': 'Гвинея', 'countryCode': '+224'},
                     {'icon': 'fi-gp', 'name': 'Гваделупа', 'countryCode': '+590'},
                     {'icon': 'fi-gq', 'name': 'Экваториальная Гвинея', 'countryCode': '+240'},
                     {'icon': 'fi-gr', 'name': 'Греция', 'countryCode': '+30'},
                     {'icon': 'fi-gs', 'name': 'Южная Георгия и Южные Сандвичевы острова', 'countryCode': '+500'},
                     {'icon': 'fi-gt', 'name': 'Гватемала', 'countryCode': '+502'},
                     {'icon': 'fi-gu', 'name': 'Гуам', 'countryCode': '+1-671'},
                     {'icon': 'fi-gw', 'name': 'Гвинея-Бисау', 'countryCode': '+245'},
                     {'icon': 'fi-gy', 'name': 'Гайана', 'countryCode': '+592'},
                     {'icon': 'fi-hk', 'name': 'Гонконг', 'countryCode': '+852'},
                     {'icon': 'fi-hm', 'name': 'Остров Херд и острова Макдональд', 'countryCode': '+672'},
                     {'icon': 'fi-hn', 'name': 'Гондурас', 'countryCode': '+504'},
                     {'icon': 'fi-hr', 'name': 'Хорватия', 'countryCode': '+385'},
                     {'icon': 'fi-ht', 'name': 'Гаити', 'countryCode': '+509'},
                     {'icon': 'fi-hu', 'name': 'Венгрия', 'countryCode': '+36'},
                     {'icon': 'fi-id', 'name': 'Индонезия', 'countryCode': '+62'},
                     {'icon': 'fi-ie', 'name': 'Ирландия', 'countryCode': '+353'},
                     {'icon': 'fi-il', 'name': 'Израиль', 'countryCode': '+972'},
                     {'icon': 'fi-im', 'name': 'Остров Мэн', 'countryCode': '+44-1624'},
                     {'icon': 'fi-in', 'name': 'Индия', 'countryCode': '+91'},
                     {'icon': 'fi-io', 'name': 'Британская территория в Индийском океане', 'countryCode': '+246'},
                     {'icon': 'fi-iq', 'name': 'Ирак', 'countryCode': '+964'},
                     {'icon': 'fi-ir', 'name': 'Иран', 'countryCode': '+98'},
                     {'icon': 'fi-is', 'name': 'Исландия', 'countryCode': '+354'},
                     {'icon': 'fi-it', 'name': 'Италия', 'countryCode': '+39'},
                     {'icon': 'fi-je', 'name': 'Джерси', 'countryCode': '+44-1534'},
                     {'icon': 'fi-jm', 'name': 'Ямайка', 'countryCode': '+1-876'},
                     {'icon': 'fi-jo', 'name': 'Иордания', 'countryCode': '+962'},
                     {'icon': 'fi-jp', 'name': 'Япония', 'countryCode': '+81'},
                     {'icon': 'fi-ke', 'name': 'Кения', 'countryCode': '+254'},
                     {'icon': 'fi-kg', 'name': 'Киргизия', 'countryCode': '+996'},
                     {'icon': 'fi-kh', 'name': 'Камбоджа', 'countryCode': '+855'},
                     {'icon': 'fi-ki', 'name': 'Кирибати', 'countryCode': '+686'},
                     {'icon': 'fi-km', 'name': 'Коморы', 'countryCode': '+269'},
                     {'icon': 'fi-kn', 'name': 'Сент-Китс и Невис', 'countryCode': '+1-869'},
                     {'icon': 'fi-kp', 'name': 'Северная Корея', 'countryCode': '+850'},
                     {'icon': 'fi-kr', 'name': 'Южная Корея', 'countryCode': '+82'},
                     {'icon': 'fi-kw', 'name': 'Кувейт', 'countryCode': '+965'},
                     {'icon': 'fi-ky', 'name': 'Каймановы острова', 'countryCode': '+1-345'},
                     {'icon': 'fi-kz', 'name': 'Казахстан', 'countryCode': '+7'},
                     {'icon': 'fi-la', 'name': 'Лаос', 'countryCode': '+856'},
                     {'icon': 'fi-lb', 'name': 'Ливан', 'countryCode': '+961'},
                     {'icon': 'fi-lc', 'name': 'Сент-Люсия', 'countryCode': '+1-758'},
                     {'icon': 'fi-li', 'name': 'Лихтенштейн', 'countryCode': '+423'},
                     {'icon': 'fi-lk', 'name': 'Шри-Ланка', 'countryCode': '+94'},
                     {'icon': 'fi-lr', 'name': 'Либерия', 'countryCode': '+231'},
                     {'icon': 'fi-ls', 'name': 'Лесото', 'countryCode': '+266'},
                     {'icon': 'fi-lt', 'name': 'Литва', 'countryCode': '+370'},
                     {'icon': 'fi-lu', 'name': 'Люксембург', 'countryCode': '+352'},
                     {'icon': 'fi-lv', 'name': 'Латвия', 'countryCode': '+371'},
                     {'icon': 'fi-ly', 'name': 'Ливия', 'countryCode': '+218'},
                     {'icon': 'fi-ma', 'name': 'Марокко', 'countryCode': '+212'},
                     {'icon': 'fi-mc', 'name': 'Монако', 'countryCode': '+377'},
                     {'icon': 'fi-md', 'name': 'Молдова', 'countryCode': '+373'},
                     {'icon': 'fi-me', 'name': 'Черногория', 'countryCode': '+382'},
                     {'icon': 'fi-mf', 'name': 'Сен-Мартен', 'countryCode': '+590'},
                     {'icon': 'fi-mg', 'name': 'Мадагаскар', 'countryCode': '+261'},
                     {'icon': 'fi-mh', 'name': 'Маршалловы Острова', 'countryCode': '+692'},
                     {'icon': 'fi-mk', 'name': 'Северная Македония', 'countryCode': '+389'},
                     {'icon': 'fi-ml', 'name': 'Мали', 'countryCode': '+223'},
                     {'icon': 'fi-mm', 'name': 'Мьянма', 'countryCode': '+95'},
                     {'icon': 'fi-mn', 'name': 'Монголия', 'countryCode': '+976'},
                     {'icon': 'fi-mo', 'name': 'Макао', 'countryCode': '+853'},
                     {'icon': 'fi-mp', 'name': 'Северные Марианские острова', 'countryCode': '+1-670'},
                     {'icon': 'fi-mq', 'name': 'Мартиника', 'countryCode': '+596'},
                     {'icon': 'fi-mr', 'name': 'Мавритания', 'countryCode': '+222'},
                     {'icon': 'fi-ms', 'name': 'Монтсеррат', 'countryCode': '+1-664'},
                     {'icon': 'fi-mt', 'name': 'Мальта', 'countryCode': '+356'},
                     {'icon': 'fi-mu', 'name': 'Маврикий', 'countryCode': '+230'},
                     {'icon': 'fi-mv', 'name': 'Мальдивы', 'countryCode': '+960'},
                     {'icon': 'fi-mw', 'name': 'Малави', 'countryCode': '+265'},
                     {'icon': 'fi-mx', 'name': 'Мексика', 'countryCode': '+52'},
                     {'icon': 'fi-my', 'name': 'Малайзия', 'countryCode': '+60'},
                     {'icon': 'fi-mz', 'name': 'Мозамбик', 'countryCode': '+258'},
                     {'icon': 'fi-na', 'name': 'Намибия', 'countryCode': '+264'},
                     {'icon': 'fi-nc', 'name': 'Новая Каледония', 'countryCode': '+687'},
                     {'icon': 'fi-ne', 'name': 'Нигер', 'countryCode': '+227'},
                     {'icon': 'fi-nf', 'name': 'Остров Норфолк', 'countryCode': '+672'},
                     {'icon': 'fi-ng', 'name': 'Нигерия', 'countryCode': '+234'},
                     {'icon': 'fi-ni', 'name': 'Никарагуа', 'countryCode': '+505'},
                     {'icon': 'fi-nl', 'name': 'Нидерланды', 'countryCode': '+31'},
                     {'icon': 'fi-no', 'name': 'Норвегия', 'countryCode': '+47'},
                     {'icon': 'fi-np', 'name': 'Непал', 'countryCode': '+977'},
                     {'icon': 'fi-nr', 'name': 'Науру', 'countryCode': '+674'},
                     {'icon': 'fi-nu', 'name': 'Ниуэ', 'countryCode': '+683'},
                     {'icon': 'fi-nz', 'name': 'Новая Зеландия', 'countryCode': '+64'},
                     {'icon': 'fi-om', 'name': 'Оман', 'countryCode': '+968'},
                     {'icon': 'fi-pa', 'name': 'Панама', 'countryCode': '+507'},
                     {'icon': 'fi-pe', 'name': 'Перу', 'countryCode': '+51'},
                     {'icon': 'fi-pf', 'name': 'Французская Полинезия', 'countryCode': '+689'},
                     {'icon': 'fi-pg', 'name': 'Папуа — Новая Гвинея', 'countryCode': '+675'},
                     {'icon': 'fi-ph', 'name': 'Филиппины', 'countryCode': '+63'},
                     {'icon': 'fi-pk', 'name': 'Пакистан', 'countryCode': '+92'},
                     {'icon': 'fi-pl', 'name': 'Польша', 'countryCode': '+48'},
                     {'icon': 'fi-pm', 'name': 'Сен-Пьер и Микелон', 'countryCode': '+508'},
                     {'icon': 'fi-pn', 'name': 'Питкэрн', 'countryCode': '+64'},
                     {'icon': 'fi-pr', 'name': 'Пуэрто-Рико', 'countryCode': '+1-787'},
                     {'icon': 'fi-ps', 'name': 'Палестина', 'countryCode': '+970'},
                     {'icon': 'fi-pt', 'name': 'Португалия', 'countryCode': '+351'},
                     {'icon': 'fi-pw', 'name': 'Палау', 'countryCode': '+680'},
                     {'icon': 'fi-py', 'name': 'Парагвай', 'countryCode': '+595'},
                     {'icon': 'fi-qa', 'name': 'Катар', 'countryCode': '+974'},
                     {'icon': 'fi-re', 'name': 'Реюньон', 'countryCode': '+262'},
                     {'icon': 'fi-ro', 'name': 'Румыния', 'countryCode': '+40'},
                     {'icon': 'fi-rs', 'name': 'Сербия', 'countryCode': '+381'},
                     {'icon': 'fi-ru', 'name': 'Россия', 'countryCode': '+7'},
                     {'icon': 'fi-rw', 'name': 'Руанда', 'countryCode': '+250'},
                     {'icon': 'fi-sa', 'name': 'Саудовская Аравия', 'countryCode': '+966'},
                     {'icon': 'fi-sb', 'name': 'Соломоновы Острова', 'countryCode': '+677'},
                     {'icon': 'fi-sc', 'name': 'Сейшельские Острова', 'countryCode': '+248'},
                     {'icon': 'fi-sd', 'name': 'Судан', 'countryCode': '+249'},
                     {'icon': 'fi-se', 'name': 'Швеция', 'countryCode': '+46'},
                     {'icon': 'fi-sg', 'name': 'Сингапур', 'countryCode': '+65'},
                     {'icon': 'fi-sh', 'name': 'Остров Святой Елены', 'countryCode': '+290'},
                     {'icon': 'fi-si', 'name': 'Словения', 'countryCode': '+386'},
                     {'icon': 'fi-sj', 'name': 'Шпицберген и Ян-Майен', 'countryCode': '+47'},
                     {'icon': 'fi-sk', 'name': 'Словакия', 'countryCode': '+421'},
                     {'icon': 'fi-sl', 'name': 'Сьерра-Леоне', 'countryCode': '+232'},
                     {'icon': 'fi-sm', 'name': 'Сан-Марино', 'countryCode': '+378'},
                     {'icon': 'fi-sn', 'name': 'Сенегал', 'countryCode': '+221'},
                     {'icon': 'fi-so', 'name': 'Сомали', 'countryCode': '+252'},
                     {'icon': 'fi-sr', 'name': 'Суринам', 'countryCode': '+597'},
                     {'icon': 'fi-ss', 'name': 'Южный Судан', 'countryCode': '+211'},
                     {'icon': 'fi-st', 'name': 'Сан-Томе и Принсипи', 'countryCode': '+239'},
                     {'icon': 'fi-sv', 'name': 'Эль-Сальвадор', 'countryCode': '+503'},
                     {'icon': 'fi-sx', 'name': 'Синт-Мартен', 'countryCode': '+1-721'},
                     {'icon': 'fi-sy', 'name': 'Сирия', 'countryCode': '+963'},
                     {'icon': 'fi-sz', 'name': 'Эсватини', 'countryCode': '+268'},
                     {'icon': 'fi-tc', 'name': 'Теркс и Кайкос', 'countryCode': '+1-649'},
                     {'icon': 'fi-td', 'name': 'Чад', 'countryCode': '+235'},
                     {'icon': 'fi-tf', 'name': 'Французские Южные и Антарктические территории', 'countryCode': '+262'},
                     {'icon': 'fi-tg', 'name': 'Того', 'countryCode': '+228'},
                     {'icon': 'fi-th', 'name': 'Таиланд', 'countryCode': '+66'},
                     {'icon': 'fi-tj', 'name': 'Таджикистан', 'countryCode': '+992'},
                     {'icon': 'fi-tk', 'name': 'Токелау', 'countryCode': '+690'},
                     {'icon': 'fi-tl', 'name': 'Восточный Тимор', 'countryCode': '+670'},
                     {'icon': 'fi-tm', 'name': 'Туркмения', 'countryCode': '+993'},
                     {'icon': 'fi-tn', 'name': 'Тунис', 'countryCode': '+216'},
                     {'icon': 'fi-to', 'name': 'Тонга', 'countryCode': '+676'},
                     {'icon': 'fi-tr', 'name': 'Турция', 'countryCode': '+90'},
                     {'icon': 'fi-tt', 'name': 'Тринидад и Тобаго', 'countryCode': '+1-868'},
                     {'icon': 'fi-tv', 'name': 'Тувалу', 'countryCode': '+688'},
                     {'icon': 'fi-tw', 'name': 'Тайвань', 'countryCode': '+886'},
                     {'icon': 'fi-tz', 'name': 'Танзания', 'countryCode': '+255'},
                     {'icon': 'fi-ua', 'name': 'Украина', 'countryCode': '+380'},
                     {'icon': 'fi-ug', 'name': 'Уганда', 'countryCode': '+256'},
                     {'icon': 'fi-um', 'name': 'Внешние малые острова США', 'countryCode': '+1'},
                     {'icon': 'fi-us', 'name': 'США', 'countryCode': '+1'},
                     {'icon': 'fi-uy', 'name': 'Уругвай', 'countryCode': '+598'},
                     {'icon': 'fi-uz', 'name': 'Узбекистан', 'countryCode': '+998'},
                     {'icon': 'fi-va', 'name': 'Ватикан', 'countryCode': '+379'},
                     {'icon': 'fi-vc', 'name': 'Сент-Винсент и Гренадины', 'countryCode': '+1-784'},
                     {'icon': 'fi-ve', 'name': 'Венесуэла', 'countryCode': '+58'},
                     {'icon': 'fi-vg', 'name': 'Британские Виргинские острова', 'countryCode': '+1-284'},
                     {'icon': 'fi-vi', 'name': 'Американские Виргинские острова', 'countryCode': '+1-340'},
                     {'icon': 'fi-vn', 'name': 'Вьетнам', 'countryCode': '+84'},
                     {'icon': 'fi-vu', 'name': 'Вануату', 'countryCode': '+678'},
                     {'icon': 'fi-wf', 'name': 'Уоллис и Футуна', 'countryCode': '+681'},
                     {'icon': 'fi-ws', 'name': 'Самоа', 'countryCode': '+685'},
                     {'icon': 'fi-ye', 'name': 'Йемен', 'countryCode': '+967'},
                     {'icon': 'fi-yt', 'name': 'Майотта', 'countryCode': '+262'},
                     {'icon': 'fi-za', 'name': 'Южно-Африканская Республика', 'countryCode': '+27'},
                     {'icon': 'fi-zm', 'name': 'Замбия', 'countryCode': '+260'},
                     {'icon': 'fi-zw', 'name': 'Зимбабве', 'countryCode': '+263'},
                     {'icon': 'fi-arab', 'name': 'Арабский союз', 'countryCode': '+971'},
                     {'icon': 'fi-cefta', 'name': 'Центральноевропейская свободная торговая ассоциация', 'countryCode': '+381'},
                     {'icon': 'fi-cp', 'name': 'Остров Клиппертон', 'countryCode': '+508'},
                     {'icon': 'fi-dg', 'name': 'Диего-Гарсия', 'countryCode': '+246'},
                     {'icon': 'fi-eac', 'name': 'Восточноафриканский союз', 'countryCode': '+254'},
                     {'icon': 'fi-es-ct', 'name': 'Каталония', 'countryCode': '+34'},
                     {'icon': 'fi-es-ga', 'name': 'Галисия', 'countryCode': '+34'},
                     {'icon': 'fi-es-pv', 'name': 'Баскские земли', 'countryCode': '+34'},
                     {'icon': 'fi-eu', 'name': 'Европейский союз', 'countryCode': '+32'},
                     {'icon': 'fi-gb-eng', 'name': 'Англия', 'countryCode': '+44'},
                     {'icon': 'fi-gb-nir', 'name': 'Северная Ирландия', 'countryCode': '+44'},
                     {'icon': 'fi-gb-sct', 'name': 'Шотландия', 'countryCode': '+44'},
                     {'icon': 'fi-gb-wls', 'name': 'Уэльс', 'countryCode': '+44'},
                     {'icon': 'fi-ic', 'name': 'Канарские острова', 'countryCode': '+34'},
                     {'icon': 'fi-pc', 'name': 'Тихоокеанский совет', 'countryCode': '+682'},
                     {'icon': 'fi-sh-ac', 'name': 'Остров Вознесения', 'countryCode': '+247'},
                     {'icon': 'fi-sh-hl', 'name': 'Остров Святой Елены', 'countryCode': '+290'},
                     {'icon': 'fi-sh-ta', 'name': 'Тристан-да-Кунья', 'countryCode': '+290'},
                     {'icon': 'fi-un', 'name': 'Организация Объединенных Наций', 'countryCode': '+1'},
                     {'icon': 'fi-xk', 'name': 'Косово', 'countryCode': '+383'}
                 ],
                symbols: {
                    'А': 'A', 'Б': 'B', 'В': 'V', 'Г': 'G', 'Д': 'D', 'Е': 'E', 'Ё': 'Yo', 'Ж': 'Zh', 'З': 'Z', 'И': 'I',
                    'Й': 'Y', 'К': 'K', 'Л': 'L', 'М': 'M', 'Н': 'N', 'О': 'O', 'П': 'P', 'Р': 'R', 'С': 'S', 'Т': 'T',
                    'У': 'U', 'Ф': 'F', 'Х': 'Kh', 'Ц': 'Ts', 'Ч': 'Ch', 'Ш': 'Sh', 'Щ': 'Shch', 'Ы': 'Y', 'Э': 'E',
                    'Ю': 'Yu', 'Я': 'Ya', 'а': 'a', 'б': 'b', 'в': 'v', 'г': 'g', 'д': 'd', 'е': 'e', 'ё': 'yo', 'ж': 'zh',
                    'з': 'z', 'и': 'i', 'й': 'y', 'к': 'k', 'л': 'l', 'м': 'm', 'н': 'n', 'о': 'o', 'п': 'p', 'р': 'r',
                    'с': 's', 'т': 't', 'у': 'u', 'ф': 'f', 'х': 'kh', 'ц': 'ts', 'ч': 'ch', 'ш': 'sh', 'щ': 'shch', 'ы': 'y',
                    'э': 'e', 'ю': 'yu', 'я': 'ya'
                },
                currentDate: new Date(),
                participants: null,
                userModel: null,
                eventId: null,
                baseUrl: null,
                inviteUserId: null,
                errors: null,
                user: {
                    firstName: null,
                    firstNameEng: null,
                    lastName: null,
                    lastNameEng: null,
                    birthDate: null,
                    gender: null,
                    role: USER_ROLE.ADMIN,
                    email: null,
                    phone: null,
                    password: null,
                    passwordDouble: null
                },
                options: [
                    {
                        user_id: window.$cookies.get(IDENTIFIER),
                        entity: 'user',
                        name: 'Weight',
                        value: null,
                        type: 'string',
                    },
                    {
                        user_id: window.$cookies.get(IDENTIFIER),
                        entity: 'user',
                        name: 'Height',
                        value: null,
                        type: 'string',
                    },
                ],
            };
        },
        props: {
            baseUrlProps: String,
            eventIdProps: Number,
            inviteUserIdProps: Number,
            urlKeyProps: Boolean,
        },
        components: {
            Card,
            InputText,
            Button,
            InputMask,
            FloatLabel,
            Password,
            AppFormWrapperComponent,
            Dropdown
        },
        methods: {
            translationFirstName: function (event) { this.user.firstNameEng = this.translation(this.user.firstName) },
            translationLastName: function (event) { this.user.lastNameEng = this.translation(this.user.lastName) },
            translation: function (argField) { return argField.split('').map(char => this.symbols[char] || char).join(''); },
            dateFormat: async function(dateStr) {
                const dateObj = await new Date(dateStr);
                const day = String(dateObj.getDate()).padStart(2, '0');
                const month = String(dateObj.getMonth() + 1).padStart(2, '0');
                const year = dateObj.getFullYear();
                return `${day}.${month}.${year}`;
            },
            isValid: function(fields) {
                this.errors = fields
            },
            getAttributes: async function() {
                let attributes = {
                    first_name: await this.user.firstName,
                    first_name_eng: await this.user.firstNameEng,
                    last_name: await this.user.lastName,
                    last_name_eng: await this.user.lastNameEng,
                    gender: await this.user.gender,
                    password: await this.user.password,
                };
                if (this.user.birthDate) {
                    attributes.birth_date = await this.dateFormat(this.user.birthDate);
                }
                if (this.user.email) {
                    attributes.email = await this.user.email;
                }
                if (this.user.phone) {
                    attributes.phone = await `${this.selectedCountries.countryCode.trim()} ${this.user.phone.trim()}`;
                }
                return attributes;
            },
            eventRecord: async function(attributesRecord) {
                await eventRecordRequest(attributesRecord)
                    .then(async (response) => {
                        const data = response.data.result.original;
                        this.participants = await data.attributes;
                    })
                    .catch(async(error) => {
                        await createLogOptionRequest({
                            current_date: `${this.currentDate.getDate().toString().padStart(2, '0')}-${(this.currentDate.getMonth() + 1).toString().padStart(2, '0')}-${this.currentDate.getFullYear()}`,
                            current_time: `${this.currentDate.getHours().toString().padStart(2, '0')}:${this.currentDate.getMinutes().toString().padStart(2, '0')}:${this.currentDate.getSeconds().toString().padStart(2, '0')}`,
                            method: 'registrationRequest',
                            status: error.code,
                            request_data: attributesRecord.toString(),
                            message: error.message
                        })
                    });
            },
            createOption: async function(attributesOptions) {
                await createOptionRequest(attributesOptions)
                    .catch(async (error) => {
                        await createLogOptionRequest({
                            current_date: `${this.currentDate.getDate().toString().padStart(2, '0')}-${(this.currentDate.getMonth() + 1).toString().padStart(2, '0')}-${this.currentDate.getFullYear()}`,
                            current_time: `${this.currentDate.getHours().toString().padStart(2, '0')}:${this.currentDate.getMinutes().toString().padStart(2, '0')}:${this.currentDate.getSeconds().toString().padStart(2, '0')}`,
                            method: 'createOptionRequest',
                            status: error.code,
                            request_data: attributesRecord.toString(),
                            message: error.message
                        })
                    });
            },
            createInvite: async function(attributesInvite) {
                await createInvitedRequest(attributesInvite)
                    .then(async (response) => {
                        // TODO: выполнить действие
                    })
                    .catch(async (error) => {
                        await createLogOptionRequest({
                            current_date: `${this.currentDate.getDate().toString().padStart(2, '0')}-${(this.currentDate.getMonth() + 1).toString().padStart(2, '0')}-${this.currentDate.getFullYear()}`,
                            current_time: `${this.currentDate.getHours().toString().padStart(2, '0')}:${this.currentDate.getMinutes().toString().padStart(2, '0')}:${this.currentDate.getSeconds().toString().padStart(2, '0')}`,
                            method: 'createInvitedRequest',
                            status: error.code,
                            request_data: attributesInvite.toString(),
                            message: error.message
                        })
                    });
            },
            signUp: async function () {
                if (this.user.password && this.user.passwordDouble && this.user.password === this.user.passwordDouble) {
                    const attributes = await this.getAttributes();
                    if (this.urlKey)  {
                        attributes.role = 'athlete';
                         await registrationRequest(attributes)
                            .then(async (response) => {
                                await this.$emit('messageSuccessEmit', MESSAGES.FORM_SUCCESS);
                                const data = response.data.result.original;
                                // this.userModel = await Object.assign(new UserModel(), data.attributes)
                                this.user = data.attributes;
                            })
                            .catch(async (error) => {
                                await createLogOptionRequest({
                                    current_date: `${this.currentDate.getDate().toString().padStart(2, '0')}-${(this.currentDate.getMonth() + 1).toString().padStart(2, '0')}-${this.currentDate.getFullYear()}`,
                                    current_time: `${this.currentDate.getHours().toString().padStart(2, '0')}:${this.currentDate.getMinutes().toString().padStart(2, '0')}:${this.currentDate.getSeconds().toString().padStart(2, '0')}`,
                                    method: 'registrationRequest',
                                    status: error.code,
                                    request_data: attributes.toString(),
                                    message: error.message
                                })
                            });

                        this.user.role = USER_ROLE.ATHLETE;

                        let attributesInvite = {
                            who_user_id: this.inviteUserId,
                            user_id: this.user.id,
                        }
                        let attributesRecord = {
                            event_id: this.eventId,
                            user_id: this.user.id,
                            invited_user_id: this.inviteUserId,
                            admin_id: this.inviteUserId
                        };
                        let attributesOptions = [
                            {
                                user_id: this.user.id,
                                entity: "user",
                                name: "Weight",
                                value: this.options[0].weight,
                                type: "string",
                            },
                            {
                                user_id: this.user.id,
                                entity: "user",
                                name: "Height",
                                value: this.options[1].height,
                                type: "string",
                            }
                        ];

                         await this.createInvite(attributesInvite);

                        let i = 0;
                        while(i < attributesOptions.length) {
                             await this.createOption(attributesOptions[i]);
                            i++;
                        }
                        await this.eventRecord(attributesRecord);
                        window.location = this.baseUrl + ENDPOINTS.LOGIN;
                        return;
                    }

                    attributes.role = 'admin';
                    registrationRequest(attributes)
                        .then(async (response) => {
                            if ('error' in response.data) {
                                this.isValid(response.data.error.data);
                                return;
                            }
                            const data = response.data.result.original;
                            await this.$emit('messageSuccessEmit', MESSAGES.FORM_SUCCESS);
                            this.userModel = Object.assign(new UserModel(), data.attributes);
                            window.location = this.baseUrl + ENDPOINTS.LOGIN;
                        })
                        .catch(async (error) => {
                            await createLogOptionRequest({
                                current_date: `${this.currentDate.getDate().toString().padStart(2, '0')}-${(this.currentDate.getMonth() + 1).toString().padStart(2, '0')}-${this.currentDate.getFullYear()}`,
                                current_time: `${this.currentDate.getHours().toString().padStart(2, '0')}:${this.currentDate.getMinutes().toString().padStart(2, '0')}:${this.currentDate.getSeconds().toString().padStart(2, '0')}`,
                                method: 'registrationRequest',
                                status: error.code,
                                request_data: attributes.toString(),
                                message: error.message
                            })
                        });
                } else {
                    this.$emit('messageErrorEmit', MESSAGES.PASSWORD_DOUBLE);
                }
            },
        },
        watch: {
            eventIdProps: {
                handler(value) {
                    this.eventId = value;
                },
                immediate: true,
                deep: true
            },
            inviteUserIdProps: {
                handler(value) {
                    this.inviteUserId = value;
                },
                immediate: true,
                deep: true
            },
            baseUrlProps: {
                handler(value) {
                    this.baseUrl = value;
                },
                immediate: true,
                deep: true
            },
            urlKeyProps: {
                handler(value) {
                    this.urlKey = value;
                },
                immediate: true,
                deep: true
            }
        }
    }
</script>

<template>
    <AppFormWrapperComponent>
        <div class="d-flex d-between wrap">
            <div class="form-block w-46">
                <label for="name">Имя</label>
                <InputText type="text"
                           v-model="this.user.firstName"
                           @input="this.translationFirstName($event)"
                           class="w-100"
                           :invalid="this.errors !== null && 'first_name' in this.errors" />
                <section id="errorField" v-if="this.errors !== null && 'first_name' in this.errors">
                    <small v-for="error in this.errors.first_name">
                        <i class="pi pi-times-circle"></i> {{ error }}
                    </small>
                </section>

            </div>
            <div class="form-block w-46">
                <label for="lastName">Фамилия</label>
                <InputText type="text"
                           v-model="this.user.lastName"
                           @input="translationLastName($event)"
                           class="w-100"
                           :invalid="this.errors !== null && 'last_name' in this.errors" />
                <section id="errorField" v-if="this.errors !== null && 'last_name' in this.errors">
                    <small v-for="error in this.errors.last_name">
                        <i class="pi pi-times-circle"></i> {{ error }}
                    </small>
                </section>
            </div>
        </div>
        <div class="d-flex d-between wrap">
            <div class="form-block w-46">
                <label for="nameLat">Имя на латинице</label>
                <InputText type="text"
                           v-model="this.user.firstNameEng"
                           class="w-100"
                           :invalid="this.errors !== null && 'first_name_eng' in this.errors" />
                <section id="errorField" v-if="this.errors !== null && 'first_name_eng' in this.errors">
                    <small v-for="error in this.errors.first_name_eng">
                        <i class="pi pi-times-circle"></i> {{ error }}
                    </small>
                </section>
            </div>
            <div class="form-block w-46">
                <label for="lastNameLat">Фамилия на латинице</label>
                <InputText type="text"
                           v-model="this.user.lastNameEng"
                           class="w-100"
                           :invalid="this.errors !== null && 'last_name_eng' in this.errors" />
                <section id="errorField" v-if="this.errors !== null && 'first_name' in this.errors">
                    <small v-for="error in this.errors.first_name">
                        <i class="pi pi-times-circle"></i> {{ error }}
                    </small>
                </section>
            </div>
        </div>
        <div class="form-block">
            <label for="#">email</label>
            <InputText type="email"
                       v-model="this.user.email"
                       class="w-100"
                       :invalid="this.errors !== null && 'email' in this.errors" />
            <section id="errorField" v-if="this.errors !== null && 'email' in this.errors">
                <small v-for="error in this.errors.email">
                    <i class="pi pi-times-circle"></i> {{ error }}
                </small>
            </section>
        </div>
        <div class="form-block">
            <label for="tel">Номер телефона</label>
            <div class="d-flex d-between wrap">
                <Dropdown v-model="this.selectedCountries"
                          :options="this.countries"
                          filter
                          optionLabel="name"
                          placeholder="Выберите страну"
                          checkmark
                          :highlightOnSelect="false" >
                    <template #option="slotProps">
                        <div class="flex items-center">
                             <span :class="'fi ' + slotProps.option.icon"></span>
                            {{ slotProps.option.name }}
                        </div>
                    </template>
                </Dropdown>

                <InputMask id="tel"
                           v-model="this.user.phone"
                           mask=" (999) 999-99-99"
                           class="w-100"
                           :invalid="this.errors !== null && 'phone' in this.errors" />
            </div>

            <section id="errorField" v-if="this.errors !== null && 'phone' in this.errors">
                <small v-for="error in this.errors.phone">
                    <i class="pi pi-times-circle"></i> {{ error }}
                </small>
            </section>
        </div>
        <div class="d-flex d-between wrap">
            <div class="form-block w-46">
                <label for="#">Дата рождения</label>
                <InputText type="date"
                           v-model="this.user.birthDate"
                           class="w-100"
                           :invalid="this.errors !== null && 'birth_date' in this.errors" />
                <section id="errorField" v-if="this.errors !== null && 'birth_date' in this.errors">
                    <small v-for="error in this.errors.birth_date">
                        <i class="pi pi-times-circle"></i> {{ error }}
                    </small>
                </section>
            </div>
            <div class="form-block w-46">
                <label for="#">Укажите ваш пол</label>
                <div class="flexing">
                    <label for="radioMale" class="w-auto">
                        <input type="radio"
                               v-model="this.user.gender"
                               name="gender"
                               value="Мужчина"
                               class="w-auto" />
                        Мужской
                    </label>
                    <label for="radioFemale" class="w-auto">
                        <input type="radio"
                               v-model="this.user.gender"
                               name="gender"
                               value="Женщина"
                               class="w-auto" />
                        Женский
                    </label>
                </div>
            </div>
        </div>
        <div class="form-block">
            <label for="#">Придумайте пароль</label>
            <Password toggleMask
                      v-model="this.user.password"
                      id="input-password"
                      promptLabel="Введите пароль"
                      weakLabel="Простой пароль"
                      mediumLabel="Пароль средней сложности"
                      strongLabel="Сложный пароль"
                      :invalid="this.errors !== null && 'password' in this.errors" />
            <section id="errorField" v-if="this.errors !== null && 'password' in this.errors">
                <small v-for="error in this.errors.password">
                    <i class="pi pi-times-circle"></i> {{ error }}
                </small>
            </section>
        </div>
        <div class="form-block">
            <label for="#">Повторите пароль</label>
            <Password toggleMask
                      v-model="this.user.passwordDouble"
                      id="input-password"
                      promptLabel="Введите пароль"
                      weakLabel="Простой пароль"
                      mediumLabel="Пароль средней сложности"
                      strongLabel="Сложный пароль" />
        </div>
        <section v-if="this.urlKey">
            <div class="form-block">
                <label for="#">Укажите ваш рост</label>
                <InputText type="number"
                           v-model="this.options[1].height"
                           class="w-100" />
            </div>
            <div class="form-block">
                <label for="#">Укажите ваш вес</label>
                <InputText type="number"
                           v-model="this.options[0].weight"
                           class="w-100" />
            </div>
        </section>
        <div class="form-block d-flex d-between">
            <Button label="Создать аккаунт"
                    @click="this.signUp"
                    class="w-100"
                    severity="success"/>
        </div>
    </AppFormWrapperComponent>
</template>

<style scoped>
input:invalid {
    border: 1px solid red;
}
.flexing {
    display: flex;
    gap: 10px;
}

.nameLatInput {
    margin-top: 30px;
}
.p-password{
    width: 100%;
}
label {
    margin-bottom: 0.5em;
}
</style>
