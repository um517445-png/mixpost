<?php

namespace Inovector\Mixpost\Actions;

use Inovector\Mixpost\Models\Post;

class PublishPost
{
    public function __invoke(Post $post): void
    {
        if ($post->isScheduleProcessing()) {
            return;
        }

        $post->setScheduleProcessing();

        $accountPublishPost = app(AccountPublishPost::class);

        foreach ($post->accounts as $account) {
            if (! $account->isServiceActive()) {
                $post->insertErrors($account, ['Service disabled']);
                continue;
            }

            if ($account->isUnauthorized()) {
                $post->insertErrors($account, ['Access token expired']);
                continue;
            }

            $response = $accountPublishPost($account, $post);

            if ($response->isUnauthorized()) {
                $account->setUnauthorized();
                $post->insertErrors($account, ['Access token expired']);
                continue;
            }

            if ($response->hasError()) {
                $post->insertErrors($account, $response->context());
            } else {
                $post->insertProviderData($account, $response);
            }
        }

        if ($post->hasErrors()) {
            $post->setFailed();
        } else {
            $post->setPublished();
        }
    }
}
