<?php

declare(strict_types=1);

namespace Application\model\classes;

final readonly class ChatIA
{
    private const CHAT_SERVICE_URL = "http://chat-service:5000/chat";

    public static function sendMessage(string $message): ?array
    {
        $payload = json_encode(["message" => $message]);

        $ch = curl_init(self::CHAT_SERVICE_URL);
        curl_setopt_array($ch, [
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => $payload,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER     => ['Content-Type: application/json']
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);

        if($response === false) {
            $error = curl_error($ch);
            $ch = null;
            return ['response' => "Error de cURL: " . $curlError];
        }
        
        if ($httpCode !== 200) {
            return ['response' => "Servicio IA devolvió código: $httpCode"];
        }

        $ch = null;

        return json_decode($response, true) ?? ["response" => "Error de conexión"];
    }
}
