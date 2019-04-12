<?php
namespace NPusher;

class NPusher
{
    const GOOGLE_GCM_URL = 'https://fcm.googleapis.com/fcm/send';

    private $apiKey;
    private $proxy;
    private $output;

    public function __construct($apiKey, $proxy = null)
    {
        $this->apiKey = $apiKey;
        $this->proxy  = $proxy;
    }

    /**
     * @param string|array $regIds
     * @param string $data
     * @throws \Exception
     */
    public function notify($token, $data)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, self::GOOGLE_GCM_URL);
        if (!is_null($this->proxy)) {
            curl_setopt($ch, CURLOPT_PROXY, $this->proxy);
        }
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->getHeaders());
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $this->getPostFields($token, $data));

        $result = curl_exec($ch);
        if ($result === false) {
            throw new \Exception(curl_error($ch));
        }
        curl_close($ch);
        $this->output = $result;
    }
    /**
     * @return array
     */
    public function getOutputAsArray()
    {
        return json_decode($this->output, true);
    }
    /**
     * @return object
     */
    public function getOutputAsObject()
    {
        return json_decode($this->output);
    }
    private function getHeaders()
    {
        return [
            'Authorization: key=' . $this->apiKey,
            'Content-Type: application/json',
        ];
    }
    private function getPostFields($token, $data)
    {
        $notificationDefault = [
            'sound'    => 'default',
            'priority' => 'high',
        ];

        $notification = array_merge($data, $notificationDefault);

        $fields = [
            'to'           => $token,
            'notification' => $notification,
        ];
        return json_encode($fields, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);
    }
}
