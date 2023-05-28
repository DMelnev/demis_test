<?php


namespace App\Service;


class PhoneNumberFilter
{
    private const ALLOWED_COUNTRIES = [
        "ru" => ["length" => 11, "codes" => ["|^8|", "|^7|",]],
    ];

    public function filter($number): bool
    {
        $marker = true;
        $phone = preg_replace('/[^0-9]/', '', $number);
        foreach (self::ALLOWED_COUNTRIES as $item) {
            if (strlen($phone) == $item["length"]) {
                foreach ($item["codes"] as $code) {
                    if (preg_match($code, $phone)) {
                        $marker = false;
                        break;
                    }
                }
                if ($marker) break;
            }
        }
        return $marker;
    }

    public function clearPhoneNumber(?string $number): ?string
    {
        if (!$number) return null;
        $phone = preg_replace('/[^0-9]/', '', $number);
        if (strlen($phone) == 10 && $phone[0] == '9') $phone = '7' . $phone;
        if (strlen($phone) == 11 && $phone[0] == '8') $phone[0] = '7';
        return $phone;
    }
}