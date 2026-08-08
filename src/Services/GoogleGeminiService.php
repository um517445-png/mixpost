<?php

namespace Inovector\Mixpost\Services;

use Inovector\Mixpost\Abstracts\Service;
use Inovector\Mixpost\Enums\ServiceGroup;

class GoogleGeminiService extends Service
{
    public static function group(): ServiceGroup
    {
        return ServiceGroup::MISCELLANEOUS;
    }

    public static function form(): array
    {
        return [
            'api_key' => '',
        ];
    }

    public static function formRules(): array
    {
        return [
            'api_key' => ['required'],
        ];
    }

    public static function formMessages(): array
    {
        return [
            'api_key' => 'The Google Gemini API Key is required.',
        ];
    }
}
