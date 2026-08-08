<script setup>
import {ref} from "vue";
import {router} from "@inertiajs/vue3";
import useNotifications from "@/Composables/useNotifications";
import Panel from "@/Components/Surface/Panel.vue";
import Input from "@/Components/Form/Input.vue";
import PrimaryButton from "@/Components/Button/PrimaryButton.vue";
import HorizontalGroup from "@/Components/Layout/HorizontalGroup.vue";
import Error from "@/Components/Form/Error.vue";
import LabelSuffix from "../Form/LabelSuffix.vue";
import Flex from "../Layout/Flex.vue";
import Checkbox from "../Form/Checkbox.vue";
import Label from "../Form/Label.vue";

const props = defineProps({
    form: {
        required: true,
        type: Object
    }
})

const {notify} = useNotifications();
const errors = ref({});

const save = () => {
    errors.value = {};

    router.put(route('mixpost.services.update', {service: 'google_gemini'}), props.form, {
        preserveScroll: true,
        onSuccess() {
            notify('success', 'Google Gemini AI service configuration saved successfully');
        },
        onError: (err) => {
            errors.value = err;
        },
    });
}
</script>
<template>
    <Panel>
        <template #title>
            <div class="flex items-center">
                <span class="mr-xs font-bold text-lg">✨</span>
                <span>Google Gemini AI</span>
            </div>
        </template>

        <template #description>
            <p>Connect Google Gemini AI to generate post ideas, hashtags, rephrase, and translate text directly inside Mixpost.</p>
            <p>
                <a href="https://aistudio.google.com/app/apikey" class="link" target="_blank">
                    Get your API Key from Google AI Studio</a>.
            </p>
        </template>

        <HorizontalGroup class="mt-lg">
            <template #title>
                <label for="api_key">API Key <LabelSuffix danger>*</LabelSuffix></label>
            </template>

            <Input v-model="form.configuration.api_key"
                   :error="errors['configuration.api_key'] !== undefined"
                   type="password"
                   id="api_key"
                   placeholder="AIzaSy..."
                   autocomplete="off"/>

            <template #footer>
                <Error :message="errors['configuration.api_key']"/>
            </template>
        </HorizontalGroup>

        <HorizontalGroup class="mt-lg">
            <template #title>
                Status
            </template>

            <Flex :responsive="false" class="items-center">
                <Checkbox v-model:checked="form.active" id="active"/>
                <Label for="active" class="mb-0!">Active</Label>
            </Flex>

            <template #footer>
                <Error :message="errors.active"/>
            </template>
        </HorizontalGroup>

        <PrimaryButton @click="save" class="mt-lg">Save</PrimaryButton>
    </Panel>
</template>
