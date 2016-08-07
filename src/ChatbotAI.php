<?php

namespace App;


use ApiAi\Client;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class ChatbotAI
{

    protected $apiClient;
    protected $config;

    /**
     * ChatbotAI constructor.
     * @param $config
     */
    public function __construct($config)
    {
        $this->config = $config;
        $this->log = new Logger('general');
        $this->log->pushHandler(new StreamHandler('debug.log'));
        $this->apiClient = new Client($this->config['apiai_token']);
    }

    /**
     * Get the answer to the user's message
     * @param $message
     * @return string
     */
    public function getAnswer(string $message)
    {
        // Simple example returning the user's message
        return 'Define your own logic to reply to this message: ' . $message;

        // Do whatever you like to analyze the message
        // Example:
        // if(preg_match('[hi|hey|hello]', strtolower($message))) {
            // return 'Hi, nice to meet you!';
        // }
    }

    /**
     * Get the answer to the user's message with help from api.ai
     * @param string message
     * @return string
     */
    public function getApiAIAnswer($message)
    {

        try {

            $query = $this->apiClient->get('query', [
                'query' => $message,
            ]);

            $response = json_decode((string)$query->getBody(), true);

            return "You choose " . $response['result']['parameters']['language'];
        } catch (\Exception $error) {
            $this->log->warning($error->getMessage());
        }

    }

    /**
     * Get the answer to the user's message with help from wit.ai
     * @param $message
     * @return string
     */
    public function getWitAIAnswer($message)
    {
        return 'Wit ai support coming soon';
    }


}