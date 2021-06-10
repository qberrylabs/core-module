<?php

namespace Modules\CoreModule\Traits;

trait EmailTemplateTrait {

    public function getTransferTemplate($emailContent,array $new)
    {
        $old = [
            'sender_name',
            'recipient_name',
            'from_amount',
            'to_amount',
            'from_currency',
            'to_currency',
            'fee_amount',
            'exchange_rate',
            'transaction_date',
            'id',
            ];

            $content = str_replace($old, $new, $emailContent);
            return $content;
    }

    public function getRequestTemplate($emailContent,array $new)
    {
        $old =
        [
            'sender_name',
            'recipient_name',
            'from_amount',
            'to_amount',
            'from_currency',
            'to_currency',
            'fee_amount',
            'exchange_rate',
            'transaction_date',
            'id',
        ];
            $content = str_replace($old, $new, $emailContent);
            return $content;
    }

    public function getDeposit($emailContent,array $new)
    {
        $old =
        [
            'user_full_name',
            'deposit_amount',
        ];
            $content = str_replace($old, $new, $emailContent);
            return $content;
    }


}
