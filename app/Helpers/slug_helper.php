<?php

if (! function_exists('slugify_text')) {
    /**
     * Převede text na URL slug bez diakritiky, mezer a speciálních znaků.
     *
     * @param string $text Vstupní text
     * @return string Normalizovaný slug
     */
    function slugify_text(string $text): string
    {
        $text = trim($text);

        if ($text === '') {
            return '';
        }

        $transliterated = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $text);
        $transliterated = $transliterated !== false ? $transliterated : $text;

        $slug = preg_replace('/[^a-zA-Z0-9]+/', '-', $transliterated);

        if ($slug === null) {
            $slug = $transliterated;
        }

        return strtolower(trim($slug, '-'));
    }
}

if (! function_exists('slugify_path')) {
    /**
     * Převede cestu složenou z více segmentů na normalizovanou URL.
     *
     * @param string $path Vstupní cesta s libovolnými znaky
     * @return string Normalizovaná cesta bez diakritiky a mezer
     */
    function slugify_path(string $path): string
    {
        $segments = preg_split('~/+~', trim($path, '/'));

        if ($segments === false) {
            return slugify_text($path);
        }

        $normalized = array_map(static fn (string $segment): string => slugify_text($segment), $segments);

        return implode('/', array_filter($normalized, static fn (string $segment): bool => $segment !== ''));
    }
}