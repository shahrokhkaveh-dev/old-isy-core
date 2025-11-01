<?php

namespace App\Repositories\Interfaces;

interface TranslationProviderInterface
{
    /**
     * Get provider name
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Translate text using this provider
     *
     * @param string $text
     * @param string $sourceLang
     * @param string $targetLang
     * @return string
     */
    public function translate(string $text, string $sourceLang, string $targetLang): string;

    /**
     * Check if provider supports HTML
     *
     * @return bool
     */
    public function supportsHtml(): bool;

    /**
     * Get provider configuration
     *
     * @return array
     */
    public function getConfig(): array;
}
