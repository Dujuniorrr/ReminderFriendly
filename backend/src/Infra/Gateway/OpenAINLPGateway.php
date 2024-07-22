<?php

namespace Src\Infra\Gateway;

use DateTime;
use Src\Application\DTO\NLPGateway\NLPOutput;
use Src\Application\Enviroment\Env;
use Src\Domain\Character;
use Exception;
use Src\Application\Exceptions\NLPErrorException;
use Src\Application\Gateways\NLPGateway;
use Src\Application\Http\Server\HTTPClient;

class OpenAINLPGateway implements NLPGateway
{
    private HTTPClient $httpClient;
    private string $apiKey;
    private string $apiUrl = 'https://api.openai.com/v1/';

    public function __construct(HTTPClient $httpClient, Env $env)
    {
        $this->httpClient = $httpClient;
        $this->apiKey = $env->get('OPENAI_API_KEY');
    }

    public function formatMessage(string $message, Character $character): NLPOutput
    {
        $prompt = $this->generatePrompt($message, $character);

        $response = $this->makeRequest($prompt)['body'];

        $processedData = json_decode($response['choices'][0]['message']['content'], true);

        if (isset($processedData['error'])) {
            throw new NLPErrorException($processedData['error']);
        }

        if (!isset($processedData['msg']) || !isset($processedData['date']))  throw new NLPErrorException('Não consegui entender seu lembrete!');

        $nlpOutput = new NLPOutput($processedData['msg'], new DateTime($processedData['date']));

        return $nlpOutput;
    }

    private function makeRequest($message)
    {
        $endpoint = 'chat/completions';

        $headers = [
            'Authorization' => 'Bearer ' . $this->apiKey,
            'Content-Type' => 'application/json'
        ];

        $body =  [
            'model' => 'gpt-4o',
            'messages' => [
                [
                    'role' => 'user',
                    'content' => $message
                ]
            ]
        ];

        return $this->httpClient->post(
            $this->apiUrl . $endpoint,
            $headers,
            $body
        );
    }

    private function generatePrompt(string $message, Character $character): string
    {
        $now = new DateTime();
        $formattedDate = $now->format('Y-m-d H:i:s');
        
        $prompt = "
            Olá Chat.

            Um usuário enviou um lembrete, onde está escrito:

            '{$message}'


            Você irá interpretar este lembrete como um personagem. Existem algumas regras, caso sejam seguidas, você deve me retornar uma mensagem contendo uma estrutura JSON com as seguintes chaves: 'msg' e 'date', caso não sejam, retorne apenas um JSON com a chave 'error' informando o que está faltando, utilizando o mesmo humor e personalidade de {$character->getName()} . Observe: não precisa formatar o JSON com markdown.

            As regras são as seguintes: A data, o horario e o que será lembrado devem ser compreendíveis no lembrete original. JAMAIS suponha algo a ser lembrado ou horario, caso não haja um dos dois no lembrete original, retorne o json com erro indicando o que está faltando no lembrete, é essencial ter um lembrete com estas duas informações claras, então informe ao individuo seus erros, caso haja.

            Caso não hajas erros: Você deverá formatar um JSON onde a chave 'msg' irá conter um texto que se trata da sua imitação do personagem {$character->getName()}. Este texto será uma alteração bem humorada do seguinte lembrete enviado pelo usuário, com proposito de o lembrar de sua tarefa. Porém, diferente do lembrete original, o texto não deve mencionar o período, data ou hora da tarefa. Certifique-se de incluir o humor característico do personagem, fazendo comentários ou piadas que se adequem à sua personalidade. Use emojis e tente relacionar o texto com a personalidade do personagem o máximo possível. O objetivo é criar um lembrete que seja memorável e adequado à situação.
            
            Além disso, a chave 'date' do JSON deve conter um DateTime com o valor sugerido no texto do lembrete. Hoje é {$formattedDate}, interprete o lembrete e adicione o valor da data em 'date'. PORÉM, caso o data OU horário não sejam interpretáveis retorne o json de erro informado.

            Para entender melhor o personagem, aqui vão algumas informações:
            - Nome: {$character->getName()}
            - Humor: {$character->getHumor()}
            - Papel: {$character->getRole()}
            - Origem: {$character->getOrigin()}
            - Maneirismos de fala: {$character->getSpeechMannerisms()}
            - Sotaque: {$character->getAccent()}
            - Arquétipo: {$character->getArchetype()}
            
            Lembre-se de escrever o texto sempre no idioma pt-br, ele deve ser curto. Lembre a pessoa do lembrete que foi criado! 
                
            Siga todas as intruções fielmente, não realize suposições.
        ";

        return $prompt;
    }
}
