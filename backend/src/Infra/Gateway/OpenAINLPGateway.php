<?php

namespace Src\Infra\Gateway;

use DateTime;
use Src\Application\DTO\NLPGateway\NLPOutput;
use Src\Application\Enviroment\Env;
use Src\Domain\Character;
use Exception;
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

        $response = $this->makeRequest($this->generatePrompt($message, $character));

        $responseData = json_decode($response['body'], true);
        $dataFormatted = json_decode($responseData['choices'][0]['message']['content'], true);


        if (isset($dataFormatted['error'])) {
            throw new Exception($dataFormatted['error']);
        }


        $nlpOutput = new NLPOutput($dataFormatted['msg'], new DateTime($dataFormatted['date']));

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
            Siga as seguintes instruções fielmente: 
    
            Você irá interpretar um personagem, e deve me retornar uma mensagem contendo uma estrutura JSON com as seguintes chaves: 'msg' e 'date', ou apenas com a chave 'error'. Observe: não precisa formatar o JSON com markdown.
    
            A chave 'msg' deve conter um texto que se trata da sua imitação do personagem {$character->getName()}. Este texto será uma alteração bem humorada do seguinte lembrete: '{$message}'. Certifique-se de incluir o humor característico do personagem, fazendo comentários ou piadas que se adequem à sua personalidade. Use emojis e tente relacionar o texto com a personalidade do personagem o máximo possível. O objetivo é criar um lembrete que seja memorável e adequado à situação.
    
            Para entender melhor o personagem, aqui vão algumas informações:
            - Nome: {$character->getName()}
            - Humor: {$character->getHumor()}
            - Papel: {$character->getRole()}
            - Origem: {$character->getOrigin()}
            - Maneirismos de fala: {$character->getSpeechMannerisms()}
            - Sotaque: {$character->getAccent()}
            - Arquétipo: {$character->getArchetype()}
                
            Além disso, a chave 'date' deve conter um DateTime com o valor sugerido no texto do lembrete. Hoje é {$formattedDate}, interprete o lembrete e adicione o valor da data em 'date'.

            Entretanto, a data/horario e a tarefa devem estar bem definidas no lembrete original, caso não esteja, retorne um JSON com chave 'error' e o valor deve ser uma frase do personagem informando que não entendeu qual é a tarefa ou a data e hora, utilizando o mesmo humor e personalidade de {$character->getName()}. Não suponha uma atividade a ser lembrada ou horario, caso não haja um dos dois no lembrete original, retorne o json com erro indicando o que está faltando no lembrete, é essencial ter um lembrete com estas duas informações claras, então informe ao individuo seus erros.
            
            Lembre-se de escrever o texto no idioma pt-br, lembre a pessoa do lembrete que foi criado, não faça em um idiona diferente, mesmo que o personagem tenha outra nacionalidade! 
                
            Siga todas as intruções fielmente, não realize suposições.
            ";

        return $prompt;
    }
}
