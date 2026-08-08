<script setup>
import { ref } from 'vue';
import axios from 'axios';
import Modal from "@/Components/Modal/Modal.vue";
import PrimaryButton from "@/Components/Button/PrimaryButton.vue";
import SecondaryButton from "@/Components/Button/SecondaryButton.vue";
import Sparkles from "@/Icons/Sparkles.vue";
import Loading from "@/Icons/Loading.vue";

const props = defineProps({
    show: {
        type: Boolean,
        default: false,
    },
});

const emit = defineEmits(['close', 'insert']);

const prompt = ref('');
const action = ref('generate');
const generatedText = ref('');
const isLoading = ref(false);
const errorMessage = ref('');

const actions = [
    { id: 'generate', label: '✍️ منشور جديد' },
    { id: 'hashtags', label: '🏷️ هاشتاجات' },
    { id: 'rephrase', label: '🔄 إعادة صياغة' },
    { id: 'translate', label: '🌐 ترجمة' },
];

const generateContent = async () => {
    if (!prompt.value.trim()) return;

    isLoading.value = true;
    errorMessage.value = '';

    try {
        const response = await axios.post(route('mixpost.ai.generate'), {
            prompt: prompt.value,
            action: action.value,
        });

        generatedText.value = response.data.text;
    } catch (error) {
        errorMessage.value = error.response?.data?.error || 'حدث خطأ غير متوقع أثناء الاتصال بالذكاء الاصطناعي.';
    } finally {
        isLoading.value = false;
    }
};

const insertContent = () => {
    if (generatedText.value) {
        emit('insert', generatedText.value);
        closeModal();
    }
};

const closeModal = () => {
    generatedText.value = '';
    errorMessage.value = '';
    emit('close');
};
</script>

<template>
    <Modal :show="show" max-width="2xl" @close="closeModal">
        <div class="p-lg text-right">
            <div class="flex items-center justify-between border-b border-gray-200 pb-md mb-md">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-full bg-amber-100 flex items-center justify-center text-amber-600">
                        <Sparkles class="w-5 h-5"/>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900">مساعد الذكاء الاصطناعي ✨ (Google Gemini)</h3>
                </div>
                <button @click="closeModal" class="text-gray-400 hover:text-gray-600 text-xl font-bold">&times;</button>
            </div>

            <!-- Action Tabs -->
            <div class="flex flex-wrap gap-2 mb-md">
                <button v-for="item in actions" :key="item.id"
                        @click="action = item.id"
                        :class="[
                            'px-md py-xs rounded-lg text-sm font-medium transition-colors',
                            action === item.id 
                                ? 'bg-amber-500 text-white shadow-sm' 
                                : 'bg-gray-100 text-gray-700 hover:bg-gray-200'
                        ]">
                    {{ item.label }}
                </button>
            </div>

            <!-- Prompt Input -->
            <div class="mb-md">
                <label class="block text-sm font-semibold text-gray-700 mb-xs">وصف المحتوى أو المطلوب من الذكاء الاصطناعي:</label>
                <textarea v-model="prompt"
                          rows="3"
                          placeholder="مثال: اكتب منشور تسويقي عن افتتاح مشروع عقاري جديد في القاهرة التجمع الخامس بصياغة جذابة ومؤثرة..."
                          class="w-full rounded-lg border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 text-sm p-sm"></textarea>
            </div>

            <!-- Generate Button -->
            <div class="flex justify-end mb-md">
                <PrimaryButton @click="generateContent" :disabled="isLoading || !prompt.trim()" class="bg-amber-600 hover:bg-amber-700">
                    <template v-if="isLoading">
                        <Loading class="w-4 h-4 mr-2 animate-spin"/>
                        جاري التوليد بواسطة Gemini...
                    </template>
                    <template v-else>
                        توليد بالذكاء الاصطناعي ✨
                    </template>
                </PrimaryButton>
            </div>

            <!-- Error Notification -->
            <div v-if="errorMessage" class="p-sm mb-md bg-red-50 border border-red-200 rounded-lg text-red-700 text-sm">
                ⚠️ {{ errorMessage }}
            </div>

            <!-- Output Preview -->
            <div v-if="generatedText" class="mt-md pt-md border-t border-gray-200">
                <label class="block text-sm font-semibold text-gray-700 mb-xs">النتيجة المولّدة:</label>
                <div class="p-md bg-gray-50 rounded-lg border border-gray-200 whitespace-pre-wrap text-sm text-gray-800 max-h-60 overflow-y-auto mb-md">
                    {{ generatedText }}
                </div>
                <div class="flex justify-end gap-2">
                    <SecondaryButton @click="closeModal">إلغاء</SecondaryButton>
                    <PrimaryButton @click="insertContent" class="bg-emerald-600 hover:bg-emerald-700">
                        إدراج في منشور السوشيال ميديا 📥
                    </PrimaryButton>
                </div>
            </div>
        </div>
    </Modal>
</template>