<?php

namespace Inovector\Mixpost\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Http;
use Inovector\Mixpost\Facades\ServiceManager;

class AiGenerateController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        $request->validate([
            'prompt' => ['required', 'string'],
            'action' => ['nullable', 'string']
        ]);

        $config = ServiceManager::get('google_gemini', 'configuration');

        if (empty($config) || empty($config['api_key'])) {
            return response()->json([
                'error' => 'برجاء تفعيل خدمة Google Gemini وإدخال API Key من صفحة الخدمات أولاً.'
            ], 422);
        }

        $apiKey = $config['api_key'];
        $userPrompt = $request->input('prompt');
        $action = $request->input('action', 'generate');

        $systemInstruction = match($action) {
            'hashtags' => "أنت مساعد تسويقي متخصص في السوشيال ميديا. قم بتوليد قائمة هاشتاجات احترافية وشائعة وعالية التفاعل بناءً على النص التالي، واكتب الهاشتاجات فقط بشكل منظم ومناسب للمحتوى العربي واللغات الأخرى:",
            'rephrase' => "أنت كاتب محتوى محترف. أعد صياغة النص التالي بأسلوب جذاب ومؤثر ومناسب لنشر السوشيال ميديا:",
            'translate' => "ترجم النص التالي إلى اللغة العربية الاحترافية المناسبة للسوشيال ميديا بأسلوب طبيعي وجذاب:",
            default => "أنت مساعد ذكاء اصطناعي محترف لتوليد محتوى السوشيال ميديا والتسويق الرقمي. اكتب منشوراً جذاباً واحترافياً شاملاً مع رموز تعبيرية (Emojis) بناءً على المطلوب التالي:"
        };

        $fullPrompt = $systemInstruction . "

" . $userPrompt;

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json'
            ])->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key={$apiKey}", [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $fullPrompt]
                        ]
                    ]
                ]
            ]);

            if ($response->failed()) {
                $response = Http::withHeaders([
                    'Content-Type' => 'application/json'
                ])->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key={$apiKey}", [
                    'contents' => [
                        [
                            'parts' => [
                                ['text' => $fullPrompt]
                            ]
                        ]
                    ]
                ]);
            }

            if ($response->failed()) {
                return response()->json([
                    'error' => 'حدث خطأ أثناء الاتصال بـ Google Gemini API: ' . $response->body()
                ], 500);
            }

            $data = $response->json();
            $generatedText = $data['candidates'][0]['content']['parts'][0]['text'] ?? '';

            return response()->json([
                'text' => trim($generatedText)
            ]);

        } catch (\Throwable $e) {
            return response()->json([
                'error' => 'عذراً، حدث خطأ في الاتصال بالذكاء الاصطناعي: ' . $e->getMessage()
            ], 500);
        }
    }
}