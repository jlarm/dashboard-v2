<?php

namespace App\Enums;

enum DealJacketQuestions: string
{
    case individual_q3_answer = 'There is no Odometer Statement in deal.';
    case individual_q4_answer = 'The deal does not have a two page model Privacy Notice statement and/or was not signed.';
    case individual_q5_answer = 'Menu is not present.';
    case individual_q6_answer = 'Menu not filled out properly.';
    case individual_q7_answer = 'No separate signed contract for each product sold on menu.';
    case individual_q8_answer = 'All customers are not being treated the same regarding product markups on menu system.';
    case individual_q9_answer = 'OFAC not run and/or on file either physically or electronically.';
    case individual_q10_answer = 'The Red Flag software was not run and on file either physically or electronically.';
    case individual_q11_answer = 'No copy of the Buyer\'s Guide in deal jacket.';
    case individual_q12_answer = 'Buyer\'s Guide is not filled out properly and/or signed by customer.';
    case individual_q13_answer = 'RBPN and/or Exception notice not presented and signed by customer.';
    case individual_q14_answer = 'The Buyers Order & the RISC do not match up regarding final purchase price.';
    case individual_q15_answer = 'The Menu, Buyers Order & the RISC do not match up regarding ancillary products purchased.';
    case individual_q16_answer = 'Products purchased or denied are "NOT CLEARLY" displayed on the menu and/or "Settlement Disclosure Document".';
    case individual_q17_answer = 'The amount charged is not similar to that charged for other purchasers.';
    case individual_q18_answer = 'MSRP of Vehicle did exceed price.';
    case individual_q19_answer = 'Deal was not sent to more than one finance source.';
    case individual_q20_answer = 'Credit application not completed properly, accurate and signed by customer.';
    case individual_q21_answer = 'The handwritten credit application is not signed and/or matches the bank copy.';
    case individual_q22_answer = 'Adverse Action not filled out when warranted.';
    case individual_q23_answer = 'The DPP form is not filled out properly stating dealership CMS policy mark up rate and actual rate spread to customer.';
    case individual_q24_answer = 'Markups are not handled the same for similar customers.';
    case individual_q25_answer = 'The date on RISC is not accurate with no backdating.';
    case individual_q26_answer = 'All contracts are not signed by customer(s).';
    case individual_q27_answer = 'All signatures do not match up between menu, buyers order, RISC and all other product contracts.';
    case individual_q28_answer = 'There is not a copy of customers Driver\'s License in deal.';
    case individual_q29_answer = 'Language of contracts given to customers not proper for negotiation if required by state law.';
    case individual_q30_answer = 'All state specific disclosures are not included in deal.';
    case individual_q31_answer = 'Cosigner Notice not signed.';
    case individual_q32_answer = 'Promissory Note from the customer is not properly disclosed.';
    case individual_q33_answer = 'The "Cashed Deferred" down payment was not paid off before the 2nd scheduled payment period.';
    case individual_q34_answer = 'The Deal Recap or reconciliation documents not reviewed and/or in file.';
    case individual_q35_answer = 'The 8300 procedures not followed for transactions defined as "CASH".';
    case individual_q36_answer = 'No receipt for any cash down payments in deal.';
    case individual_q37_answer = 'The trade in vehicle not properly disclosed (line itemed) on the buyers order and RISC.';
    case individual_q38_answer = 'Lease deal contract not properly displaying all products purchased.';
    case individual_q39_answer = 'It is not clear what the customer purchased and/or the deal does not reflect the norm in the dealership.';
    case individual_q40_answer = 'The deal jacket is not complete with all information required based on the customer needs and wants.';

    public static function fromKey(string $key): DealJacketQuestions
    {
        return match ($key) {
            'individual_q3_answer' => self::individual_q3_answer,
            'individual_q4_answer' => self::individual_q4_answer,
            'individual_q5_answer' => self::individual_q5_answer,
            'individual_q6_answer' => self::individual_q6_answer,
            'individual_q7_answer' => self::individual_q7_answer,
            'individual_q8_answer' => self::individual_q8_answer,
            'individual_q9_answer' => self::individual_q9_answer,
            'individual_q10_answer' => self::individual_q10_answer,
            'individual_q11_answer' => self::individual_q11_answer,
            'individual_q12_answer' => self::individual_q12_answer,
            'individual_q13_answer' => self::individual_q13_answer,
            'individual_q14_answer' => self::individual_q14_answer,
            'individual_q15_answer' => self::individual_q15_answer,
            'individual_q16_answer' => self::individual_q16_answer,
            'individual_q17_answer' => self::individual_q17_answer,
            'individual_q18_answer' => self::individual_q18_answer,
            'individual_q19_answer' => self::individual_q19_answer,
            'individual_q20_answer' => self::individual_q20_answer,
            'individual_q21_answer' => self::individual_q21_answer,
            'individual_q22_answer' => self::individual_q22_answer,
            'individual_q23_answer' => self::individual_q23_answer,
            'individual_q24_answer' => self::individual_q24_answer,
            'individual_q25_answer' => self::individual_q25_answer,
            'individual_q26_answer' => self::individual_q26_answer,
            'individual_q27_answer' => self::individual_q27_answer,
            'individual_q28_answer' => self::individual_q28_answer,
            'individual_q29_answer' => self::individual_q29_answer,
            'individual_q30_answer' => self::individual_q30_answer,
            'individual_q31_answer' => self::individual_q31_answer,
            'individual_q32_answer' => self::individual_q32_answer,
            'individual_q33_answer' => self::individual_q33_answer,
            'individual_q34_answer' => self::individual_q34_answer,
            'individual_q35_answer' => self::individual_q35_answer,
            'individual_q36_answer' => self::individual_q36_answer,
            'individual_q37_answer' => self::individual_q37_answer,
            'individual_q38_answer' => self::individual_q38_answer,
            'individual_q39_answer' => self::individual_q39_answer,
            'individual_q40_answer' => self::individual_q40_answer,
        };
    }
}
