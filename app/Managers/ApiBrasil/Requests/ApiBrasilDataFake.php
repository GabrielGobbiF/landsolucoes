<?php

namespace App\Managers\ApiBrasil\Requests;

class ApiBrasilDataFake
{
    public function __construct() {}


    /**
     * cards
     * POST
     * @return array
     */
    public function createCard()
    {
        return [
            "id" => "9d42fdd2-4342-43dc-b419-e90f7cfae2b5",
            "account_id" => "9ca8113d-4173-4448-9636-9e9f37317937",
            "tracking_code" => null,
            "type" => "virtual",
            "status" => "active",
            "holder" => "GABRIEL V GOBBI",
            "issuer" => "visa",
            "number" => "4329********5997",
            "is_noname" => false,
            "sub_status" => null,
            "expiration_date" => "2029-10-16 00:00:00",
            "estimated_delivery_date" => null,
            "issued_at" => "2024-10-16 17:28:42",
            "printed_at" => null,
            "expedited_at" => null,
            "delivered_at" => null,
            "created_at" => "2024-10-16 17:28:38",
            "updated_at" => "2024-10-16 17:28:45",
            "allow_ecommerce" => true,
            "allow_withdrawal" => true,
            "allow_mcc_control" => false,
            "allow_contactless" => true,
            "contactless_limit" => "100",
            "allow_intl_purchase" => true,
            "card_request_id" => null,
            "tracking_url" => "https:\/\/flashcourier.com.br\/rastreio\/IDZ00000347208",
            "bucket_id" => "9ca8113d-4173-4448-9636-9e9f37317937",
            "mcc_groups" => []
        ];
    }

    /**
     * cards
     * GET
     * @return array
     */
    public function getCardsRequestsByUser()
    {
        return [
            [
                "id" => "9d40a639-9dad-4aa8-8bfa-ca1d5f5089a7",
                "account_id" => "9ca8113d-4173-4448-9636-9e9f37317937",
                "status" => "approved",
                "created_at" => "2024-10-15 13:32:02",
                "updated_at" => "2024-10-15 13:46:23",
                "card_type" => "physical",
                "quantity" => 1,
                "cr_image_id" => null
            ],
            [
                "id" => "9d40a639-9dad-4aa8-8bfa-ca1d5f5089a7",
                "account_id" => "9ca8113d-4173-4448-9636-9e9f37317937",
                "status" => "completed",
                "created_at" => "2024-10-15 13:32:02",
                "updated_at" => "2024-10-15 13:46:23",
                "card_type" => "virtual",
                "quantity" => 1,
                "cr_image_id" => null
            ]
        ];
    }

    public function showCard()
    {
        return [
            "data" => [
                [
                    "id" => "9d40ab50-b4a0-40cf-beec-8aa4df5cb06b",
                    "account_id" => "9ca8113d-4173-4448-9636-9e9f37317937",
                    "tracking_code" => null,
                    "type" => "virtual",
                    "status" => "active",  //active //pending
                    "holder" => "GABRIEL V GOBBI",
                    "issuer" => "visa",
                    "number" => "4329********2030",
                    "is_noname" => false,
                    "sub_status" => null,
                    "expiration_date" => "2029-10-15 00:00:00",
                    "estimated_delivery_date" => null,
                    "issued_at" => "2024-10-15 13:46:20",
                    "printed_at" => null,
                    "expedited_at" => null,
                    "delivered_at" => null,
                    "created_at" => "2024-10-15 13:46:16",
                    "updated_at" => "2024-10-15 13:46:22",
                    "allow_ecommerce" => true,
                    "allow_withdrawal" => true,
                    "allow_mcc_control" => false,
                    "allow_contactless" => true,
                    "contactless_limit" => "100",
                    "allow_intl_purchase" => true,
                    "card_request_id" => "9d40a639-9dad-4aa8-8bfa-ca1d5f5089a7",
                    "tracking_url" => "https://flashcourier.com.br/rastreio/IDZ00000347185",
                    "bucket_id" => "9ca8113d-4173-4448-9636-9e9f37317937",
                    "mcc_groups" => []
                ]
            ]

        ];
    }

    /**
     * cards
     * GET
     * @return array
     */
    public function getCardsByUser()
    {
        #return ["data" => []];

        return [
            "teste" => true,
            "data" => [
                [
                    "id" => "9d40ab50-b4a0-40cf-beec-8aa4df5cb06b",
                    "account_id" => "9ca8113d-4173-4448-9636-9e9f37317937",
                    "tracking_code" => null,
                    "type" => "virtual",
                    "status" => "pending",  //active //pending
                    "holder" => "GABRIEL V GOBBI",
                    "issuer" => "visa",
                    "number" => "4329********3912",
                    "is_noname" => false,
                    "sub_status" => null,
                    "expiration_date" => "2029-10-15 00:00:00",
                    "estimated_delivery_date" => null,
                    "issued_at" => "2024-10-15 13:46:20",
                    "printed_at" => null,
                    "expedited_at" => null,
                    "delivered_at" => null,
                    "created_at" => "2024-10-15 13:46:16",
                    "updated_at" => "2024-10-15 13:46:22",
                    "allow_ecommerce" => true,
                    "allow_withdrawal" => true,
                    "allow_mcc_control" => false,
                    "allow_contactless" => true,
                    "contactless_limit" => "100",
                    "allow_intl_purchase" => true,
                    "card_request_id" => "9d40a639-9dad-4aa8-8bfa-ca1d5f5089a7",
                    "tracking_url" => "https://flashcourier.com.br/rastreio/IDZ00000347185",
                    "bucket_id" => "9ca8113d-4173-4448-9636-9e9f37317937",
                    "mcc_groups" => []
                ],
                [
                    "id" => "9d40ab50-b4a0-40cf-beec-8aa4df5cb06b",
                    "account_id" => "9ca8113d-4173-4448-9636-9e9f37317937",
                    "tracking_code" => null,
                    "type" => "physical",
                    "status" => "active",  //active //pending
                    "holder" => "GABRIEL V GOBBI",
                    "issuer" => "visa",
                    "number" => "4329********2043",
                    "is_noname" => false,
                    "sub_status" => null,
                    "expiration_date" => "2029-10-15 00:00:00",
                    "estimated_delivery_date" => null,
                    "issued_at" => "2024-10-15 13:46:20",
                    "printed_at" => null,
                    "expedited_at" => null,
                    "delivered_at" => null,
                    "created_at" => "2024-10-15 13:46:16",
                    "updated_at" => "2024-10-15 13:46:22",
                    "allow_ecommerce" => true,
                    "allow_withdrawal" => true,
                    "allow_mcc_control" => false,
                    "allow_contactless" => true,
                    "contactless_limit" => "100",
                    "allow_intl_purchase" => true,
                    "card_request_id" => "9d40a639-9dad-4aa8-8bfa-ca1d5f5089a7",
                    "tracking_url" => "https://flashcourier.com.br/rastreio/IDZ00000347185",
                    "bucket_id" => "9ca8113d-4173-4448-9636-9e9f37317937",
                    "mcc_groups" => []
                ],
                [
                    "id" => "9d40ab50-b4a0-40cf-beec-8aa4df5cb06b",
                    "account_id" => "9ca8113d-4173-4448-9636-9e9f37317937",
                    "tracking_code" => null,
                    "type" => "virtual",
                    "status" => "active",  //active //pending
                    "holder" => "GABRIEL V GOBBI",
                    "issuer" => "visa",
                    "number" => "4329********2030",
                    "is_noname" => false,
                    "sub_status" => null,
                    "expiration_date" => "2029-10-15 00:00:00",
                    "estimated_delivery_date" => null,
                    "issued_at" => "2024-10-15 13:46:20",
                    "printed_at" => null,
                    "expedited_at" => null,
                    "delivered_at" => null,
                    "created_at" => "2024-10-15 13:46:16",
                    "updated_at" => "2024-10-15 13:46:22",
                    "allow_ecommerce" => true,
                    "allow_withdrawal" => true,
                    "allow_mcc_control" => false,
                    "allow_contactless" => true,
                    "contactless_limit" => "100",
                    "allow_intl_purchase" => true,
                    "card_request_id" => "9d40a639-9dad-4aa8-8bfa-ca1d5f5089a7",
                    "tracking_url" => "https://flashcourier.com.br/rastreio/IDZ00000347185",
                    "bucket_id" => "9ca8113d-4173-4448-9636-9e9f37317937",
                    "mcc_groups" => []
                ]
            ]

        ];
    }

    /**
     * pix/keys
     * POST
     * @return array
     */
    public function createKeyByUser()
    {
        return [
            "idAccount" => 3036713,
            "bankAccountNumber" => "5772 3657",
            "bankBranchNumber" => "78292230",
            "bankAccountType" => "CC",
            "ispb" => "59588111",
            "beneficiaryType" => "J",
            "nationalRegistration" => "70280792000180",
            "name" => "Sr. Carlos Kauan Dias Jr.",
            "tradeName" => "Escobar e Pacheco e Filhos",
            "keyType" => "evp",
            "key" => "60026b0e-ba3d-33f7-b812-679daa97e8bd",
            "dateKeyCreated" => "2004-07-25T09:11:18-0300",
            "dateKeyOwnership" => "1998-10-31T22:59:43-0200",
            "description" => "",
            "keyStatus" => "OPEN"
        ];
    }

    /**
     * pix/qr-codes/decode
     *
     * @return array
     */
    public function dataFakeStorePixTransfer($request)
    {
        return  [
            "teste" => true,
            "id" => "9d3107ed-c564-4f62-a48f-426223554c2f",
            "payer_payee_id" => "9d16988e-e52b-4a11-80e6-1833c3bbc4ae",
            "method" => "key",
            "status" => "processing",
            "amount" => $request['amount'],
            "description" => "teste",
            "meta" => null,
            "created_at" => now(),
            "updated_at" => "2024-10-07 19:12:04",
            "e2e_id" => "E13370835202410072211BUJCMAUNRHU",
            "direction" => "out",
            "id_tx" => null,
            "refunded_amount" => "0",
            "user_id" => "9ca81140-6925-4e5a-abf5-517dc0760b6a",
            "reason" => null,
            "bucket_id" => "9ca8113d-4173-4448-9636-9e9f37317937",
            "payer_payee" => [
                "id" => "9d16988e-e52b-4a11-80e6-1833c3bbc4ae",
                "key" => "64820963000114",
                "created_at" => "2024-09-24 15:49:03",
                "updated_at" => "2024-09-24 15:49:03",
                "bank_account_id" => "9d16988e-dddf-4c9b-9cc8-c70931c62a37",
                "bucket_id" => "9ca8113d-4173-4448-9636-9e9f37317937",
                "bank_account" => [
                    "id" => "9d16988e-dddf-4c9b-9cc8-c70931c62a37",
                    "verified" => false,
                    "bank" => "301",
                    "branch" => "0001",
                    "account_number" => "183280558",
                    "account_digit" => "",
                    "document" => "64820963000114",
                    "created_at" => "2024-09-24 15:49:03",
                    "updated_at" => "2024-09-24 15:49:03",
                    "name" => "Ceenepejota",
                    "type" => "payments",
                    "holder_type" => "company",
                    "bank_id" => "9ca8a41d-b63d-4737-ae34-a976d8aa5ed5",
                    "branch_digit" => null,
                    "bank_name" => "DOCK IP S.A.",
                    "is_savings_account" => false,
                    "bank_detail" => [
                        "id" => "9ca8a41d-b63d-4737-ae34-a976d8aa5ed5",
                        "ispb" => "13370835",
                        "code" => "301",
                        "short_name" => "DOCK IP S.A.",
                        "name" => "DOCK INSTITUIÇÃO DE PAGAMENTO S.A.",
                        "image" => null,
                        "created_at" => "2024-08-01 00:00:18",
                        "updated_at" => "2024-10-01 00:00:18"
                    ]
                ]
            ]
        ];
    }

    /**
     * pix/qr-codes/decode
     *
     * @return array
     */
    public function dataFakeQrCodeDecode()
    {
        return [
            "teste" => true,
            "e2e_id" => "E133708352024100721198DDVAW6WG79",
            "id_tx" => "***",
            "key" => "f83d1e20-0662-4c64-a295-1b95b2a17730",
            "code_type" => "static_qr",
            "beneficiary" => [
                "name" => "Gabriel Vasconcelos Gobbi",
                "document" => "***.622.278-**",
                "type" => "person"
            ],
            "bank_account" => [
                "bank_name" => "BPP IP S.A.",
                "number" => "183280496",
                "branch" => "0001",
                "type" => "payments",
                "ispb" => "13370835"
            ],
            "amount" => 12,
            "address" => [
                "city" => "SAO PAULO",
                "zip_code" => null
            ],
            "description" => null
        ];
    }

    /**
     * pix/qr-codes/static
     *
     * @return array
     */
    public function dataFakeQrCodeStatic()
    {
        return  [
            "test" => true,
            "emv" => "00020101021126580014br.gov.bcb.pix0136f83d1e20-0662-4c64-a295-1b95b2a17730520400005303986540510.005802BR5925Gabriel Vasconcelos Gobbi6009SAO PAULO62070503***63041725",
            "text" => "MDAwMjAxMDEwMjExMjY1ODAwMTRici5nb3YuYmNiLnBpeDAxMzZmODNkMWUyMC0wNjYyLTRjNjQtYTI5NS0xYjk1YjJhMTc3MzA1MjA0MDAwMDUzMDM5ODY1NDA1MTAuMDA1ODAyQlI1OTI1R2FicmllbCBWYXNjb25jZWxvcyBHb2JiaTYwMDlTQU8gUEFVTE82MjA3MDUwMyoqKjYzMDQxNzI1",
            "image" => "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",
            "createdDate" => "2024-10-07T11:53:35.701Z",
            "id" => "9d306b24-ec6b-48ac-a4d3-19a52e7acc62"
        ];
    }
}
