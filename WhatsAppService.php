<?php

class WhatsAppService
{
    /**
     * Format the WhatsApp message to HTML-based.
     *
     * @author Aghits Nidallah
     * @param string $message
     * @return string
     */
    public static function formatMessage(string $message): string
    {
        $nl2br_message = nl2br($message);
        $bold = preg_replace('/\*(.*?)\*/', '<b>$1</b>', $nl2br_message);
        $italic = preg_replace('/\_(.*?)\_/', '<i>$1</i>', $bold);
        $strikethrough = preg_replace('/\~(.*?)\~/', '<strike>$1</strike>', $italic);
        $monospace = preg_replace('/\```(.*?)\```/', '<code>$1</code>', $strikethrough);

        $url = preg_replace(
            '/(http(s)?:\/\/.)?(www\.)?[-a-zA-Z0-9@:%._\+~#\=]{2,256}\.[a-z]{2,6}\b([-a-zA-Z0-9@:%_\+.~#?&\/\=]*)/',
            '<a class="text-blue-500" href="$0" target="_blank">$0</a>',
            $monospace
        );

        $unicode = preg_replace_callback(
            ['/(\\\(u|U)[a-fA-F0-9]{4,8})/'],
            function ($matches) {
                $code = preg_replace('/\\\u|\\\U/', '', $matches[0]);
                return "&#x$code;";
            },
            $url
        );

        return $unicode;
    }
}
