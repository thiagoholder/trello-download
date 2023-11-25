<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;

class TrelloController extends Controller
{
    public function downloadAttachment(Request $request)
    {
        // Recupere os parâmetros da query string
        $apiKey = "{change with Trello ApiKey}";
        $token = "{change with Trello token}";
        $cardId = $request->query('cardId');
        $attachmentId = $request->query('attachmentId');
        $fileName = $request->query('fileName');

        $attachmentUrl = "https://api.trello.com/1/cards/{$cardId}/attachments/{$attachmentId}/download/{$fileName}";

        $params = [
            'key' => $apiKey,
            'token' => $token,
        ];

        $attachmentUrl .= '?' . http_build_query($params);

        $response = Http::withHeaders(['Authorization' => 'OAuth oauth_consumer_key="' . $apiKey . '", oauth_token="' . $token . '"'])
            ->get($attachmentUrl);

        if ($response->successful()) {
            // Salve o conteúdo do arquivo no armazenamento local
            $filePath = public_path("downloads/{$fileName}");
            File::put($filePath, $response->body());
            
            return "Anexo baixado com sucesso e salvo em: {$filePath}";
        } else {
            return "Erro ao baixar o anexo. Código de status: " . $response->status();
        }
    }
}
