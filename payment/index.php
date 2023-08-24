<?php

class Payment
{
    private $secretid = 'A21AAKZWDL7gJz5MsIYGhPb0LGlVyvebpf_0DFhpKgpp2rhlddK_uMpmV50HA8w4d13RhuDGXpteNd796dmlkwYzSanO4WT0w';

    public function createInvoice($userId, $invoiceDescription, $invoiceAmount)
    {
        $invoiceId = 'KIMS' . random_int(1000000, 9999999) . $userId; // ?? INVOICE ID SIMPAN UNTUK USER
        $ch = curl_init();

        // Data to be sent in the POST request
        $headers = [
            'Authorization: Bearer '.$this->secretid,
            'Content-Type: application/json',
        ];
        $data = [
            'intent' => 'CAPTURE',
            'purchase_units' => [
                [
                    'reference_id' => $invoiceId,
                    'description' => $invoiceDescription,
                    'amount' => [
                        'currency_code' => 'USD',
                        'value' => '100',
                        'breakdown' => [
                            'item_total' => [
                                'currency_code' => 'USD',
                                'value' => '100',
                            ]
                        ]
                    ],
                    'items' => [
                        [
                            'name' => $invoiceId,
                            'description' => $invoiceDescription,
                            'quantity' => '1', // ?? Berapa Itemnya
                            'unit_amount' => [
                                'value' => '100', // ?? Harga Item
                                'currency_code' => 'USD'
                            ]
                        ],
                        // ?? Tambahkan item disini sebagai array
                        // [
                        //     'name' => $invoiceId,
                        //     'description' => $invoiceDescription,
                        //     'quantity' => '1', // ?? Berapa Itemnya
                        //     'unit_amount' => [
                        //         'value' => '100', // ?? Harga Item
                        //         'currency_code' => 'USD'
                        //     ]
                        // ],
                    ],
                ]
            ],
            // "application_context" => [
            //     "return_url" => "",      // ?? Example return url
            //     "cancel_url" => ""       // ?? Example cancel url
            // ]
        ];
        $data = json_encode($data);

        // Set cURL options
        curl_setopt($ch, CURLOPT_URL, 'https://api-m.sandbox.paypal.com/v2/checkout/orders');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        // Execute cURL session and get the response
        $response = curl_exec($ch);
        var_dump($response);
        echo "<br/>";
        var_dump($data);
        echo "<br/>";

        // Check for errors
        if (curl_errno($ch)) {
            // Handle error, e.g., timeout, SSL problems, etc.
            echo 'Error:' . curl_error($ch);
        } else {
            $createInvoice = json_decode($response, true);
            if (!empty($createInvoice['id'])) {

                $db = new db;
                $db->insertInvoices('123', $createInvoice['id'], $invoiceId);

                $approveLink = '';
                foreach ($createInvoice['links'] as $link) {
                    if ($link['rel'] === 'approve') {
                        $approveLink = $link['href'];
                        break;  // Exit the loop once we find the approve link
                    }
                }
                if (!empty($approveLink)) {
                    header('Location: ' . $approveLink);
                } else {
                    echo "Approve link not found";
                }
            } else {
                echo "Response didn't match";
            }
        }
        curl_close($ch);
        die();
    }

    function PaypalValidateWebhook($id) {
        // ?? TODO: Create Webhook event on Paypal URL : https://developer.paypal.com/docs/api/webhooks/v1/
        // ?? Example received Webhook URL : https://developer.paypal.com/api/rest/webhooks#sample-message-payload
        
        $ch = curl_init();

        // Data to be sent in the POST request
        $headers = [
            'Authorization: Bearer '.$this->secretid,
            'Content-Type: application/json',
        ];

        // Set cURL options
        curl_setopt($ch, CURLOPT_URL, 'https://api.sandbox.paypal.com/v2/checkout/orders/'.$id.'/capture');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        // Execute cURL session and get the response
        $response = json_decode(curl_exec($ch));
        if($response['details']['issue'] != 'ORDER_NOT_APPROVED'){
            // ?? Lakukan Sesuatu Jika berhasil
        } else {
            // ?? Lakukan Sesuatu Jika tidak berhasil
        }
        die();
    }
}
