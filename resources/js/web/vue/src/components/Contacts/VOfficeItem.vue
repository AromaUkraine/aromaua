<template>
    <ul class="location__list">
        <li class="location__item">
            <svg class="svg-sprite location__icon" width="18px" height="23px">
                <use :xlink:href="getImage('#pin')"></use>
            </svg>
            <div class="location__info">
                <address class="location__address">
                    {{ office.address }}
                </address>
                <span class="location__text">{{ office.info }}</span>
            </div>
        </li>
        <li
            class="location__item"
            v-for="contact in office.contacts"
            :key="contact.id"
        >
            <svg
                v-if="isPhone(contact.type)"
                class="svg-sprite location__icon"
                width="24px"
                height="24px"
            >
                <use v-bind:xlink:href="getImage('#phone')"></use>
            </svg>
            <div v-if="isPhone(contact.type)" class="location__info">
                <a class="location__link" :href="contact.clear_value">{{
                    contact.value
                }}</a>
                <span class="location__text">{{ contact.description }}</span>
            </div>
            <div v-if="!isPhone(contact.type)" class="location__info location__link--mail">
            <a
                class="location__link"
                :href="contact.clear_value"
                >{{ contact.value }}</a>
            <span class="location__text">{{ contact.description }}</span>
            </div>
        </li>
    </ul>
</template>

<script>
export default {
    name: "OfficeItem",
    props: {
        office: {
            default() {
                return null;
            }
        }
    },
    methods: {
        getImage(key) {
            return this.office.image_path + key;
        },
        isPhone(type) {
            return type === "phone";
        },
        isWebsite(type) {
            return type === "website";
        },
        withMap() {
            return !!$this.office.map;
        }
    }
};
</script>

<style scoped></style>
